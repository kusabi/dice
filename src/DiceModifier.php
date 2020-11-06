<?php

namespace Kusabi\Dice;

/**
 * A dice modifier simply adds a modifier to the results of another DiceInterface
 *
 * @see DiceInterface
 */
class DiceModifier implements DiceInterface
{
    /**
     * The base dice to roll
     *
     * @var DiceInterface
     */
    protected $dice;

    /**
     * The modifier to apply to the dice roll
     *
     * @var int
     */
    protected $modifier = 0;

    /**
     * DiceModifier constructor.
     *
     * @param DiceInterface $dice
     * @param int $modifier
     */
    public function __construct(DiceInterface $dice, $modifier)
    {
        $this->setDice($dice);
        $this->setModifier($modifier);
    }

    /**
     * Convert the dice to a string
     *
     * @return string
     */
    public function __toString()
    {
        $base = (string) $this->dice;
        $modifier = $this->modifier;
        if (strpos($base, ', ') !== false) {
            $base = "({$base})";
        }
        if (preg_match('/(.*?)\+(\d+)$/', $base, $matches)) {
            $modifier = $this->modifier + $matches[2];
            $base = $matches[1];
        }
        return $base.'+'.$modifier;
    }

    /**
     * Get the dice being modified
     *
     * @return DiceInterface
     */
    public function getDice()
    {
        return $this->dice;
    }

    /**
     * Set the dice being modified
     *
     * @param DiceInterface $dice
     *
     * @return self
     */
    public function setDice(DiceInterface $dice)
    {
        $this->dice = $dice;
        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * Augments result by the modifier
     *
     * @see DiceInterface::getMaximumRoll()
     */
    public function getMaximumRoll()
    {
        return $this->getDice()->getMaximumRoll() + $this->getModifier();
    }

    /**
     * {@inheritdoc}
     *
     * Augments result by the modifier
     *
     * @see DiceInterface::getMinimumRoll()
     */
    public function getMinimumRoll()
    {
        return $this->getDice()->getMinimumRoll() + $this->getModifier();
    }

    /**
     * Get the amount to modifying results by
     *
     * @return int
     */
    public function getModifier()
    {
        return $this->modifier;
    }

    /**
     * Set the amount to modifying results by
     *
     * @param int $modifier
     *
     * @return self
     */
    public function setModifier($modifier)
    {
        $this->modifier = (int) $modifier;
        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * Augments result by the modifier
     *
     * @see DiceInterface::getRoll()
     */
    public function getRoll()
    {
        return $this->getDice()->getRoll() + $this->getModifier();
    }
}
