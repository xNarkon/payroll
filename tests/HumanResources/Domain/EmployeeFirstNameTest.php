<?php

declare(strict_types=1);

namespace Tests\HumanResources\Domain;

use DomainException;
use HumanResources\Domain\EmployeeFirstName;
use PHPUnit\Framework\TestCase;

final class EmployeeFirstNameTest extends TestCase
{
    public function testThrowsExceptionOnEmptyInputValueFormat(): void
    {
        $this->expectException(DomainException::class);
        new EmployeeFirstName('');
    }

    public function testProperlyConstructingObject(): void
    {
        $name = new EmployeeFirstName($value = 'Ola');

        self::assertEquals($value, $name->getValue());
    }
}
