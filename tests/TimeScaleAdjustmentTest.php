<?php

namespace Ascetik\UnitscaleTime\Tests;

use Ascetik\UnitscaleCore\Containers\ScaleContainer;
use Ascetik\UnitscaleTime\Factories\TimeScaler;
use PHPUnit\Framework\TestCase;

class TimeScaleAdjustmentTest extends TestCase
{
    public function testSimpleSecondsAdjustment()
    {
        $value = TimeScaler::adjust(60);
        $this->assertSame('1m', (string)$value);
    }

    public function testShouldConvertScaleFromSecondsToOneMinute()
    {
        $value = TimeScaler::adjust(60);
        $this->assertEquals('1m', (string) $value);
    }

    public function testShouldConvertScaleFromSecondsToOneHour()
    {
        $value = TimeScaler::adjust(3600);
        $this->assertEquals('1h', (string) $value);
    }

    public function testShouldConvertScaleFromSecondsToMinutes()
    {
        $primitive = TimeScaler::adjust(3000);
        $this->assertEquals('50m', (string) $primitive);
    }

    public function testShouldConvertSecondsToDay()
    {
        $primitive = TimeScaler::adjust(86400);
        $this->assertSame('1d', (string) $primitive);
    }

    public function testTimeReductionFromHoursToDay()
    {
        $primitive = TimeScaler::fromHours(24)->adjust();
        $this->assertSame('1d', (string) $primitive);
    }

    public function testShouldConvertHoursToDaysAndHour()
    {
        $primitive = TimeScaler::fromHours(25)->adjust();
        $this->assertSame('1d 1h', (string) $primitive);
    }

    public function testShouldConvertDaysToWeeks()
    {
        $primitive = TimeScaler::fromDays(8)->adjust();
        $this->assertSame('1W 1d', (string) $primitive);
    }

    public function testShouldConvertFromNanoToSecondsWithSomeScalesLeft()
    {
        $primitive = TimeScaler::fromNano(1010010000)->adjust();
        $this->assertSame('1s 10ms 10μs', (string) $primitive);
    }


    public function testShouldGiveHundredMicroSeconds()
    {
        $primitive = TimeScaler::adjust(0.0001);
        $this->assertSame('100μs', (string) $primitive);
    }


    public function testShouldLimitReductionToMinutes()
    {
        $seconds = TimeScaler::unit(3650)->adjust()->asMinutes();
        $this->assertSame('60m 50s', (string) $seconds);
    }

    public function testShouldIllustrateFirstReadmeExample()
    {
        $value = TimeScaler::unit(3700)->adjust();
        $this->assertSame('1h 1m 40s', (string) $value);
    }

    public function testShouldIllustrateReadmeExampleTwoA()
    {
        $value = TimeScaler::fromMilli(1010)
            ->adjust();
        $this->assertSame('1s 10ms', (string) $value);
    }

    public function testShouldIllustrateReadmeExampleTwoB()
    {
        $value = TimeScaler::fromMicro(3000000)
            ->adjust()
            ->asMilli();
        $this->assertSame('3000ms', (string) $value);
    }

    public function testShouldIllustrateReadmeExampleTwoC()
    {
        $value = TimeScaler::unit(86570)->adjust();
        $this->assertIsFloat($value->raw());
        $this->assertSame('1d 2m 50s', (string) $value);
        $hours = $value->asHours();
        $this->assertSame('24h 2m 50s', (string) $hours);
    }

    public function testShouldIllustrateReadmeExampleTwoD()
    {
        $value = TimeScaler::unit(3600)->adjust()->asYears();
        $this->assertSame('1h', (string) $value);
    }
}
