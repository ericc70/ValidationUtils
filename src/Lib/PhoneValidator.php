<?php
namespace Ericc70\ValidationUtils\Lib;

use Exception;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\NumberParseException;
use Ericc70\ValidationUtils\Exception\ValidatorException;
use Ericc70\ValidationUtils\Interface\ValidatorInterface;


class PhoneValidator implements ValidatorInterface {
    private $phoneNumberUtil;
    private $forbiddenNumbers;

    public function __construct($forbiddenNumbersFile) {
        $this->phoneNumberUtil = PhoneNumberUtil::getInstance();
        $this->forbiddenNumbers = $this->loadForbiddenNumbers($forbiddenNumbersFile);
    }
    private function loadForbiddenNumbers($forbiddenNumbersFile) {
        $forbiddenNumbers = [];

        // Essayer de charger les numéros interdits depuis le fichier spécifié
        $forbiddenNumbersData = file_get_contents($forbiddenNumbersFile);
        
        if (!$forbiddenNumbersData) {
            // Essayer de charger depuis un autre fichier de secours
            $forbiddenNumbersFileFallback =  realpath(__DIR__ . '/../Data/forbidenNumberPhone.json');
            $forbiddenNumbersData = file_get_contents($forbiddenNumbersFileFallback);
        }
        
        if (!$forbiddenNumbersData) {
            // Impossible de charger les numéros interdits, faire quelque chose (par exemple, générer une erreur)
            throw new Exception("Impossible de charger les numéros interdits.");
        }

        $forbiddenNumbers = json_decode($forbiddenNumbersData, true);

        return $forbiddenNumbers;
    }

    public function validate($phoneNumber):bool {
        try {
            // Vérifier le format du numéro de téléphone
            $phoneNumberObject = $this->phoneNumberUtil->parse($phoneNumber, null);
            if (!$this->phoneNumberUtil->isValidNumber($phoneNumberObject)) {
                return false;
            }

            // Vérifier si le numéro de téléphone est interdit
            foreach ($this->forbiddenNumbers as $pattern) {
                if (preg_match($pattern, $phoneNumber)) {
                    return false;
                }
            }

            return true;
        } catch (NumberParseException $e) {
            return false;
        }
    }
}