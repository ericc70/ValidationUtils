<?php

namespace  Ericc70\ValidationUtils\Class;

class IPManipulator {
    
    private $ipAddress;
    
    public function __construct($ipAddress) {
        $this->ipAddress = $ipAddress;
    }
    
    public function getIPAddress() {
        return $this->ipAddress;
    }
    
    public function validateIP() {
        if (filter_var($this->ipAddress, FILTER_VALIDATE_IP)) {
            return true;
        } 
            return false;
        
    }
    
    public function getIPVersion() {
        if (filter_var($this->ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return 'IPv4';
        } elseif (filter_var($this->ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            return 'IPv6';
        } 

            return 'Unknown';
        
    }
    
    public function getOctets() {
        if ($this->validateIP()) {
            $octets = explode('.', $this->ipAddress);
            return $octets;
        } 
            return false;
        
    }
    
    public function reverseDNSLookup() {
        if ($this->validateIP()) {
            $reverseIP = implode('.', array_reverse(explode('.', $this->ipAddress)));
            $hostname = gethostbyaddr($reverseIP);
            return $hostname;
        } 
            return false;
        
    }


}

