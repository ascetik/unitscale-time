<?php

namespace Ascetik\UnitscaleTime\Extensions;

use Ascetik\UnitscaleCore\Parsers\ScaleCommandParser;
use Ascetik\UnitscaleCore\Types\Scale;
use Ascetik\UnitscaleTime\Extensions\AdjustedTimeValue;
use Ascetik\UnitscaleTime\Values\TimeScaleValue;

/**
 * Decompose given Time value by multiple chained scales
 *
 * @mixin AdjustedTimeValue
 * @version 1.0.0
 */
class DetailedTimeValue extends AdjustedTimeValue
{
    /**
     * Next value to display
     *
     * @var self|null
     */
    private ?self $next = null;
    
    protected ?Scale $lowest = null;

    public function __call($name, $arguments): static
    {
        $parser = new ScaleCommandParser('as', 'until');
        $command = $parser->parse($name);
        $reference = match ($command->prefix) {
            'as' => $this->reference->limitTo($command->name),
            'until' => $this->until($command->name)
        };
        return new static($reference);
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

    private function until(string $scale)
    {
        $this->lowest = TimeScaleValue::createScale($scale);
    }

    private function setNextWith(int|float $value)
    {
        $leftValue = new TimeScaleValue($value);
        $ref = $this->reference->useValue($leftValue);
        // $highest = $ref->withHighestValue();
        // echo $highest->value->getUnit() . PHP_EOL;
        // echo ($this->lowest?->unit() ?? 'pas de lowest sur ce coup là !') . PHP_EOL;
        $this->next = new static($ref);
    }
}
