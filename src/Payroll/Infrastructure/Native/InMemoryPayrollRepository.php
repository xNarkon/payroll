<?php

declare(strict_types=1);

namespace Payroll\Infrastructure\Native;

use Payroll\Domain\Payroll;
use Payroll\Domain\Repository\PayrollRepositoryInterface;

class InMemoryPayrollRepository implements PayrollRepositoryInterface
{
    private array $storage;

    public function __construct()
    {
        $this->storage = [];
    }

    public function persist(Payroll $payroll): void
    {
        $this->storage[$payroll->getEmployeeIdentifier()] = $payroll;
    }

    public function hasPayroll(string $employeeIdentifier): bool
    {
        return isset($this->storage[$employeeIdentifier]);
    }
}
