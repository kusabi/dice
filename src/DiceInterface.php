<?php

namespace Kusabi\Dice;

/**
 * A dice implementation should be able to give a minimum and maximum potential roll.
 *
 * A dice implementation should be able to give a random value between the minimum and maximum potential roll.
 *
 * @author Christian Harvey <hikusabi@gmail.com>
 */
interface DiceInterface
{
    /**
     * Get the smallest possible outcome of rolling this dice
     *
     * @return int
     */
    public function getMinimumRoll(): int;

    /**
     * Get the largest possible outcome of rolling this dice
     *
     * @return int
     */
    public function getMaximumRoll(): int;

    /**
     * Roll the dice and return the value
     *
     * @return int
     */
    public function getRoll(): int;
}
