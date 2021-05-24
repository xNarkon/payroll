<?php

declare(strict_types=1);

namespace Tests\SharedKernel\Domain\Factory;

use PHPUnit\Framework\TestCase;
use SharedKernel\Domain\Exception\SalarySupplementIsUnsupportedException;
use SharedKernel\Domain\Factory\SalarySupplementFactory;
use SharedKernel\Domain\FixedAmountSalarySupplement;
use SharedKernel\Domain\PercentageSalarySupplement;

final class SalarySupplementFactoryTest extends TestCase
{
    public function testThrowsExceptionOnUnsupportedSupplementType(): void
    {
        $factory = new SalarySupplementFactory();

        $this->expectException(SalarySupplementIsUnsupportedException::class);
        $factory->create('unsupported_type', 0);
    }

    public function dataProvider(): array
    {
        return [
            [
                PercentageSalarySupplement::SYMBOL,
                PercentageSalarySupplement::class,
            ],
            [
                FixedAmountSalarySupplement::SYMBOL,
                FixedAmountSalarySupplement::class,
            ],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testProperlyCreatedSupplements(string $type, string $expectedClass): void
    {
        // Arrange
        $factory = new SalarySupplementFactory();

        // Act
        $supplement = $factory->create($type, 10);

        // Assert
        self::assertInstanceOf($expectedClass, $supplement);
    }
}
