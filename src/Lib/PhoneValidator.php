<?php

namespace Ericc70\ValidationUtils\Lib;

use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\NumberParseException;
use Ericc70\ValidationUtils\Exception\ValidatorException;
use Ericc70\ValidationUtils\Interface\ValidatorInterface;

class PhoneValidator implements ValidatorInterface
{
    private $phoneNumberUtil;
    private $forbiddenNumbers;
    private $includeNationalCode;
    private $allowedNationalCodes;

    private const FORBIDDEN_NUMBERS_FILE = '/../Data/forbiddenNumberPhone.txt';

    public function __construct(bool $includeNationalCode = true, array $allowedNationalCodes = [33])
    {
        $this->phoneNumberUtil = PhoneNumberUtil::getInstance();
        $this->forbiddenNumbers = $this->loadForbiddenNumbers();
        $this->includeNationalCode = $includeNationalCode;
        $this->allowedNationalCodes = $allowedNationalCodes;
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

    public static function getInstance(bool $includeNationalCode = true, array $allowedNationalCodes = []): self
    {
        return new self($includeNationalCode, $allowedNationalCodes);
    }

    public function validate($phoneNumber): bool
    {
        try {
            $phoneNumberObject = $this->parsePhoneNumber($phoneNumber);
            $this->validateNumberFormat($phoneNumberObject);
            // $this->validateNumberIsAllowed($phoneNumberObject);
            return true;
        } catch (NumberParseException $e) {
            throw new ValidatorException('Invalid phone number');
        }
    }
/**private */
    private function parsePhoneNumber($phoneNumber, $pays=null)
    {
        return $this->phoneNumberUtil->parse($phoneNumber, $pays);
    }

    private function validateNumberFormat($phoneNumberObject)
    {
        if (!$this->phoneNumberUtil->isValidNumber($phoneNumberObject)) {
            throw new ValidatorException('Invalid phone number');
        }
    }

    private function validateNumberIsAllowed($phoneNumberObject)
    {
        $phoneNumberData = ($this->includeNationalCode) ? $phoneNumberObject->getCountryCode() : '';
        $phoneNumberData .= $phoneNumberObject->getNationalNumber();

        if (!in_array($phoneNumberObject->getCountryCode(), $this->allowedNationalCodes, true)) {
            throw new ValidatorException('Invalid national code');
        }

        if (in_array($phoneNumberData, $this->forbiddenNumbers, true)) {
            throw new ValidatorException('Forbidden phone number');
        }
    }

    public function validatePhoneNumberInternationalFormat($phoneNumber): bool
    {
        $phoneNumberObject = $this->parsePhoneNumber($phoneNumber);
        $this->validateNumberFormat($phoneNumberObject);

        return true;
    }

    public function validatePhoneNumberNationalFormat($phoneNumber, $pays): bool
    {
       
        $phoneNumberObject = $this->parsePhoneNumber($phoneNumber, $pays);
    
        $this->validateNumberFormat($phoneNumberObject);
    
        if ($this->includeNationalCode) {
            throw new ValidatorException('Phone number must be in national format (without country code)');
        }
    
        return true;
    }

    // public function validatePhoneNumberWithNationalCode($phoneNumber, $nationalCode): bool
    // {
    //     $phoneNumberObject = $this->parsePhoneNumber($phoneNumber, $nationalCode);

    //     $this->validateNumberFormat($phoneNumberObject);

    //     if ($phoneNumberObject->getCountryCode() !== $nationalCode) {
    //         throw new ValidatorException('Incorrect national code');
    //     }

    //     return true;
    // }

    public function validateFixedOrMobile($phoneNumber): string
    {
        $phoneNumberObject = $this->parsePhoneNumber($phoneNumber);
        $this->validateNumberFormat($phoneNumberObject);

        if ($this->phoneNumberUtil->getNumberType($phoneNumberObject) === PhoneNumberType::FIXED_LINE) {
            return 'fixed';
        } elseif ($this->phoneNumberUtil->getNumberType($phoneNumberObject) === PhoneNumberType::MOBILE) {
            return 'mobile';
        } else {
            throw new ValidatorException('Le type du numéro de téléphone n\'est ni fixe ni mobile.');
        }
    }


    public function setIncludeNationalCode(bool $includeNationalCode)
    {
        $this->includeNationalCode = $includeNationalCode;
    }

    public function getIncludeNationalCode(): bool
    {
        return $this->includeNationalCode;
    }

    public function getAllowedNationalCodes(): array
    {
        return $this->allowedNationalCodes;
    }
}
