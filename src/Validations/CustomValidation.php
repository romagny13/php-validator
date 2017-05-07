<?php
namespace PHPValidator\Validations;

class CustomValidation extends Validation
{
    protected $callable;

    public function __construct(callable $callable, $message)
    {
        $this->callable = $callable;
        $this->message = $message;
    }

    function  __invoke($value)
    {
        if(!$this->hasValue($value)){
            return true;
        }
        return call_user_func($this->callable, $value);
    }
}