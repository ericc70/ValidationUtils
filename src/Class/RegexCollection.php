<?php

namespace  Ericc70\ValidationUtils\Class;

use Exception;

class RegexCollection
{
    public static function getRegex($name)
    {
        $regexes = [
            'alphaNumeric' => '/^[a-zA-Z0-9]+$/',
            'email' => '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            // Ajoutez d'autres regex réutilisables ici...
        ];

        if (isset($regexes[$name])) {
            return $regexes[$name];
        }

        throw new Exception("Regex '$name' not found.");
    }
}
