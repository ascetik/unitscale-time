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

    public function testShouldAdjustAndDetailHoursToDaysAndHour()
    {
        $primitive = TimeScaler::fromHours(25);
        $detailed = $primitive->detail();
        $raw = round($primitive->adjust()->raw(), 3);
        $this->assertSame('1d 1h', (string) $detailed);
        $this->assertSame(1.042, $raw);
    }

    public function testShouldDetailDaysToWeeks()
    {
        $primitive = TimeScaler::fromDays(8)->detail();
        $this->assertSame('1W 1d', (string) $primitive);
    }

    public function testShouldDetailFromNanoToSecondsWithSomeScalesLeft()
    {
        $primitive = TimeScaler::fromNano(1010010000)->detail();
        $this->assertSame('1s 10ms 10μs', (string) $primitive);
    }


    public function testShouldDetailHundredMicroSeconds()
    {
        $primitive = TimeScaler::unit(0.0001)->detail();
        $this->assertSame('100μs', (string) $primitive);
    }


    public function testShouldLimitReductionToMinutes()
    {
        $seconds = TimeScaler::unit(3650)->detail()->asMinutes();
        $this->assertSame('60m 50s', (string) $seconds);
    }

    public function testShouldIllustrateFirstReadmeExample()
    {
        $value = TimeScaler::unit(3700)->detail();
        $this->assertSame('1h 1m 40s', (string) $value);
    }

    public function testShouldIllustrateReadmeExampleTwoA()
    {
        $value = TimeScaler::fromMilli(1010)
            ->detail();
        $this->assertSame('1s 10ms', (string) $value);
    }

    public function testShouldIllustrateReadmeExampleTwoB()
    {
        $value = TimeScaler::fromMicro(3000000)
            ->detail()
            ->asMilli();
        $this->assertSame('3000ms', (string) $value);
    }

    public function testShouldIllustrateReadmeExampleTwoC()
    {
        $value = TimeScaler::unit(86570)->detail();
        $this->assertIsFloat($value->raw());
        $this->assertSame('1d 2m 50s', (string) $value);
        $hours = $value->asHours();
        $this->assertSame('24h 2m 50s', (string) $hours);
    }

    public function testShouldIllustrateReadmeExampleTwoD()
    {
        $value = TimeScaler::unit(3600)->detail()->asYears();
        $this->assertSame('1h', (string) $value);
    }
}
