<?php

declare(strict_types=1);

namespace Payroll\Application;

use ArrayIterator;
use Iterator;
use IteratorAggregate;

final class PayrollReport implements IteratorAggregate
{
    /**
     * @param PayrollReportItem[] $items
     */
    public function __construct(private array $items)
    {
    }

    public function getIterator(): Iterator
    {
        return new ArrayIterator($this->items);
    }
}
