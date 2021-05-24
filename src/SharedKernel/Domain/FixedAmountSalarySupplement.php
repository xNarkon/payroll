<?php

declare(strict_types=1);

namespace SharedKernel\Domain;

use SharedKernel\Domain\Exception\SalarySupplementHasInvalidValueException;

final class FixedAmountSalarySupplement implements SalarySupplementInterface
{
    public const SYMBOL = 'fixed_amount';
    private int $value;

    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new SalarySupplementHasInvalidValueException('Value must be a positive value higher than 0');
        }

        $this->value = $value;
    }

    public function getSymbol(): string
    {
        return self::SYMBOL;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
