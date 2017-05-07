<?php

namespace PHPValidator\Validations;

use PHPValidator\Helpers\ValidationHelper;

class Validation
{
    protected $message;
    protected $defaultMessages =  [
        'required' => 'This field is required.',
        'minLength' => 'Please enter at least than {0} characters.',
        'maxLength' => 'Please enter no more than {0} characters.',
        'pattern' => 'Please fix this field.',
        'custom' => 'Please fix this field'
    ];

    public static function hasValue($value) {
        return !ValidationHelper::isNullOrEmptyOrFalse($value);
    }

    public function getMessage(){
        return $this->message;
    }
}

