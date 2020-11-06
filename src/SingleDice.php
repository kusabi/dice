<?php

namespace Kusabi\Dice;

/**
 * A regular n-sided die.
 *
 * The number of sides can be set and the range will always be 1 to n
 *
 * @see DiceInterface
 */
class SingleDice implements DiceInterface
{
    /**
     * The number of sides for this dice
     *
     * @var int
     */
    protected $sides = 1;

    /**
     * Dice constructor.
     *
     * @param int $sides
     */
    public function __construct($sides)
    {
        $this->setSides($sides);
    }

    /**
     * Convert the dice to a string
     *
     * @return string
     */
    public function __toString()
    {
        return '1d'.$this->sides;
    }

    /**
     * {@inheritdoc}
     *
     * @see DiceInterface::getMaximumRoll()
     */
    public function getMaximumRoll()
    {
        return $this->getSides();
    }

    /**
     * {@inheritdoc}
     *
     * @see DiceInterface::getMinimumRoll()
     */
    public function getMinimumRoll()
    {
        return 1;
    }

    /**
     * {@inheritdoc}
     *
     * @see DiceInterface::getRoll()
     */
    public function getRoll()
    {
        return mt_rand($this->getMinimumRoll(), $this->getMaximumRoll());
    }

    /**
     * Get the number of sides for this dice
     *
     * @return int
     */
    public function getSides()
    {
        return $this->sides;
    }

    /**
     * Set the number of sides for this dice
     *
     * @param int $sides
     *
     * @return self
     */
    public function setSides($sides)
    {
        $this->sides = max((int) $sides, 1);
        return $this;
    }
}
