<?php

declare(strict_types=1);

namespace HumanResources\Infrastructure\Doctrine;

use HumanResources\Domain\DataMapper\DepartmentDataMapperInterface;
use HumanResources\Domain\Department;
use HumanResources\Domain\DepartmentIdentifier;
use HumanResources\Domain\DepartmentName;
use SharedKernel\Domain\Factory\SalarySupplementFactoryInterface;

final class DepartmentDataMapper implements DepartmentDataMapperInterface
{
    public function __construct(private SalarySupplementFactoryInterface $salarySupplementFactory)
    {
    }

    public function fromRaw(array $rawData): Department
    {
        return new Department(
            new DepartmentIdentifier($rawData['uuid']),
            new DepartmentName($rawData['name']),
            $this->salarySupplementFactory->create(
                $rawData['salary_supplement_type'],
                (int) $rawData['salary_supplement_value'],
            )
        );
    }

    public function fromPrimitives(
        string $identifier,
        string $name,
        string $salarySupplementType,
        int $salarySupplementValue
    ): Department {
        return new Department(
            new DepartmentIdentifier($identifier),
            new DepartmentName($name),
            $this->salarySupplementFactory->create(
                $salarySupplementType,
                $salarySupplementValue
            )
        );
    }

    public function toRaw(Department $department): array
    {
        return [
            'uuid' => $department->getId()->getValue(),
            'name' => $department->getName()->getValue(),
            'salary_supplement_type' => $department->getSalarySupplement()->getSymbol(),
            'salary_supplement_value' => $department->getSalarySupplement()->getValue(),
        ];
    }
}
