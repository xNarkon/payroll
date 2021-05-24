<?php

declare(strict_types=1);

namespace Tests\Payroll\Application;

use InvalidArgumentException;
use Payroll\Application\Filter;
use Payroll\Application\PayrollReportFilters;
use PHPUnit\Framework\TestCase;

final class PayrollReportFiltersTest extends TestCase
{
    public function testThrowsExceptionOnUnsupportedFilter(): void
    {
        $filters = new PayrollReportFilters();

        $this->expectException(InvalidArgumentException::class);
        $filters->filterBy(
            new Filter('unknown_filter', 'example')
        );
    }

    public function dataProvider(): array
    {
        return [
            [
                'department_name',
            ],
            [
                'employee_first_name',
            ],
            [
                'employee_last_name',
            ],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testProperlyConstructingSort(string $filterField): void
    {
        // Arrange
        $filters = new PayrollReportFilters();

        // Act
        $filters->filterBy(
            $filter = new Filter($filterField, 'example_value')
        );

        // Assert
        self::assertEquals([$filter], $filters->getChosenFilters());
    }
}
