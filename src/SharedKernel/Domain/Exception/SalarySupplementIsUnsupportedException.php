<?php

declare(strict_types=1);

namespace SharedKernel\Domain\Exception;

use DomainException;

final class SalarySupplementIsUnsupportedException extends DomainException
{
    public static function forType(string $type): self
    {
        return new self(sprintf('Salary supplement type is not supported: %s', $type));
    }
}
