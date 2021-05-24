<?php

declare(strict_types=1);

namespace HumanResources\Infrastructure\Doctrine\DBAL;

use Doctrine\DBAL\Connection;
use HumanResources\Domain\DataMapper\DepartmentDataMapperInterface;
use HumanResources\Domain\Department;
use HumanResources\Domain\DepartmentIdentifier;
use HumanResources\Domain\Exception\DepartmentPersistenceException;
use HumanResources\Domain\Repository\DepartmentRepositoryInterface;
use Throwable;

final class DbalDepartmentRepository implements DepartmentRepositoryInterface
{
    public function __construct(
        private Connection $connection,
        private DepartmentDataMapperInterface $dataMapper
    ) {
    }

    public function persist(Department $department): void
    {
        $this->connection->insert(
            'departments',
            $this->dataMapper->toRaw($department)
        );
    }

    public function find(DepartmentIdentifier $departmentIdentifier): Department
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        try {
            $statement = $queryBuilder
                ->select('*')
                ->from('departments')
                ->where('uuid = :uuid')
                ->setParameter('uuid', $departmentIdentifier->getValue())
                ->execute();
            $departmentRawData = $statement->fetchAssociative();
        } catch (Throwable $throwable) {
            throw DepartmentPersistenceException::forInternalError($throwable);
        }

        if (false === $departmentRawData) {
            throw DepartmentPersistenceException::forNotFoundDepartment($departmentIdentifier);
        }

        return $this->dataMapper->fromRaw($departmentRawData);
    }
}
