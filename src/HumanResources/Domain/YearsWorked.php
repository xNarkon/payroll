<?php

declare(strict_types=1);

namespace HumanResources\Domain;

use DomainException;

final class YearsWorked
{
    private int $value;

    public function __construct(int $value)
    {
        if ($value < 0) {
            throw new DomainException('Years worked must have be a positive value');
        }

        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
