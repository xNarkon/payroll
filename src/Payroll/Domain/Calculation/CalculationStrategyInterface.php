<?php

declare(strict_types=1);

namespace Payroll\Domain\Calculation;

use Payroll\Domain\Payroll;
use Payroll\Domain\PayrolledEmployee;
use SharedKernel\Domain\SalarySupplementInterface;

interface CalculationStrategyInterface
{
    public function supports(SalarySupplementInterface $salarySupplement): bool;

    public function calculate(PayrolledEmployee $payrolledEmployee): Payroll;
}
