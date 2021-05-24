<?php

declare(strict_types=1);

namespace HumanResources\Domain\Repository;

use HumanResources\Domain\Employee;
use HumanResources\Domain\EmployeeIdentifier;
use HumanResources\Domain\Exception\EmployeePersistenceException;

interface EmployeeRepositoryInterface
{
    /**
     * @throws EmployeePersistenceException
     */
    public function find(EmployeeIdentifier $employeeIdentifier): Employee;

    /**
     * @throws EmployeePersistenceException
     */
    public function persist(Employee $employee): void;
}
