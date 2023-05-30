<?php

class DomainChecker {
    private $bannedDomains;

    public function __construct() {
        $this->bannedDomains = $this->loadBannedDomains();
    }

    private function loadBannedDomains() {
        $bannedDomainsFile = './../Data/forbidenDomainEmail.txt';
        if (file_exists($bannedDomainsFile)) {
            return file($bannedDomainsFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        } else {
            throw new InvalidArgumentException("Banned domains file not found: $bannedDomainsFile");
        }
    }

    public function isDomainBanned($email) {
        $domain = substr(strrchr($email, "@"), 1);
        return in_array($domain, $this->bannedDomains);
    }
}