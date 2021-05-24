<?php

declare(strict_types=1);

namespace HumanResources\Application\CQRS\Command;

final class CreateDepartmentCommand
{
    public function __construct(
        private string $identifier,
        private string $name,
        private string $salarySupplementType,
        private int $salarySupplementValue
    ) {
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSalarySupplementType(): string
    {
        return $this->salarySupplementType;
    }

    public function getSalarySupplementValue(): int
    {
        return $this->salarySupplementValue;
    }
}
