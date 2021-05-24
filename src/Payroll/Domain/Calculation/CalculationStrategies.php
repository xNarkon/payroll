<?php

declare(strict_types=1);

namespace Payroll\Domain\Calculation;

use ArrayIterator;
use Iterator;
use IteratorAggregate;

final class CalculationStrategies implements IteratorAggregate
{
    private array $calculationStrategies;

    public function __construct(CalculationStrategyInterface ...$calculationStrategies)
    {
        $this->calculationStrategies = $calculationStrategies;
    }

    public function getIterator(): Iterator
    {
        return new ArrayIterator($this->calculationStrategies);
    }
}
