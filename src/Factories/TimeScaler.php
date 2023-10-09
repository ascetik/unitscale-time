<?php

/**
 * This is part of the UnitScale Time package.
 *
 * @package    unitscale-time
 * @category   Scale value factory
 * @license    https://opensource.org/license/mit/  MIT License
 * @copyright  Copyright (c) 2023, Vidda
 * @author     Vidda <vidda@ascetik.fr>
 */

declare(strict_types=1);

namespace Ascetik\UnitscaleTime\Factories;

use Ascetik\UnitscaleCore\Extensions\AdjustedValue;
use Ascetik\UnitscaleCore\Types\ScaleValue;
use Ascetik\UnitscaleCore\Types\ScaleValueFactory;
use Ascetik\UnitscaleCore\Utils\PrefixedCommand;
use Ascetik\UnitscaleTime\Values\TimeScaleValue;

/**
 * Build TimeScaleValue instances
 *
 * @method TimeScaleValue fromYears(int|float|null $value)
 * @method TimeScaleValue fromMonths(int|float|null $value)
 * @method TimeScaleValue fromWeeks(int|float|null $value)
 * @method TimeScaleValue fromDays(int|float|null $value)
 * @method TimeScaleValue fromHours(int|float|null $value)
 * @method TimeScaleValue fromMinutes(int|float|null $value)
 * @method TimeScaleValue fromBase(int|float|null $value)
 * @method TimeScaleValue fromSeconds(int|float|null $value)
 * @method TimeScaleValue fromMilli(int|float|null $value)
 * @method TimeScaleValue fromMicro(int|float|null $value)
 * @method TimeScaleValue fromNano(int|float|null $value)
 * @method TimeScaleValue fromPico(int|float|null $value)
 *
 * @version 1.1.0
 */
class TimeScaler extends ScaleValueFactory
{
    public static function unit(int|float $value, string $unit = ''): TimeScaleValue
    {
        return new TimeScaleValue($value);
    }

    public static function adjust(int|float $value, string $unit = ''): AdjustedValue
    {
        return self::unit($value)->adjust();
    }

    protected static function createWithCommand(PrefixedCommand $command, array $args = []): ScaleValue
    {
        $value = match (count($args)) {
            1 => $args[0],
            default => 0
        };
        return TimeScaleValue::createFromScale((float) $value, $command->name);
    }
}
