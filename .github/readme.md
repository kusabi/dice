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