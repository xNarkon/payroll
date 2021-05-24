<?php

declare(strict_types=1);

namespace HumanResources\Framework\CLI;

use HumanResources\Application\CQRS\Command\CreateDepartmentCommand;
use HumanResources\Application\CQRS\Command\CreateEmployeeCommand;
use HumanResources\Application\CQRS\Query\GetDepartmentSalarySupplementQuery;
use HumanResources\Application\DepartmentSalarySupplementDto;
use SharedKernel\Application\CQRS\IntegrationEvent\EmployeeAddedEvent;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Uid\Uuid;

final class InitialFixturesCommand extends Command
{
    use HandleTrait;

    public function __construct(
        private MessageBusInterface $humanResourcesCommandBus,
        MessageBusInterface $humanResourcesQueryBus,
        private MessageBusInterface $integrationEventBus
    ) {
        parent::__construct('hr:initial-fixtures');
        $this->messageBus = $humanResourcesQueryBus;
    }

    protected function configure(): void
    {
        $this->setDescription('Adds default startup data');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->humanResourcesCommandBus->dispatch(
            new CreateDepartmentCommand(
                $hrDepartmentUuid = (string) Uuid::v4(),
                'HR',
                'fixed_amount',
                10000
            )
        );
        $this->humanResourcesCommandBus->dispatch(
            new CreateDepartmentCommand(
                $customerServiceDepartmentUuid = (string) Uuid::v4(),
                'Customer Service',
                'percentage',
                10
            )
        );
        $this->createEmployee(
            $hrDepartmentUuid,
            'Adam',
            'Kowalski',
            100000,
            15,
        );
        $this->createEmployee(
            $customerServiceDepartmentUuid,
            'Ania',
            'Nowak',
            110000,
            5,
        );

        $output->writeln('<info>Initial data successfully generated</info>');

        return Command::SUCCESS;
    }

    private function createEmployee(
        string $departmentUuid,
        string $firstName,
        string $lastName,
        int $salaryValue,
        int $yearsWorked
    ): void {
        $this->humanResourcesCommandBus->dispatch(
            new CreateEmployeeCommand(
                $employeeUuid = (string) Uuid::v4(),
                $departmentIdentifier = $departmentUuid,
                $firstName,
                $lastName,
                $salaryCurrency = 'USD',
                $salaryValue,
                $yearsWorked,
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
    }
}
