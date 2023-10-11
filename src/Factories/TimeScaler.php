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

use Ascetik\UnitscaleCore\Types\ScaleValue;
use Ascetik\UnitscaleCore\Types\ScaleValueFactory;
use Ascetik\UnitscaleCore\Utils\PrefixedCommand;
use Ascetik\UnitscaleTime\Values\TimeScaleValue;

/**
 * Build TimeScaleValue instances
 *
 * @method static TimeScaleValue fromYears(int|float|null $value)
 * @method static TimeScaleValue fromMonths(int|float|null $value)
 * @method static TimeScaleValue fromWeeks(int|float|null $value)
 * @method static TimeScaleValue fromDays(int|float|null $value)
 * @method static TimeScaleValue fromHours(int|float|null $value)
 * @method static TimeScaleValue fromMinutes(int|float|null $value)
 * @method static TimeScaleValue fromBase(int|float|null $value)
 * @method static TimeScaleValue fromSeconds(int|float|null $value)
 * @method static TimeScaleValue fromMilli(int|float|null $value)
 * @method static TimeScaleValue fromMicro(int|float|null $value)
 * @method static TimeScaleValue fromNano(int|float|null $value)
 * @method static TimeScaleValue fromPico(int|float|null $value)
 *
 * @version 2.0.0
 */
class TimeScaler extends ScaleValueFactory
{
    public static function unit(int|float $value, string $unit = ''): TimeScaleValue
    {
        return new TimeScaleValue($value);
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
