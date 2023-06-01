<?php

namespace  Ericc70\ValidationUtils\Class;

use InvalidArgumentException;

class DomainChecker
{
    private $bannedDomains;

    public function __construct()
    {
        $this->bannedDomains = $this->loadBannedDomains();
    }

    private function loadBannedDomains()
    {
        $bannedDomainsFile = $this->getBannedDomainsFilePath();

        if (file_exists($bannedDomainsFile)) {
            $domains = file($bannedDomainsFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            return array_map('trim', $domains);
        } else {
            throw new InvalidArgumentException("Banned domains file not found: $bannedDomainsFile");
        }
    }

    private function getBannedDomainsFilePath()
    {
        $baseDir = realpath(__DIR__ . '/../Data');
        return $baseDir . '/forbidenDomainEmail.txt';
    }

    public function isDomainBanned($email)
    {
        $domain = $this->extractDomainFromEmail($email);
        return in_array($domain, $this->bannedDomains);
    }

    private function extractDomainFromEmail($email)
    {
        $parts = explode('@', $email);
        return end($parts);
    }
}
