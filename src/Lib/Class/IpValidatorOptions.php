<?php

namespace Ericc70\ValidationUtils\Lib\Class;


class IpValidatorOptions {
    
    private bool $tor = false;
    private bool $privateIp = false;
    private bool $localhostIp = false;
    private bool $ipV4 = false;
    private bool $ipV6 = false;
    private array $forbidenIp = [];
    private array $allowIp = [];
    private array $allowCountry = [];
    private array $forbidenCountry = [];


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

    public function getTor():bool
    {
        return $this->tor;
    }

    public function getPrivateIp():bool
    {
        return $this->privateIp;
    }

    public function getLocalhostIp():bool
    {
        return $this->localhostIp;
    }

    public function getIpV4():bool
    {
        return $this->ipV4;
    }
    public function getIpV6():bool
    {
        return $this->ipV6;
    }
    public function hasForbidenIp():bool
    {
        return !empty($this->forbidenIp);
    }
    public function getForbidenIp():array
    {
        return $this->forbidenIp;
    }
    
    public function hasAllowIp():bool
    {
        return !empty($this->allowIp);
    }
    public function getAllowIp():array
    {
        return $this->allowIp;
    }
    public function hasAllowCountry():bool
    {
        return !empty($this->allowCountry);
    }
    public function getAllowCountry():array
    {
        return $this->allowCountry;
    }
    public function hasForbidenCountry():bool
    {
        return !empty($this->forbidenCountry);
    }
    public function getForbidenCountry():array
    {
        return $this->forbidenCountry;
    }
    


}