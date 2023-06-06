<?php
use PHPUnit\Framework\TestCase;
use Ericc70\ValidationUtils\Lib\PasswordValidator;

class PasswordValidatorTest extends TestCase
{
    public function testValidPassword()
    {
        $validator = new PasswordValidator();

        $this->assertTrue($validator->validate('Abcdef1-ef'));
    }

    // public function testInvalidPassword()
    // {
    //     $validator = new PasswordValidator();

    //     $this->assertFalse($validator->validate('abc123'));
    // }

    // public function testForbiddenPassword()
    // {
    //     $validator = new PasswordValidator();

    //     $this->assertFalse($validator->validate('Azerty@123'));
    // }

    public function testCustomOptions()
    {
        $validator = new PasswordValidator();

        $options = [
            'minLength' => 8,
            'minNumericCharacters' => 2,
            'minSpecialCharacters' => 2,
            'minUpperCaseCharacters' => 1,
            'forbidenPassword' => false,
        ];

        $this->assertTrue($validator->validate('Pass!23!', $options));
    }

    // public function testEntropyCalculation()
    // {
    //     $validator = new PasswordValidator();

    //     $this->assertEquals(25.0, $validator->getEntropy('Abc123!'));
    // }

    // public function testBitsCount()
    // {
    //     $validator = new PasswordValidator();

    //     $this->assertEquals(26, $validator->getBits('Abc123!'));
    // }
}
