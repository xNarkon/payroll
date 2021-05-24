<?php

declare(strict_types=1);

namespace Tests\Payroll\Domain\Calculation;

use Money\Money;
use Payroll\Domain\Calculation\FixedAmountSalarySupplementCalculationStrategy;
use Payroll\Domain\PayrolledEmployee;
use PHPUnit\Framework\TestCase;
use SharedKernel\Domain\FixedAmountSalarySupplement;
use SharedKernel\Domain\PercentageSalarySupplement;

final class FixedAmountSalarySupplementCalculationStrategyTest extends TestCase
{
    public function properValuesDataProvider(): array
    {
        return [
            [
                10000,
                10,
                Money::USD(100000),
                Money::USD(200000),
            ],
            [
                20000,
                10,
                Money::USD(250000),
                Money::USD(450000),
            ],
            [
                20000,
                15,
                Money::USD(250000),
                Money::USD(450000),
            ],
            [
                20000,
                0,
                Money::USD(250000),
                Money::USD(270000),
            ],
        ];
    }

    /**
     * @dataProvider properValuesDataProvider
     */
    public function testProperlyCalculates(
        int $supplement,
        int $employeeYearsWorked,
        Money $baseSalary,
        Money $calculatedFinalSalary
    ): void {
        // Arrange
        $strategy = new FixedAmountSalarySupplementCalculationStrategy();
        $payrolledEmployee = new PayrolledEmployee(
            'b9ef3280-a408-4b15-b1f5-297fa2b70374',
            new FixedAmountSalarySupplement($supplement),
            $employeeYearsWorked,
            $baseSalary
        );

        // Act
        $payroll = $strategy->calculate($payrolledEmployee);

        // Assert
        self::assertEquals($calculatedFinalSalary->getAmount(), $payroll->getCalculatedFinalSalary()->getAmount());
        self::assertTrue($calculatedFinalSalary->equals($payroll->getCalculatedFinalSalary()));
    }

    public function testSupportsOnlyProperSupplement(): void
    {
        // Arrange
        $strategy = new FixedAmountSalarySupplementCalculationStrategy();

        // Act
        $result = $strategy->supports(new FixedAmountSalarySupplement(1000));

        // Assert
        self::assertTrue($result);
    }

    public function testDoesNotSupportOtherSupplements(): void
    {
        // Arrange
        $strategy = new FixedAmountSalarySupplementCalculationStrategy();

        // Act
        $result = $strategy->supports(new PercentageSalarySupplement(100));

        // Assert
        self::assertFalse($result);
    }
}
