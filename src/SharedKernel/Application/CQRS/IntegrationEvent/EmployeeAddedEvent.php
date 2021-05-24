<?php

declare(strict_types=1);

namespace SharedKernel\Application\CQRS\IntegrationEvent;

final class EmployeeAddedEvent
{
    public function __construct(
        private string $employeeIdentifier,
        private int $yearsWorked,
        private int $baseSalaryValue,
        private string $baseSalaryCurrency,
        private string $salarySupplementType,
        private int $salarySupplementValue,
    ) {
    }

    public function getEmployeeIdentifier(): string
    {
        return $this->employeeIdentifier;
    }

    public function getYearsWorked(): int
    {
        return $this->yearsWorked;
    }

    public function getBaseSalaryValue(): int
    {
        return $this->baseSalaryValue;
    }

    public function getBaseSalaryCurrency(): string
    {
        return $this->baseSalaryCurrency;
    }

    public function getSalarySupplementType(): string
    {
        return $this->salarySupplementType;
    }

    public function getSalarySupplementValue(): int
    {
        return $this->salarySupplementValue;
    }
}
