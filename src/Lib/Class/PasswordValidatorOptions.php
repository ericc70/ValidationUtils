<?php

namespace Ericc70\ValidationUtils\Lib\Class;

class PasswordValidatorOptions {
   
    protected int $minLength = 10;
    protected int $maxLength = 255;
    protected int $minSpecialCharacters = 1;
    protected int $minNumericCharacters = 1;
    protected int $minAlphaCharacters = 1;
    protected int $minLowerCaseCharacters = 1;
    protected int $minUpperCaseCharacters = 1;
    protected int $maxRepeatedCharacters =3;
    protected bool $forbidenPassword = true;

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
 
    public function isforbidenPassword():bool
    {
        return $this->forbidenPassword;
    }

    public function getMinLength():int
    {
        return $this->minLength;
    }

    public function getmaxLength():int
    {
        return $this->maxLength;
    }

    public function getMinNumericCharacters():int
    {
        return $this->minNumericCharacters;
    }

    public function getMinSpecialCharacters():int
    {
        return $this->minSpecialCharacters;
    }

    public function getMinAlphaCharacters():int
    {
        return $this->minAlphaCharacters;
    }

    public function getMinLowerCaseCharacters():int
    {
        return $this->minLowerCaseCharacters;
    }
   
    public function getMinUpperCaseCharacters():int
    {
        return $this->minUpperCaseCharacters;
    }

    public function getMaxRepeatedCharacters():int
    {
        return $this->maxRepeatedCharacters;
    }
}