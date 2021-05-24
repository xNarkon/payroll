<?php

declare(strict_types=1);

namespace HumanResources\Domain;

use Money\Money;

final class Employee
{
    public function __construct(
        private EmployeeIdentifier $identifier,
        private EmployeeFirstName $firstName,
        private EmployeeLastName $lastName,
        private DepartmentIdentifier $departmentIdentifier,
        private Money $baseSalary,
        private YearsWorked $yearsWorked,
    ) {
    }

    public function getId(): EmployeeIdentifier
    {
        return $this->identifier;
    }

    public function getFirstName(): EmployeeFirstName
    {
        return $this->firstName;
    }

    public function getLastName(): EmployeeLastName
    {
        return $this->lastName;
    }

    public function getDepartmentIdentifier(): DepartmentIdentifier
    {
        return $this->departmentIdentifier;
    }

    public function getBaseSalary(): Money
    {
        return $this->baseSalary;
    }

    public function getYearsWorked(): YearsWorked
    {
        return $this->yearsWorked;
    }
}
