<?php
namespace PHPValidator\Validations;

class PatternValidation extends Validation
{
    protected $pattern;

    public function __construct($pattern, $message)
    {
        $this->pattern = $pattern;
        $this->message = $message;
    }

    function  __invoke($value)
    {
        if(!$this->hasValue($value)){
            return true;
        }
        return preg_match($this->pattern, $value) === 1;
    }
}