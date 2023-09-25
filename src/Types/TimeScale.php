<?php

/**
 * This is part of the UnitScale package.
 *
 * @package    UnitScale
 * @category   Time Scale Base
 * @license    https://opensource.org/license/mit/  MIT License
 * @copyright  Copyright (c) 2023, Vidda
 * @author     Vidda <vidda@ascetik.fr>
 */

declare(strict_types=1);

namespace Ascetik\UnitscaleTime\Types;

use Ascetik\UnitscaleCore\Types\Scale;


/**
 * Implement common time scale methods
 *
 * @abstract
 * @version 1.0.0
 */
abstract class TimeScale implements Scale
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
