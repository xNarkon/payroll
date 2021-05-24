<?php

declare(strict_types=1);

namespace Payroll\Domain\Exception;

use DomainException;
use SharedKernel\Domain\SalarySupplementInterface;

final class PayrollCalculationHasFailedException extends DomainException
{
    public static function forUnsupportedSalarySupplement(SalarySupplementInterface $salarySupplement): self
    {
        return new self(sprintf('Salary supplement is not supported: %s', \get_class($salarySupplement)));
    }
}
