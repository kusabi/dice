<?php

namespace Kusabi\Dice\Tests\Unit;

use Kusabi\Dice\DiceGroup;
use Kusabi\Dice\DiceInterface;
use Kusabi\Dice\DiceModifier;
use Kusabi\Dice\SingleDice;
use PHPUnit\Framework\TestCase;

class DiceModifierTest extends TestCase
{
    public function testComplexTypes()
    {
        $dice = new DiceModifier(
            new DiceGroup(
                new SingleDice(4),
                new DiceModifier(new SingleDice(8), 2),
                new DiceGroup(
                    new DiceModifier(new SingleDice(4), 2),
                    new SingleDice(2)
                )
            ),
            10
        );
        $this->assertEquals(18, $dice->getMinimumRoll());
        $this->assertEquals(32, $dice->getMaximumRoll());
    }

    public function testConstructor()
    {
        $base = new SingleDice(6);
        $dice = new DiceModifier($base, 4);
        $this->assertSame(4, $dice->getModifier());
        $this->assertSame($base, $dice->getDice());
        $this->assertSame(5, $dice->getMinimumRoll());
        $this->assertSame(10, $dice->getMaximumRoll());
    }

    public function testConstructorWithArray()
    {
        $base = new SingleDice(6);
        $dice = new DiceModifier($base, []);
        $this->assertSame(0, $dice->getModifier());
        $this->assertSame($base, $dice->getDice());
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(6, $dice->getMaximumRoll());
    }

    public function testConstructorWithFloat()
    {
        $base = new SingleDice(6);
        $dice = new DiceModifier($base, 4.5);
        $this->assertSame(4, $dice->getModifier());
        $this->assertSame($base, $dice->getDice());
        $this->assertSame(5, $dice->getMinimumRoll());
        $this->assertSame(10, $dice->getMaximumRoll());
    }

    public function testConstructorWithString()
    {
        $base = new SingleDice(6);
        $dice = new DiceModifier($base, '4');
        $this->assertSame(4, $dice->getModifier());
        $this->assertSame($base, $dice->getDice());
        $this->assertSame(5, $dice->getMinimumRoll());
        $this->assertSame(10, $dice->getMaximumRoll());
    }

    public function testDiceInterface()
    {
        $this->assertInstanceOf(DiceInterface::class, new DiceModifier(new SingleDice(6), 4));
    }

    public function testGetRollReturnsNumberBetweenMinAndMax()
    {
        $dice = new DiceModifier(new SingleDice(1), 2);
        for ($i = 0; $i < 10; $i++) {
            $roll = $dice->getRoll();
            $this->assertGreaterThanOrEqual(1, $roll);
            $this->assertLessThanOrEqual(3, $roll);
        }
    }

    public function testSetDice()
    {
        $base = new SingleDice(6);
        $other = new SingleDice(3);
        $dice = new DiceModifier($base, 4);
        $this->assertSame($other, $dice->setDice($other)->getDice());
    }

    public function testSetModifier()
    {
        $base = new SingleDice(6);
        $dice = new DiceModifier($base, 0);
        $dice->setModifier(4);
        $this->assertSame(4, $dice->getModifier());
        $this->assertSame($base, $dice->getDice());
        $this->assertSame(5, $dice->getMinimumRoll());
        $this->assertSame(10, $dice->getMaximumRoll());
    }

    public function testSetModifierIsChainable()
    {
        $dice = new DiceModifier(new SingleDice(1), 1);
        $this->assertSame(3, $dice->setModifier(3)->getModifier());
    }

    public function testSetModifierWithArray()
    {
        $base = new SingleDice(6);
        $dice = new DiceModifier($base, 0);
        $dice->setModifier([]);
        $this->assertSame(0, $dice->getModifier());
        $this->assertSame($base, $dice->getDice());
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(6, $dice->getMaximumRoll());
    }

    public function testSetModifierWithFloat()
    {
        $base = new SingleDice(6);
        $dice = new DiceModifier($base, 0);
        $dice->setModifier(4.5);
        $this->assertSame(4, $dice->getModifier());
        $this->assertSame($base, $dice->getDice());
        $this->assertSame(5, $dice->getMinimumRoll());
        $this->assertSame(10, $dice->getMaximumRoll());
    }

    public function testSetModifierWithString()
    {
        $base = new SingleDice(6);
        $dice = new DiceModifier($base, 0);
        $dice->setModifier('4');
        $this->assertSame(4, $dice->getModifier());
        $this->assertSame($base, $dice->getDice());
        $this->assertSame(5, $dice->getMinimumRoll());
        $this->assertSame(10, $dice->getMaximumRoll());
    }

    public function testToString()
    {
        $this->assertSame('1d6+5', (string) new DiceModifier(new SingleDice(6), 5));
        $this->assertSame('2d6+5', (string) new DiceModifier(new DiceGroup(new SingleDice(6), new SingleDice(6)), 5));
        $this->assertSame('1d5+10', (string) new DiceModifier(new DiceModifier(new SingleDice(5), 5), 5));
        $this->assertSame('(1d6, 1d5)+5', (string) new DiceModifier(new DiceGroup(new SingleDice(6), new SingleDice(5)), 5));
    }
}
