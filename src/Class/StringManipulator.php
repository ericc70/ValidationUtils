<?php

namespace Ericc70\ValidationUtils\Class;

class StringManipulator
{
    public function countCharacters($string): int
    {
        return strlen($string);
    }

    public function countNumericCharacters($string): int
    {
        return preg_match_all('/[0-9]/', $string);
    }

    public function countAlphaCharacters($string): int
    {
        return preg_match_all('/[a-zA-Z]/', $string);
    }

    public function countSpecialCharacters($string): int
    {
        return preg_match_all('/[^\w\s]/u', $string);
    }

    public function countLowerCharacters($string): int
    {
        return preg_match_all('/[a-z]/', $string);
    }

    public function countUpperCharacters($string): int
    {
        return preg_match_all('/[A-Z]/', $string);
    }

    public function countBits($string): int
    {
        $chars = str_split($string);
        $bitCount = 0;

        foreach ($chars as $char) {
            $bitCount += substr_count(decbin(ord($char)), '1');
        }

        return $bitCount;
    }

    public function isString($string): bool
    {
        return is_string($string);
    }

    public function calculateEntropy($value): float
    {
        $uniqueChars = count(array_count_values(str_split($value)));
        $entropy = log(pow($uniqueChars, strlen($value)), 2);
        return $entropy;
    }
}
