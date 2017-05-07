<?php

namespace PHPValidator\Validations;

class RequiredValidation extends Validation
{
    public function __construct($message)
    {
        $this->message = $message;
    }

    public function __invoke($value)
    {
        return $this->hasValue($value);
    }
}