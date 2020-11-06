<?php

namespace Kusabi\Dice\Tests\Unit;

use InvalidArgumentException;
use Kusabi\Dice\Dice;
use Kusabi\Dice\DiceGroup;
use Kusabi\Dice\DiceInterface;
use Kusabi\Dice\DiceModifier;
use PHPUnit\Framework\TestCase;

class DiceGroupTest extends TestCase
{
    public function testInstanceOfDiceInterface()
    {
        $this->assertInstanceOf(DiceInterface::class, new DiceGroup(new Dice(6), new Dice(6)));
    }

    public function testSetDice()
    {
        $dice = new DiceGroup(
            new Dice(4),
            new Dice(6)
        );
        $dice->setDice(new Dice(4));
        $this->assertCount(1, $dice->getDice());
        $this->assertCount(1, $dice);
    }

    public function testAddDice()
    {
        $dice = new DiceGroup(
            new Dice(4),
            new Dice(6)
        );
        $dice->addDice(new Dice(4));
        $this->assertCount(3, $dice->getDice());
        $this->assertCount(3, $dice);
    }

    public function testUnset()
    {
        $dice = new DiceGroup(
            new Dice(4),
            new Dice(6)
        );
        unset($dice[1]);
        $this->assertCount(1, $dice->getDice());
        $this->assertCount(1, $dice);
    }

    public function testIsset()
    {
        $dice = new DiceGroup(
            new Dice(4),
            new Dice(6)
        );
        $this->assertTrue(isset($dice[0]));
        $this->assertFalse(isset($dice[2]));
    }

    public function testArrayGet()
    {
        $dice = new DiceGroup(
            new Dice(4),
            new Dice(6)
        );
        $this->assertInstanceOf(Dice::class, $dice[0]);
    }

    public function testArraySet()
    {
        $dice = new DiceGroup(
            new Dice(4),
            new Dice(6)
        );
        $dice[2] = new Dice(2);
        $this->assertCount(3, $dice->getDice());
        $this->assertCount(3, $dice);
    }

    public function testArraySetThrowsExceptionWhenNotDiceInterface()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('All dice in the group must implement DiceInterface');
        $dice = new DiceGroup(new Dice(4));
        $dice[2] = 'test';
    }

    public function testDiceCanBeIteratedThrough()
    {
        $dice = new DiceGroup(
            new Dice(4),
            new Dice(6)
        );
        foreach ($dice as $die) {
            $this->assertInstanceOf(DiceInterface::class, $die);
        }
    }

    public function testD4()
    {
        $dice = new DiceGroup(new Dice(4), new Dice(4));
        $this->assertEquals(2, $dice->getMinimumRoll());
        $this->assertEquals(8, $dice->getMaximumRoll());
    }

    public function testD6()
    {
        $dice = new DiceGroup(new Dice(6), new Dice(6), new Dice(6));
        $this->assertEquals(3, $dice->getMinimumRoll());
        $this->assertEquals(18, $dice->getMaximumRoll());
    }

    public function testD20()
    {
        $dice = new DiceGroup(new Dice(20), new Dice(20));
        $this->assertEquals(2, $dice->getMinimumRoll());
        $this->assertEquals(40, $dice->getMaximumRoll());
    }

    public function testGetRollReturnsNumberBetweenMinAndMax()
    {
        $dice = new DiceGroup(new Dice(2), new Dice(3));
        for ($i = 0; $i < 10; $i++) {
            $roll = $dice->getRoll();
            $this->assertGreaterThanOrEqual(1, $roll);
            $this->assertLessThanOrEqual(5, $roll);
        }
    }

    public function testMixedSides()
    {
        $dice = new DiceGroup(new Dice(4), new Dice(6), new Dice(8));
        $this->assertEquals(3, $dice->getMinimumRoll());
        $this->assertEquals(18, $dice->getMaximumRoll());
    }

    public function testComplexTypes()
    {
        $dice = new DiceGroup(
            new Dice(4),
            new DiceModifier(new Dice(6), 10),
            new DiceGroup(
                new Dice(4),
                new DiceModifier(new Dice(8), 5)
            )
        );
        $this->assertEquals(19, $dice->getMinimumRoll());
        $this->assertEquals(37, $dice->getMaximumRoll());
    }
}
