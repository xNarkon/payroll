<?php

declare(strict_types=1);

namespace Payroll\Domain\Service;

use Payroll\Domain\Calculation\CalculationStrategies;
use Payroll\Domain\Calculation\CalculationStrategyInterface;
use Payroll\Domain\Exception\PayrollCalculationHasFailedException;
use Payroll\Domain\Payroll;
use Payroll\Domain\PayrolledEmployee;

final class StrategyBasedPayrollCalculator implements PayrollCalculatorInterface
{
    public function __construct(private CalculationStrategies $calculationStrategies)
    {
    }

    public function calculate(PayrolledEmployee $payrolledEmployee): Payroll
    {
        /** @var CalculationStrategyInterface $calculationStrategy */
        foreach ($this->calculationStrategies as $calculationStrategy) {
            if ($calculationStrategy->supports($payrolledEmployee->getSalarySupplement())) {
                return $calculationStrategy->calculate($payrolledEmployee);
            }
        }

        throw PayrollCalculationHasFailedException::forUnsupportedSalarySupplement($payrolledEmployee->getSalarySupplement());
    }
}
