<?php

declare(strict_types=1);

namespace SharedKernel\Domain;

interface SalarySupplementInterface
{
    public function getSymbol(): string;

    public function getValue(): int;
}
