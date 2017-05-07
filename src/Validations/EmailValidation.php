<?php
namespace PHPValidator\Validations;

class EmailValidation extends Validation
{
    public function __construct($message)
    {
        $this->message = $message;
    }

    function __invoke($value)
    {
        if(!$this->hasValue($value)){
            return true;
        }
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}