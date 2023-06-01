<?php

namespace Ericc70\ValidationUtils\Lib;

use Ericc70\ValidationUtils\Exception\ValidatorException;
use Ericc70\ValidationUtils\Interface\ValidatorInterface;

class StringValidator implements ValidatorInterface
{
    public function validate($value, $options = []): bool
    {
        // Vérifier si la valeur est une chaîne de caractères
        if (!is_string($value)) {
            throw new ValidatorException('Ceci n\est pas une chaine de caractère');
        }

        // Vérifier la longueur minimale
        if (isset($options['minLength']) && strlen($value) < $options['minLength']) {
            throw new ValidatorException('Longueur minimal requis');
        }

        // Vérifier la longueur maximale
        if (isset($options['maxLength']) && strlen($value) > $options['maxLength']) {
            throw new ValidatorException('Longueur maximun dépassée');
        }

        // Vérifier la présence d'une expression régulière
        if (isset($options['regex']) && !preg_match($options['regex'], $value)) {
            throw new ValidatorException('Vérification spécifique fail');
        }

        // Autres règles de validation spécifiques selon les besoins...

        return true;
    }
}