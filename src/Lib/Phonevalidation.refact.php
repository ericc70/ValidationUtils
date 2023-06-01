<?php
class PhoneValidator implements ValidatorInterface
{
    private $phoneNumberUtil;
    private $forbiddenNumbers;
    private $includeNationalCode;
    private $limitNationalCodes;

    public function __construct($includeNationalCode = true, $limitNationalCodes = false)
    {
        $this->phoneNumberUtil = PhoneNumberUtil::getInstance();
        $this->forbiddenNumbers = $this->loadForbiddenNumbers();
        $this->includeNationalCode = $includeNationalCode;
        $this->limitNationalCodes = $limitNationalCodes;
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

    public function validate($phoneNumber, $includeNationalCode = null, $limitNationalCodes = null): bool
    {
        $includeNationalCode = $includeNationalCode !== null ? $includeNationalCode : $this->includeNationalCode;
        $limitNationalCodes = $limitNationalCodes !== null ? $limitNationalCodes : $this->limitNationalCodes;

        $phoneNumberObject = $this->parsePhoneNumber($phoneNumber);
        $this->validateNumberFormat($phoneNumberObject);
        $this->validateNumberIsAllowed($phoneNumberObject, $includeNationalCode, $limitNationalCodes);

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

    private function validateNumberIsAllowed($phoneNumberObject, $includeNationalCode, $limitNationalCodes)
    {
        $phoneNumberData = '';
        if ($includeNationalCode) {
            $phoneNumberData .= $phoneNumberObject->getCountryCode();
        }
        $phoneNumberData .= $phoneNumberObject->getNationalNumber();

        if ($limitNationalCodes && !in_array($phoneNumberObject->getCountryCode(), $this->allowedNationalCodes)) {
            throw new ValidatorException('Indicatif national non autorisé');
        }

        if (in_array($phoneNumberData, $this->forbiddenNumbers)) {
            throw new ValidatorException('Numéro non autorisé');
        }
    }
}
