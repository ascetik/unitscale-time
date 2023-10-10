<?php

namespace Ascetik\UnitscaleTime\Tests;

use Ascetik\UnitscaleCore\Containers\ScaleContainer;
use Ascetik\UnitscaleTime\Factories\TimeScaler;
use PHPUnit\Framework\TestCase;

class TimeScaleAdjustmentTest extends TestCase
{
    public function testSimpleSecondsAdjustment()
    {
        $value = TimeScaler::unit(60)->adjust();
        $this->assertSame('1m', (string) $value);
    }

    public function testShouldConvertScaleFromSecondsToOneMinute()
    {
        $value = TimeScaler::unit(60)->adjust();
        $this->assertEquals('1m', (string) $value);
    }

    public function testShouldConvertScaleFromSecondsToOneHour()
    {
        $value = TimeScaler::unit(3600)->adjust();
        $this->assertEquals('1h', (string) $value);
    }

    public function testShouldConvertScaleFromSecondsToMinutes()
    {
        $primitive = TimeScaler::unit(3000)->adjust();
        $this->assertEquals('50m', (string) $primitive);
    }

    public function testShouldConvertSecondsToDay()
    {
        $primitive = TimeScaler::unit(86400)->adjust();
        $this->assertSame('1d', (string) $primitive);
    }

    public function testShouldAdjustHoursToDay()
    {
        $primitive = TimeScaler::fromHours(24)->adjust();
        $this->assertSame('1d', (string) $primitive);
    }

    
}
