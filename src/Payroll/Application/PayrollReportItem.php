<?php

declare(strict_types=1);

namespace Payroll\Application;

use Money\Currency;
use Money\Money;

final class PayrollReportItem
{
    public function __construct(
        private string $employeeFirstName,
        private string $employeeLastName,
        private string $departmentName,
        private string $baseSalaryValue,
        private string $baseSalaryCurrency,
        private string $salarySupplementType,
        private string $payrollSalaryValue,
        private string $payrollSalaryCurrency,
        private string $payrollSupplementSalaryValue,
        private string $payrollSupplementSalaryCurrency,
    ) {
    }

    public function getEmployeeFirstName(): string
    {
        return $this->employeeFirstName;
    }

    public function getEmployeeLastName(): string
    {
        return $this->employeeLastName;
    }

    public function getDepartmentName(): string
    {
        return $this->departmentName;
    }

    public function getBaseSalary(): Money
    {
        return new Money(
            $this->baseSalaryValue,
            new Currency($this->baseSalaryCurrency)
        );
    }

    public function getSalarySupplementType(): string
    {
        return $this->salarySupplementType;
    }

    public function getPayrollSupplementValue(): Money
    {
        return new Money(
            $this->payrollSupplementSalaryValue,
            new Currency($this->payrollSupplementSalaryCurrency)
        );
    }

    public function getPayrollSalary(): Money
    {
        return new Money(
            $this->payrollSalaryValue,
            new Currency($this->payrollSalaryCurrency)
        );
    }
}
