<?php

namespace Ericc70\ValidationUtils\Lib;

use Ericc70\ValidationUtils\Interface\ValidatorInterface;

class StringValidator implements ValidatorInterface
{
    public function validate($value, $options = []): bool
    {
        // Vérifier si la valeur est une chaîne de caractères
        if (!is_string($value)) {
            return false;
        }

        // Vérifier la longueur minimale
        if (isset($options['minLength']) && strlen($value) < $options['minLength']) {
            return false;
        }

        // Vérifier la longueur maximale
        if (isset($options['maxLength']) && strlen($value) > $options['maxLength']) {
            return false;
        }

        // Vérifier la présence d'une expression régulière
        if (isset($options['regex']) && !preg_match($options['regex'], $value)) {
            return false;
        }

        // Autres règles de validation spécifiques selon les besoins...

        return true;
    }
}