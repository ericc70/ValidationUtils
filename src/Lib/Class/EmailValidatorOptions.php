<?php

namespace Ericc70\ValidationUtils\Lib\Class;


class EmailValidatorOptions {
    public bool $checkBan = false;

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