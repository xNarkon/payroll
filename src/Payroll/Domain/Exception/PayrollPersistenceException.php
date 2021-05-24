<?php

declare(strict_types=1);

namespace Payroll\Domain\Exception;

use DomainException;
use Throwable;

final class PayrollPersistenceException extends DomainException
{
    public static function forInternalError(Throwable $throwable): self
    {
        return new self(
            sprintf('Got internal error while processing data: %s', $throwable->getMessage()),
            $throwable->getCode(),
            $throwable
        );
    }
}
