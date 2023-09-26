# unitscale-time
Convert a unit of time to another

From picoseconds to seconds,then minutes, hours, days, weeks, months and years.

## Release version 0.1.0

- Time value adjustment : Convert a time value to a chain of values
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

The base scale uses seconds. All conversions use this base to compute their value.

### Time adjustment

The adjustment of a time value is a little different.
The string representation of the instance displays a complete chain of time values.
The greatest time value is instanciated with the integer part of its presumed amount
and builds a littler one with the decimal part of this amount, building another one and so on
until the original amount is entirely consumed.

Some examples :

```php

echo TimeScaler::adjust(3600); // prints '1h'

// or

echo TimeScaler::unit(3600)->adjust(); // same result

echo TimeScaler::adjust(3700); // prints '1h 1m 40s'

```

To adjust time from another scale :

```php

echo TimeScaler::unit(1010)
    ->fromMilli()
    ->adjust(); // prints '1s 10ms'
```

Choose the maximum scale :

```php
echo TimeScaler::adjust(86570)
    ->toHours(); // prints '24H 1m 10s'

echo TimeScaler::unit(3000000)
    ->fromMicro()
    ->adjust()
    ->toMilli(); // prints '3000ms'


echo TimeScaler::adjust(3600)
    ->toYears(); // prints '1h', obviously

```

> The purpose of all that mess is just to display a task ellapsed time nicely... Just like always, this package is just a little tool for a dumby newbie.

