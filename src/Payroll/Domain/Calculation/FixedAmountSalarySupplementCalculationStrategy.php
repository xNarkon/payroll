<?php

declare(strict_types=1);

namespace Payroll\Domain\Calculation;

use Money\Money;
use Payroll\Domain\Payroll;
use Payroll\Domain\PayrolledEmployee;
use SharedKernel\Domain\FixedAmountSalarySupplement;
use SharedKernel\Domain\SalarySupplementInterface;

final class FixedAmountSalarySupplementCalculationStrategy implements CalculationStrategyInterface
{
    private const MINIMUM_WORKED_YEARS_ALLOWED_FOR_CALCULATION = 1;
    private const MAXIMUM_WORKED_YEARS_WITH_SALARY_SUPPLEMENTATION = 10;

    public function supports(SalarySupplementInterface $salarySupplement): bool
    {
        return $salarySupplement instanceof FixedAmountSalarySupplement;
    }

    public function calculate(PayrolledEmployee $payrolledEmployee): Payroll
    {
        $salarySupplementValue = $payrolledEmployee->getSalarySupplement()->getValue();
        $employeeYearsWorked = $payrolledEmployee->getYearsWorked();

        if ($payrolledEmployee->getYearsWorked() <= 0) {
            $employeeYearsWorked = self::MINIMUM_WORKED_YEARS_ALLOWED_FOR_CALCULATION;
        }

        if ($employeeYearsWorked >= self::MAXIMUM_WORKED_YEARS_WITH_SALARY_SUPPLEMENTATION) {
            $employeeYearsWorked = self::MAXIMUM_WORKED_YEARS_WITH_SALARY_SUPPLEMENTATION;
        }

        $salarySupplementAmount = (new Money(
            $salarySupplementValue,
            $payrolledEmployee->getBaseSalary()->getCurrency()
        ))->multiply((string) $employeeYearsWorked);
        $supplementedSalary = $payrolledEmployee->getBaseSalary()->add($salarySupplementAmount);

        return new Payroll(
            $payrolledEmployee->getEmployeeIdentifier(),
            $salarySupplementAmount,
            $supplementedSalary
        );
    }
}
