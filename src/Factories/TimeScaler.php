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
use Ascetik\UnitscaleCore\Types\ScaleValueFactory;
use Ascetik\UnitscaleTime\Values\TimeScaleValue;

/**
 * Build TimeScaleValue instances
 *
 * @version 1.0.0
 */
class TimeScaler implements ScaleValueFactory
{
    public static function unit(int|float $value, string $unit = ''): TimeScaleValue
    {
        return new TimeScaleValue($value);
    }

    public static function adjust(int|float $value, string $unit = ''): AdjustedValue
    {
        return self::unit($value)->adjust();
    }
}
