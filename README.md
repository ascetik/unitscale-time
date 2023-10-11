# unitscale-time
Convert a unit of time to another

From picoseconds to seconds, then minutes, hours, days, weeks, months and years.

## Release version 1.0.0

- Upgraded core package.

## Breaking changes

- Handling base scales

Scaler factory handles methods starting with "from" prefix.
ScaleValue is no longer able to handle base scale mutation and only uses "to" methods.

See unitscale-core package README file for more informations.

- Handling ajdustment

The previous version provided a detailed adjustment, with a chain of values displaying decomposed time value.
In this new version, the same functionnality is provided by calling *detail()* method.
The *adjust()* method now returns a Time value with its highest scale without the chain of values.

See adjustment documentation below.

## Usage

To get an instance of time value :

```php

$converter = TimeScaler::unit(3000);

```
**TimeScaler** factory returns instances of **TimeScaleValue** objects with some methods to get a result in the appropriate format.


```php

// Like its parent class, **TimeScaleValue** is Stringable.
echo $unit; // prints '3000s', the time amount concanated with its scaled unit

// but you can get the value for further calculations
echo $unit->raw(); // prints 3000, int or float value

// and get the integer value
echo $unit->integer(); // prints 3000 too as integer type

echo $unit->isInteger() ? 'int' : 'float'; // will print "int" in this case

```

Default scale is *seconds*, like the example above.

Available time scales are :
- years
- months
- weeks
- days
- hours
- minutes
- seconds (base scale)
- milli (seconds)
- micro (seconds)
- nano (seconds)
- pico (seconds)

**TimeScaler** factory provides static methods to build time values with other scales.
Just add "from" and the scale you want (camelCase) and call it with the amount as argument :

```php

echo TimeScaler::fromDays(7); // prints "7d"

```
, providing methods for scale convertion.
Use the enumerated scales above and prefix them with a *to* (camelCase) and get a new converted TimeScaleValue.

Some examples :

```php

echo TimeScaler::fromDays(7)->toWeeks(); //prints "1W"

echo TimeScaler::fromMilli(60000)->toMinutes(); //prints "1m"

echo TimeScaler::fromMinutes(2)->toMilli(); //prints "120000ms"

echo TimeScaler::unit(time())
    ->toYears()
    ->raw(); //prints the number of years from 1970 as float

```

The base scale uses seconds. All conversions use this base to compute their value.

### Time adjustment

A time value can be adjusted to its highest scale depending on its amount :

```php

echo TimeScaler::unit(3600)->adjust(); // prints '1h'

echo TimeScaler::unit(3700)->adjust(); // prints '1.028h'

```

As you can see, the decimal part of the value, limited to 3, does not reflect the number of minutes left.
You can get a complete string representation with a chain of successive time values by using *detail()* method.

Some examples :

```php

echo TimeScaler::unit(1010)->detail(); // prints "16m 50s"

echo TimeScaler::fromMilli(1010)->detail(); // prints '1s 10ms'

```

You can limit the highest scale to a chosen scale :

```php
echo TimeScaler::unit(86570)->detail();             // prints '1d 1m 10s'
echo TimeScaler::unit(86570)->detail()->asHours();  // prints '24H 1m 10s'

echo TimeScaler::fromMicro(3000000)->adjust()->asMilli(); // prints '3000ms' instead of 3s

echo TimeScaler::unit(3600)->adjust()->asYears(); // prints '1h', obviously

```

Limit the lowest scale :

```php

echo TimeScaler::unit(86570)->detail()->asHours()->untilMinutes() . PHP_EOL; // prints '24H 1m', without seconds

```

## Conclusion

The purpose of all that mess is just to display the ellapsed time of a task nicely instead of choosing an arbitrary unit... Another package that is just a little tool made by a dumby newbie.

