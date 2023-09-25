<?php

namespace Ascetik\UnitscaleTime\Tests;

use Ascetik\UnitscaleTime\Scales\SecondScale;
use PHPUnit\Framework\TestCase;

class TimeScaleTest extends TestCase
{
    public function testSecondScaleShouldNotAlterValue()
    {
        $scale = new SecondScale();
        $this->assertSame('s',$scale->unit());
    }
}
