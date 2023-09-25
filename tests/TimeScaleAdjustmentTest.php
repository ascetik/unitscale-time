<?php

namespace Ascetik\UnitscaleTime\Tests;

use Ascetik\UnitscaleTime\Factories\TimeScaler;
use PHPUnit\Framework\TestCase;

class TimeScaleAdjustmentTest extends TestCase
{
    public function testSimpleSecondsAdjustment()
    {
        $value = TimeScaler::adjust(60);
        $this->assertSame('1m', (string)$value);
    }

    
}
