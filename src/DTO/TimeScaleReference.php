<?php

namespace Ascetik\UnitscaleTime\DTO;

use Ascetik\UnitscaleCore\Containers\ScaleContainer;
use Ascetik\UnitscaleCore\DTO\ScaleReference;
use Ascetik\UnitscaleCore\Types\Scale;
use Ascetik\UnitscaleCore\Types\ScaleValue;
use Ascetik\UnitscaleTime\Values\TimeScaleValue;

class TimeScaleReference extends ScaleReference
{
    public function __construct(
        TimeScaleValue $value,
        ScaleContainer $scales = null,
        protected ?Scale $highest = null,
        protected ?Scale $lowest = null
    ) {
        parent::__construct($value, $scales);
    }

    public function withHighestValue(): static
    {
        return $this->useValue($this->highest());
    }
    
    public function withValue(int|float $value): static
    {
        if ($this->value->raw() === $value) {
            return $this;
        }
        return $this->useValue($this->value->withValue($value));
    }

    public function useValue(TimeScaleValue $value): static
    {
        return new static($value, $this->scales, $this->highest, $this->lowest);
    }

    /**
     * The choice for a precision at 6 is
     * totally arbitrary.
     * I will find a way to decide what
     * amount is better.
     */
    public function modulo(ScaleValue $value): int|float
    {
        $totalTime = $this->value->toBase()->raw();
        $forward = $value->getScale()->forward(1);
        return round(fmod($totalTime, $forward), 6);
    }
}
