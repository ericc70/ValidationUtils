<?php

namespace Ericc70\ValidationUtils\Lib;

use Ericc70\ValidationUtils\Exception\ValidatorException;
use Ericc70\ValidationUtils\Interface\ValidatorInterface;

class StringValidator implements ValidatorInterface
{
    public function validate($value, $options = []): bool
    {
        $this->checkValueType($value);
        $this->checkMinLength($value, $options);
        $this->checkMaxLength($value, $options);
        $this->checkRegex($value, $options);
        $this->checkRequired($value, $options);
        // Ajouter d'autres règles de validation spécifiques si nécessaire...

        return true;
    }

    private function checkValueType($value)
    {
        if (!is_string($value)) {
            throw new ValidatorException('Ceci n\'est pas une chaîne de caractères');
        }
    }

    private function checkMinLength($value, $options)
    {
        if (isset($options['minLength']) && strlen($value) < $options['minLength']) {
            throw new ValidatorException('La longueur minimale n\'est pas respectée');
        }
    }

    private function checkMaxLength($value, $options)
    {
        if (isset($options['maxLength']) && strlen($value) > $options['maxLength']) {
            throw new ValidatorException('La longueur maximale est dépassée');
        }
    }

    private function checkRegex($value, $options)
    {
        if (isset($options['regex']) && !preg_match($options['regex'], $value)) {
            throw new ValidatorException('La vérification spécifique a échoué');
        }
    }

    private function checkRequired($value, $options): void
    {
        if (isset($options['required']) && $options['required'] && empty($value)) {
            throw new ValidatorException('La valeur est requise');
        }
    }
}
