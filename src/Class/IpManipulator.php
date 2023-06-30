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

            return false;
        
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


    public function getCountryCode(){
        //
        $url = "https://freegeoip.app/json/{$this->ipAddress}";
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        
        if (isset($data['country_code'])) {
            return $data['country_code'];
        } 
         
        return 0;
    
    }


    // function isPrivateIp($ip) {
    //     return preg_match('/^(10\.|192\.168\.|172\.(1[6-9]|2\d|3[0-1])\.)/', $ip);
    //   }

      // only IP V4
      public function isPrivateIP() {
        return filter_var($this->ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false;      
      }

    //   function isLocalhostIp($ip) {
    //     return preg_match('/^(127\.0\.0\.1|::1|fe80::1|::ffff:127\.0\.0\.1)/', $ip);
    //   }

    //   function isBehindNAT($ip) {
    //     return preg_match('/^(10\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}|192\.168\.[0-9]{1,3}\.[0-9]{1,3}|172\.(1[6-9]|2[0-9]|3[0-1])\.[0-9]{1,3}\.[0-9]{1,3}|169\.254\.[0-9]{1,3}\.[0-9]{1,3}|192\.0\.2\.[0-9]{1,3}|198\.51\.100\.[0-9]{1,3}|203\.0\.113\.[0-9]{1,3})$/',$ip);
    //   }



}

