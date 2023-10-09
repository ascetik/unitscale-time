# unitscale-time
Convert a unit of time to another

From picoseconds to seconds, then minutes, hours, days, weeks, months and years.

## Release version 1.0.0

- Upgraded core package.

## Breaking changes

Scaler factory handles methods starting with "from" prefix.
ScaleValue is no longer able to handle base scale mutation and only uses "to" methods.

See unitscale-core package README file for more informations.

## Usage

To get an instance of time value :

```php

$converter = TimeScaler::unit(3000);

```

Time converter uses least multiples, from pico to milliseconds.
Then it uses seconds, minutes, hours, days, weeks, months and years.
Default scale is *seconds*.

Some examples :

```php
$unit = TimeScaler::unit(10);
echo $unit; // prints '10s'
echo $unit->raw(); // prints 10

echo TimeScaler::fromDays(7)->toWeeks(); //prints "1W"

echo TimeScaler::fromMilli(60000)->toMinutes(); //prints "1m"

echo TimeScaler::fromMinutes(2)->toMilli(); //prints "120000ms"

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

echo TimeScaler::unit(3600)->adjust(); // prints '1h'

echo TimeScaler::unit(3700)->adjust(); // prints '1h 1m 40s'

```

To adjust time from another scale :

```php

echo TimeScaler::fromMilli(1010)
    ->adjust(); // prints '1s 10ms'
```

Choose the maximum scale :

```php
echo TimeScaler::adjust(86570)
    ->asHours(); // prints '24H 1m 10s'

echo TimeScaler::fromMicro(3000000)
    ->adjust()
    ->asMilli(); // prints '3000ms'


echo TimeScaler::unit(3600)
    ->adjust()
    ->asYears(); // prints '1h', obviously

```

> The purpose of all that mess is just to display a task ellapsed time nicely... Just like always, this package is just a little tool for a dumby newbie.

