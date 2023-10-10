<?php

/**
 * This is part of the UnitScale Time package.
 *
 * @package    unitscale-time
 * @category   ScaleValue adjustment Extension
 * @license    https://opensource.org/license/mit/  MIT License
 * @copyright  Copyright (c) 2023, Vidda
 * @author     Vidda <vidda@ascetik.fr>
 */

namespace Ascetik\UnitscaleTime\Extensions;

use Ascetik\UnitscaleCore\Parsers\ScaleCommandParser;
use Ascetik\UnitscaleCore\Types\Scale;
use Ascetik\UnitscaleTime\DTO\TimeScaleReference;
use Ascetik\UnitscaleTime\Extensions\AdjustedTimeValue;
use Ascetik\UnitscaleTime\Values\TimeScaleValue;

/**
 * Decompose given Time value with multiple chained scales
 *
 * @mixin AdjustedTimeValue
 * @method self untilYears()
 * @method self untilMonths()
 * @method self untilWeeks()
 * @method self untilDays()
 * @method self untilHours()
 * @method self untilMinutes()
 * @method self untilSeconds()
 * @method self untilBase()
 * @method self untilMilli()
 * @method self untilMicro()
 * @method self untilNano()
 * @method self untilPico()
 *
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

    public function __construct(
        TimeScaleReference $reference,
        protected ?Scale $lowest = null
    ) {
        parent::__construct($reference);
    }

    public function __call($name, $arguments): static
    {
        $parser = new ScaleCommandParser('as', 'until');
        $command = $parser->parse($name);
        return match ($command->prefix) {
            'as' => $this->limitTo($command->name),
            'until' => $this->until($command->name)
        };
    }

    public function __toString(): string
    {
        $highest = $this->reference->withHighestValue();
        $origin = $highest->value;

        /**
         * Scale comparison will be available
         * on next core package release
         */
        if($origin->getScale() == $this->lowest){
            return (string) $origin->withValue($origin->integer());
        }

        if (!$origin->isInteger() && $origin->raw() > 1) {
            $origin = $highest->withValue($origin->integer())->value;
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

    private function limitTo(string $scale): self
    {
        $reference = $this->reference->limitTo($scale);
        return new self($reference);
    }

    private function until(string $scale): self
    {
        $this->lowest = TimeScaleValue::createScale($scale);
        return $this;
    }

    private function setNextWith(int|float $value)
    {
        $leftValue = new TimeScaleValue($value);
        $ref = $this->reference->useValue($leftValue);
        $this->next = new self($ref, $this->lowest);
    }
}
