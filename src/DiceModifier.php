<?php

namespace Kusabi\Dice;

/**
 * A dice modifier simply adds a modifier to the results of another DiceInterface
 *
 * @author Christian Harvey <hikusabi@gmail.com>
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
    public function __construct(DiceInterface $dice, int $modifier)
    {
        $this->setDice($dice);
        $this->setModifier($modifier);
    }

    /**
     * Get the dice being modified
     *
     * @return DiceInterface
     */
    public function getDice(): DiceInterface
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
    public function setDice(DiceInterface $dice): self
    {
        $this->dice = $dice;
        return $this;
    }

    /**
     * Get the amount to modifying results by
     *
     * @return int
     */
    public function getModifier(): int
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
    public function setModifier(int $modifier): self
    {
        $this->modifier = $modifier;
        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * Augments result by the modifier
     *
     * @see DiceInterface::getMinimumRoll()
     */
    public function getMinimumRoll(): int
    {
        return $this->getDice()->getMinimumRoll() + $this->getModifier();
    }

    /**
     * {@inheritdoc}
     *
     * Augments result by the modifier
     *
     * @see DiceInterface::getMaximumRoll()
     */
    public function getMaximumRoll(): int
    {
        return $this->getDice()->getMaximumRoll() + $this->getModifier();
    }

    /**
     * {@inheritdoc}
     *
     * Augments result by the modifier
     *
     * @see DiceInterface::getRoll()
     */
    public function getRoll(): int
    {
        return $this->getDice()->getRoll() + $this->getModifier();
    }
}
