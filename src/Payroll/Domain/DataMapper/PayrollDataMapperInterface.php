<?php

declare(strict_types=1);

namespace Payroll\Domain\DataMapper;

use Payroll\Domain\Payroll;

interface PayrollDataMapperInterface
{
    public function toRaw(Payroll $payroll): array;
}
