# unitscale-time
Convert a unit of time to another

From picoseconds to seconds,then minutes, hours, days, weeks, months and years.

## Usage

To get an instance of the time converter :

```php

$converter = TimeScaler::unit(3000);

```

Time converter uses least multiples, from pico to milliseconds.
Then it uses seconds, minutes, hours, days, weeks, months and years.

Some examples :

```php

echo TimeScaler::unit(7)
    ->fromDays()
    ->toWeeks(); //prints "1W"

echo TimeScaler::unit(60000)
    ->fromMilli()
    ->toMinutes(); //prints "1m"

echo TimeScaler::unit(2)
    ->fromMinutes()
    ->toMilli(); //prints "120000ms"

echo TimeScaler::unit(time())
    ->toYears()
    ->raw(); //prints the number of years from 1970 as float

```

The _second_ scale (s) is the base scale.
