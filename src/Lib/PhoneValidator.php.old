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

    public function __construct()
    {
        $this->phoneNumberUtil = PhoneNumberUtil::getInstance();
        $this->forbiddenNumbers = $this->loadForbiddenNumbers();
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
        try {
            // Vérifier le format du numéro de téléphone
            $phoneNumberObject = $this->phoneNumberUtil->parse($phoneNumber, null);
            if (!$this->phoneNumberUtil->isValidNumber($phoneNumberObject)) {
                throw new ValidatorException('Numéro non valide');
            }

        // Vérifier si le numéro de téléphone est interdit
        $phoneNumberData = $phoneNumberObject->getCountryCode() . $phoneNumberObject->getNationalNumber();
        if (in_array($phoneNumberData, $this->forbiddenNumbers)) {
            throw new ValidatorException('Numéro non autorisé');
        }
            return true;
        } catch (NumberParseException $e) {
            return false;
        }
    }
}