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
 * @method self asYears()
 * @method self asMonths()
 * @method self asWeeks()
 * @method self asDays()
 * @method self asHours()
 * @method self asMinutes()
 * @method self asSeconds()
 * @method self asBase()
 * @method self asMilli()
 * @method self asMicro()
 * @method self asNano()
 * @method self asPico()
 *
 * @version 2.0.0
 */
class AdjustedTimeValue extends AdjustedValue
{
    private TimeScaleReference $reference;

    public function __construct(TimeScaleReference $reference)
    {
        $this->reference = $reference->rounded(3);
        $this->setReference($this->reference);
    }

    public static function buildWith(ScaleValue $value): static
    {
        $reference = new TimeScaleReference($value);
        return new static($reference);
    }

}
