<?php

namespace Ericc70\ValidationUtils\Lib;

use libphonenumber\RegionCode;
use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\NumberParseException;
use libphonenumber\CountryCodeToRegionCodeMap;
use Ericc70\ValidationUtils\Exception\ValidatorException;
use Ericc70\ValidationUtils\Interface\ValidatorInterface;
use Ericc70\ValidationUtils\Lib\Class\PhoneValidatorOptions;

class PhoneValidator implements ValidatorInterface
{
    private $phoneNumberUtil;
    private $forbiddenNumbers;

    private const FORBIDDEN_NUMBERS_FILE = '/../Data/forbiddenNumberPhone.txt';

    public function __construct()
    {
        $this->phoneNumberUtil = PhoneNumberUtil::getInstance();
        $this->forbiddenNumbers = $this->loadForbiddenNumbers();
    }



    public function validate( $phone, array $options = []): bool
    {

        $phoneOptions = new PhoneValidatorOptions($options);
        $phoneNumber = $this->parsePhoneNumber($phone);

        if (!$this->validateNumberFormat($phoneNumber)) {
            throw new ValidatorException('Invalid phone number');
        }
        if ($phoneOptions->hasCurrentCountry() && !$this->validatePhoneNumberNationalFormat($phone, $phoneOptions->getCurrentCountry())) {
            throw new ValidatorException('Invalid phone number for country');
        }
        if ($phoneOptions->isFixedEnabled() && !$this->validateFixed($phoneNumber)) {
            throw new ValidatorException('Invalid phone fixe');
        }
        if ($phoneOptions->isMobileEnabled() && !$this->validateMobile($phoneNumber)) {
            throw new ValidatorException('Invalid phone mobile');
        }
        if ($phoneOptions->isFormatE164Enabled() && !$this->validateE164Format($phone)) {
            throw new ValidatorException('Invalid format E164');
        }
    
        if ($phoneOptions->hasRestrictedCountries() && $this->validateRestrictedCountry($phoneNumber, $phoneOptions->getRestrictedCountries())) {
            throw new ValidatorException('Restricted country');
        }

        if ($phoneOptions->hasAllowedCountries() && !$this->validateAllowedCountries($phoneNumber, $phoneOptions->getAllowedCountries() )) {
            throw new ValidatorException('Allowed Countries');
        }
        if ($phoneOptions->isForbiddenNumberEnabled() && !$this->validateForbidenNumbers($phoneNumber)) {
            throw new ValidatorException(' Forbiden country');
        }
        if ($phoneOptions->isSpecialCharactersEnabled() && !$this->validateSpecialCharacters($phoneNumber)) {
            throw new ValidatorException('Error Special Characters');
        }
        return true;
    }


    private function validatePhoneNumberNationalFormat($phoneNumber,  $pays): bool
    {
        $supportedRegions = $this->phoneNumberUtil->getSupportedRegions();

        if (!in_array($pays, $supportedRegions)) {
            return false; // Code de pays invalide
        }

        $phoneNumberObject = $this->parsePhoneNumber($phoneNumber, $pays);

        // return  $this->validateNumberFormat($phoneNumberObject);
        return $this->phoneNumberUtil->isValidNumberForRegion($phoneNumberObject, $pays);
    }

  
    private function validateNumberFormat($phoneNumberObject): bool
    {
        
        return $this->phoneNumberUtil->isValidNumber($phoneNumberObject);
    }

    private function validateFixed($phoneNumber): bool
    {
        // $phoneNumberObject = $this->parsePhoneNumber($phoneNumber);
        $this->validateNumberFormat($phoneNumber);
        if ($this->phoneNumberUtil->getNumberType($phoneNumber) === PhoneNumberType::FIXED_LINE) {
            return true;
        }
        return false;
    }

    private function validateMobile($phoneNumber): bool
    {
        // $phoneNumberObject = $this->parsePhoneNumber($phoneNumber);
        $this->validateNumberFormat($phoneNumber);
        if ($this->phoneNumberUtil->getNumberType($phoneNumber) === PhoneNumberType::MOBILE) {
            return true;
        }
        return false;
    }

    private function parsePhoneNumber($phoneNumber, $pays = null)
    {
        return $this->phoneNumberUtil->parse($phoneNumber, $pays);
    }

    private function loadForbiddenNumbers(): array
    {
        $forbiddenNumbersFile = realpath(__DIR__ . self::FORBIDDEN_NUMBERS_FILE);

        if (file_exists($forbiddenNumbersFile)) {
            return file($forbiddenNumbersFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        } else {
            throw new \InvalidArgumentException("Forbidden numbers file not found: $forbiddenNumbersFile");
        }
    }

    private function validateForbidenNumbers( $phoneNumber): bool
    {
        return in_array($phoneNumber, $this->forbiddenNumbers, true);
    }

    private function validateE164Format($phoneNumber): bool
    {
        $phoneNumberObject = $this->parsePhoneNumber($phoneNumber);
        $normalizedNumber = $this->phoneNumberUtil->format($phoneNumberObject, PhoneNumberFormat::E164);

        return $phoneNumber === $normalizedNumber;
    }

    private function validateRestrictedCountry($phoneNumber, array $allowedCountries): bool
    {
        
        $phoneNumberCountryCode = $this->phoneNumberUtil->getRegionCodeForNumber($phoneNumber);

        return in_array($phoneNumberCountryCode, $allowedCountries);
    }

    private function validateAllowedCountries($phoneNumber, array $allowedCountries): bool
    {
      
        $phoneNumberCountryCode = $this->phoneNumberUtil->getRegionCodeForNumber($phoneNumber);

        return in_array($phoneNumberCountryCode, $allowedCountries);
    }
   
    private function validateSpecialCharacters($phoneNumber): bool
    {
        // Définissez ici les caractères spéciaux que vous souhaitez interdire
        $forbiddenCharacters = ['@', '#', '$', '%', '&', '*'];

        // Vérifiez si le numéro de téléphone contient des caractères spéciaux
        foreach ($forbiddenCharacters as $character) {
            if (strpos($phoneNumber, $character) !== false) {
                return false;
            }
        }

        return true;
    }
}

    // public static function getInstance(bool $includeNationalCode = true, array $allowedNationalCodes = []): self
    // {
    //     return new self($includeNationalCode, $allowedNationalCodes);
    // }
