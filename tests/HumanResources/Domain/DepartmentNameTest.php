<?php

declare(strict_types=1);

namespace Tests\HumanResources\Domain;

use DomainException;
use HumanResources\Domain\DepartmentName;
use PHPUnit\Framework\TestCase;

final class DepartmentNameTest extends TestCase
{
    public function testThrowsExceptionOnEmptyInputValueFormat(): void
    {
        $this->expectException(DomainException::class);
        new DepartmentName('');
    }

    public function testProperlyConstructingObject(): void
    {
        $name = new DepartmentName($value = 'Tech');

        self::assertEquals($value, $name->getValue());
    }
}
