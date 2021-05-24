<?php

declare(strict_types=1);

namespace HumanResources\Application\CQRS\Command;

final class CreateEmployeeCommand
{
    public function __construct(
        private string $identifier,
        private string $departmentIdentifier,
        private string $firstName,
        private string $lastName,
        private string $salaryCurrency,
        private int $salaryValue,
        private int $yearsWorked,
    ) {
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getDepartmentIdentifier(): string
    {
        return $this->departmentIdentifier;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getSalaryCurrency(): string
    {
        return $this->salaryCurrency;
    }

    public function getSalaryValue(): int
    {
        return $this->salaryValue;
    }

    public function getYearsWorked(): int
    {
        return $this->yearsWorked;
    }
}
