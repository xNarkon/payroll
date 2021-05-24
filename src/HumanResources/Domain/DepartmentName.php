<?php

declare(strict_types=1);

namespace HumanResources\Domain;

use DomainException;

final class DepartmentName
{
    private string $name;

    public function __construct(string $name)
    {
        if (empty($name)) {
            throw new DomainException('Department name cannot be empty');
        }

        $this->name = $name;
    }

    public function getValue(): string
    {
        return $this->name;
    }
}
