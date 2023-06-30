<?php

namespace Ericc70\ValidationUtils\Lib;


use Ericc70\ValidationUtils\Interface\ValidatorInterface;
use Ericc70\ValidationUtils\Lib\Class\IpValidatorOptions;

class IpValidator implements ValidatorInterface {

    public function validate( $ip, array $options = []): bool
    {

        $ipOptions = new IpValidatorOptions($options);

        if($ipOptions->getTor() );

        if($ipOptions->getPrivateIp());

        if($ipOptions->getLocalhostIp());

        if($ipOptions->getIpV4());
        if($ipOptions->getIpV6());

        if($ipOptions->hasForbidenIp());
        if($ipOptions->hasAllowIp());
        if($ipOptions->hasAllowCountry());
        if($ipOptions->hasForbidenCountry());


        return 0;
    }


    // function isPrivateIp($ip) {
    //     return preg_match('/^(10\.|192\.168\.|172\.(1[6-9]|2\d|3[0-1])\.)/', $ip);
    //   }
      
    

    //   function isLocalhostIp($ip) {
    //     return preg_match('/^(127\.0\.0\.1|::1|fe80::1|::ffff:127\.0\.0\.1)/', $ip);
    //   }

    //   function isBehindNAT($ip) {
    //     return preg_match('/^(10\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}|192\.168\.[0-9]{1,3}\.[0-9]{1,3}|172\.(1[6-9]|2[0-9]|3[0-1])\.[0-9]{1,3}\.[0-9]{1,3}|169\.254\.[0-9]{1,3}\.[0-9]{1,3}|192\.0\.2\.[0-9]{1,3}|198\.51\.100\.[0-9]{1,3}|203\.0\.113\.[0-9]{1,3})$/',$ip);
    //   }

      


      

}