<?php

declare(strict_types=1);

namespace Payroll\Application;

use InvalidArgumentException;

final class PayrollReportFilters
{
    public function __construct(private array $filters = [])
    {
    }

    public function getAvailableFilters(): array
    {
        return [
            'department_name',
            'employee_first_name',
            'employee_last_name',
        ];
    }

    public function getChosenFilters(): array
    {
        return $this->filters;
    }

    public function filterBy(Filter ...$filters): void
    {
        foreach ($filters as $filter) {
            if (false === \in_array($filter->getName(), $this->getAvailableFilters(), true)) {
                throw new InvalidArgumentException(sprintf('Filter %s is not supported', $filter->getName()));
            }
        }

        $this->filters = $filters;
    }
}
