<?php

namespace Ericc70\ValidationUtils\Lib;

use InvalidArgumentException;
use Ericc70\ValidationUtils\Class\StringManipulator;
use Ericc70\ValidationUtils\Interface\ValidatorInterface;
use Ericc70\ValidationUtils\Lib\Class\PasswordValidatorOptions;

class PasswordValidator  implements ValidatorInterface
{
    private $stringManipulator;

    public function __construct()
    {
        $this->stringManipulator = new StringManipulator();
    }

    public function validate($value, array $options = []): bool
    {
        $passwordOptions = new PasswordValidatorOptions($options);

        if (!$this->validateLength($value, $passwordOptions)) {
            return false;
        }

        if (!$this->validateSpecialCharacters($value, $passwordOptions)) {
            return false;
        }

        if (!$this->validateNumericCharacters($value, $passwordOptions)) {
            return false;
        }

        if (!$this->validateAlphaCharacters($value, $passwordOptions)) {
            return false;
        }

        if (!$this->valideCaseCharacters($value, $passwordOptions))

        if (!$this->validateRepeatedCharacters($value, $passwordOptions))

        if ($this->isPasswordForbidden($value)) {
            return false;
        }

        return true;
    }

    public function getEntropy($value) :float
    {
        return $this->stringManipulator->calculateEntropy($value);
    }

    public function getBits($value) :int
    {
        return $this->stringManipulator->countBits($value);
    }

    private function validateLength($value, $passwordOptions): bool
    {
        $nunberCaractere = $this->stringManipulator->countCharacters($value);
        if (isset($passwordOptions->minLength)) {
            if ($nunberCaractere <= $passwordOptions->minLength) {
                return false;
            }
        }

        if (isset($passwordOptions->maxLength)) {
            if ($nunberCaractere >= $passwordOptions->maxLength) {
                return false;
            }
        }

        return true;
    }

    

    private function validateSpecialCharacters($value, $passwordOptions): bool
    {
        if (isset($passwordOptions->minSpecialCharacters)) {
            $specialCount = $this->stringManipulator->countSpecialCharacters($value);
            if ($specialCount <= $passwordOptions->minSpecialCharacters) {
                return false;
            }
        }

        return true;
    }

    private function validateNumericCharacters($value, $passwordOptions): bool
    {
        if (isset($passwordOptions->minNumericCharacters)) {
            $numCount = $this->stringManipulator->countNumericCharacters($value);
                  if ($numCount <= $passwordOptions->minNumericCharacters) {
                return false;
            }
        }

        return true;
    }

    private function validateAlphaCharacters($value, $passwordOptions): bool
    {
        if (isset($passwordOptions->minAlphaCharacters)) {
            $alphaCount = $this->stringManipulator->countAlphaCharacters($value);
            if ($alphaCount <= $passwordOptions->minAlphaCharacters) {
                return false;
            }
        }

        return true;
    }

    private function valideCaseCharacters($value, $passwordOptions ){
       

        if (isset($passwordOptions->minLowerCaseCharacters)) {
            $lowercaseCount = $this->stringManipulator->countLowerCharacters($value); 
            if ($lowercaseCount <= $passwordOptions->minLowerCaseCharacters) {
                return false;
            }
        }
        if (isset($passwordOptions->minUpperCaseCharacters)) {
            $lowercaseCount = $this->stringManipulator->countUpperCharacters($value);
            if ($lowercaseCount <= $passwordOptions->minUpperCaseCharacters) {
                return false;
            }
        }
  
   
    }
 
    

    private function forbiddenPassword($string)
    {
        $baseDir = realpath(__DIR__ . '/../Data');
        $file = $baseDir . '/forbidenPassword.txt';
        if (file_exists($file)) {
            $domains = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            return array_map('trim', $domains);
        } else {
            throw new InvalidArgumentException("Banned domains file not found: $file");
        }
    }

    
    private function validateRepeatedCharacters($value, $passwordOptions): bool
    {
        $repeatedChars = preg_match('/(.)\1{' . ($passwordOptions->maxRepeatedCharacters - 1) . ',}/', $value);
        return !$repeatedChars;
    }



    private function isPasswordForbidden($value): bool
    {
        $forbiddenPasswords = $this->forbiddenPassword($value);
        if (in_array($value, $forbiddenPasswords)) {
            return true;
        }

        return false;
    }

/*
    private function validatePasswordStrength($value, $passwordOptions): bool
        {
            $score = 0;

            // Vérification de la longueur
            $length = strlen($value);
            if ($length >= $passwordOptions->minLength) {
                $score++;
            }

            // Vérification de la diversité des caractères
            if ($this->validateLowerAndUpperCase($value)) {
                $score++;
            }

            if ($this->validateAlphaNumericCharacters($value)) {
                $score++;
            }

            // Vérification de la complexité
            $entropy = $this->calculateEntropy($value);
            if ($entropy >= $passwordOptions->minEntropy) {
                $score++;
            }

            return $score >= $passwordOptions->minScore;
        }

    private function validatePasswordSimilarity($value, $passwordOptions): bool
    {
        // Vérification de la similarité avec des informations personnelles
        $personalInfo = $this->getPersonalInfo(); // Méthode à implémenter
        foreach ($personalInfo as $info) {
            if (strpos($value, $info) !== false) {
                return false;
            }
        }

        return true;
    }

    private function getPersonalInfo()
    {
        // Retourne une liste d'informations personnelles (noms, adresses e-mail, dates de naissance, etc.)
        // qui ne doivent pas être présentes dans le mot de passe
        // À implémenter en fonction de votre contexte et des informations disponibles
        return [];
    }
*/
}



   

