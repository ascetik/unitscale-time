<?php

namespace Ascetik\UnitscaleTime\Tests;

use Ascetik\UnitscaleTime\Factories\TimeScaler;
use Ascetik\UnitscaleTime\Scales\TimeScale;
use Ascetik\UnitscaleTime\Values\TimeScaleValue;
use PHPUnit\Framework\TestCase;

class TimeScaleValueTest extends TestCase
{
    public function testTimeScaleValueInstance()
    {
        $value = new TimeScaleValue(60);
        $this->assertInstanceOf(TimeScale::class, $value->getScale());
        $this->assertSame('60s', (string) $value);
    }

    public function testSameTestUsingFactory()
    {
        $value = TimeScaler::unit(60);
        $this->assertSame('60s', (string) $value);
    }

    public function testShouldHaveAMinuteScale()
    {
        $value = TimeScaler::unit(60)->fromMinutes();
        $this->assertSame('60m', (string) $value);
    }

    public function testSHouldBeConvertedToOneMinute()
    {
        $value = TimeScaler::unit(60)->toMinutes();
        $this->assertSame('1m', (string) $value);
    }

    public function testShouldConvertMilliSecondsToHours()
    {
        $ms = 1000 * 3600 * 2;
        $value = TimeScaler::unit($ms)->fromMilli()->toHours();
        $this->assertSame('2h', (string) $value);
    }

    public function testFirstReadmeDemo()
    {
        $this->assertSame(
            '1W',
            (string) TimeScaler::unit(7)
                ->fromDays()
                ->toWeeks()
        ); //prints "1W", raw() method would return *1*

    }
}
