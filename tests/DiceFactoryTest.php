<?php

namespace Kusabi\Tests;

use InvalidArgumentException;
use Kusabi\Dice\Dice;
use Kusabi\Dice\DiceFactory;
use Kusabi\Dice\DiceFactoryInterface;
use Kusabi\Dice\DiceGroup;
use Kusabi\Dice\DiceModifier;
use PHPUnit\Framework\TestCase;

class DiceFactoryTest extends TestCase
{
    public function testInstanceOfDiceInterface()
    {
        $this->assertInstanceOf(DiceFactoryInterface::class, new DiceFactory());
    }

    public function testThrowsExceptionWhenNotString()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Input format is not supported');
        $factory = new DiceFactory();
        $factory->generateDice([]);
    }

    public function testThrowsExceptionForInvalidStringFormat()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Could not parse the string to a dice setup');
        $factory = new DiceFactory();
        $factory->generateDice('not-real');
    }

    public function testThrowsExceptionForTooFewSides()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('A dice cannot have less than 1 sides');
        $factory = new DiceFactory();
        $factory->generateDice('1d0');
    }

    public function testThrowsExceptionForTooSmallOfAMultiplier()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The multiplier cannot be less than 1');
        $factory = new DiceFactory();
        $factory->generateDice('0d4');
    }

    public function testD4Simple()
    {
        $factory = new DiceFactory();
        $dice = $factory->generateDice('d4');
        $this->assertInstanceOf(Dice::class, $dice);
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(4, $dice->getMaximumRoll());
    }

    public function testD4Multiple()
    {
        $factory = new DiceFactory();
        $dice = $factory->generateDice('2d4');
        $this->assertInstanceOf(DiceGroup::class, $dice);
        $this->assertSame(2, $dice->getMinimumRoll());
        $this->assertSame(8, $dice->getMaximumRoll());
    }

    public function testD4Modified()
    {
        $factory = new DiceFactory();
        $dice = $factory->generateDice('1d4+2');
        $this->assertInstanceOf(DiceModifier::class, $dice);
        $this->assertSame(3, $dice->getMinimumRoll());
        $this->assertSame(6, $dice->getMaximumRoll());
    }

    public function testD6Simple()
    {
        $factory = new DiceFactory();
        $dice = $factory->generateDice('d6');
        $this->assertInstanceOf(Dice::class, $dice);
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(6, $dice->getMaximumRoll());
    }

    public function testD6Multiple()
    {
        $factory = new DiceFactory();
        $dice = $factory->generateDice('2d6');
        $this->assertInstanceOf(DiceGroup::class, $dice);
        $this->assertSame(2, $dice->getMinimumRoll());
        $this->assertSame(12, $dice->getMaximumRoll());
    }

    public function testD6Modified()
    {
        $factory = new DiceFactory();
        $dice = $factory->generateDice('2d6+10');
        $this->assertInstanceOf(DiceModifier::class, $dice);
        $this->assertSame(12, $dice->getMinimumRoll());
        $this->assertSame(22, $dice->getMaximumRoll());
    }

    public function testD8Simple()
    {
        $factory = new DiceFactory();
        $dice = $factory->generateDice('d8');
        $this->assertInstanceOf(Dice::class, $dice);
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(8, $dice->getMaximumRoll());
    }

    public function testD8Multiple()
    {
        $factory = new DiceFactory();
        $dice = $factory->generateDice('4d8');
        $this->assertInstanceOf(DiceGroup::class, $dice);
        $this->assertSame(4, $dice->getMinimumRoll());
        $this->assertSame(32, $dice->getMaximumRoll());
    }

    public function testD8Modified()
    {
        $factory = new DiceFactory();
        $dice = $factory->generateDice('2d8+10');
        $this->assertInstanceOf(DiceModifier::class, $dice);
        $this->assertSame(12, $dice->getMinimumRoll());
        $this->assertSame(26, $dice->getMaximumRoll());
    }

    public function testD10Simple()
    {
        $factory = new DiceFactory();
        $dice = $factory->generateDice('d10');
        $this->assertInstanceOf(Dice::class, $dice);
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(10, $dice->getMaximumRoll());
    }

    public function testD10Multiple()
    {
        $factory = new DiceFactory();
        $dice = $factory->generateDice('2d10');
        $this->assertInstanceOf(DiceGroup::class, $dice);
        $this->assertSame(2, $dice->getMinimumRoll());
        $this->assertSame(20, $dice->getMaximumRoll());
    }

    public function testD10Modified()
    {
        $factory = new DiceFactory();
        $dice = $factory->generateDice('2d10 + 10');
        $this->assertInstanceOf(DiceModifier::class, $dice);
        $this->assertSame(12, $dice->getMinimumRoll());
        $this->assertSame(30, $dice->getMaximumRoll());
    }

    public function testD12Simple()
    {
        $factory = new DiceFactory();
        $dice = $factory->generateDice('d12');
        $this->assertInstanceOf(Dice::class, $dice);
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(12, $dice->getMaximumRoll());
    }

    public function testD12Multiple()
    {
        $factory = new DiceFactory();
        $dice = $factory->generateDice('2d12');
        $this->assertInstanceOf(DiceGroup::class, $dice);
        $this->assertSame(2, $dice->getMinimumRoll());
        $this->assertSame(24, $dice->getMaximumRoll());
    }

    public function testD12Modified()
    {
        $factory = new DiceFactory();
        $dice = $factory->generateDice('10d12+0');
        $this->assertInstanceOf(DiceGroup::class, $dice);
        $this->assertSame(10, $dice->getMinimumRoll());
        $this->assertSame(120, $dice->getMaximumRoll());
    }

    public function testD20Simple()
    {
        $factory = new DiceFactory();
        $dice = $factory->generateDice('d20');
        $this->assertInstanceOf(Dice::class, $dice);
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(20, $dice->getMaximumRoll());
    }

    public function testD20Multiple()
    {
        $factory = new DiceFactory();
        $dice = $factory->generateDice('1d20');
        $this->assertInstanceOf(Dice::class, $dice);
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(20, $dice->getMaximumRoll());
    }

    public function testD20Modified()
    {
        $factory = new DiceFactory();
        $dice = $factory->generateDice('10d20+0');
        $this->assertInstanceOf(DiceGroup::class, $dice);
        $this->assertSame(10, $dice->getMinimumRoll());
        $this->assertSame(200, $dice->getMaximumRoll());
    }

    public function testD100Simple()
    {
        $factory = new DiceFactory();
        $dice = $factory->generateDice('d100');
        $this->assertInstanceOf(Dice::class, $dice);
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(100, $dice->getMaximumRoll());
    }

    public function testD100Multiple()
    {
        $factory = new DiceFactory();
        $dice = $factory->generateDice('100d100');
        $this->assertInstanceOf(DiceGroup::class, $dice);
        $this->assertSame(100, $dice->getMinimumRoll());
        $this->assertSame(10000, $dice->getMaximumRoll());
    }

    public function testD100Modified()
    {
        $factory = new DiceFactory();
        $dice = $factory->generateDice('100d100+100');
        $this->assertInstanceOf(DiceModifier::class, $dice);
        $this->assertSame(200, $dice->getMinimumRoll());
        $this->assertSame(10100, $dice->getMaximumRoll());
    }
}
