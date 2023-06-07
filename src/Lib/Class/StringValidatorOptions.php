<?php

namespace Ericc70\ValidationUtils\Lib\Class;


class StringValidatorOptions {

    protected int $minLength = 1;
    protected int $maxLength = 255;
    protected string $regex = "";
    protected bool $required = false;

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
    
    public function hasRegex():bool
    {
        return $this->regex != '';
    }
    
    public function getMinLength():int
    {
        return $this->minLength;
    }

    public function getMaxLength():int
    {
        return $this->maxLength;
    }

    public function isRequired():bool
    {
        return $this->required;
    }

    public function getRegex():string
    {
        return $this->regex;
    }
}