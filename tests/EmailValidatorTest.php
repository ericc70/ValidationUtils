<?php
use Ericc70\ValidationUtils\Lib\EmailValidator;
use Ericc70\ValidationUtils\Lib\EmailValidatorOptions;
use Ericc70\ValidationUtils\Exeption\EmailValidatorException;
use PHPUnit\Framework\TestCase;

class EmailValidatorTest extends TestCase
{
    public function testValidEmail()
    {
        $validator = new EmailValidator();
        $email = 'test@example.com';

        $this->assertTrue($validator->validate($email));
    }

    public function testInvalidEmail()
    {
        $validator = new EmailValidator();
        $email = 'invalidemail';

        $this->expectException(EmailValidatorException::class);
        $validator->validate($email);
    }
}