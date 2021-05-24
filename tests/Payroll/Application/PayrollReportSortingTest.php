<?php

declare(strict_types=1);

namespace Tests\Payroll\Application;

use InvalidArgumentException;
use Payroll\Application\PayrollReportSorting;
use PHPUnit\Framework\TestCase;

final class PayrollReportSortingTest extends TestCase
{
    public function testThrowsExceptionOnUnsupportedSort(): void
    {
        $filters = new PayrollReportSorting();

        $this->expectException(InvalidArgumentException::class);
        $filters->sortBy('unknown_sort', 'desc');
    }

    public function testThrowsExceptionOnUnsupportedDirection(): void
    {
        $filters = new PayrollReportSorting();

        $this->expectException(InvalidArgumentException::class);
        $filters->sortBy('department_name', 'unsupported_direction');
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
            [
                'base_salary',
            ],
            [
                'salary_supplement_type',
            ],
            [
                'supplement_salary_value',
            ],
            [
                'final_salary',
            ],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testProperlyConstructingSort(string $sortField): void
    {
        // Arrange
        $filters = new PayrollReportSorting();

        // Act
        $filters->sortBy($sortField, 'desc');

        // Assert
        self::assertEquals($sortField, $filters->getSort());
    }
}
