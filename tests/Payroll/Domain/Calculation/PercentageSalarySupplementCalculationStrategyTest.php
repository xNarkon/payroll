<?php

declare(strict_types=1);

namespace Tests\Payroll\Domain\Calculation;

use Money\Money;
use Payroll\Domain\Calculation\PercentageSalarySupplementCalculationStrategy;
use Payroll\Domain\PayrolledEmployee;
use PHPUnit\Framework\TestCase;
use SharedKernel\Domain\FixedAmountSalarySupplement;
use SharedKernel\Domain\PercentageSalarySupplement;

final class PercentageSalarySupplementCalculationStrategyTest extends TestCase
{
    public function properValuesDataProvider(): array
    {
        return [
            [
                10,
                Money::USD(110000),
                Money::USD(121000),
            ],
            [
                100,
                Money::USD(110000),
                Money::USD(220000),
            ],
            [
                5,
                Money::USD(110000),
                Money::USD(115500),
            ],
        ];
    }

    /**
     * @dataProvider properValuesDataProvider
     */
    public function testProperlyCalculates(int $percentage, Money $baseSalary, Money $calculatedFinalSalary): void
    {
        // Arrange
        $strategy = new PercentageSalarySupplementCalculationStrategy();
        $payrolledEmployee = new PayrolledEmployee(
            'b9ef3280-a408-4b15-b1f5-297fa2b70374',
            new PercentageSalarySupplement($percentage),
            10,
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
        $strategy = new PercentageSalarySupplementCalculationStrategy();

        // Act
        $result = $strategy->supports(new PercentageSalarySupplement(50));

        // Assert
        self::assertTrue($result);
    }

    public function testDoesNotSupportOtherSupplements(): void
    {
        // Arrange
        $strategy = new PercentageSalarySupplementCalculationStrategy();

        // Act
        $result = $strategy->supports(new FixedAmountSalarySupplement(10000));

        // Assert
        self::assertFalse($result);
    }
}
