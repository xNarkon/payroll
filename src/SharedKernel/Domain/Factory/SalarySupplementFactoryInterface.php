<?php

declare(strict_types=1);

namespace SharedKernel\Domain\Factory;

use SharedKernel\Domain\SalarySupplementInterface;

interface SalarySupplementFactoryInterface
{
    public function create(string $type, int $value): SalarySupplementInterface;
}
