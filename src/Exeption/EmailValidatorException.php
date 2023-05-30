<?php

namespace  Ericc70\ValidationUtils\Exeption;

use Exception;
use Throwable;



class EmailValidatorException extends Exception {
    public function __construct($message = "Invalid email address", $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}