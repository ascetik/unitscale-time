<?php

declare(strict_types=1);

namespace Ascetik\UnitscaleTime\Tests;

use Ascetik\UnitscaleCore\Scales\CustomScale;
use Ascetik\UnitscaleTime\Factories\TimeScaleFactory;
use Ascetik\UnitscaleTime\Scales\TimeScale;
use PHPUnit\Framework\TestCase;

class TimeScaleFactoryTest extends TestCase
{
    private TimeScaleFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new TimeScaleFactory();
    }

    public function testShouldUseSecondsAsBaseScale()
    {
        $scale = $this->factory->base();
        $this->assertSame('s', $scale->unit());
        $this->assertSame(1, $scale->factor());
        $this->assertSame(1000, $scale->forward(1000));
        $this->assertSame(1000, $scale->backward(1000));
    }

    public function testShouldHandleCustomScalesUnderSeconds()
    {
        $scale = $this->factory->pico();
        $this->assertInstanceOf(CustomScale::class, $scale);
    }

    public function testShouldReturnTimeScalesSinceSeconds()
    {
        $scale = $this->factory->hours();
        $this->assertInstanceOf(TimeScale::class, $scale);
    }

    public function testMinuteScale()
    {
        $scale = $this->factory->minutes();
        $this->assertSame('m', $scale->unit());
        $this->assertSame(60, $scale->factor());
        $this->assertSame(120, $scale->forward(2));
        $this->assertSame(3, $scale->backward(180));
    }

    public function testHourScale()
    {
        $scale = $this->factory->hours();
        $this->assertSame('h', $scale->unit());
        $this->assertSame(3600, $scale->factor());
        $this->assertSame(7200, $scale->forward(2));
        $this->assertSame(1, $scale->backward(3600));
    }

    public function testDayScale()
    {
        $scale = $this->factory->days();
        $this->assertSame('d', $scale->unit());
        $this->assertSame(86400, $scale->factor());
        $this->assertSame(172800, $scale->forward(2));
        $this->assertSame(1, $scale->backward(86400));
    }

    public function testWeekScale()
    {
        $scale = $this->factory->weeks();
        $week = 86400 * 7;
        $this->assertSame('W', $scale->unit());
        $this->assertSame($week, $scale->factor());
        $this->assertSame($week * 2, $scale->forward(2));
        $this->assertSame(1, $scale->backward($week));
    }

    public function testMonthScale()
    {
        $scale = $this->factory->months();
        $month = 86400 * 30;
        $this->assertSame('M', $scale->unit());
        $this->assertSame($month, $scale->factor());
        $this->assertSame($month * 2, $scale->forward(2));
        $this->assertSame(1, $scale->backward($month));
    }

    public function testYearScale()
    {
        $scale = $this->factory->years();
        $year = 86400 * 365;
        $this->assertSame('Y', $scale->unit());
        $this->assertSame($year, $scale->factor());
        $this->assertSame($year * 2, $scale->forward(2));
        $this->assertSame(1, $scale->backward($year));
    }

    public function testMicroSecondsForward()
    {
        $scale = $this->factory->micro();
        $this->assertEquals(1, $scale->forward(1000000));
    }

    public function testNanoSecondsBackWard()
    {
        $scale = $this->factory->nano();
        $this->assertEquals(1,$scale->backward(0.000000001));
    }
}
