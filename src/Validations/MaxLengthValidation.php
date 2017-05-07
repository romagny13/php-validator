<?php
namespace PHPValidator\Validations;

class MaxLengthValidation extends Validation
{
    protected $maxLength;

    public function __construct($maxLength, $message)
    {
        $this->maxLength = $maxLength;
        $this->message = $message;
    }

    function  __invoke($value)
    {
        if(!$this->hasValue($value)){
            return true;
        }
        return strlen($value) < $this->maxLength;
    }
}