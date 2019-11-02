[![Release Badge](https://img.shields.io/github/release/kusabi/dice.svg)](https://img.shields.io/github/release/kusabi/dice.svg)
[![Tag Badge](https://img.shields.io/github/tag/kusabi/dice.svg)](https://img.shields.io/github/tag/kusabi/dice.svg)
[![Coverage Badge](https://img.shields.io/codacy/coverage/052f13a29e4e4e92bc293d93b8dcc956.svg)](https://img.shields.io/codacy/grade/49f3e278271f44d9833e29a8b8080b45.svg)
[![Grade Badge](https://img.shields.io/codacy/grade/052f13a29e4e4e92bc293d93b8dcc956.svg)](https://img.shields.io/codacy/grade/49f3e278271f44d9833e29a8b8080b45.svg)
[![Issues Badge](https://img.shields.io/github/issues/kusabi/dice.svg)](https://img.shields.io/github/issues/kusabi/dice.svg)
[![Licence Badge](https://img.shields.io/github/license/kusabi/dice.svg)](https://img.shields.io/github/license/kusabi/dice.svg)
[![Code Size](https://img.shields.io/github/languages/code-size/kusabi/dice.svg)](https://img.shields.io/github/languages/code-size/kusabi/dice.svg)


A library designed to simulate the functionality of a dice set in a table top game
such as Dungeons and Dragons.

# Installation

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

# Using the library

The simplest way to use the library is by using the Dice factory class.

A simple example would be

```php
$diceFactory = new DiceFactory();

$result = $diceFactory->generateDice('5d12+4')->getRoll();
```


## Using the Dice class

RPG games need a way to simulate odds of many complexities.

To cater to this, they tend to require numerous multi-sided dice.

The common set is a D4, D6, D8, D10, D12, D20 and D100.

This library contains three Dice implementations that when used together can simulate a huge range of possibilities.

The first class is `Dice`. A `Dice` object takes a single parameter which represents the number of sides it has.

```php
$dice = new Dice(4);
$min = $dice->getMinimumRoll();
$max = $dice->getMaximumRoll();
$result = $dice->getRoll();
```

# Using the dice modifier class

The `DiceModifier` class uses the [Decorator](https://sourcemaking.com/design_patterns/decorator) pattern to augment the results of another implementation of `DiceInterface`.

It takes two arguments, the first is another object that implements `DiceInterface` and the second is an integer to augment the result by.

The example below simulates how you might represent `1D12+4`.

```php
$dice = new DiceModifier(New Dice(12), 4);
$min = $dice->getMinimumRoll();
$max = $dice->getMaximumRoll();
$result = $dice->getRoll();
```

# Using the dice group class

The `DiceGroup` can cluster multiple implementations of `DiceInterface` together, and returns the sum of results from all of them.

Because one of those instances can be a `Dice`, `DiceModifier` or even another `DiceGroup` and because this object can itself by placed into a `DiceModifier` instance, the possibilities are fairly sufficient.

The example below simulates how you might represent `5D12+4`.

```php
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

# Using the dice factory

The `DiceFactory` makes creating a dice implementation simpler.

You can pass it the common string form of a dice instead of figuring out how to build it.

```php
$diceFactory = new DiceFactory();
$dice = $diceFactory->generateDice('5d12+4');
$min = $dice->getMinimumRoll();
$max = $dice->getMaximumRoll();
$result = $dice->getRoll();
```

or more simply

```php
$diceFactory = new DiceFactory();
$result = $diceFactory->generateDice('5d12+4')->getRoll();
```

The class will throw an `/InvalidArgumentException` if it fails to parse the string so make sure you plan for that.

```php
$diceFactory = new DiceFactory();
try {
    $result = $diceFactory->generateDice('5d12+4')->getRoll();
} catch(/InvalidArgumentException $exception) {
    echo "Could not parse the string"
}
```