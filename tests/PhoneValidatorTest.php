<?php

namespace Ericc70\ValidationUtils\tests;


use PHPUnit\Framework\TestCase;

use libphonenumber\NumberParseException;
use Ericc70\ValidationUtils\Lib\PhoneValidator;
use Ericc70\ValidationUtils\Exception\ValidatorException;

class PhoneValidatorTest extends TestCase
{
    private $validator;

    private const VALID_PHONE = "+33300000102";
    private const VALID_PHONE_2 = "+33411223344";
    private const VALID_MOBILE = "+33650303030";
    private const FORBIDEN_PHONE = "+33606060606";
    private const INVALID = "600102";


    protected function setUp(): void
    {
        $this->validator = new PhoneValidator();
    }

    public function testValidPhone()
    {
        /* simple utilisation*/
        $this->assertTrue($this->validator->validate(self::VALID_PHONE));

        /* avec option */
        $isValid = $this->validator->validate(self::VALID_MOBILE,  ['mobile' => true]);
        $this->assertTrue($isValid);
        $isValid = $this->validator->validate(self::VALID_PHONE,  ['fixed' => true]);
        $this->assertTrue($isValid);

        /* format e 164 */
        $this->assertTrue($this->validator->validate(self::VALID_PHONE_2, ['formatE164' => true]));
        /* test valid phone for country */
        $this->assertTrue($this->validator->validate(self::VALID_PHONE, ['currentCountry' => 'FR']));
        /* test avec liste pays restricted */
        $this->assertTrue($this->validator->validate(self::VALID_PHONE_2, ['restrictedCountries' => ['US']]));

        $this->assertTrue($this->validator->validate(self::VALID_PHONE_2, ['allowedCountries' => ['FR']]));
        /* test avec list country allowed et phone mobile*/
        $this->assertTrue($this->validator->validate(self::VALID_MOBILE, ['allowedCountries' => ['FR'], 'mobile' => true]));


        $this->assertTrue($this->validator->validate(self::FORBIDEN_PHONE, ['forbiddenNumber' => false]));
        $this->assertTrue($this->validator->validate(self::VALID_PHONE_2, ['forbiddenNumber' => true]));
        $this->assertTrue($this->validator->validate(self::VALID_PHONE, ['specialCharacters' => true]));
    }

    public function testInvalidPhone()
    {
        $this->expectException(NumberParseException::class);
        $this->validator->validate(self::INVALID);
        //  $this->assertTrue($this->validator->validate(self::VALID_PHONE_2, ['restrictedCountries'=> ['FR']]));
    }

    public function testForbiden()
    {
        $this->expectException(ValidatorException::class);
        $this->validator->validate(self::FORBIDEN_PHONE, ['forbiddenNumber' => true]);
    }

    public function testCharacter()
    {
        $invalidNumber = "+3365*11#111";
        $this->expectException(ValidatorException::class);
        $this->validator->validate($invalidNumber, ['specialCharacters' => true]);
    }

    public function testInvalidFixe()
    {
        $this->expectException(ValidatorException::class);
        $this->validator->validate(self::VALID_MOBILE, ['fixed' => true]);
    }

    public function testInvalidFormatE164()
    {
        $this->expectException(ValidatorException::class);
        $this->validator->validate("+3365030303", ['formatE164' => true]);
    }

    public function testInvalidCountry()
    {
        $this->expectException(ValidatorException::class);
        $this->validator->validate(self::VALID_MOBILE, ['currentCountry' => 'US']);
    }


    public function testInvalidRestrictedCountries()
    {
        $this->expectException(ValidatorException::class);
        $this->validator->validate(self::VALID_PHONE, ['restrictedCountries' => ['FR']]);
    }

    public function testInvalidAllowedCountries()
    {
        $this->expectException(ValidatorException::class);
        $this->validator->validate(self::VALID_PHONE, ['allowedCountries' => ['US']]);
    }

    // // Test avec l'option 'mobile' et 'allowedCountries'
    public function testInvalidMobileAllowedCountries()
    {
        $this->expectException(ValidatorException::class);
        $this->validator->validate(self::VALID_PHONE, ['allowedCountries' => ['US'], 'fixed' => true]);
    }

    public function testInvalidMobileAllowedCountries2()
    {
        $this->expectException(ValidatorException::class);
        $this->validator->validate(self::VALID_PHONE, ['allowedCountries' => ['fr'], 'mobile' => true]);
    }

 
    

 





}
