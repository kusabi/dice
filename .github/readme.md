This library is designed to simulate the functionality of a dice set in a table top game
such as Dungeons and Dragons.

# Dice

RPG games need a way to simulate odds of many complexities.

To cater to this, they tend to require numerous multi-sided dice.

The common set is a D4, D6, D8, D10, D12, D20 and D100.

This library contains three Dice implementations that when used together can simulate a huge range of possibilities.

The first class is `Dice`. A `Dice` object takes a single parameter which represents the number of sides it has.

#### Example usage

```php
$dice = new Dice(4);
$min = $dice->getMinimumRoll();
$max = $dice->getMaximumRoll();
$result = $dice->getRoll();
```

# Dice Modifier

The `DiceModifier` class uses the [Decorator](https://sourcemaking.com/design_patterns/decorator) pattern to augment the results of another implementation of `DiceInterface`.

It takes two arguments, the first is another object that implements `DiceInterface` and the second is an integer to augment the result by.

The example below simulates how you might represent `1D12+4`.

#### Example usage

```php
$dice = new DiceModifier(New Dice(12), 4);
$min = $dice->getMinimumRoll();
$max = $dice->getMaximumRoll();
$result = $dice->getRoll();
```

# Dice Group

The `DiceGroup` can cluster multiple implementations of `DiceInterface` together, and returns the sum of results from all of them.

Because one of those instances can be a `Dice`, `DiceModifier` or even another `DiceGroup` and because this object can itself by placed into a `DiceModifier` instance, the possibilities are fairly sufficient.

The example below simulates how you might represent `5D12+4`.

#### Example usage

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