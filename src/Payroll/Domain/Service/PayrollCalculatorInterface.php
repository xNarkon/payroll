<?php

declare(strict_types=1);

namespace Payroll\Domain\Service;

use Payroll\Domain\Payroll;
use Payroll\Domain\PayrolledEmployee;

interface PayrollCalculatorInterface
{
    public function calculate(PayrolledEmployee $payrolledEmployee): Payroll;
}
