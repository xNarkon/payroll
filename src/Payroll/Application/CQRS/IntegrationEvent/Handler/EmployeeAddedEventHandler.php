<?php

declare(strict_types=1);

namespace Payroll\Application\CQRS\IntegrationEvent\Handler;

use Money\Currency;
use Money\Money;
use Payroll\Domain\PayrolledEmployee;
use Payroll\Domain\Repository\PayrollRepositoryInterface;
use Payroll\Domain\Service\PayrollCalculatorInterface;
use SharedKernel\Application\CQRS\IntegrationEvent\EmployeeAddedEvent;
use SharedKernel\Domain\Factory\SalarySupplementFactoryInterface;

final class EmployeeAddedEventHandler
{
    public function __construct(
        private SalarySupplementFactoryInterface $salarySupplementFactory,
        private PayrollRepositoryInterface $payrollRepository,
        private PayrollCalculatorInterface $payrollCalculator,
    ) {
    }

    public function __invoke(EmployeeAddedEvent $event): void
    {
        $payrolledEmployee = new PayrolledEmployee(
            $event->getEmployeeIdentifier(),
            $this->salarySupplementFactory->create(
                $event->getSalarySupplementType(),
                $event->getSalarySupplementValue()
            ),
            $event->getYearsWorked(),
            new Money(
                $event->getBaseSalaryValue(),
                new Currency($event->getBaseSalaryCurrency())
            )
        );
        $payroll = $this->payrollCalculator->calculate($payrolledEmployee);

        $this->payrollRepository->persist($payroll);
    }
}
