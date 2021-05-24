<?php

declare(strict_types=1);

namespace Tests\HumanResources\Domain;

use DomainException;
use HumanResources\Domain\DepartmentIdentifier;
use PHPUnit\Framework\TestCase;

final class DepartmentIdentifierTest extends TestCase
{
    public function testThrowsExceptionOnInvalidInputValueFormat(): void
    {
        $this->expectException(DomainException::class);
        new DepartmentIdentifier('test-incorrect-uuid');
    }

    public function testProperlyConstructingObject(): void
    {
        $name = new DepartmentIdentifier($value = '772c0598-f635-409f-9072-d096e18257ea');

        self::assertEquals($value, $name->getValue());
    }
}
