<?php


use PHPUnit\Framework\TestCase;
use Ericc70\ValidationUtils\Lib\StringValidator;
use Ericc70\ValidationUtils\Class\RegexCollection;
use Ericc70\ValidationUtils\Exception\ValidatorException;

class StringValidatorTest extends TestCase
{
    public function testValidateValidString()
    {
        $validator = new StringValidator();
        $result = $validator->validate('Hello');
        $this->assertTrue($result);
    }

    public function testValidateNonString()
    {
        $this->expectException(ValidatorException::class);
        $this->expectExceptionMessage("Ceci n'est pas une chaîne de caractères");

        $validator = new StringValidator();
        $validator->validate(123);
    }

    public function testValidateShortString()
    {
        $this->expectException(ValidatorException::class);
        $this->expectExceptionMessage('Longueur minimale requise');

        $validator = new StringValidator();
        $options = ['minLength' => 5];
        $validator->validate('Hello', $options);
    }

    public function testValidateLongString()
    {
        $this->expectException(ValidatorException::class);
        $this->expectExceptionMessage('Longueur maximale dépassée');

        $validator = new StringValidator();
        $options = ['maxLength' => 5];
        $validator->validate('Hello World', $options);
    }

    public function testValidateInvalidRegex()
    {
        $this->expectException(ValidatorException::class);
        $this->expectExceptionMessage('Vérification spécifique échouée');

        $validator = new StringValidator();
        $options = ['regex' => '/^[A-Z]+$/'];
        $validator->validate('Hello', $options);
    }

    public function testValidateCustomOption()
    {
        $validator = new StringValidator();
        $options = ['customOption' => 'value'];
        $result = $validator->validate('Hello', $options);
        $this->assertTrue($result);
    }

    public function testValidateRegexCollection()
    {
        $validator = new StringValidator();
        $options = ['regex' => RegexCollection::getRegex('email')];
        $result = $validator->validate('test@example.com', $options);
        $this->assertTrue($result);
    }
    public function testInvalidateRegexCollection()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Regex \'php\' not found.');

        $validator = new StringValidator();
        $options = ['regex' => RegexCollection::getRegex('php')];
        $result = $validator->validate('test@example.com', $options);
       
    }
}
