<?php

namespace Ericc70\ValidationUtils\Lib;

use Exception;
use InvalidArgumentException;
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

    public function __construct(bool $includeNationalCode = true, array $allowedNationalCodes = ['33', '32'])
    {
        $this->phoneNumberUtil = PhoneNumberUtil::getInstance();
        $this->forbiddenNumbers = $this->loadForbiddenNumbers();
        $this->includeNationalCode = $includeNationalCode;
        $this->allowedNationalCodes = $allowedNationalCodes;
    }

    private function loadForbiddenNumbers()
    {
        $forbiddenNumbers = [];
        $forbiddenNumbersFile = realpath(__DIR__ . '/../Data/forbiddenNumberPhone.txt');

        if (file_exists($forbiddenNumbersFile)) {
            $numbers = file($forbiddenNumbersFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            return array_map('trim', $numbers);
        } else {
            throw new InvalidArgumentException("Forbidden numbers file not found: $forbiddenNumbersFile");
        }
    }

    public function validate($phoneNumber): bool
    {
        $phoneNumberObject = $this->parsePhoneNumber($phoneNumber);
        $this->validateNumberFormat($phoneNumberObject);
        $this->validateNumberIsAllowed($phoneNumberObject);

        return true;
    }

    private function parsePhoneNumber($phoneNumber)
    {
        try {
            return $this->phoneNumberUtil->parse($phoneNumber, null);
        } catch (NumberParseException $e) {
            throw new ValidatorException('Numéro non valide');
        }
    }

    private function validateNumberFormat($phoneNumberObject)
    {
        if (!$this->phoneNumberUtil->isValidNumber($phoneNumberObject)) {
            throw new ValidatorException('Numéro non valide');
        }
    }

    private function validateNumberIsAllowed($phoneNumberObject)
    {
        $phoneNumberData = '';
        if ($this->includeNationalCode) {
            $phoneNumberData .= $phoneNumberObject->getCountryCode();
        }
        $phoneNumberData .= $phoneNumberObject->getNationalNumber();

        if (!in_array($phoneNumberObject->getCountryCode(), $this->allowedNationalCodes)) {
            throw new ValidatorException('Indicatif national non autorisé');
        }

        if (in_array($phoneNumberData, $this->forbiddenNumbers)) {
            throw new ValidatorException('Numéro non autorisé');
        }
    }

    public function setAllowedNationalCodes(array $allowedNationalCodes)
    {
        $this->allowedNationalCodes = $allowedNationalCodes;
    }

    public function getAllowedNationalCodes()
    {
        return $this->allowedNationalCodes;
    }
}

