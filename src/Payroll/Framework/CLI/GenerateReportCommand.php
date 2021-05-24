<?php

declare(strict_types=1);

namespace Payroll\Framework\CLI;

use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;
use Payroll\Application\Filter;
use Payroll\Application\PayrollReport;
use Payroll\Application\PayrollReportFilters;
use Payroll\Application\PayrollReportItem;
use Payroll\Application\PayrollReportQueryInterface;
use Payroll\Application\PayrollReportSorting;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class GenerateReportCommand extends Command
{
    private PayrollReportSorting $sorting;
    private PayrollReportFilters $filters;

    public function __construct(
        private PayrollReportQueryInterface $payrollReportQuery,
    ) {
        $this->sorting = new PayrollReportSorting();
        $this->filters = new PayrollReportFilters();
        parent::__construct('payroll:report:generate');
    }

    protected function configure(): void
    {
        $this->setDescription('Generates the payroll report');
        $this->addOption(
            'sort',
            's',
            InputOption::VALUE_OPTIONAL,
            sprintf('Column sort. Available sorts: [%s]', implode(', ', $this->sorting->getAvailableSorts())),
            'employee_first_name'
        );
        $this->addOption('sort_direction', 'd', InputOption::VALUE_OPTIONAL, 'Sorting direction', 'desc');
        $this->addOption(
            'filters',
            'f',
            InputOption::VALUE_OPTIONAL,
            sprintf(
                'Column filter. Available filters: [%s]. Example syntax: employee_first_name=Ania,department_name=HR',
                implode(', ', $this->filters->getAvailableFilters())
            )
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->configureSorting($input);
        $this->configureFilters($input);

        $payrollReport = $this->payrollReportQuery->get(
            $this->sorting,
            $this->filters
        );

        $this->renderReportTable($output, $payrollReport);

        return Command::SUCCESS;
    }

    protected function configureSorting(InputInterface $input): void
    {
        if (false === empty($input->getOption('sort')) && false === empty($input->getOption('sort_direction'))) {
            $this->sorting->sortBy(
                $input->getOption('sort'),
                $input->getOption('sort_direction')
            );
        }
    }

    protected function renderReportTable(
        OutputInterface $output,
        PayrollReport $payrollReport,
    ): void {
        $numberFormatter = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, new ISOCurrencies());
        $table = new Table($output);

        $table->setHeaders(
            [
                'Employee first name',
                'Employee last name',
                'Department',
                'Base salary',
                'Supplement type',
                'Salary supplement',
                'Payroll salary',
            ]
        );

        /** @var PayrollReportItem $payrollReportItem */
        foreach ($payrollReport as $payrollReportItem) {
            $table->addRow(
                [
                    $payrollReportItem->getEmployeeFirstName(),
                    $payrollReportItem->getEmployeeLastName(),
                    $payrollReportItem->getDepartmentName(),
                    $moneyFormatter->format($payrollReportItem->getBaseSalary()),
                    $payrollReportItem->getSalarySupplementType(),
                    $moneyFormatter->format($payrollReportItem->getPayrollSupplementValue()),
                    $moneyFormatter->format($payrollReportItem->getPayrollSalary()),
                ]
            );
        }

        $table->render();
    }

    protected function configureFilters(InputInterface $input): void
    {
        if (false === empty($input->getOption('filters'))) {
            $filters = explode(',', $input->getOption('filters'));

            $this->filters->filterBy(
                ...array_map(
                    static function (string $filter) {
                        $filterChunks = explode('=', $filter);

                        return new Filter($filterChunks[0], $filterChunks[1]);
                    },
                    $filters
                )
            );
        }
    }
}
