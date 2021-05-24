<?php

declare(strict_types=1);

namespace Tests\HumanResources\Application\CQRS\Command\Handler;

use HumanResources\Application\CQRS\Command\CreateEmployeeCommand;
use HumanResources\Application\CQRS\Command\Handler\CreateEmployeeCommandHandler;
use HumanResources\Infrastructure\Native\InMemoryEmployeeRepository;
use PHPUnit\Framework\TestCase;

final class CreateEmployeeCommandHandlerTest extends TestCase
{
    public function testHandlerPersistsNewDepartment(): void
    {
        // Arrange
        $handler = new CreateEmployeeCommandHandler(
            $repository = new InMemoryEmployeeRepository(),
        );

        // Act
        $handler(
            new CreateEmployeeCommand(
                $identifier = 'f955aee9-3e1f-45ae-bd9f-80aba593315b',
                'd5fa6902-21e3-4708-bf47-857927a78126',
                'Janek',
                'Kowal',
                'USD',
                10000,
                5
            )
        );

        // Assert
        self::assertTrue($repository->hasEmployee($identifier));
    }
}
