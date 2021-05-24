<?php

declare(strict_types=1);

namespace HumanResources\Domain;

use SharedKernel\Domain\SalarySupplementInterface;

final class Department
{
    public function __construct(
        private DepartmentIdentifier $id,
        private DepartmentName $name,
        private SalarySupplementInterface $salarySupplement,
    ) {
    }

    public function getId(): DepartmentIdentifier
    {
        return $this->id;
    }

    public function getName(): DepartmentName
    {
        return $this->name;
    }

    public function getSalarySupplement(): SalarySupplementInterface
    {
        return $this->salarySupplement;
    }
}
