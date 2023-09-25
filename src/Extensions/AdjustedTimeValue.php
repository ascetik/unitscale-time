<?php

namespace Ascetik\UnitscaleTime\Extensions;

use Ascetik\UnitscaleCore\Extensions\AdjustedValue;
use Ascetik\UnitscaleCore\Types\ScaleValue;
use Ascetik\UnitscaleTime\DTO\TimeScaleReference;
use Ascetik\UnitscaleTime\Values\TimeScaleValue;

class AdjustedTimeValue extends AdjustedValue
{
    private ?TimeScaleValue $next = null;

    public function __construct(private TimeScaleReference $reference)
    {
    }

    public function __toString(): string
    {
        $highest = $this->reference->withHighestValue();
        $origin = $highest->value;
        $raw = $origin->raw();
        if ($raw !== (int) $raw && $raw > 1) {
            $origin = $highest->withValue((int) $raw)->value;
            $modulo = $this->reference->modulo($highest->value);
            if ($modulo > 0) {
                $this->setNextWith($modulo);
            }
        }
        $output = array_filter(
            [$origin, $this->next],
            fn (?string $litteral) => $litteral !== null
        );
        return implode(' ', $output);
    }

    public static function buildWith(ScaleValue $value): static
    {
        $reference = new TImeScaleReference($value);
        return new self($reference);
    }

    private function setNextWith(int|float $value)
    {
        $leftValue = new TimeScaleValue($value);
        $this->next = new static($this->reference->useValue($leftValue));
    }
}
