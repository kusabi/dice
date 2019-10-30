<?php

namespace Kusabi\Tests;

use Kusabi\Dice\Dice;
use Kusabi\Dice\DiceGroup;
use Kusabi\Dice\DiceInterface;
use Kusabi\Dice\DiceModifier;
use PHPUnit\Framework\TestCase;

class DiceModifierTest extends TestCase
{
    public function testInstanceOfDiceInterface()
    {
        $this->assertInstanceOf(DiceInterface::class, new DiceModifier(new Dice(6), 4));
    }

    public function testModifierCanBeSet()
    {
        $dice = new DiceModifier(new Dice(6), 4);
        $this->assertSame(10, $dice->setModifier(10)->getModifier());
    }

    public function testDiceCanBeSet()
    {
        $d = new Dice(1);
        $dice = new DiceModifier(new Dice(6), 4);
        $this->assertSame($d, $dice->setDice($d)->getDice());
    }

    public function testD4()
    {
        $dice = new DiceModifier(new Dice(4), 3);
        $this->assertEquals(4, $dice->getMinimumRoll());
        $this->assertEquals(7, $dice->getMaximumRoll());
    }

    public function testD6()
    {
        $dice = new DiceModifier(new Dice(6), 0);
        $this->assertEquals(1, $dice->getMinimumRoll());
        $this->assertEquals(6, $dice->getMaximumRoll());
    }

    public function testD8()
    {
        $dice = new DiceModifier(new Dice(8), 5);
        $this->assertEquals(6, $dice->getMinimumRoll());
        $this->assertEquals(13, $dice->getMaximumRoll());
    }

    public function testD10()
    {
        $dice = new DiceModifier(new Dice(10), 1);
        $this->assertEquals(2, $dice->getMinimumRoll());
        $this->assertEquals(11, $dice->getMaximumRoll());
    }

    public function testD12()
    {
        $dice = new DiceModifier(new Dice(12), 100);
        $this->assertEquals(101, $dice->getMinimumRoll());
        $this->assertEquals(112, $dice->getMaximumRoll());
    }

    public function testD20()
    {
        $dice = new DiceModifier(new Dice(20), 17);
        $this->assertEquals(18, $dice->getMinimumRoll());
        $this->assertEquals(37, $dice->getMaximumRoll());
    }

    public function testD100()
    {
        $dice = new DiceModifier(new Dice(100), 12);
        $this->assertEquals(13, $dice->getMinimumRoll());
        $this->assertEquals(112, $dice->getMaximumRoll());
    }

    public function testGetRollReturnsNumberBetweenMinAndMax()
    {
        $dice = new DiceModifier(new Dice(1), 2);
        for ($i = 0; $i < 10; $i++) {
            $roll = $dice->getRoll();
            $this->assertGreaterThanOrEqual(1, $roll);
            $this->assertLessThanOrEqual(3, $roll);
        }
    }

    public function testComplexTypes()
    {
        $dice = new DiceModifier(
            new DiceGroup(
                new Dice(4),
                new DiceModifier(new Dice(8), 2),
                new DiceGroup(
                    new DiceModifier(new Dice(4), 2),
                    new Dice(2)
                )
            ),
            10
        );
        $this->assertEquals(18, $dice->getMinimumRoll());
        $this->assertEquals(32, $dice->getMaximumRoll());
    }
}
