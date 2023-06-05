<?php

namespace Ericc70\ValidationUtils\tests;

use PHPUnit\Framework\TestCase;
use Ericc70\ValidationUtils\Class\StringManipulator;

class StringManipulatorTest extends TestCase
{

    private $stringManipulator;
    
    protected function setUp(): void
    {
        $this->stringManipulator = new StringManipulator();
    }

    public function testCountCharacters()
    {
        
        $this->assertEquals(6, $this->stringManipulator->countCharacters('Hello!'));
        $this->assertEquals(0, $this->stringManipulator->countCharacters(''));
        $this->assertEquals(10, $this->stringManipulator->countCharacters('1234567890'));
    }

    public function testCountNumericCharacters()
    {
        
        $this->assertEquals(3, $this->stringManipulator->countNumericCharacters('Hello123'));
        $this->assertEquals(0, $this->stringManipulator->countNumericCharacters('Hello'));
        $this->assertEquals(5, $this->stringManipulator->countNumericCharacters('12345'));
    }

    public function testCountAlphaCharacters()
    {
       
        $this->assertEquals(5, $this->stringManipulator->countAlphaCharacters('Hello123'));
        $this->assertEquals(5, $this->stringManipulator->countAlphaCharacters('Hello'));
        $this->assertEquals(0, $this->stringManipulator->countAlphaCharacters('12345'));
    }

    public function testCountSpecialCharacters()
    {
        
        $this->assertEquals(1, $this->stringManipulator->countSpecialCharacters('Hello!'));
        $this->assertEquals(0, $this->stringManipulator->countSpecialCharacters('Hello'));
        $this->assertEquals(0, $this->stringManipulator->countSpecialCharacters('12345'));
    }

    public function testCountLowerCharacters()
    {
        
        $this->assertEquals(4, $this->stringManipulator->countLowerCharacters('Hello!'));
        $this->assertEquals(0, $this->stringManipulator->countLowerCharacters('HELLO'));
        $this->assertEquals(0, $this->stringManipulator->countLowerCharacters('12345'));
    }

    public function testCountUpperCharacters()
    {
     
        $this->assertEquals(1, $this->stringManipulator->countUpperCharacters('Hello!'));
        $this->assertEquals(5, $this->stringManipulator->countUpperCharacters('HELLO'));
        $this->assertEquals(0, $this->stringManipulator->countUpperCharacters('12345'));
    }

    public function testCountBits()
    {
    
        $this->assertEquals(22, $this->stringManipulator->countBits('Hello!'));
        $this->assertEquals(0, $this->stringManipulator->countBits(''));
        $this->assertEquals(17, $this->stringManipulator->countBits('12345'));
    }

    public function testIsString()
    {
 
        $this->assertTrue($this->stringManipulator->isString('Hello'));
        $this->assertTrue($this->stringManipulator->isString('12345'));
        $this->assertFalse($this->stringManipulator->isString(12345));
    }

    public function testCalculateEntropy()
    {
        
        $this->assertEquals(10.0, $this->stringManipulator->calculateEntropy('Hello'));
        $this->assertEquals(0, $this->stringManipulator->calculateEntropy(''));
        $this->assertEquals(0, $this->stringManipulator->calculateEntropy('a'));
    }
}
