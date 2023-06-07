<?php

namespace Ericc70\ValidationUtils\Lib;

use Ericc70\ValidationUtils\Class\StringManipulator;
use Ericc70\ValidationUtils\Exception\ValidatorException;
use Ericc70\ValidationUtils\Interface\ValidatorInterface;
use Ericc70\ValidationUtils\Lib\Class\StringValidatorOptions;
use Ericc70\ValidationUtils\Trait\StringTrait;

class StringValidator implements ValidatorInterface
{
    
    use StringTrait;

    private $stringManipulator;

    public function __construct()
    {
        $this->stringManipulator = new StringManipulator();
    }

    public function validate( $value, array $options = []): bool
    {

        $stringOptions = new StringValidatorOptions($options);

      if(!$this->checkValueType($value, $stringOptions))
      {
        return throw new ValidatorException('Ceci n\'est pas une chaîne de caractères');
      }

        /* options*/
        $this->checkMinLength($value, $stringOptions);
        $this->checkMaxLength($value, $stringOptions);
        $this->checkRegex($value, $stringOptions);
        $this->checkRequired($value, $stringOptions);
        // Ajouter d'autres règles de validation spécifiques si nécessaire...

        return true;
    }

    private function checkValueType( $value): bool
    { 
        return  $this->stringManipulator->IsString($value);
    }

    private function checkMinLength(  $value, StringValidatorOptions $stringOptions): bool
    {  
        if ( $stringOptions->getMinLength() >= $this->countCharacters($value)   ) {
            throw new ValidatorException('La longueur minimale n\'est pas respectée');
        }
        return true;
    }

    private function checkMaxLength( $value, StringValidatorOptions $stringOptions): bool
    { 
        if (  $this->countCharacters($value) >=  $stringOptions->getMaxLength()  ) {
            throw new ValidatorException('La longueur maximale est dépassée ');
        }
        return true;
    }

    private function checkRegex( $value, StringValidatorOptions $stringOptions): bool
    {
        if ($stringOptions->hasRegex() && !preg_match($stringOptions->getRegex(), $value)) {
            throw new ValidatorException('La vérification spécifique a échoué');
        }
        return true;
    }

    private function checkRequired( $value, StringValidatorOptions $stringOptions): bool
    {
        if ($stringOptions->isRequired() && empty($value)) {
            throw new ValidatorException('La valeur est requise');
        }
        return true;
    }

    private function countCharacters($value)
    {
        return $this->stringManipulator->countCharacters($value);
    }
}
