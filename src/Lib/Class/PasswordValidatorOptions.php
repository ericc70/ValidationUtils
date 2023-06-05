<?php

namespace Ericc70\ValidationUtils\Lib\Class;


class PasswordValidatorOptions {
    public int $minLength;
    public int $maxLenght;
    public int $minSpecialCharacters;
    public int $minNumericCharacters;
    public int $minAlphaCharacters;
    public int $minLowerCaseCharacters;
    public int $minUpperCaseCharacters;
    public int $maxRepeatedCharacters =2;

    public function __construct(array $options = []) {
        $this->hydrate($options);
    }

    private function hydrate(array $options) {
        foreach ($options as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}