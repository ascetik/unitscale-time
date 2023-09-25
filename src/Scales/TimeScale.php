<?php

/**
 * This is part of the UnitScale Time package.
 *
 * @package    unitscale-time
 * @category   Time Scale Base
 * @license    https://opensource.org/license/mit/  MIT License
 * @copyright  Copyright (c) 2023, Vidda
 * @author     Vidda <vidda@ascetik.fr>
 */

declare(strict_types=1);

namespace Ascetik\UnitscaleTime\Scales;

use Ascetik\UnitscaleCore\Types\Scale;


/**
 * Implement common time scale methods
 *
 * @version 1.0.0
 */
class TimeScale implements Scale
{
    public function __construct(private readonly int $factor, private readonly string $unit)
    {
    }

    public function forward(int|float $value): int|float
    {
        return $value * $this->factor;
    }

    public function backward(int|float $value): int|float
    {
        return $value / $this->factor;
    }

    public function factor(): int|float
    {
        return $this->factor;
    }

    public function unit(): string
    {
        return $this->unit;
    }

}
