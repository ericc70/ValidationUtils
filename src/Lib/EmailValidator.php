<?php

namespace Ericc70\ValidationUtils\Lib;

use Throwable;
use Ericc70\ValidationUtils\Class\DomainChecker;
use Ericc70\ValidationUtils\Interface\ValidatorInterface;
use Ericc70\ValidationUtils\Lib\Class\EmailValidatorOptions;
use Ericc70\ValidationUtils\Exception\ValidatorException;

class EmailValidator implements ValidatorInterface {
    private $domainChecker;
    
    public function __construct(DomainChecker $domainChecker = null) {
        $this->domainChecker = $domainChecker ?: new DomainChecker();
    }

    public function validate( $value, array $options = []): bool {
        $emailOptions = new EmailValidatorOptions($options);
  
        $domain = $this->extractDomain($value);
        
        if (!$this->isValidEmail($value)) {
            throw new ValidatorException('L\'adresse email n\'est pas valide.');
        }

        if ($emailOptions->isValidDomain() && !$this->isValidDomain($domain)) {
            throw new ValidatorException('Le domaine de l\'adresse email n\'est pas valide.');
        }
;
        if ($emailOptions->isBanDomain() && $this->domainChecker->isDomainBanned($value)) {
            
            throw new ValidatorException('Le domaine de l\'adresse email est banni.');
        }

        return true;
    }

    private function isValidEmail($value): bool {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    private function extractDomain($value): string {
        $parts = explode('@', $value);
        if (count($parts) < 2) {
            throw new ValidatorException('Le domaine de l\'adresse email n\'est pas valide.');
        }
        return $parts[1];
    }

    private function isValidDomain($domain): bool {
        $parts = explode('.', $domain);
        return count($parts) >= 2 && checkdnsrr($domain . '.', 'MX');
    }
}
