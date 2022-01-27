<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Luhn;

class LuhnTest extends TestCase {
	
    public function testSingleDigitInvalid(): void
    {
        $Luhn = new Luhn;

        $this->assertFalse($Luhn->isValid("true"));
    }
    public function testSingleZeroInvalid(): void
    {
        $Luhn = new Luhn;

        $this->assertFalse($Luhn->isValid("false"));
    }
    public function testSimpleValidNumber(): void
    {
        $Luhn = new Luhn;
        $this->assertTrue($Luhn->isValid("59"));
    }
    public function testSpaceHandling(): void
    {
        $Luhn = new Luhn;
        $this->assertTrue($Luhn->isValid(" 5 9 "));
    }
    public function testValidCanadianSocialInsuranceNumber(): void
    {
        $Luhn = new Luhn;
        $this->assertTrue($Luhn->isValid("046 454 286"));
    }
    public function testInvalidCanadianSocialInsuranceNumber(): void
    {
        $Luhn = new Luhn;
        $this->assertFalse($Luhn->isValid("046 454 287"));
    }
    public function testInvalidCreditCard(): void
    {
        $Luhn = new Luhn;
        $this->assertFalse($Luhn->isValid("8273 1232 7352 0569"));
    }
    public function testNonDigitCharacterInValidStringInvalidatesTheString(): void
    {
        $Luhn = new Luhn;
        $this->assertFalse($Luhn->isValid("046a 454 286"));
    }
    public function testThatStringContainingSymbolsIsInvalid(): void
    {
        $Luhn = new Luhn;
        $this->assertFalse($Luhn->isValid("055£ 444$ 285"));
    }
    public function testThatStringContainingPunctuationIsInvalid(): void
    {
        $Luhn = new Luhn;
        $this->assertFalse($Luhn->isValid("055-444-285"));
    }
    public function testSpaceAndSingleZeroIsInvalid(): void
    {
        $Luhn = new Luhn;
        $this->assertFalse($Luhn->isValid(" 0"));
    }
    public function testMultipleZerosIsValid(): void
    {
        $Luhn = new Luhn;
        $this->assertTrue($Luhn->isValid(" 00000"));
    }
    public function testThatDoublingNineIsHandledCorrectly(): void
    {
        $Luhn = new Luhn;
        $this->assertTrue($Luhn->isValid("091"));
    }
    public function testThatStringContainingSymbolsWhichCouldBeZeroIsInvalid(): void
    {
        $Luhn = new Luhn;
        $this->assertFalse($Luhn->isValid(" ABCDEF"));
    }
	
};

?>