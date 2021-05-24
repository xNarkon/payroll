<?php

declare(strict_types=1);

namespace HumanResources\Infrastructure\Native;

use HumanResources\Domain\Employee;
use HumanResources\Domain\EmployeeIdentifier;
use HumanResources\Domain\Exception\EmployeePersistenceException;
use HumanResources\Domain\Repository\EmployeeRepositoryInterface;

final class InMemoryEmployeeRepository implements EmployeeRepositoryInterface
{
    private array $storage;

    public function __construct()
    {
        $this->storage = [];
    }

    public function persist(Employee $employee): void
    {
        $this->storage[$employee->getId()->getValue()] = $employee;
    }

    public function find(EmployeeIdentifier $employeeIdentifier): Employee
    {
        if (isset($this->storage[$employeeIdentifier->getValue()])) {
            return $this->storage[$employeeIdentifier->getValue()];
        }

        throw EmployeePersistenceException::forNotFoundEmployee($employeeIdentifier);
    }

    public function hasEmployee(string $identifier): bool
    {
        return isset($this->storage[$identifier]);
    }
}
