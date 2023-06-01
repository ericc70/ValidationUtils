<?php
namespace  Ericc70\ValidationUtils\Exception;
use Exception;


class ValidatorException extends Exception
{
    // private $fieldName;

    public function __construct($message,  $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        // $this->fieldName = $fieldName;
    }

    // public function getFieldName()
    // {
    //     return $this->fieldName;
    // }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}


