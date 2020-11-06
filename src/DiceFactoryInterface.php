<?php

namespace Kusabi\Dice;

/**
 * A dice factory is responsible for creating a dice setup from a given input
 *
 * @author Christian Harvey <hikusabi@gmail.com>
 */
interface DiceFactoryInterface
{
    /**
     * Generate a Dice to roll
     *
     * @param mixed $input
     *
     * @return DiceInterface
     */
    public function generateDice($input);
}
