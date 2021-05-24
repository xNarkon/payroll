<?php

declare(strict_types=1);

namespace Payroll\Domain\Repository;

use Payroll\Domain\Exception\PayrollPersistenceException;
use Payroll\Domain\Payroll;

interface PayrollRepositoryInterface
{
    /**
     * @throws PayrollPersistenceException
     */
    public function persist(Payroll $payroll): void;
}
