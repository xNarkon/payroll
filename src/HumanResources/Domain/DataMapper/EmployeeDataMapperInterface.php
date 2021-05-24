<?php

declare(strict_types=1);

namespace HumanResources\Domain\DataMapper;

use HumanResources\Domain\Employee;

interface EmployeeDataMapperInterface
{
    public function fromRaw(array $rawData): Employee;

    public function fromPrimitives(
        string $identifier,
        string $firstName,
        string $lastName,
        string $departmentIdentifier,
        int $salaryValue,
        string $salaryCurrency,
        int $yearsWorked
    ): Employee;

    public function toRaw(Employee $employee): array;
}
