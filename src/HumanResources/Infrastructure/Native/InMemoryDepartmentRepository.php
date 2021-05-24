<?php

declare(strict_types=1);

namespace HumanResources\Infrastructure\Native;

use HumanResources\Domain\Department;
use HumanResources\Domain\DepartmentIdentifier;
use HumanResources\Domain\Exception\DepartmentPersistenceException;
use HumanResources\Domain\Repository\DepartmentRepositoryInterface;

final class InMemoryDepartmentRepository implements DepartmentRepositoryInterface
{
    private array $storage;

    public function __construct()
    {
        $this->storage = [];
    }

    public function persist(Department $department): void
    {
        $this->storage[$department->getId()->getValue()] = $department;
    }

    public function find(DepartmentIdentifier $departmentIdentifier): Department
    {
        if (isset($this->storage[$departmentIdentifier->getValue()])) {
            return $this->storage[$departmentIdentifier->getValue()];
        }

        throw DepartmentPersistenceException::forNotFoundDepartment($departmentIdentifier);
    }

    public function hasDepartment(string $departmentIdentifier): bool
    {
        return isset($this->storage[$departmentIdentifier]);
    }
}
