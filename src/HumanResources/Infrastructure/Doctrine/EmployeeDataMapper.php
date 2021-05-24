<?php

declare(strict_types=1);

namespace HumanResources\Infrastructure\Doctrine;

use HumanResources\Domain\DataMapper\EmployeeDataMapperInterface;
use HumanResources\Domain\DepartmentIdentifier;
use HumanResources\Domain\Employee;
use HumanResources\Domain\EmployeeFirstName;
use HumanResources\Domain\EmployeeIdentifier;
use HumanResources\Domain\EmployeeLastName;
use HumanResources\Domain\YearsWorked;
use Money\Currency;
use Money\Money;

final class EmployeeDataMapper implements EmployeeDataMapperInterface
{
    public function fromRaw(array $rawData): Employee
    {
        return new Employee(
            new EmployeeIdentifier($rawData['uuid']),
            new EmployeeFirstName($rawData['first_name']),
            new EmployeeLastName($rawData['last_name']),
            new DepartmentIdentifier($rawData['department_uuid']),
            new Money(
                (int) $rawData['salary_value'],
                new Currency($rawData['salary_currency'])
            ),
            new YearsWorked((int) $rawData['years_worked'])
        );
    }

    public function fromPrimitives(
        string $identifier,
        string $firstName,
        string $lastName,
        string $departmentIdentifier,
        int $salaryValue,
        string $salaryCurrency,
        int $yearsWorked
    ): Employee {
        return new Employee(
            new EmployeeIdentifier($identifier),
            new EmployeeFirstName($firstName),
            new EmployeeLastName($lastName),
            new DepartmentIdentifier($departmentIdentifier),
            new Money(
                $salaryValue,
                new Currency($salaryCurrency)
            ),
            new YearsWorked($yearsWorked)
        );
    }

    public function toRaw(Employee $employee): array
    {
        return [
            'uuid' => $employee->getId()->getValue(),
            'first_name' => $employee->getFirstName()->getValue(),
            'last_name' => $employee->getLastName()->getValue(),
            'department_uuid' => $employee->getDepartmentIdentifier()->getValue(),
            'salary_currency' => $employee->getBaseSalary()->getCurrency()->getCode(),
            'salary_value' => $employee->getBaseSalary()->getAmount(),
            'years_worked' => $employee->getYearsWorked()->getValue(),
        ];
    }
}
