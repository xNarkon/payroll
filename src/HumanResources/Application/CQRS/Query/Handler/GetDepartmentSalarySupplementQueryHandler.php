<?php

declare(strict_types=1);

namespace HumanResources\Application\CQRS\Query\Handler;

use HumanResources\Application\CQRS\Query\GetDepartmentSalarySupplementQuery;
use HumanResources\Application\DepartmentSalarySupplementDto;
use HumanResources\Domain\DepartmentIdentifier;
use HumanResources\Domain\Repository\DepartmentRepositoryInterface;

final class GetDepartmentSalarySupplementQueryHandler
{
    private DepartmentRepositoryInterface $departmentRepository;

    public function __construct(DepartmentRepositoryInterface $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function __invoke(GetDepartmentSalarySupplementQuery $query): DepartmentSalarySupplementDto
    {
        $department = $this->departmentRepository->find(new DepartmentIdentifier($query->getDepartmentIdentifier()));

        return new DepartmentSalarySupplementDto(
            $department->getSalarySupplement()->getSymbol(),
            $department->getSalarySupplement()->getValue(),
        );
    }
}
