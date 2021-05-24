<?php

declare(strict_types=1);

namespace Tests\HumanResources\Domain;

use DomainException;
use HumanResources\Domain\EmployeeLastName;
use PHPUnit\Framework\TestCase;

final class EmployeeLastNameTest extends TestCase
{
    public function testThrowsExceptionOnEmptyInputValueFormat(): void
    {
        $this->expectException(DomainException::class);
        new EmployeeLastName('');
    }

    public function testProperlyConstructingObject(): void
    {
        $name = new EmployeeLastName($value = 'Zaczesana');

        self::assertEquals($value, $name->getValue());
    }
}
