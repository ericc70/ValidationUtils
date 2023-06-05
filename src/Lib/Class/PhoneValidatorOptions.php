<?php

namespace Ericc70\ValidationUtils\Lib\Class;


class PhoneValidatorOptions {
    
    private bool $mobile = false;
    private bool $fixed = false;
    private bool $formatE164 = false;
    private array $restrictedCountries = [];
    private array $allowedCountries = [];
    private bool $forbiddenNumber = false;
    private string $currentCountry = '';
    private bool $specialCharacters = false;
    
    //...



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
    public function hasAllowedCountries(): bool
    {
        return !empty($this->allowedCountries);
    }
    
    public function hasRestrictedCountries (): bool
    {
        return !empty($this->restrictedCountries);
    }

    public function hasCurrentCountry():bool
    {
        return $this->currentCountry != '';
    }

    
    public function isMobileEnabled(): bool
    {
        return $this->mobile;
    }
    
    public function isFixedEnabled(): bool
    {
        return $this->fixed;
    }
    
    public function isFormatE164Enabled(): bool
    {
        return $this->formatE164;
    }
    
    public function getRestrictedCountries(): array
    {
        return $this->restrictedCountries;
    }
    
    public function getAllowedCountries(): array
    {
        return $this->allowedCountries;
    }
    
    public function isForbiddenNumberEnabled(): bool
    {
        return $this->forbiddenNumber;
    }

    public function getCurrentCountry (){
        return $this->currentCountry;
    }

    public function isSpecialCharactersEnabled():bool
    {
        return $this->specialCharacters;
    }
}