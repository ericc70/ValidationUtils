<?php

namespace  Ericc70\ValidationUtils\Class;

use Exception;

class RegexCollection
{
    private static $regexes = [
        'alphaNumeric' => '/^[a-zA-Z0-9]+$/',
        'email' => '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
        'url' => '/^(http|https):\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,}(\/\S*)?$/',
        // Ajoutez d'autres regex réutilisables ici...
    ];

    public static function getRegex($name)
    {
        if (isset(self::$regexes[$name])) {
            return self::$regexes[$name];
        }

        throw new Exception("Regex '$name' not found.");
    }

    public static function addRegex($name, $regex)
    {
        self::$regexes[$name] = $regex;
    }
}
