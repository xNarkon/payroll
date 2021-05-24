<?php

declare(strict_types=1);

namespace Tests\SharedKernel\Domain;

use PHPUnit\Framework\TestCase;
use SharedKernel\Domain\Exception\SalarySupplementHasInvalidValueException;
use SharedKernel\Domain\FixedAmountSalarySupplement;

final class FixedAmountSalarySupplementTest extends TestCase
{
    public function invalidInputValueDataProvider(): array
    {
        return [
            [
                0,
            ],
            [
                -10,
            ],
        ];
    }

    /**
     * @dataProvider invalidInputValueDataProvider
     */
    public function testThrowsExceptionOnInvalidInputValue(int $invalidValue): void
    {
        $this->expectException(SalarySupplementHasInvalidValueException::class);
        new FixedAmountSalarySupplement($invalidValue);
    }
}
