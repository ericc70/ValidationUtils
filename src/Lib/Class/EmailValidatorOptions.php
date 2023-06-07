<?php

namespace Ericc70\ValidationUtils\Lib\Class;


class EmailValidatorOptions {
   
    protected bool $banDomain = false;
    private bool $validDomain = true;
    // private bool $banEmail = false;
    // private string $listBanEmail = '';

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

    public function isBanDomain()
    {
        return $this->banDomain;
    }

    // public function isBanEmail()
    // {
    //     return $this->banDomain;
    // }
    public function isvalidDomain()
    {
        return $this->validDomain;
    }


}