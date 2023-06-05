<?php

namespace Ericc70\ValidationUtils\Interface;

interface ValidatorInterface {
    public function validate( $value, array $option): bool;
}