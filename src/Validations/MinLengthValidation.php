<?php

namespace PHPValidator\Validations;

class MinLengthValidation extends Validation
{
    protected $minLength;

    public function __construct($minLength, $message)
    {
        $this->minLength = $minLength;
        $this->message = $message;
    }

    function  __invoke($value)
    {
        // if has no value don't evaluate (this is the job of required validation)
        if(!$this->hasValue($value)){
            return true;
        }
        return strlen($value) > $this->minLength;
    }
}