<?php

declare(strict_types=1);

namespace Payroll\Application\Exception;

use Exception;
use Throwable;

final class PayrollReportGenerationHasFailed extends Exception
{
    public static function forInternalError(Throwable $throwable): self
    {
        return new self(
            sprintf('Got internal error while processing report data: %s', $throwable->getMessage()),
            $throwable->getCode(),
            $throwable
        );
    }
}
