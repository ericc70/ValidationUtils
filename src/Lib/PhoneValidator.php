<?php

namespace Ericc70\ValidationUtils\Lib;

use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\NumberParseException;
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



    public function validate($phoneNumber, array $options = []): bool
    {

        $phoneOptions = new PhoneValidatorOptions($options);


        if (!$this->validateNumberFormat($phoneNumber)) {
            return false;
        }
        if (!$this->validatePhoneNumberNationalFormat($phoneNumber, $phoneOptions->getCurrentCountry())) {
            return false;
        }
        if ($phoneOptions->isFixedEnabled() && !$this->validateFixed($phoneNumber)) {
            return false;
        }
        if ($phoneOptions->isMobileEnabled() && !$this->validateMobile($phoneNumber)) {
            return false;
        }
        if ($phoneOptions->isFormatE164Enabled() && !$this->validateE164Format($phoneNumber)) {
            return false;
        }
        $restrictedCountries = $phoneOptions->getRestrictedCountries();
        if ($phoneOptions->hasRestrictedCountries() && !$this->validateRestrictedCountry($phoneNumber, $restrictedCountries)) {
            return false;
        }

        $allowedCountries = $phoneOptions->getAllowedCountries();
        if ($phoneOptions->hasAllowedCountries() && !$this->validateAllowedCountries($phoneNumber, $allowedCountries)) {
            return false;
        }
        if ($phoneOptions->isForbiddenNumberEnabled() && !$this->validateSpecialCharacters($phoneNumber)) {
            return false;
        }
        return true;
    }


    private function validatePhoneNumberNationalFormat($phoneNumber, $pays): bool
    {

        $phoneNumberObject = $this->parsePhoneNumber($phoneNumber, $pays);

        return  $this->validateNumberFormat($phoneNumberObject);
    }


    private function validateNumberFormat($phoneNumberObject): bool
    {
        return $this->phoneNumberUtil->isValidNumber($phoneNumberObject);
    }

    private function validateFixed($phoneNumber): bool
    {
        $phoneNumberObject = $this->parsePhoneNumber($phoneNumber);
        $this->validateNumberFormat($phoneNumberObject);
        if ($this->phoneNumberUtil->getNumberType($phoneNumberObject) === PhoneNumberType::FIXED_LINE) {
            return true;
        }
        return false;
    }

    private function validateMobile($phoneNumber): bool
    {
        $phoneNumberObject = $this->parsePhoneNumber($phoneNumber);
        $this->validateNumberFormat($phoneNumberObject);
        if ($this->phoneNumberUtil->getNumberType($phoneNumberObject) === PhoneNumberType::MOBILE) {
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

    private function validateForbidenNumbers(string $phoneNumber): bool
    {
        return in_array($phoneNumber, $this->forbiddenNumbers, true);
    }
    // public static function getInstance(bool $includeNationalCode = true, array $allowedNationalCodes = []): self
    // {
    //     return new self($includeNationalCode, $allowedNationalCodes);
    // }

    private function validateE164Format($phoneNumber): bool
    {
        $phoneNumberObject = $this->parsePhoneNumber($phoneNumber);
        $normalizedNumber = $this->phoneNumberUtil->format($phoneNumberObject, PhoneNumberFormat::E164);

        return ($phoneNumber === $normalizedNumber);
    }

    private function validateRestrictedCountry($phoneNumber, array $allowedCountries): bool
    {
        $phoneNumberObject = $this->parsePhoneNumber($phoneNumber);
        $phoneNumberCountryCode = $this->phoneNumberUtil->getRegionCodeForNumber($phoneNumberObject);

        return in_array($phoneNumberCountryCode, $allowedCountries);
    }

    private function validateAllowedCountries($phoneNumber, array $allowedCountries): bool
    {
        $phoneNumberObject = $this->parsePhoneNumber($phoneNumber);
        $phoneNumberCountryCode = $this->phoneNumberUtil->getRegionCodeForNumber($phoneNumberObject);

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
