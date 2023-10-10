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
use Ascetik\UnitscaleCore\Traits\UseHighestValue;
use Ascetik\UnitscaleCore\Types\ScaleValue;
use Ascetik\UnitscaleTime\DTO\TimeScaleReference;

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
 * @method static asYears()
 * @method static asMonths()
 * @method static asWeeks()
 * @method static asDays()
 * @method static asHours()
 * @method static astoMinutes()
 * @method static asSeconds()
 * @method static asBase()
 * @method static asMilli()
 * @method static asMicro()
 * @method static asNano()
 * @method static asPico()
 *
 * @version 2.0.0
 */
class AdjustedTimeValue extends AdjustedValue
{
    use UseHighestValue;

    public function __construct(protected TimeScaleReference $reference)
    {
        $this->setReference($reference);
    }

    public static function buildWith(ScaleValue $value): static
    {
        $reference = new TimeScaleReference($value);
        return new static($reference);
    }
}
