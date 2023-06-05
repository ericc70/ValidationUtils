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
    private const VALID_MOBILE = "+33650303647";
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


        $this->assertTrue($this->validator->validate(self::VALID_PHONE_2, ['formatE164'=>true]));
        /* test valid phone for country */
        $this->assertTrue($this->validator->validate(self::VALID_PHONE, ['currentCountry'=>'FR']));
        /* test avec liste pays restricted */
         $this->assertTrue($this->validator->validate(self::VALID_PHONE_2, ['restrictedCountries'=> ['US']]));
         
         $this->assertTrue($this->validator->validate(self::VALID_PHONE_2, ['allowedCountries'=> ['FR']]));
         /* test avec list country allowed et phone mobile*/
         $this->assertTrue($this->validator->validate(self::VALID_MOBILE, ['allowedCountries'=> ['FR'], 'mobile' => true ]));

        $this->assertTrue($this->validator->validate(self::VALID_PHONE, ['specialCharacters' => true]));
    }


    public function testInvalidPhone()
    {

        $this->expectException(NumberParseException::class);
        $this->validator->validate(self::INVALID);
    

//  $this->assertTrue($this->validator->validate(self::VALID_PHONE_2, ['restrictedCountries'=> ['FR']]));


    
    $invalidNumber = "+3365*11#111";

   
    $this->expectException(ValidatorException::class);
    $this->validator->validate($invalidNumber, ['specialCharacters' => true]);
}
  
}
