<?php

declare(strict_types=1);

namespace HumanResources\Application\CQRS\Command\Handler;

use HumanResources\Application\CQRS\Command\CreateDepartmentCommand;
use HumanResources\Domain\Department;
use HumanResources\Domain\DepartmentIdentifier;
use HumanResources\Domain\DepartmentName;
use HumanResources\Domain\Repository\DepartmentRepositoryInterface;
use SharedKernel\Domain\Factory\SalarySupplementFactoryInterface;

final class CreateDepartmentCommandHandler
{
    public function __construct(
        private DepartmentRepositoryInterface $departmentRepository,
        private SalarySupplementFactoryInterface $salarySupplementFactory
    ) {
    }

    public function __invoke(CreateDepartmentCommand $command): void
    {
        $this->departmentRepository->persist(
            new Department(
                new DepartmentIdentifier($command->getIdentifier()),
                new DepartmentName($command->getName()),
                $this->salarySupplementFactory->create(
                    $command->getSalarySupplementType(),
                    $command->getSalarySupplementValue()
                )
            )
        );
    }
}
