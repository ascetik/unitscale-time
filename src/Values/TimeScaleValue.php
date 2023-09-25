<?php

namespace Ascetik\UnitscaleTime\Values;

use Ascetik\UnitscaleCore\Extensions\AdjustedValue;
use Ascetik\UnitscaleCore\Types\ScaleFactory;
use Ascetik\UnitscaleCore\Types\ScaleValue;
use Ascetik\UnitscaleTime\Factories\TimeScaleFactory;

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
