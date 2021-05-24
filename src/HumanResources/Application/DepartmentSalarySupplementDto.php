<?php

declare(strict_types=1);

namespace HumanResources\Application;

final class DepartmentSalarySupplementDto
{
    public function __construct(private string $salarySupplementType, private int $salarySupplementValue)
    {
    }

    public function getSalarySupplementType(): string
    {
        return $this->salarySupplementType;
    }

    public function getSalarySupplementValue(): int
    {
        return $this->salarySupplementValue;
    }
}
