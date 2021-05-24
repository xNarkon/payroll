<?php

declare(strict_types=1);

namespace Tests\Payroll\Application\CQRS\IntegrationEvent\Handler;

use Payroll\Application\CQRS\IntegrationEvent\Handler\EmployeeAddedEventHandler;
use Payroll\Domain\Calculation\CalculationStrategies;
use Payroll\Domain\Calculation\FixedAmountSalarySupplementCalculationStrategy;
use Payroll\Domain\Calculation\PercentageSalarySupplementCalculationStrategy;
use Payroll\Domain\Service\StrategyBasedPayrollCalculator;
use Payroll\Infrastructure\Native\InMemoryPayrollRepository;
use PHPUnit\Framework\TestCase;
use SharedKernel\Application\CQRS\IntegrationEvent\EmployeeAddedEvent;
use SharedKernel\Domain\Factory\SalarySupplementFactory;

final class EmployeeAddedEventHandlerTest extends TestCase
{
    public function testProperlyCalculatesAndPersistsPayrollForNewEmployee(): void
    {
        // Arrange
        $handler = new EmployeeAddedEventHandler(
            new SalarySupplementFactory(),
            $payrollRepository = new InMemoryPayrollRepository(),
            new StrategyBasedPayrollCalculator(
                new CalculationStrategies(
                    new FixedAmountSalarySupplementCalculationStrategy(),
                    new PercentageSalarySupplementCalculationStrategy(),
                )
            )
        );

        // Act
        $handler(
            new EmployeeAddedEvent(
                $employeeIdentifier = '5e16dec8-e294-49c2-b929-d89f4407f229',
                10,
                50000,
                'USD',
                'percentage',
                5
            )
        );

        // Assert
        self::assertTrue($payrollRepository->hasPayroll($employeeIdentifier));
    }
}
