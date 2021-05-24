<?php

declare(strict_types=1);

namespace Payroll\Infrastructure\Doctrine;

use Payroll\Domain\DataMapper\PayrollDataMapperInterface;
use Payroll\Domain\Payroll;

final class PayrollDataMapper implements PayrollDataMapperInterface
{
    public function toRaw(Payroll $payroll): array
    {
        return [
            'employee_uuid' => $payroll->getEmployeeIdentifier(),
            'supplement_salary_value' => $payroll->getSalarySupplement()->getAmount(),
            'supplement_salary_currency' => $payroll->getSalarySupplement()->getCurrency()->getCode(),
            'final_salary_value' => $payroll->getCalculatedFinalSalary()->getAmount(),
            'final_salary_currency' => $payroll->getCalculatedFinalSalary()->getCurrency()->getCode(),
        ];
    }
}
