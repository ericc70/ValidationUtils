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

    public function testInvalidExeptionMessage()
    {
        $validator = new EmailValidator();
        $email = 'test@example';

        try {
            $validator->validate($email);
            $this->fail('Expected EmailValidatorException was not thrown.');
        } catch (EmailValidatorException $e) {
            $this->assertEquals('L\'adresse email n\'est pas valide.', $e->getMessage());
        }
    }

    public function testDomaineInexistant()
    {
        $validator = new EmailValidator();
        $email = 'invalidemail@asdfggffgfff/fd';

        $this->expectException(EmailValidatorException::class);
        $validator->validate($email);
    }

    public function testWithBanDomain()
    {
        $email = 'test@yopmail.com';

        // Options de validation
        $options = [
            'checkBan' => true
        ];
        $validator = new EmailValidator();


        $this->expectException(EmailValidatorException::class);
        $validator->validate($email, $options);
    }
    
    public function testWithNoBanDomain()
    {
        $email = 'test@gmail.com';

        // Options de validation
        $options = [
            'checkBan' => true
        ];
        $validator = new EmailValidator();


        $this->assertTrue( $validator->validate($email, $options));
       
    }
}
