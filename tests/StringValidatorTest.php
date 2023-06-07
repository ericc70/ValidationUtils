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
        // $this->expectExceptionMessage("Ceci n'est pas une chaîne de caractères");

        $validator = new StringValidator();
       
        $validator->validate(123);
    }

    public function testValidateShortString()
    {
        $this->expectException(ValidatorException::class);
        $this->expectExceptionMessage('La longueur minimale n\'est pas respectée');

        $validator = new StringValidator();
        $options = ['minLength' => 5];
        $validator->validate('Hello', $options);
    }

    public function testValidateLongString()
    {
        $this->expectException(ValidatorException::class);
        $this->expectExceptionMessage('La longueur maximale est dépassée');

        $validator = new StringValidator();
        $options = ['maxLength' => 8];
        $validator->validate('Hello World', $options);
    }

    public function testValidateInvalidRegex()
    {
        $this->expectException(ValidatorException::class);
        $this->expectExceptionMessage('La vérification spécifique a échoué');

        $validator = new StringValidator();
        $options = ['regex' => '/^[A-Z]+$/'];
        $validator->validate('Hello', $options);
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

    public function testRequiredString()
    {
        $validator = new StringValidator();
        $result = $validator->validate('Hello', ['required'=> true]);
        $this->assertTrue($result);
    }
    public function testInvalidRequiredString()
    {
        $validator = new StringValidator();
        $this->expectException(ValidatorException::class);
      $validator->validate('', ['required'=> true]);
        
    }
}
