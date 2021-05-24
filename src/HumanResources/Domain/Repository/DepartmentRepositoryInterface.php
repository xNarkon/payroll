<?php

declare(strict_types=1);

namespace HumanResources\Domain\Repository;

use HumanResources\Domain\Department;
use HumanResources\Domain\DepartmentIdentifier;
use HumanResources\Domain\Exception\DepartmentPersistenceException;

interface DepartmentRepositoryInterface
{
    /**
     * @throws DepartmentPersistenceException
     */
    public function persist(Department $department): void;

    /**
     * @throws DepartmentPersistenceException
     */
    public function find(DepartmentIdentifier $departmentIdentifier): Department;
}
