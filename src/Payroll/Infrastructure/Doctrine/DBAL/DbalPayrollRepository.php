<?php

declare(strict_types=1);

namespace Payroll\Infrastructure\Doctrine\DBAL;

use Doctrine\DBAL\Connection;
use Payroll\Domain\DataMapper\PayrollDataMapperInterface;
use Payroll\Domain\Exception\PayrollPersistenceException;
use Payroll\Domain\Payroll;
use Payroll\Domain\Repository\PayrollRepositoryInterface;
use Throwable;

class DbalPayrollRepository implements PayrollRepositoryInterface
{
    public function __construct(private Connection $connection, private PayrollDataMapperInterface $dataMapper)
    {
    }

    public function persist(Payroll $payroll): void
    {
        try {
            $this->connection->insert(
                'payrolls',
                $this->dataMapper->toRaw($payroll)
            );
        } catch (Throwable $throwable) {
            throw PayrollPersistenceException::forInternalError($throwable);
        }
    }
}
