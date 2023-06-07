<?php

use Ericc70\ValidationUtils\Exception\ValidatorException;
use Ericc70\ValidationUtils\Lib\EmailValidator;
use Ericc70\ValidationUtils\Class\DomainChecker;
use PHPUnit\Framework\TestCase;

class EmailValidatorTest extends TestCase
{
    public function testValidEmail()
    {
        $validator = new EmailValidator();
        $this->assertTrue($validator->validate('test@example.com'));
        $this->assertTrue($validator->validate('mail@yopmail.com', [ 'BanDomain' => false ]));
    }

    public function testInvalidEmail()
    {
        $this->expectException(ValidatorException::class);
       

        $validator = new EmailValidator();
        $validator->validate('invalid_email');
    }

    public function testInvalidDomain()
    {
        
    $this->expectException(ValidatorException::class);

       $validator = new EmailValidator();
       $validator->validate('mail@fake.domaine');
    }
    
    public function testNoContolDomain()
    {
       $validator = new EmailValidator();
       $this->assertTrue($validator->validate('mail@fake.domaine', [ 'validDomain' => false ]));
    }

    public function testBanDomain()
    {
      
       $this->expectException(ValidatorException::class);
        $validator = new EmailValidator();
       $validator->validate('mail@yopmail.com', [ 'banDomain' => true ]);
    }




    

  
}