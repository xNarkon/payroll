<?php

declare(strict_types=1);

namespace SharedKernel\Domain\Factory;

use SharedKernel\Domain\Exception\SalarySupplementIsUnsupportedException;
use SharedKernel\Domain\FixedAmountSalarySupplement;
use SharedKernel\Domain\PercentageSalarySupplement;
use SharedKernel\Domain\SalarySupplementInterface;

final class SalarySupplementFactory implements SalarySupplementFactoryInterface
{
    public function create(string $type, int $value): SalarySupplementInterface
    {
        if (PercentageSalarySupplement::SYMBOL === $type) {
            return new PercentageSalarySupplement($value);
        }

        if (FixedAmountSalarySupplement::SYMBOL === $type) {
            return new FixedAmountSalarySupplement($value);
        }

        throw SalarySupplementIsUnsupportedException::forType($type);
    }
}
