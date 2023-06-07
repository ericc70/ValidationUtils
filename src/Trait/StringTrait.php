<?php

namespace Ericc70\ValidationUtils\Trait;

trait StringTrait {


    public function getEntropy($value) :float
    {
        return $this->stringManipulator->calculateEntropy($value);
    }

    public function getBits($value) :int
    {
        return $this->stringManipulator->countBits($value);
    }



}