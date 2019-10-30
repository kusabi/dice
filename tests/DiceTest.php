<?php

namespace Kusabi\Tests;

use Kusabi\Dice\Dice;
use Kusabi\Dice\DiceInterface;
use PHPUnit\Framework\TestCase;

class DiceTest extends TestCase
{
    public function testInstanceOfDiceInterface()
    {
        $this->assertInstanceOf(DiceInterface::class, new Dice(6));
    }

    public function testSidesCanBeSet()
    {
        $dice = new Dice(6);
        $this->assertSame(13, $dice->setSides(13)->getSides());
    }

    public function testD4()
    {
        $dice = new Dice(4);
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(4, $dice->getMaximumRoll());
    }

    public function testD6()
    {
        $dice = new Dice(6);
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(6, $dice->getMaximumRoll());
    }

    public function testD8()
    {
        $dice = new Dice(8);
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(8, $dice->getMaximumRoll());
    }

    public function testD10()
    {
        $dice = new Dice(10);
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(10, $dice->getMaximumRoll());
    }

    public function testD12()
    {
        $dice = new Dice(12);
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(12, $dice->getMaximumRoll());
    }

    public function testD20()
    {
        $dice = new Dice(20);
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(20, $dice->getMaximumRoll());
    }

    public function testD100()
    {
        $dice = new Dice(100);
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(100, $dice->getMaximumRoll());
    }

    public function testGetRollReturnsNumberBetweenMinAndMax()
    {
        $dice = new Dice(6);
        for ($i = 0; $i < 10; $i++) {
            $roll = $dice->getRoll();
            $this->assertGreaterThanOrEqual(1, $roll);
            $this->assertLessThanOrEqual(6, $roll);
        }
    }
}
