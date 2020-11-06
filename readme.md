# PHP Dice

![Tests](https://github.com/kusabi/dice/workflows/tests/badge.svg)
[![codecov](https://codecov.io/gh/kusabi/dice/branch/main/graph/badge.svg)](https://codecov.io/gh/kusabi/dice)
[![Licence Badge](https://img.shields.io/github/license/kusabi/dice.svg)](https://img.shields.io/github/license/kusabi/dice.svg)
[![Release Badge](https://img.shields.io/github/release/kusabi/dice.svg)](https://img.shields.io/github/release/kusabi/dice.svg)
[![Tag Badge](https://img.shields.io/github/tag/kusabi/dice.svg)](https://img.shields.io/github/tag/kusabi/dice.svg)
[![Issues Badge](https://img.shields.io/github/issues/kusabi/dice.svg)](https://img.shields.io/github/issues/kusabi/dice.svg)
[![Code Size](https://img.shields.io/github/languages/code-size/kusabi/dice.svg?label=size)](https://img.shields.io/github/languages/code-size/kusabi/dice.svg)

<sup>A library designed to simulate the table-top dice for games like Dungeons and Dragons.</sup>


## Compatibility and dependencies

This library is compatible with PHP version `5.6`, `7.0`, `7.1`, `7.2`, `7.3` and `7.4`.

This library has no dependencies.

## Installation

Installation is simple using composer.

```bash
composer require kusabi/dice
```

Or simply add it to your `composer.json` file

```json
{
    "require": {
        "kusabi/dice": "^1.0"
    }
}
```

## Using the library

The simplest way to use the library is by using the Dice factory class.

A simple example would be

```php
use Kusabi\Dice\DiceFactory;

$factory = new DiceFactory();
$result = $factory->generateDice('5d12+4')->getRoll();
```


## Using the Dice class

This library contains 3 dice implementations that when used together can simulate a huge range of possibilities.

The first class is `Dice`. A `Dice` object takes a single parameter which represents the number of sides it has.

```php
use Kusabi\Dice\Dice;

$dice = new Dice(4);
$min = $dice->getMinimumRoll();
$max = $dice->getMaximumRoll();
$result = $dice->getRoll();
```

## Using the dice modifier class

The `DiceModifier` class uses the [Decorator](https://sourcemaking.com/design_patterns/decorator) pattern to augment the results of another implementation of `DiceInterface`.

It takes two arguments, the first is another object that implements `DiceInterface` and the second is an integer to augment the result by.

The example below simulates how you might represent `1D12+4`.

```php
use Kusabi\Dice\Dice;
use Kusabi\Dice\DiceModifier;

$dice = new DiceModifier(New Dice(12), 4);
$min = $dice->getMinimumRoll();
$max = $dice->getMaximumRoll();
$result = $dice->getRoll();
```

## Using the dice group class

The `DiceGroup` can cluster multiple implementations of `DiceInterface` together, and returns the sum of results from all of them.

Because one of those instances can be a `Dice`, `DiceModifier` or even another `DiceGroup` and because this object can itself by placed into a `DiceModifier` instance, the possibilities are fairly sufficient.

The example below simulates how you might represent `5D12+4`.

```php
use Kusabi\Dice\Dice;
use Kusabi\Dice\DiceModifier;
use Kusabi\Dice\DiceGroup;

$dice = new DiceModifier(
    new DiceGroup(
        New Dice(12), 
        New Dice(12), 
        New Dice(12), 
        New Dice(12), 
        New Dice(12)
    ), 4
);
$min = $dice->getMinimumRoll();
$max = $dice->getMaximumRoll();
$result = $dice->getRoll();
```

## Using the dice factory

The `DiceFactory` makes creating a dice implementation simpler.

You can pass it the common string form of a dice instead of figuring out how to build it.

```php
use Kusabi\Dice\DiceFactory;

$factory = new DiceFactory();
$dice = $factory->generateDice('5d12+4');
$min = $dice->getMinimumRoll();
$max = $dice->getMaximumRoll();
$result = $dice->getRoll();
```

or more simply

```php
use Kusabi\Dice\DiceFactory;

$factory = new DiceFactory();
$result = $factory->generateDice('5d12+4')->getRoll();
```

The class will throw an `/InvalidArgumentException` if it fails to parse the string so make sure you plan for that.

```php
use Kusabi\Dice\DiceFactory;

$factory = new DiceFactory();
try {
    $result = $factory->generateDice('5d12+4')->getRoll();
} catch(\InvalidArgumentException $exception) {
    echo "Could not parse the string";
}
```