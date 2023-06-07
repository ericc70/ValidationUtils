<?php
use PHPUnit\Framework\TestCase;
use Ericc70\ValidationUtils\Lib\PasswordValidator;
use Ericc70\ValidationUtils\Exception\ValidatorException;

class PasswordValidatorTest extends TestCase
{
    public function testValidPassword()
    {
        $validator = new PasswordValidator();

        $this->assertTrue($validator->validate('Aty@1232rg'));
       
    }



    public function testInvalidPassword()
    {
        $validator = new PasswordValidator();

        $this->expectException(ValidatorException::class);
        $validator->validate('Azer23');
    }

    public function testForbiddenPassword()
    {
        $validator = new PasswordValidator();

        $this->expectException(ValidatorException::class);
        $validator->validate('Azerty@123');
        
    }

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
    public function testInvalidCustomOptions()
    {
        $validator = new PasswordValidator();

        $options = [
            'minLength' => 8,
            'minNumericCharacters' => 2,
            'minSpecialCharacters' => 2,
            'minUpperCaseCharacters' => 1,
            'forbidenPassword' => true,
        ];
        $this->expectException(ValidatorException::class);
        $validator->validate('Pass!23!', $options);
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
