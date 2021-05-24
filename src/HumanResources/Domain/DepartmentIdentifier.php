<?php

declare(strict_types=1);

namespace HumanResources\Domain;

use DomainException;

final class DepartmentIdentifier
{
    private string $identifier;

    public function __construct(string $value)
    {
        if (!preg_match(
            '/^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[4][0-9a-fA-F]{3}-[89ABab][0-9a-fA-F]{3}-[0-9a-fA-F]{12}$/',
            $value
        )) {
            throw new DomainException('Department identifier has invalid format');
        }

        $this->identifier = $value;
    }

    public function getValue(): string
    {
        return $this->identifier;
    }
}
