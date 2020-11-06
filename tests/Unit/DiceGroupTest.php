<?php

namespace Kusabi\Dice\Tests\Unit;

use InvalidArgumentException;
use Kusabi\Dice\DiceGroup;
use Kusabi\Dice\DiceInterface;
use Kusabi\Dice\DiceModifier;
use Kusabi\Dice\SingleDice;
use PHPUnit\Framework\TestCase;

class DiceGroupTest extends TestCase
{
    public function testAddDice()
    {
        $dice = new DiceGroup(
            new SingleDice(4),
            new SingleDice(6)
        );
        $this->assertCount(3, $dice->addDice(new SingleDice(4))->getDice());
        $this->assertCount(4, $dice->addDice(new SingleDice(4)));
    }

    public function testArrayCountable()
    {
        $dice = new DiceGroup(
            new SingleDice(4),
            new SingleDice(6)
        );
        $this->assertCount(2, $dice);
    }

    public function testArrayGet()
    {
        $dice = new DiceGroup(
            new SingleDice(4),
            new SingleDice(6)
        );
        $this->assertInstanceOf(SingleDice::class, $dice[0]);
    }

    public function testArrayIsset()
    {
        $dice = new DiceGroup(
            new SingleDice(4),
            new SingleDice(6)
        );
        $this->assertTrue(isset($dice[0]));
        $this->assertFalse(isset($dice[2]));
    }

    public function testArrayIterable()
    {
        $dice = new DiceGroup(
            new SingleDice(4),
            new SingleDice(6)
        );
        foreach ($dice as $die) {
            $this->assertInstanceOf(DiceInterface::class, $die);
        }
    }

    public function testArraySet()
    {
        $dice = new DiceGroup(
            new SingleDice(4),
            new SingleDice(6)
        );
        $dice[2] = new SingleDice(2);
        $this->assertCount(3, $dice->getDice());
        $this->assertCount(3, $dice);
    }

    public function testArraySetThrowsExceptionWhenNotDiceInterface()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('All dice in the group must implement DiceInterface');
        $dice = new DiceGroup(new SingleDice(4));
        $dice[2] = 'test';
    }

    public function testComplexTypes()
    {
        $dice = new DiceGroup(
            new SingleDice(4),
            new DiceModifier(new SingleDice(6), 10),
            new DiceGroup(
                new SingleDice(4),
                new DiceModifier(new SingleDice(8), 5)
            )
        );
        $this->assertEquals(19, $dice->getMinimumRoll());
        $this->assertEquals(37, $dice->getMaximumRoll());
    }

    public function testDiceInterface()
    {
        $this->assertInstanceOf(DiceInterface::class, new DiceGroup(new SingleDice(6), new SingleDice(6)));
    }

    public function testGetRollReturnsNumberBetweenMinAndMax()
    {
        $dice = new DiceGroup(new SingleDice(2), new SingleDice(3));
        for ($i = 0; $i < 10; $i++) {
            $roll = $dice->getRoll();
            $this->assertGreaterThanOrEqual(1, $roll);
            $this->assertLessThanOrEqual(5, $roll);
        }
    }

    public function testMixedSides()
    {
        $dice = new DiceGroup(new SingleDice(4), new SingleDice(6), new SingleDice(8));
        $this->assertEquals(3, $dice->getMinimumRoll());
        $this->assertEquals(18, $dice->getMaximumRoll());
    }

    public function testSetDice()
    {
        $dice = new DiceGroup(
            new SingleDice(4),
            new SingleDice(6)
        );
        $dice->setDice(new SingleDice(4));
        $this->assertCount(1, $dice->getDice());
        $this->assertCount(1, $dice);
    }

    public function testToString()
    {
        $this->assertSame('1d6', (string) new DiceGroup(new SingleDice(6)));
        $this->assertSame('2d6', (string) new DiceGroup(new SingleDice(6), new SingleDice(6)));
        $this->assertSame('3d6', (string) new DiceGroup(new SingleDice(6), new SingleDice(6), new SingleDice(6)));
        $this->assertSame('2d6, 1d3', (string) new DiceGroup(new SingleDice(6), new SingleDice(3), new SingleDice(6)));
        $this->assertSame('1d6+5', (string) new DiceGroup(new DiceModifier(new SingleDice(6), 5)));
        $this->assertSame('2d6+5', (string) new DiceGroup(new DiceModifier(new SingleDice(6), 5), new SingleDice(6)));
        $this->assertSame('2d6+10', (string) new DiceGroup(new DiceModifier(new SingleDice(6), 5), new DiceModifier(new SingleDice(6), 5)));
        $this->assertSame('1d6+5, 1d5+5', (string) new DiceGroup(new DiceModifier(new SingleDice(6), 5), new DiceModifier(new SingleDice(5), 5)));
    }

    public function testUnset()
    {
        $dice = new DiceGroup(
            new SingleDice(4),
            new SingleDice(6)
        );
        unset($dice[1]);
        $this->assertCount(1, $dice->getDice());
        $this->assertCount(1, $dice);
    }
}
