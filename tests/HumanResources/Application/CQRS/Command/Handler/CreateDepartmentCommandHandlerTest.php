<?php

declare(strict_types=1);

namespace Tests\HumanResources\Application\CQRS\Command\Handler;

use HumanResources\Application\CQRS\Command\CreateDepartmentCommand;
use HumanResources\Application\CQRS\Command\Handler\CreateDepartmentCommandHandler;
use HumanResources\Infrastructure\Native\InMemoryDepartmentRepository;
use PHPUnit\Framework\TestCase;
use SharedKernel\Domain\Factory\SalarySupplementFactory;

final class CreateDepartmentCommandHandlerTest extends TestCase
{
    public function testHandlerPersistsNewDepartment(): void
    {
        // Arrange
        $handler = new CreateDepartmentCommandHandler(
            $repository = new InMemoryDepartmentRepository(),
            new SalarySupplementFactory()
        );

        // Act
        $handler(
            new CreateDepartmentCommand(
                $identifier = 'f955aee9-3e1f-45ae-bd9f-80aba593315b',
                'Test',
                'percentage',
                10
            )
        );

        // Assert
        self::assertTrue($repository->hasDepartment($identifier));
    }
}
