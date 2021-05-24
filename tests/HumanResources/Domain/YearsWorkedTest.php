<?php

declare(strict_types=1);

namespace HumanResources\Domain;

use DomainException;
use PHPUnit\Framework\TestCase;

final class YearsWorkedTest extends TestCase
{
    public function dataProvider(): array
    {
        return [
            [
                0,
            ],
            [
                5,
            ],
        ];
    }

    public function testThrowsExceptionOnNegativeInputValueFormat(): void
    {
        $this->expectException(DomainException::class);
        new YearsWorked(-1);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testProperlyConstructingObject(int $value): void
    {
        $years = new YearsWorked($value);

        self::assertEquals($value, $years->getValue());
    }
}
