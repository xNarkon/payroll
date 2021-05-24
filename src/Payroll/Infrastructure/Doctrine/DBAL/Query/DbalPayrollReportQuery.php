<?php

declare(strict_types=1);

namespace Payroll\Infrastructure\Doctrine\DBAL\Query;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Payroll\Application\Exception\PayrollReportGenerationHasFailed;
use Payroll\Application\Filter;
use Payroll\Application\PayrollReport;
use Payroll\Application\PayrollReportFilters;
use Payroll\Application\PayrollReportItem;
use Payroll\Application\PayrollReportQueryInterface;
use Payroll\Application\PayrollReportSorting;
use Throwable;

final class DbalPayrollReportQuery implements PayrollReportQueryInterface
{
    private const COLUMN_MAP = [
        'department_name' => 'd.name',
        'employee_first_name' => 'e.first_name',
        'employee_last_name' => 'e.last_name',
        'base_salary' => 'e.salary_value',
        'salary_supplement_type' => 'd.salary_supplement_type',
        'supplement_salary_value' => 'p.supplement_salary_value',
        'final_salary' => 'p.final_salary_value',
    ];

    public function __construct(private Connection $connection)
    {
    }

    public function get(PayrollReportSorting $sort, PayrollReportFilters $filters): PayrollReport
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select(
                'e.first_name',
                'e.last_name',
                'e.salary_value',
                'e.salary_currency',
                'd.name',
                'd.salary_supplement_type',
                'p.final_salary_value',
                'p.final_salary_currency',
                'p.supplement_salary_value',
                'p.supplement_salary_currency'
            )
            ->from('employees', 'e')
            ->join('e', 'departments', 'd', 'e.department_uuid = d.uuid')
            ->join('e', 'payrolls', 'p', 'e.uuid = p.employee_uuid');
        $this->addSorting($sort, $queryBuilder);
        $this->addFiltering($filters, $queryBuilder);

        try {
            $statement = $queryBuilder->execute();
            $result = $statement->fetchAllAssociative();
        } catch (Throwable $throwable) {
            throw PayrollReportGenerationHasFailed::forInternalError($throwable);
        }

        return $this->createReport($result);
    }

    private function mapToColumn(string $queryArgument): ?string
    {
        return self::COLUMN_MAP[$queryArgument] ?? null;
    }

    private function addSorting(PayrollReportSorting $sort, QueryBuilder $queryBuilder): void
    {
        if (null !== $sort->getSort()) {
            $queryBuilder->orderBy($this->mapToColumn($sort->getSort()), $sort->getDirection());
        }
    }

    private function addFiltering(PayrollReportFilters $filters, QueryBuilder $queryBuilder): void
    {
        if (false === empty($filters->getChosenFilters())) {
            /** @var Filter $filter */
            foreach ($filters->getChosenFilters() as $filter) {
                $filterColumn = $this->mapToColumn($filter->getName());

                if (null === $filterColumn) {
                    continue;
                }

                $queryBuilder->orWhere(sprintf('%s = :%s', $filterColumn, $filter->getName()));
                $queryBuilder->setParameter(sprintf(':%s', $filter->getName()), $filter->getValue());
            }
        }
    }

    private function createReport(array $result): PayrollReport
    {
        return new PayrollReport(
            array_map(
                static fn (array $row) => new PayrollReportItem(
                    $row['first_name'],
                    $row['last_name'],
                    $row['name'],
                    $row['salary_value'],
                    $row['salary_currency'],
                    $row['salary_supplement_type'],
                    $row['final_salary_value'],
                    $row['final_salary_currency'],
                    $row['supplement_salary_value'],
                    $row['supplement_salary_currency'],
                ),
                $result
            )
        );
    }
}
