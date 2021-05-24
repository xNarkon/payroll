<?php

declare(strict_types=1);

namespace Payroll\Application;

use Payroll\Application\Exception\PayrollReportGenerationHasFailed;

interface PayrollReportQueryInterface
{
    /**
     * @throws PayrollReportGenerationHasFailed
     */
    public function get(PayrollReportSorting $sort, PayrollReportFilters $filters): PayrollReport;
}
