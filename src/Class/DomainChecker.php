<?php

namespace  Ericc70\ValidationUtils\Class;

use InvalidArgumentException;

class DomainChecker {
    private $bannedDomains;

    public function __construct() {
        $this->bannedDomains = $this->loadBannedDomains();
    }

    private function loadBannedDomains() {
        $bannedDomainsFile = realpath(__DIR__ . '/../Data/forbidenDomainEmail.txt');
       
        if (file_exists($bannedDomainsFile)) {
            $domains = file($bannedDomainsFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
          return array_map('trim', $domains);
      
        } else {
            throw new InvalidArgumentException("Banned domains file not found: $bannedDomainsFile");
        }
    }

    public function isDomainBanned($email) {
        $domain = substr(strrchr($email, "@"), 1);
   
        return in_array($domain, $this->bannedDomains);
    }
}