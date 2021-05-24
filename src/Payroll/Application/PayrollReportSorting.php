<?php

declare(strict_types=1);

namespace Payroll\Application;

use InvalidArgumentException;

final class PayrollReportSorting
{
    private const DIRECTIONS = ['asc', 'desc'];

    private ?string $sort;
    private ?string $direction;

    public function __construct()
    {
        $this->sort = null;
        $this->direction = null;
    }

    public function sortBy(string $sort, string $direction): void
    {
        if (false === \in_array($sort, $this->getAvailableSorts(), true)) {
            throw new InvalidArgumentException(sprintf('Sort %s is not supported', $sort));
        }

        $this->sort = $sort;

        if (false === \in_array($direction, self::DIRECTIONS, true)) {
            throw new InvalidArgumentException(sprintf('Sort direction %s is not supported', $direction));
        }

        $this->direction = $direction;
    }

    public function getAvailableSorts(): array
    {
        return [
            'department_name',
            'employee_first_name',
            'employee_last_name',
            'base_salary',
            'salary_supplement_type',
            'supplement_salary_value',
            'final_salary',
        ];
    }

    public function getSort(): ?string
    {
        return $this->sort;
    }

    public function getDirection(): ?string
    {
        return $this->direction;
    }
}
