<?php

declare(strict_types=1);

namespace HumanResources\Framework\CLI;

use HumanResources\Application\CQRS\Command\CreateEmployeeCommand;
use HumanResources\Application\CQRS\Query\GetDepartmentSalarySupplementQuery;
use HumanResources\Application\DepartmentSalarySupplementDto;
use SharedKernel\Application\CQRS\IntegrationEvent\EmployeeAddedEvent;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Uid\Uuid;

final class AddEmployeeCommand extends Command
{
    use HandleTrait;

    public function __construct(
        private MessageBusInterface $humanResourcesCommandBus,
        MessageBusInterface $humanResourcesQueryBus,
        private MessageBusInterface $integrationEventBus,
    ) {
        parent::__construct('hr:employee:add');
        $this->messageBus = $humanResourcesQueryBus;
    }

    protected function configure(): void
    {
        $this->setDescription('Adds new employee');
        $this->addArgument('first_name', InputArgument::REQUIRED, 'Employee first name');
        $this->addArgument('last_name', InputArgument::REQUIRED, 'Employee last name');
        $this->addArgument('department_identifier', InputArgument::REQUIRED, 'Department identifier');
        $this->addArgument('years_worked', InputArgument::REQUIRED, 'Years worked in company');
        $this->addArgument(
            'salary_value',
            InputArgument::REQUIRED,
            'Salary value must be in the lowest unit e. g. cents'
        );
        $this->addArgument('salary_currency', InputArgument::OPTIONAL, 'Salary currency', 'USD');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->humanResourcesCommandBus->dispatch(
            new CreateEmployeeCommand(
                $employeeUuid = (string) Uuid::v4(),
                $departmentIdentifier = $input->getArgument('department_identifier'),
                $input->getArgument('first_name'),
                $input->getArgument('last_name'),
                $salaryCurrency = $input->getArgument('salary_currency'),
                $salaryValue = (int) $input->getArgument('salary_value'),
                $yearsWorked = (int) $input->getArgument('years_worked'),
            )
        );

        /** @var DepartmentSalarySupplementDto $departmentSalarySupplement */
        $departmentSalarySupplement = $this->handle(
            new GetDepartmentSalarySupplementQuery($departmentIdentifier)
        );

        $this->integrationEventBus->dispatch(
            new EmployeeAddedEvent(
                $employeeUuid,
                $yearsWorked,
                $salaryValue,
                $salaryCurrency,
                $departmentSalarySupplement->getSalarySupplementType(),
                $departmentSalarySupplement->getSalarySupplementValue()
            )
        );

        $output->writeln(sprintf('<info>Employee successfully added with identifier: %s</info>', $employeeUuid));

        return Command::SUCCESS;
    }
}
