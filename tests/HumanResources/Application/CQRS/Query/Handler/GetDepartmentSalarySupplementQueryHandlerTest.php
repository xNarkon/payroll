<?php

declare(strict_types=1);

namespace Tests\HumanResources\Application\CQRS\Query\Handler;

use HumanResources\Application\CQRS\Query\GetDepartmentSalarySupplementQuery;
use HumanResources\Application\CQRS\Query\Handler\GetDepartmentSalarySupplementQueryHandler;
use HumanResources\Domain\Department;
use HumanResources\Domain\DepartmentIdentifier;
use HumanResources\Domain\DepartmentName;
use HumanResources\Infrastructure\Native\InMemoryDepartmentRepository;
use PHPUnit\Framework\TestCase;
use SharedKernel\Domain\PercentageSalarySupplement;

final class GetDepartmentSalarySupplementQueryHandlerTest extends TestCase
{
    public function testQueryHandlerReturnsExpectedResult(): void
    {
        // Arrange
        $repository = new InMemoryDepartmentRepository();
        $department = new Department(
            new DepartmentIdentifier($identifier = '3535b8d7-c549-4cd6-98a9-50521e82bf18'),
            new DepartmentName('Test'),
            new PercentageSalarySupplement($salarySupplementValue = 50)
        );
        $repository->persist($department);
        $handler = new GetDepartmentSalarySupplementQueryHandler($repository);

        // Act
        $result = $handler(new GetDepartmentSalarySupplementQuery($identifier));

        // Assert
        self::assertEquals('percentage', $result->getSalarySupplementType());
        self::assertEquals($salarySupplementValue, $result->getSalarySupplementValue());
    }
}
