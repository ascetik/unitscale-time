<?php

/**
 * This is part of the UnitScale Time package.
 *
 * @package    unitscale-time
 * @category   Data Transfer Object
 * @license    https://opensource.org/license/mit/  MIT License
 * @copyright  Copyright (c) 2023, Vidda
 * @author     Vidda <vidda@ascetik.fr>
 */

declare(strict_types=1);

namespace Ascetik\UnitscaleTime\DTO;

use Ascetik\UnitscaleCore\Containers\ScaleContainer;
use Ascetik\UnitscaleCore\DTO\ScaleReference;
use Ascetik\UnitscaleCore\Types\Scale;
use Ascetik\UnitscaleCore\Types\ScaleValue;
use Ascetik\UnitscaleTime\Values\TimeScaleValue;

/**
 * Works as parent class
 * with a lowest scale limit
 *
 * @version 1.0.0
 */
class TimeScaleReference extends ScaleReference
{
    public function __construct(
        TimeScaleValue $value,
        ScaleContainer $scales = null,
        ?Scale $highest = null,
        private ?int $precision = null
    ) {
        parent::__construct($value, $scales, $highest);
    }

    /** @override */
    public function highest(): ScaleValue
    {
        $highest = parent::highest();
        if(!is_null($this->precision) && !$highest->isInteger()){
            $value = round($highest->raw(), $this->precision);
            return $highest->withValue($value);
        }
        return $highest;
    }

    public function withValue(int|float $value): static
    {
        if ($this->value->raw() === $value) {
            return $this;
        }
        return $this->useValue($this->value->withValue($value));
    }

    public function withHighestValue(): self
    {
        return $this->useValue($this->highest());
    }

    public function rounded(int $precision): self
    {
        $this->precision = $precision;
        return $this;
    }

    public function useValue(TimeScaleValue $value): static
    {
        return new static($value, $this->scales, $this->highest);
    }

    /**
     * The choice for a precision at 6 is
     * totally arbitrary.
     * I will find a way to decide
     */
    public function modulo(ScaleValue $value): int|float
    {
        $totalTime = $this->value->toBase()->raw();
        $forward = $value->getScale()->forward(1);
        return round(fmod($totalTime, $forward), 6);
    }
}
