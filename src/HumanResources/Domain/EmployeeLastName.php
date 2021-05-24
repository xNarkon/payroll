<?php

declare(strict_types=1);

namespace HumanResources\Domain;

use DomainException;

final class EmployeeLastName
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new DomainException('Employee last name cannot be empty');
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
