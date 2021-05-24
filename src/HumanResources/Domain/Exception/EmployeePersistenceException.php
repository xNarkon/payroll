<?php

declare(strict_types=1);

namespace HumanResources\Domain\Exception;

use DomainException;
use HumanResources\Domain\EmployeeIdentifier;
use Throwable;

final class EmployeePersistenceException extends DomainException
{
    public static function forInternalError(Throwable $throwable): self
    {
        return new self(
            sprintf('Got internal error while processing data: %s', $throwable->getMessage()),
            $throwable->getCode(),
            $throwable
        );
    }

    public static function forNotFoundEmployee(EmployeeIdentifier $employeeIdentifier): self
    {
        return new self(sprintf('Employee with identifier "%s" was not found', $employeeIdentifier->getValue()));
    }
}
