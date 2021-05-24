<?php

declare(strict_types=1);

namespace Payroll\Domain;

use Money\Money;
use SharedKernel\Domain\SalarySupplementInterface;

final class PayrolledEmployee
{
    public function __construct(
        private string $employeeIdentifier,
        private SalarySupplementInterface $salarySupplement,
        private int $yearsWorked,
        private Money $baseSalary,
    ) {
    }

    public function getEmployeeIdentifier(): string
    {
        return $this->employeeIdentifier;
    }

    public function getSalarySupplement(): SalarySupplementInterface
    {
        return $this->salarySupplement;
    }

    public function getYearsWorked(): int
    {
        return $this->yearsWorked;
    }

    public function getBaseSalary(): Money
    {
        return $this->baseSalary;
    }
}
