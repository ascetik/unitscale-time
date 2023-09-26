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

 declare(strict_types=1);

namespace Ascetik\UnitscaleTime\Extensions;

use Ascetik\UnitscaleCore\Extensions\AdjustedValue;
use Ascetik\UnitscaleCore\Parsers\ScaleCommandInterpreter;
use Ascetik\UnitscaleCore\Traits\UseHighestValue;
use Ascetik\UnitscaleCore\Types\ScaleValue;
use Ascetik\UnitscaleTime\DTO\TimeScaleReference;
use Ascetik\UnitscaleTime\Values\TimeScaleValue;
use BadMethodCallException;

/**
 * Handle TimeScaleValue adjustment :
 * When adjusting a time value, all values
 * use only the integer part of the
 * adjusted amount.
 * The rest is recalculated to build
 * another time value with adapted scale.
 * AdjustedTimeValue registers this new Time
 * Value as its next element.
 * Like so, the string representation
 * of the time value is completely displayed
 *
 * @method static toYears()
 * @method static toMonths()
 * @method static toWeeks()
 * @method static toDays()
 * @method static toHours()
 * @method static totoMinutes()
 * @method static toSeconds()
 * @method static toBase()
 * @method static toMilli()
 * @method static toMicro()
 * @method static toNano()
 * @method static toPico()
 *
 * @version 1.0.0
 */
class AdjustedTimeValue extends AdjustedValue
{
    use UseHighestValue;

    private ?self $next = null;

    public function __construct(private TimeScaleReference $reference)
    {
        $this->setReference($reference);
    }

    public function __call($name, $arguments): static
    {
        $parser = ScaleCommandInterpreter::parse($name);
        $reference = match ($parser->command->name) {
            'FROM' => $this->reference->until($parser->action),
            'TO' => $this->reference->limitTo($parser->action),
            default=> throw new BadMethodCallException('Method '.$name.' not implemented')
        };
        return new self($reference);
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
    
    public static function buildWith(ScaleValue $value): static
    {
        $reference = new TimeScaleReference($value);
        return new self($reference);
    }

    private function setNextWith(int|float $value)
    {
        $leftValue = new TimeScaleValue($value);
        $this->next = new static($this->reference->useValue($leftValue));
    }
}
