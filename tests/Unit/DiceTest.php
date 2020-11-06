<?php

namespace Kusabi\Dice\Tests\Unit;

use Kusabi\Dice\Dice;
use PHPUnit\Framework\TestCase;

class DiceTest extends TestCase
{
    public function testConstructor()
    {
        $dice = new Dice(10, 3, 5);
        $this->assertSame(10, $dice->getSides());
        $this->assertSame(3, $dice->getMultiplier());
        $this->assertSame(5, $dice->getOffset());
        $this->assertSame(8, $dice->getMinimumRoll());
        $this->assertSame(35, $dice->getMaximumRoll());
    }

    public function testConstructorWithoutMultiplier()
    {
        $dice = new Dice(10);
        $this->assertSame(10, $dice->getSides());
        $this->assertSame(1, $dice->getMultiplier());
        $this->assertSame(0, $dice->getOffset());
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(10, $dice->getMaximumRoll());
    }

    public function testConstructorWithoutOffset()
    {
        $dice = new Dice(10, 3);
        $this->assertSame(10, $dice->getSides());
        $this->assertSame(3, $dice->getMultiplier());
        $this->assertSame(0, $dice->getOffset());
        $this->assertSame(3, $dice->getMinimumRoll());
        $this->assertSame(30, $dice->getMaximumRoll());
    }

    public function testConstructorWithoutSides()
    {
        $dice = new Dice();
        $this->assertSame(6, $dice->getSides());
        $this->assertSame(1, $dice->getMultiplier());
        $this->assertSame(0, $dice->getOffset());
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(6, $dice->getMaximumRoll());
    }

    public function testGetRollReturnsNumberBetweenMinAndMax()
    {
        $dice = new Dice(6, 2, 5);
        for ($i = 0; $i < 100; $i++) {
            $roll = $dice->getRoll();
            $this->assertGreaterThanOrEqual(7, $roll);
            $this->assertLessThanOrEqual(17, $roll);
        }
    }

    public function testSetMultiplier()
    {
        $dice = new Dice();
        $this->assertSame(100, $dice->setMultiplier(100)->getMultiplier());
    }

    public function testSetMultiplierWithArray()
    {
        $dice = new Dice();
        $this->assertSame(0, $dice->setMultiplier([])->getMultiplier());
    }

    public function testSetMultiplierWithFloat()
    {
        $dice = new Dice();
        $this->assertSame(100, $dice->setMultiplier(100.6)->getMultiplier());
    }

    public function testSetMultiplierWithString()
    {
        $dice = new Dice();
        $this->assertSame(100, $dice->setMultiplier('100')->getMultiplier());
    }

    public function testSetOffset()
    {
        $dice = new Dice();
        $this->assertSame(100, $dice->setOffset(100)->getOffset());
    }

    public function testSetOffsetWithArray()
    {
        $dice = new Dice();
        $this->assertSame(0, $dice->setOffset([])->getOffset());
    }

    public function testSetOffsetWithFloat()
    {
        $dice = new Dice();
        $this->assertSame(100, $dice->setOffset(100.6)->getOffset());
    }

    public function testSetOffsetWithString()
    {
        $dice = new Dice();
        $this->assertSame(100, $dice->setOffset('100')->getOffset());
    }

    public function testSetSides()
    {
        $dice = new Dice();
        $this->assertSame(100, $dice->setSides(100)->getSides());
    }

    public function testSetSidesWithArray()
    {
        $dice = new Dice();
        $this->assertSame(0, $dice->setSides([])->getSides());
    }

    public function testSetSidesWithFloat()
    {
        $dice = new Dice();
        $this->assertSame(100, $dice->setSides(100.6)->getSides());
    }

    public function testSetSidesWithString()
    {
        $dice = new Dice();
        $this->assertSame(100, $dice->setSides('100')->getSides());
    }

    public function testToString()
    {
        $this->assertSame('1d6', (string) new Dice());
        $this->assertSame('1d10', (string) new Dice(10));
        $this->assertSame('3d20', (string) new Dice(20, 3));
        $this->assertSame('5d12+6', (string) new Dice(12, 5, 6));
    }
}
