<?php

declare(strict_types=1);

namespace Payroll\Domain\Calculation;

use Payroll\Domain\Payroll;
use Payroll\Domain\PayrolledEmployee;
use SharedKernel\Domain\PercentageSalarySupplement;
use SharedKernel\Domain\SalarySupplementInterface;

final class PercentageSalarySupplementCalculationStrategy implements CalculationStrategyInterface
{
    public function supports(SalarySupplementInterface $salarySupplement): bool
    {
        return $salarySupplement instanceof PercentageSalarySupplement;
    }

    public function calculate(PayrolledEmployee $payrolledEmployee): Payroll
    {
        $salarySupplementValue = $payrolledEmployee->getSalarySupplement()->getValue();
        $salarySupplementAmount = $payrolledEmployee->getBaseSalary()->multiply((string) ($salarySupplementValue / 100));
        $supplementedSalary = $payrolledEmployee->getBaseSalary()->add($salarySupplementAmount);

        return new Payroll(
            $payrolledEmployee->getEmployeeIdentifier(),
            $salarySupplementAmount,
            $supplementedSalary
        );
    }
}
