<?php

declare(strict_types=1);

namespace Tests\Payroll\Domain\Service;

use Money\Money;
use Payroll\Domain\Calculation\CalculationStrategies;
use Payroll\Domain\Calculation\FixedAmountSalarySupplementCalculationStrategy;
use Payroll\Domain\Calculation\PercentageSalarySupplementCalculationStrategy;
use Payroll\Domain\Exception\PayrollCalculationHasFailedException;
use Payroll\Domain\PayrolledEmployee;
use Payroll\Domain\Service\StrategyBasedPayrollCalculator;
use PHPUnit\Framework\TestCase;
use SharedKernel\Domain\FixedAmountSalarySupplement;
use SharedKernel\Domain\PercentageSalarySupplement;
use SharedKernel\Domain\SalarySupplementInterface;

final class StrategyBasedPayrollCalculatorTest extends TestCase
{
    public function dataProvider(): array
    {
        return [
            [
                new FixedAmountSalarySupplement(10000),
                7,
                Money::USD(20000),
                Money::USD(90000),
            ],
            [
                new PercentageSalarySupplement(50),
                0,
                Money::USD(10000),
                Money::USD(15000),
            ],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testProperlyCalculatesTheFinalSalaryUsingAppropriateStrategy(
        SalarySupplementInterface $salarySupplement,
        int $yearsWorked,
        Money $baseSalary,
        Money $expectedPayrollSalary
    ): void {
        // Arranger
        $calculationStrategies = new CalculationStrategies(
            new FixedAmountSalarySupplementCalculationStrategy(),
            new PercentageSalarySupplementCalculationStrategy()
        );
        $calculator = new StrategyBasedPayrollCalculator($calculationStrategies);
        $payrolledEmployee = new PayrolledEmployee(
            '82ef3bcb-9a59-484c-b9f6-fa7c2cfc2914',
            $salarySupplement,
            $yearsWorked,
            $baseSalary
        );

        // Act
        $payroll = $calculator->calculate($payrolledEmployee);

        // Assert
        self::assertEquals($expectedPayrollSalary, $payroll->getCalculatedFinalSalary());
    }

    public function testThrowsExceptionOnUnsupportedSalarySupplement(): void
    {
        // Arranger
        $calculationStrategies = new CalculationStrategies(
            new FixedAmountSalarySupplementCalculationStrategy()
        );
        $calculator = new StrategyBasedPayrollCalculator($calculationStrategies);
        $payrolledEmployee = new PayrolledEmployee(
            '82ef3bcb-9a59-484c-b9f6-fa7c2cfc2914',
            new PercentageSalarySupplement(50),
            0,
            Money::USD(10000),
        );

        // Act
        // Assert
        $this->expectException(PayrollCalculationHasFailedException::class);
        $calculator->calculate($payrolledEmployee);
    }
}
