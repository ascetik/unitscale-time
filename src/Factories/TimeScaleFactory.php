<?php

namespace Ascetik\UnitscaleTime\Factories;

use Ascetik\UnitscaleCore\Scales\CustomScale;
use Ascetik\UnitscaleCore\Types\Scale;
use Ascetik\UnitscaleCore\Types\ScaleFactory;
use Ascetik\UnitscaleTime\Scales\TimeScale;

class TimeScaleFactory implements ScaleFactory
{
    public function years()
    {
        return new TimeScale(86400 * 365, 'Y');
    }

    public function months()
    {
        return new TimeScale(86400 * 30, 'M');
    }

    public function weeks()
    {
        return new TimeScale(86400 * 7, 'W');
    }

    public function days()
    {
        return new TimeScale(86400, 'd');
    }

    public function hours()
    {
        return new TimeScale(3600, 'h');
    }

    public function minutes()
    {
        return new TimeScale(60, 'm');
    }

    public function base(): Scale
    {
        return new TimeScale(1, 's');
    }

    public function seconds()
    {
        return $this->base();
    }

    public function milli()
    {
        return new CustomScale(-3, 'ms');
    }

    public function micro()
    {
        return new CustomScale(-6, 'μs');
    }

    public function nano()
    {
        return new CustomScale(-9, 'ns');
    }

    public function pico()
    {
        return new CustomScale(-12, 'ps');
    }
}
