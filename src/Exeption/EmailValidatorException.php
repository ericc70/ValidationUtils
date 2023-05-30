<?php

namespace  Ericc70\ValidationUtils\Exeption;

use Exception;
use Throwable;



class EmailValidatorException extends Exception {

      public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}