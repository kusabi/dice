<?php

namespace Kusabi\Dice;

use InvalidArgumentException;

/**
 * A factory capable of creating a dice setup from a standard Dungeons and Dragons textual representation of dice
 *
 * @see DiceFactoryInterface
 */
class DiceFactory
{
    /**
     * Generate a new Dice implementation from a string
     * The format expected is the DnD5e standard. (4d12+7)
     *
     * @param string $input
     *
     * @throws InvalidArgumentException if input could not be parsed properly
     *
     * @return DiceInterface
     */
    public static function createFromString($input)
    {
        // Valid string match?
        if (preg_match('/^([0-9]+)?d([0-9]+) ?\+? ?([0-9]+)?$/', $input, $matches)) {
            // Get the multiplier
            $multiplier = isset($matches[1]) ? $matches[1] : 1;
            $multiplier = (int) ($multiplier !== '' ? $multiplier : 1);

            // Multiplier too small?
            if ($multiplier < 1) {
                throw new InvalidArgumentException('The multiplier cannot be less than 1');
            }

            // Get the number of sides
            $sides = isset($matches[2]) ? $matches[2] : 0;
            $sides = (int) ($sides !== '' ? $sides : 0);

            // Too few sides?
            if ($sides < 1) {
                throw new InvalidArgumentException('A dice cannot have less than 1 sides');
            }

            // Get the size of the modifier
            $modifier = isset($matches[3]) ? $matches[3] : 0;
            $modifier = (int) ($modifier !== '' ? $modifier : 0);

            // generate the dice setup from the parts
            return static::createFromValues($multiplier, $sides, $modifier);
        }

        // Throw an exception
        throw new InvalidArgumentException('Could not parse the string to a dice setup');
    }

    /**
     * Generate a new Dice implementation from the parts of a string format
     *
     * @param int $multiplier
     * @param int $sides
     * @param int $modifier
     *
     * @return DiceInterface
     */
    public static function createFromValues($multiplier, $sides, $modifier)
    {
        // Generate the base dice
        $base = new SingleDice($sides);

        // Add a multiplier?
        if ($multiplier > 1) {
            $group = [];
            for ($i = 0; $i < $multiplier; $i++) {
                $group[] = clone $base;
            }
            $base = new DiceGroup(...$group);
        }

        // Add a modifier?
        if ($modifier !== 0) {
            $base = new DiceModifier($base, $modifier);
        }

        // Return the Dice
        return $base;
    }
}
