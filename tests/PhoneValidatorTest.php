<?php

namespace Ericc70\ValidationUtils\tests;

use PHPUnit\Framework\TestCase;
use libphonenumber\NumberParseException;
use Ericc70\ValidationUtils\Lib\PhoneValidator;
use Ericc70\ValidationUtils\Exception\ValidatorException;

class PhoneValidatorTest extends TestCase
{
    public function testValidPhoneNumber()
    {
        $phoneNumber = '+33370707070';

        $validator = PhoneValidator::getInstance();
        $isValid = $validator->validate($phoneNumber);

        $this->assertTrue($isValid);
    }

    public function testInvalidPhoneNumber()
    {
        $phoneNumber = '123';

        $validator = PhoneValidator::getInstance();
        
        $this->expectException(ValidatorException::class);
        $validator->validate($phoneNumber);
    }

    public function testValidPhoneNumberInternationalFormat()
    {
        $phoneNumber = '+33370707070';

        $validator = PhoneValidator::getInstance();
        $isValid = $validator->validatePhoneNumberInternationalFormat($phoneNumber);

        $this->assertTrue($isValid);
    }

    public function testInvalidPhoneNumberInternationalFormat()
    {
        $phoneNumber = '123';

        $validator = PhoneValidator::getInstance();
        
        $this->expectException(NumberParseException::class);
        $validator->validatePhoneNumberInternationalFormat($phoneNumber);
    }

    public function testValidPhoneNumberNationalFormat()
    {
        $phoneNumber = '0384856552';

        $validator = PhoneValidator::getInstance(false);
        $isValid = $validator->validatePhoneNumberNationalFormat($phoneNumber, 'FR');

        $this->assertTrue($isValid);
    }

    public function testInvalidPhoneNumberNationalFormat()
    {
        $phoneNumber = '035214125';

        $validator = PhoneValidator::getInstance(false);
        
        $this->expectException(ValidatorException::class);
        $isValid = $validator->validatePhoneNumberNationalFormat($phoneNumber, 'FR');

    }

    public function testValidPhoneNumberWithNationalCode()
    {
        $phoneNumber = '0310101010';
        $nationalCode = '+33';

        $validator = PhoneValidator::getInstance();
        $isValid = $validator->validatePhoneNumberWithNationalCode($phoneNumber, $nationalCode);

        $this->assertTrue($isValid);
    }

    public function testInvalidPhoneNumberWithNationalCode()
    {
        $phoneNumber = '0145236321';
        $nationalCode = '32';

        $validator = PhoneValidator::getInstance();
        
        $this->expectException(NumberParseException::class);
        $validator->validatePhoneNumberWithNationalCode($phoneNumber, $nationalCode);
    }

    public function testValidateFixedOrMobile()
    {
        $fixedLineNumber = '+33310101010';
        $mobileNumber = '+33644444444';

        $validator = PhoneValidator::getInstance();

        $resultFixed = $validator->validateFixedOrMobile($fixedLineNumber);
        $resultMobile = $validator->validateFixedOrMobile($mobileNumber);

        $this->assertEquals('fixed', $resultFixed);
        $this->assertEquals('mobile', $resultMobile);
    }
}
