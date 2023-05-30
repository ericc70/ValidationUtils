<?php

namespace Ericc70\ValidationUtils\Lib;

use Throwable;
use Ericc70\ValidationUtils\Class\DomainChecker;
use Ericc70\ValidationUtils\Interface\ValidatorInterface;
use Ericc70\ValidationUtils\Lib\Class\EmailValidatorOptions;
use Ericc70\ValidationUtils\Exeption\EmailValidatorException;

class EmailValidator implements ValidatorInterface {

    private $domainChecker;
    
    public function __construct(DomainChecker $domainChecker = null ) {
        $this->domainChecker = $domainChecker ?? new DomainChecker();
     
    }

    public function validate($value, array $options = []): bool{

        $emailOptions = new EmailValidatorOptions($options);

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new EmailValidatorException('L\'adresse email n\'est pas valide.');
        }

        $domain = explode('@', $value)[1];
        $parts = explode('.', $domain);
        if(count($parts) < 2) {
            throw new EmailValidatorException('Le domaine de l\'adresse email n\'est pas valide 2.');
        }
        // $tld = end($parts);
        if (!checkdnsrr($domain . '.', 'MX')) {
         
            throw new EmailValidatorException('Le domaine de l\'adresse email n\'est pas valide 3.');

        }
        if ($options !== null && $emailOptions->checkBan && $this->domainChecker->isDomainBanned($value)) {
            throw new EmailValidatorException('Le domaine de l\'adresse email est banni.');
        }

        return true;
    }
}