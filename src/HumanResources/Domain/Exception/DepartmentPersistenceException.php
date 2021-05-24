<?php

declare(strict_types=1);

namespace HumanResources\Domain\Exception;

use DomainException;
use HumanResources\Domain\DepartmentIdentifier;
use Throwable;

final class DepartmentPersistenceException extends DomainException
{
    public static function forInternalError(Throwable $throwable): self
    {
        return new self(
            sprintf('Got internal error while processing data: %s', $throwable->getMessage()),
            $throwable->getCode(),
            $throwable
        );
    }

    public static function forNotFoundDepartment(DepartmentIdentifier $departmentIdentifier): self
    {
        return new self(sprintf('Department with identifier "%s" was not found', $departmentIdentifier->getValue()));
    }
}
