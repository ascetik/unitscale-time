<?php

namespace Ascetik\UnitscaleTime\Factories;

use Ascetik\UnitscaleCore\Extensions\AdjustedValue;
use Ascetik\UnitscaleCore\Types\ScaleValueFactory;
use Ascetik\UnitscaleTime\Values\TimeScaleValue;

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
