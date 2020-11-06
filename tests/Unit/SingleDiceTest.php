<?php

namespace Kusabi\Dice\Tests\Unit;

use Kusabi\Dice\DiceInterface;
use Kusabi\Dice\SingleDice;
use PHPUnit\Framework\TestCase;

class SingleDiceTest extends TestCase
{
    public function testConstructor()
    {
        $dice = new SingleDice(10);
        $this->assertSame(10, $dice->getSides());
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(10, $dice->getMaximumRoll());
    }

    public function testConstructorWithArray()
    {
        $dice = new SingleDice([]);
        $this->assertSame(1, $dice->getSides());
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(1, $dice->getMaximumRoll());
    }

    public function testConstructorWithFloat()
    {
        $dice = new SingleDice(10.5);
        $this->assertSame(10, $dice->getSides());
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(10, $dice->getMaximumRoll());
    }

    public function testConstructorWithString()
    {
        $dice = new SingleDice('10');
        $this->assertSame(10, $dice->getSides());
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(10, $dice->getMaximumRoll());
    }

    public function testDiceInterface()
    {
        $this->assertInstanceOf(DiceInterface::class, new SingleDice(6));
    }

    public function testGetRollReturnsNumberBetweenMinAndMax()
    {
        $dice = new SingleDice(6);
        for ($i = 0; $i < 10; $i++) {
            $roll = $dice->getRoll();
            $this->assertGreaterThanOrEqual(1, $roll);
            $this->assertLessThanOrEqual(6, $roll);
        }
    }

    public function testSetSides()
    {
        $dice = new SingleDice(6);
        $dice->setSides(10);
        $this->assertSame(10, $dice->getSides());
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(10, $dice->getMaximumRoll());
    }

    public function testSetSidesIsChainable()
    {
        $dice = new SingleDice(1);
        $this->assertSame(3, $dice->setSides(3)->getSides());
    }

    public function testSetSidesWithArray()
    {
        $dice = new SingleDice(6);
        $dice->setSides([]);
        $this->assertSame(1, $dice->getSides());
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(1, $dice->getMaximumRoll());
    }

    public function testSetSidesWithFloat()
    {
        $dice = new SingleDice(6);
        $dice->setSides(10.5);
        $this->assertSame(10, $dice->getSides());
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(10, $dice->getMaximumRoll());
    }

    public function testSetSidesWithString()
    {
        $dice = new SingleDice(6);
        $dice->setSides('10');
        $this->assertSame(10, $dice->getSides());
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(10, $dice->getMaximumRoll());
    }

    public function testToString()
    {
        $this->assertSame('1d6', (string) new SingleDice(6));
        $this->assertSame('1d8', (string) new SingleDice(8));
        $this->assertSame('1d10', (string) new SingleDice(10));
        $this->assertSame('1d12', (string) new SingleDice(12));
        $this->assertSame('1d20', (string) new SingleDice(20));
        $this->assertSame('1d100', (string) new SingleDice(100));
    }
}
