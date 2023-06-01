<?php

use Exception;
use PHPUnit\Framework\TestCase;
use Ericc70\ValidationUtils\Lib\PhoneValidator;
use Ericc70\ValidationUtils\Exception\ValidatorException;

class PhoneValidatorTest extends TestCase {
    public function testValidPhoneNumber() {
        $validator = new PhoneValidator();
        $isValid = $validator->validate('+33145853310');
        $this->assertTrue($isValid);
    }

    public function testInvalidPhoneNumber() {
        $validator = new PhoneValidator();
        $isValid = $validator->validate('1234567890');
        $this->assertFalse($isValid);
    }

    public function testForbiddenPhoneNumber() {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Numéro non autorisé");
        $validator = new PhoneValidator();
        $isValid = $validator->validate('+33606060606');
        $this->assertFalse($isValid);

    }
}