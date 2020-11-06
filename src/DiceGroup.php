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
 * @see DiceInterface
 */
class DiceGroup implements ArrayAccess, Countable, IteratorAggregate, DiceInterface
{
    /**
     * The dice in this group
     *
     * @var DiceInterface[]
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
     * Convert the dice to a string
     *
     * @return string
     */
    public function __toString()
    {
        $items = array_map(function (DiceInterface $dice) {
            return (string) $dice;
        }, $this->dice);

        $grouped = [];
        foreach ($items as $item) {
            foreach (explode(', ', $item) as $entry) {
                if (preg_match('/^(\d+)d(\d+)\+?(\d+)?$/', $entry, $matches)) {
                    $quantity = isset($matches[1]) ? $matches[1] : 1;
                    $sides = isset($matches[2]) ? $matches[2] : 1;
                    $modifier = isset($matches[3]) ? $matches[3] : 0;
                    if (!isset($grouped[$sides])) {
                        $grouped[$sides] = [
                            'quantity' => 0,
                            'modifier' => 0,
                            'sides' => $sides,
                        ];
                    }
                    $grouped[$sides]['quantity'] += $quantity;
                    $grouped[$sides]['modifier'] += $modifier;
                }
            }
        }

        $collection = array_map(function ($group) {
            $value = "{$group['quantity']}d{$group['sides']}";
            if ($group['modifier'] > 0) {
                $value .= "+{$group['modifier']}";
            }
            return $value;
        }, $grouped);

        return implode(', ', $collection);
    }

    /**
     * Add dice to the group
     *
     * @param DiceInterface ...$dice
     *
     * @return self
     */
    public function addDice(DiceInterface ...$dice)
    {
        $this->dice = array_merge($this->dice, $dice);
        return $this;
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
     * Get the dice in this group
     *
     * @return DiceInterface[]
     */
    public function getDice()
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
    public function setDice(DiceInterface ...$dice)
    {
        $this->dice = $dice;
        return $this;
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

    /**
     * {@inheritdoc}
     *
     * Get the sum of maximums from the whole group
     *
     * @see DiceInterface::getRoll()
     */
    public function getMaximumRoll()
    {
        return array_sum(array_map(function (DiceInterface $dice) {
            return $dice->getMaximumRoll();
        }, $this->getDice()));
    }

    /**
     * {@inheritdoc}
     *
     * Get the sum of minimums from the whole group
     *
     * @see DiceInterface::getRoll()
     */
    public function getMinimumRoll()
    {
        return array_sum(array_map(function (DiceInterface $dice) {
            return $dice->getMinimumRoll();
        }, $this->getDice()));
    }

    /**
     * {@inheritdoc}
     *
     * Get the sum of rolls from the whole group
     *
     * @see DiceInterface::getRoll()
     */
    public function getRoll()
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
     * @throws InvalidArgumentException if value does not implement DiceInterface
     *
     * @see ArrayAccess::offsetSet()
     *
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
}
