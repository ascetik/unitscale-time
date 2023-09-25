<?php

/**
 * This is part of the UnitScale package.
 *
 * @package    UnitScale
 * @category   Time Scale
 * @license    https://opensource.org/license/mit/  MIT License
 * @copyright  Copyright (c) 2023, Vidda
 * @author     Vidda <vidda@ascetik.fr>
 */

declare(strict_types=1);

namespace Ascetik\UnitscaleTime\Scales;

use Ascetik\UnitscaleTime\Types\TimeScale;

/**
 * Handle Seconds
 *
 * @version 1.0.0
 */
class SecondScale extends TimeScale
{
    public function __construct()
    {
        parent::__construct(1, 's');
    }
}
