<?php

namespace Ascetik\UnitscaleTime\Extensions;

use Ascetik\UnitscaleCore\Extensions\AdjustedValue;
use Ascetik\UnitscaleCore\Traits\UseHighestValue;
use Ascetik\UnitscaleTime\DTO\TimeScaleReference;
use Ascetik\UnitscaleTime\Values\TimeScaleValue;

class DetailedTimeValue extends AdjustedValue
{
    use UseHighestValue;

    /**
     * TODO : Implementation
     *
     * Cet objet servira à détailler un TimeScaleValue
     * exactement comme le fait l'actuel AdjustedTimeValue.
     */
    private ?self $next = null;

    public function __construct(private TimeScaleReference $reference)
    {
        $this->setReference($reference);
    }

    public function __toString(): string
    {
        $highest = $this->reference->withHighestValue();
        $origin = $highest->value;
        $raw = $origin->raw();
        $int = $origin->integer();
        if ($raw !== $int && $raw > 1) {
            $origin = $highest->withValue($int)->value;
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

    private function setNextWith(int|float $value)
    {
        $leftValue = new TimeScaleValue($value);
        $this->next = new static($this->reference->useValue($leftValue));
    }
}
