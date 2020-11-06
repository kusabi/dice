<?php

namespace Kusabi\Dice;

/**
 * A simple implementation of a dice roll used in most table top games
 *
 * It can be used to represent things like 2D6+5
 *
 * @see DiceInterface
 */
class Dice implements DiceInterface
{
    /**
     * The multiplier
     *
     * @var int
     */
    protected $multiplier;

    /**
     * The offset
     *
     * @var int
     */
    protected $offset;

    /**
     * The number of sides
     *
     * @var int
     */
    protected $sides;

    /**
     * DiceSet constructor.
     *
     * @param int $multiplier
     * @param int $offset
     * @param int $sides
     */
    public function __construct($sides = 6, $multiplier = 1, $offset = 0)
    {
        $this->setSides($sides);
        $this->setMultiplier($multiplier);
        $this->setOffset($offset);
    }

    /**
     * Convert to a string
     *
     * @return string
     */
    public function __toString()
    {
        $result = "{$this->multiplier}d{$this->sides}";
        if ($this->offset > 0) {
            $result .= "+{$this->offset}";
        }
        return $result;
    }

    /**
     * {@inheritDoc}
     *
     * @see DiceInterface::getMaximumRoll()
     */
    public function getMaximumRoll()
    {
        return ($this->sides * $this->multiplier) + $this->offset;
    }

    /**
     * {@inheritDoc}
     *
     * @see DiceInterface::getMinimumRoll()
     */
    public function getMinimumRoll()
    {
        return $this->multiplier + $this->offset;
    }

    /**
     * Get the multiplier
     *
     * @return int
     */
    public function getMultiplier()
    {
        return $this->multiplier;
    }

    /**
     * Set the multiplier
     *
     * @param int $multiplier
     *
     * @return self
     */
    public function setMultiplier($multiplier)
    {
        $this->multiplier = (int) $multiplier;
        return $this;
    }

    /**
     * Get the offset
     *
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * Set the offset
     *
     * @param int $offset
     *
     * @return self
     */
    public function setOffset($offset)
    {
        $this->offset = (int) $offset;
        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @see DiceInterface::getRoll()
     */
    public function getRoll()
    {
        return mt_rand($this->getMinimumRoll(), $this->getMaximumRoll());
    }

    /**
     * Get the number of sides
     *
     * @return int
     */
    public function getSides()
    {
        return $this->sides;
    }

    /**
     * Set the number of sides
     *
     * @param int $sides
     *
     * @return self
     */
    public function setSides($sides)
    {
        $this->sides = (int) $sides;
        return $this;
    }
}
