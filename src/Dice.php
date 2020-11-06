<?php

namespace Kusabi\Dice;

/**
 * A regular n-sided die.
 *
 * The number of sides can be set and the range will always be 1 to n
 *
 * @author Christian Harvey <hikusabi@gmail.com>
 *
 * @see DiceInterface
 */
class Dice implements DiceInterface
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
        $this->sides = $sides;
        return $this;
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
     * @see DiceInterface::getMaximumRoll()
     */
    public function getMaximumRoll()
    {
        return $this->getSides();
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
}
