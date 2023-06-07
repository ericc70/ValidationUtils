<?php

namespace Ericc70\ValidationUtils\Lib;

use Exeption;
use Exception;
use InvalidArgumentException;
use Ericc70\ValidationUtils\Trait\StringTrait;
use Ericc70\ValidationUtils\Class\StringManipulator;
use Ericc70\ValidationUtils\Exception\ValidatorException;
use Ericc70\ValidationUtils\Interface\ValidatorInterface;
use Ericc70\ValidationUtils\Lib\Class\PasswordValidatorOptions;

class PasswordValidator  implements ValidatorInterface
{
    // use StringTrait;
    private $stringManipulator;

    public function __construct()
    {
        $this->stringManipulator = new StringManipulator();
    }

    public function validate($value, array $options = []): bool
    {
        $passwordOptions = new PasswordValidatorOptions($options);


        if (!$this->validateLength($value, $passwordOptions)) {
            throw new ValidatorException('fail number Length');
        }

        if (!$this->validateSpecialCharacters($value, $passwordOptions)) {
            throw new ValidatorException('fail number special characters');
        }

        if (!$this->validateNumericCharacters($value, $passwordOptions)) {
            throw new ValidatorException('fail number numeric characters');
        }

        if (!$this->validateAlphaCharacters($value, $passwordOptions)) {
            throw new ValidatorException('fail number alpha characters');
        }

        if (!$this->valideCaseCharacters($value, $passwordOptions)) {
            throw new ValidatorException('fail number case characters');
        }

        if (!$this->validateRepeatedCharacters($value, $passwordOptions)) {
            throw new ValidatorException('fail number repeated characters');
        }


        if ($passwordOptions->isforbidenPassword() && $this->isPasswordForbidden($value)) {
            throw new ValidatorException('forbiden password');
        }



        return true;
    }


    private function validateLength($value, $passwordOptions): bool
    {
        $nunberCaractere = $this->stringManipulator->countCharacters($value);

        if ($nunberCaractere < $passwordOptions->getMinLength()) {
            throw new ValidatorException('fail number min characters');
        }

        if ($nunberCaractere >= $passwordOptions->getMaxLength()) {
            throw new ValidatorException('fail number max characters');
        }

        return true;
    }

    private function validateSpecialCharacters($value, $passwordOptions): bool
    {
        $specialCount = $this->stringManipulator->countSpecialCharacters($value);

        if ($specialCount < $passwordOptions->getMinSpecialCharacters()) {
            throw new ValidatorException('Invalid number special characters');
        }

        return true;
    }

    private function validateNumericCharacters($value, $passwordOptions): bool
    {
        $numCount = $this->stringManipulator->countNumericCharacters($value);
        if ($numCount < $passwordOptions->getMinNumericCharacters()) {
            throw new ValidatorException('Invalid number numeric characters');
        }

        return true;
    }

    private function validateAlphaCharacters($value, $passwordOptions): bool
    {
        $alphaCount = $this->stringManipulator->countAlphaCharacters($value);
        if ($alphaCount < $passwordOptions->getMinAlphaCharacters()) {
            throw new ValidatorException('Invalid number alpha characters');
        }

        return true;
    }

    private function valideCaseCharacters($value, $passwordOptions)
    {
        $lowercaseCount = $this->stringManipulator->countLowerCharacters($value);
        if ($lowercaseCount < $passwordOptions->getMinLowerCaseCharacters()) {
            throw new ValidatorException('fail number lower characters');
        }

        $lowercaseCount = $this->stringManipulator->countUpperCharacters($value);
        if ($lowercaseCount < $passwordOptions->getMinUpperCaseCharacters()) {
            throw new ValidatorException('fail number upper characters');
        }

        return true;
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
        $repeatedChars = preg_match('/(.)\1{' . ($passwordOptions->getMaxRepeatedCharacters() - 1) . ',}/', $value);
        return !$repeatedChars;
    }

    private function isPasswordForbidden($value): bool
    {
        $forbiddenPasswords = $this->forbiddenPassword($value);
        return in_array($value, $forbiddenPasswords);
     
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
