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

    public function validate(string $value, array $options = []): bool
    {

        $stringOptions = new StringValidatorOptions($options);

        $this->checkValueType($value, $stringOptions);

        /* options*/
        $this->checkMinLength($value, $stringOptions);
        $this->checkMaxLength($value, $stringOptions);
        $this->checkRegex($value, $stringOptions);
        $this->checkRequired($value, $stringOptions);
        // Ajouter d'autres règles de validation spécifiques si nécessaire...

        return true;
    }

    private function checkValueType(string $value): bool
    {
        if (!$this->stringManipulator->IsString($value)) {
            throw new ValidatorException('Ceci n\'est pas une chaîne de caractères');
        }
        return true;
    }

    private function checkMinLength( string $value, StringValidatorOptions $stringOptions): bool
    {
        if ($this->stringManipulator->countCharacters($value) <= $stringOptions->getMinLength()) {
            throw new ValidatorException('La longueur minimale n\'est pas respectée');
        }
        return true;
    }

    private function checkMaxLength(string $value, StringValidatorOptions $stringOptions): bool
    {
        if ($this->stringManipulator->countCharacters($value) >= $stringOptions->getMaxLength()) {
            throw new ValidatorException('La longueur maximale est dépassée');
        }
        return true;
    }

    private function checkRegex(string $value, StringValidatorOptions $stringOptions): bool
    {
        if ($stringOptions->hasRegex() && !preg_match($stringOptions->getRegex(), $value)) {
            throw new ValidatorException('La vérification spécifique a échoué');
        }
        return true;
    }

    private function checkRequired(string $value, StringValidatorOptions $stringOptions): bool
    {
        if ($stringOptions->isRequired() && empty($value)) {
            throw new ValidatorException('La valeur est requise');
        }
        return true;
    }
}
