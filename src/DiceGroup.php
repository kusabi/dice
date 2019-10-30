<?php

namespace Kusabi\Dice;

use ArrayAccess;
use ArrayIterator;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;

/**
 * A dice group is simply a collection of dice.
 *
 * It can be used to represent things like 2D6
 *
 * @author Christian Harvey <hikusabi@gmail.com>
 *
 * @see DiceInterface
 */
class DiceGroup implements ArrayAccess, Countable, IteratorAggregate, DiceInterface
{
    /**
     * The dice in this group
     *
     * @var array
     */
    protected $dice;

    /**
     * DiceGroup constructor.
     *
     * @param DiceInterface ...$dice
     */
    public function __construct(DiceInterface ...$dice)
    {
        $this->setDice(...$dice);
    }

    /**
     * Get the dice in this group
     *
     * @return array
     */
    public function getDice(): array
    {
        return $this->dice;
    }

    /**
     * Set the dice in this group
     *
     * @param DiceInterface ...$dice
     *
     * @return self
     */
    public function setDice(DiceInterface ...$dice): self
    {
        $this->dice = $dice;
        return $this;
    }

    /**
     * Add dice to the group
     *
     * @param DiceInterface ...$dice
     *
     * @return self
     */
    public function addDice(DiceInterface ...$dice): self
    {
        $this->dice = array_merge($this->dice, $dice);
        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * Get the sum of minimums from the whole group
     *
     * @see DiceInterface::getRoll()
     */
    public function getMinimumRoll(): int
    {
        return array_sum(array_map(function (DiceInterface $dice) {
            return $dice->getMinimumRoll();
        }, $this->getDice()));
    }

    /**
     * {@inheritdoc}
     *
     * Get the sum of maximums from the whole group
     *
     * @see DiceInterface::getRoll()
     */
    public function getMaximumRoll(): int
    {
        return array_sum(array_map(function (DiceInterface $dice) {
            return $dice->getMaximumRoll();
        }, $this->getDice()));
    }

    /**
     * {@inheritdoc}
     *
     * Get the sum of rolls from the whole group
     *
     * @see DiceInterface::getRoll()
     */
    public function getRoll(): int
    {
        return array_sum(array_map(function (DiceInterface $dice) {
            return $dice->getRoll();
        }, $this->getDice()));
    }

    /**
     * {@inheritdoc}
     *
     * @see ArrayAccess::offsetExists()
     */
    public function offsetExists($offset)
    {
        return isset($this->dice[$offset]);
    }

    /**
     * {@inheritdoc}
     *
     * @return DiceInterface
     *
     * @see ArrayAccess::offsetGet()
     */
    public function offsetGet($offset)
    {
        return $this->dice[$offset];
    }

    /**
     * {@inheritdoc}
     *
     * @see ArrayAccess::offsetSet()
     *
     * @throws InvalidArgumentException if value does not implement DiceInterface
     */
    public function offsetSet($offset, $value)
    {
        if (!is_object($value) || !$value instanceof DiceInterface) {
            throw new InvalidArgumentException('All dice in the group must implement DiceInterface');
        }
        $this->dice[$offset] = $value;
    }

    /**
     * {@inheritdoc}
     *
     * @see ArrayAccess::offsetUnset()
     */
    public function offsetUnset($offset)
    {
        unset($this->dice[$offset]);
    }

    /**
     * {@inheritdoc}
     *
     * @see Countable::count()
     */
    public function count()
    {
        return count($this->dice);
    }

    /**
     * {@inheritdoc}
     *
     * @see IteratorAggregate::getIterator()
     */
    public function getIterator()
    {
        return new ArrayIterator($this->dice);
    }
}
