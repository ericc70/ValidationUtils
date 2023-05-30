<?php

namespace Ericc70\ValidationUtils\Lib;

use Ericc70\ValidationUtils\Interface\ValidatorInterface;
use Ericc70\ValidationUtils\Exeption\EmailValidatorException;


class EmailValidator implements ValidatorInterface {
    public function validate($value): bool {
        // Logic to validate the email
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            throw new EmailValidatorException("Invalid email address: $value");
        }
    }
}