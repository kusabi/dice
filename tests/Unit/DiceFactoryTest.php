<?php

namespace Kusabi\Dice\Tests\Unit;

use InvalidArgumentException;
use Kusabi\Dice\DiceFactory;
use Kusabi\Dice\DiceGroup;
use Kusabi\Dice\DiceModifier;
use Kusabi\Dice\SingleDice;
use PHPUnit\Framework\TestCase;

class DiceFactoryTest extends TestCase
{
    public function testD100Modified()
    {
        $dice = DiceFactory::createFromString('100d100+100');
        $this->assertInstanceOf(DiceModifier::class, $dice);
        $this->assertSame(200, $dice->getMinimumRoll());
        $this->assertSame(10100, $dice->getMaximumRoll());
    }

    public function testD100Multiple()
    {
        $dice = DiceFactory::createFromString('100d100');
        $this->assertInstanceOf(DiceGroup::class, $dice);
        $this->assertSame(100, $dice->getMinimumRoll());
        $this->assertSame(10000, $dice->getMaximumRoll());
    }

    public function testD100Simple()
    {
        $dice = DiceFactory::createFromString('d100');
        $this->assertInstanceOf(SingleDice::class, $dice);
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(100, $dice->getMaximumRoll());
    }

    public function testD10Modified()
    {
        $dice = DiceFactory::createFromString('2d10 + 10');
        $this->assertInstanceOf(DiceModifier::class, $dice);
        $this->assertSame(12, $dice->getMinimumRoll());
        $this->assertSame(30, $dice->getMaximumRoll());
    }

    public function testD10Multiple()
    {
        $dice = DiceFactory::createFromString('2d10');
        $this->assertInstanceOf(DiceGroup::class, $dice);
        $this->assertSame(2, $dice->getMinimumRoll());
        $this->assertSame(20, $dice->getMaximumRoll());
    }

    public function testD10Simple()
    {
        $dice = DiceFactory::createFromString('d10');
        $this->assertInstanceOf(SingleDice::class, $dice);
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(10, $dice->getMaximumRoll());
    }

    public function testD12Modified()
    {
        $dice = DiceFactory::createFromString('10d12+0');
        $this->assertInstanceOf(DiceGroup::class, $dice);
        $this->assertSame(10, $dice->getMinimumRoll());
        $this->assertSame(120, $dice->getMaximumRoll());
    }

    public function testD12Multiple()
    {
        $dice = DiceFactory::createFromString('2d12');
        $this->assertInstanceOf(DiceGroup::class, $dice);
        $this->assertSame(2, $dice->getMinimumRoll());
        $this->assertSame(24, $dice->getMaximumRoll());
    }

    public function testD12Simple()
    {
        $dice = DiceFactory::createFromString('d12');
        $this->assertInstanceOf(SingleDice::class, $dice);
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(12, $dice->getMaximumRoll());
    }

    public function testD20Modified()
    {
        $dice = DiceFactory::createFromString('10d20+0');
        $this->assertInstanceOf(DiceGroup::class, $dice);
        $this->assertSame(10, $dice->getMinimumRoll());
        $this->assertSame(200, $dice->getMaximumRoll());
    }

    public function testD20Multiple()
    {
        $dice = DiceFactory::createFromString('1d20');
        $this->assertInstanceOf(SingleDice::class, $dice);
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(20, $dice->getMaximumRoll());
    }

    public function testD20Simple()
    {
        $dice = DiceFactory::createFromString('d20');
        $this->assertInstanceOf(SingleDice::class, $dice);
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(20, $dice->getMaximumRoll());
    }

    public function testD4Modified()
    {
        $dice = DiceFactory::createFromString('1d4+2');
        $this->assertInstanceOf(DiceModifier::class, $dice);
        $this->assertSame(3, $dice->getMinimumRoll());
        $this->assertSame(6, $dice->getMaximumRoll());
    }

    public function testD4Multiple()
    {
        $dice = DiceFactory::createFromString('2d4');
        $this->assertInstanceOf(DiceGroup::class, $dice);
        $this->assertSame(2, $dice->getMinimumRoll());
        $this->assertSame(8, $dice->getMaximumRoll());
    }

    public function testD4Simple()
    {
        $dice = DiceFactory::createFromString('d4');
        $this->assertInstanceOf(SingleDice::class, $dice);
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(4, $dice->getMaximumRoll());
    }

    public function testD6Modified()
    {
        $dice = DiceFactory::createFromString('2d6+10');
        $this->assertInstanceOf(DiceModifier::class, $dice);
        $this->assertSame(12, $dice->getMinimumRoll());
        $this->assertSame(22, $dice->getMaximumRoll());
    }

    public function testD6Multiple()
    {
        $dice = DiceFactory::createFromString('2d6');
        $this->assertInstanceOf(DiceGroup::class, $dice);
        $this->assertSame(2, $dice->getMinimumRoll());
        $this->assertSame(12, $dice->getMaximumRoll());
    }

    public function testD6Simple()
    {
        $dice = DiceFactory::createFromString('d6');
        $this->assertInstanceOf(SingleDice::class, $dice);
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(6, $dice->getMaximumRoll());
    }

    public function testD8Modified()
    {
        $dice = DiceFactory::createFromString('2d8+10');
        $this->assertInstanceOf(DiceModifier::class, $dice);
        $this->assertSame(12, $dice->getMinimumRoll());
        $this->assertSame(26, $dice->getMaximumRoll());
    }

    public function testD8Multiple()
    {
        $dice = DiceFactory::createFromString('4d8');
        $this->assertInstanceOf(DiceGroup::class, $dice);
        $this->assertSame(4, $dice->getMinimumRoll());
        $this->assertSame(32, $dice->getMaximumRoll());
    }

    public function testD8Simple()
    {
        $dice = DiceFactory::createFromString('d8');
        $this->assertInstanceOf(SingleDice::class, $dice);
        $this->assertSame(1, $dice->getMinimumRoll());
        $this->assertSame(8, $dice->getMaximumRoll());
    }

    public function testThrowsExceptionForInvalidStringFormat()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Could not parse the string to a dice setup');
        DiceFactory::createFromString('not-real');
    }

    public function testThrowsExceptionForTooFewSides()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('A dice cannot have less than 1 sides');
        DiceFactory::createFromString('1d0');
    }

    public function testThrowsExceptionForTooSmallOfAMultiplier()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The multiplier cannot be less than 1');
        DiceFactory::createFromString('0d4');
    }
}
