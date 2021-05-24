<?php

declare(strict_types=1);

namespace HumanResources\Application\CQRS\Command\Handler;

use HumanResources\Application\CQRS\Command\CreateEmployeeCommand;
use HumanResources\Domain\DepartmentIdentifier;
use HumanResources\Domain\Employee;
use HumanResources\Domain\EmployeeFirstName;
use HumanResources\Domain\EmployeeIdentifier;
use HumanResources\Domain\EmployeeLastName;
use HumanResources\Domain\Repository\EmployeeRepositoryInterface;
use HumanResources\Domain\YearsWorked;
use Money\Currency;
use Money\Money;

final class CreateEmployeeCommandHandler
{
    public function __construct(
        private EmployeeRepositoryInterface $employeeRepository
    ) {
    }

    public function __invoke(CreateEmployeeCommand $command): void
    {
        $this->employeeRepository->persist(
            new Employee(
                new EmployeeIdentifier($command->getIdentifier()),
                new EmployeeFirstName($command->getFirstName()),
                new EmployeeLastName($command->getLastName()),
                new DepartmentIdentifier($command->getDepartmentIdentifier()),
                new Money(
                    $command->getSalaryValue(),
                    new Currency($command->getSalaryCurrency())
                ),
                new YearsWorked($command->getYearsWorked())
            )
        );
    }
}
