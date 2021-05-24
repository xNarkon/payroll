<?php

declare(strict_types=1);

namespace Payroll\Domain;

use Money\Money;

final class Payroll
{
    public function __construct(
        private string $employeeIdentifier,
        private Money $salarySupplementAmount,
        private Money $calculatedFinalSalary
    ) {
    }

    public function getEmployeeIdentifier(): string
    {
        return $this->employeeIdentifier;
    }

    public function getSalarySupplement(): Money
    {
        return $this->salarySupplementAmount;
    }

    public function getCalculatedFinalSalary(): Money
    {
        return $this->calculatedFinalSalary;
    }
}
