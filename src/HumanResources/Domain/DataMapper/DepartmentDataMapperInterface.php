<?php

declare(strict_types=1);

namespace HumanResources\Domain\DataMapper;

use HumanResources\Domain\Department;

interface DepartmentDataMapperInterface
{
    public function fromRaw(array $rawData): Department;

    public function fromPrimitives(
        string $identifier,
        string $name,
        string $salarySupplementType,
        int $salarySupplementValue
    ): Department;

    public function toRaw(Department $department): array;
}
