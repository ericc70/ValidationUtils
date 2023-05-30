<?php

namespace Ericc70\ValidationUtils\Lib;

use Ericc70\ValidationUtils\Interface\ValidatorInterface;
use Ericc70\ValidationUtils\Exeption\EmailValidatorException;


class EmailValidator implements ValidatorInterface {
    public function validate($value): bool {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new EmailValidatorException('L\'adresse email n\'est pas valide.');
        }

        $domain = explode('@', $value)[1];
        $parts = explode('.', $domain);
        if(count($parts) < 2) {
            throw new EmailValidatorException('Le domaine de l\'adresse email n\'est pas valide.');
        }
        $tld = $parts[count($parts) - 1];
        if (!checkdnsrr($tld . '.', 'NS')) {
            throw new EmailValidatorException('Le domaine de l\'adresse email n\'est pas valide.');
        }

        return true;
    }
}