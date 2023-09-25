<?php

/**
 * This is part of the UnitScale Time package.
 *
 * @package    unitscale-time
 * @category   Scale value
 * @license    https://opensource.org/license/mit/  MIT License
 * @copyright  Copyright (c) 2023, Vidda
 * @author     Vidda <vidda@ascetik.fr>
 */

declare(strict_types=1);

namespace Ascetik\UnitscaleTime\Values;

use Ascetik\UnitscaleCore\Extensions\AdjustedValue;
use Ascetik\UnitscaleCore\Types\ScaleFactory;
use Ascetik\UnitscaleCore\Types\ScaleValue;
use Ascetik\UnitscaleTime\Factories\TimeScaleFactory;

/**
 * Handle Time scales from pico to milliseconds,
 * then seconds (defaut unit), minutes, hours...
 * until years
 *
 * @method self fromYears()
 * @method self fromMonths()
 * @method self fromWeeks()
 * @method self fromDays()
 * @method self fromHours()
 * @method self fromMinutes()
 * @method self fromBase()
 * @method self fromSeconds()
 * @method self fromMilli()
 * @method self fromMicro()
 * @method self fromNano()
 * @method self fromPico()
 * @method self toYears()
 * @method self toMonths()
 * @method self toWeeks()
 * @method self toDays()
 * @method self toHours()
 * @method self toMinutes()
 * @method self toBase()
 * @method self toSeconds()
 * @method self toMilli()
 * @method self toMicro()
 * @method self toNano()
 * @method self toPico()
 *
 * @version 1.0.0
 */
class TimeScaleValue extends ScaleValue
{
    public static function selector(): ScaleFactory
    {
        return new TimeScaleFactory();
    }

    public function adjust(): AdjustedValue
    {
        return AdjustedValue::buildWith($this); // TODO : AdjustedTImeValue avec une limite de longueur
    }
}
