<?php

namespace Ericc70\ValidationUtils\Interface;

interface ValidatorInterface {
    public function validate( string $value, array $option): bool;
}