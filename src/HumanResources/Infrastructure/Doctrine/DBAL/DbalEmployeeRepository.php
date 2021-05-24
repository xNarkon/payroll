<?php

declare(strict_types=1);

namespace HumanResources\Infrastructure\Doctrine\DBAL;

use Doctrine\DBAL\Connection;
use HumanResources\Domain\DataMapper\EmployeeDataMapperInterface;
use HumanResources\Domain\Employee;
use HumanResources\Domain\EmployeeIdentifier;
use HumanResources\Domain\Exception\EmployeePersistenceException;
use HumanResources\Domain\Repository\EmployeeRepositoryInterface;
use Throwable;

final class DbalEmployeeRepository implements EmployeeRepositoryInterface
{
    public function __construct(private Connection $connection, private EmployeeDataMapperInterface $dataMapper)
    {
    }

    public function find(EmployeeIdentifier $employeeIdentifier): Employee
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        try {
            $statement = $queryBuilder
                ->select('*')
                ->from('employees')
                ->where('uuid = :uuid')
                ->setParameter('uuid', $employeeIdentifier->getValue())
                ->execute();
            $employeeRawData = $statement->fetchAssociative();
        } catch (Throwable $throwable) {
            throw EmployeePersistenceException::forInternalError($throwable);
        }

        if (false === $employeeRawData) {
            throw EmployeePersistenceException::forNotFoundEmployee($employeeIdentifier);
        }

        return $this->dataMapper->fromRaw($employeeRawData);
    }

    public function persist(Employee $employee): void
    {
        try {
            $this->connection->insert(
                'employees',
                $this->dataMapper->toRaw($employee)
            );
        } catch (Throwable $throwable) {
            throw EmployeePersistenceException::forInternalError($throwable);
        }
    }
}
