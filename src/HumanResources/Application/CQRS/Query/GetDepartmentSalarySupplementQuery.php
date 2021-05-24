<?php

declare(strict_types=1);

namespace HumanResources\Application\CQRS\Query;

final class GetDepartmentSalarySupplementQuery
{
    public function __construct(private string $departmentIdentifier)
    {
    }

    public function getDepartmentIdentifier(): string
    {
        return $this->departmentIdentifier;
    }
}
