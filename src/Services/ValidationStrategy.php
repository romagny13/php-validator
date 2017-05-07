<?php


namespace PHPValidator\Services;
use PHPValidator\Helpers\ValidationHelper;
use PHPValidator\Validations\CustomValidation;
use PHPValidator\Validations\EmailValidation;
use PHPValidator\Validations\MaxLengthValidation;
use PHPValidator\Validations\PatternValidation;
use PHPValidator\Validations\RequiredValidation;
use PHPValidator\Validations\MinLengthValidation;

/**
 * Default validation strategy
 *
 * Class ValidationStrategy
 * @package PHPValidator
 */
class ValidationStrategy implements ValidationStrategyInterface
{
    protected $messages;

    public function __construct(array $messages=null)
    {
        $this->messages = isset($messages) ? $messages: [
            'required' => 'This field is required.',
            'minLength' => 'Please enter at least than {0} characters.',
            'maxLength' => 'Please enter no more than {0} characters.',
            'pattern' => 'Please fix this field.',
            'email' => 'Please enter a valid email address.',
            'custom' => 'Please fix this field.'
        ];
    }

    public function required($message = null){
        if(!isset($message)){
            $message = $this->messages['required'];
        }
        return new RequiredValidation($message);
    }

    public function minLength($minLength = 3, $message = null){
        if(!isset($message)){
            $message =  ValidationHelper::formatMessage($this->messages['minLength'], '{0}', $minLength);
        }
        return new MinLengthValidation($minLength,$message);
    }

    public function maxLength($maxLength = 30, $message = null){
        if(!isset($message)){
            $message = ValidationHelper::formatMessage($this->messages['maxLength'], '{0}', $maxLength);
        }
        return new MaxLengthValidation($maxLength,$message);
    }

    public function pattern($pattern, $message = null){
        if(!isset($message)){
            $message = $this->messages['pattern'];
        }
        return new PatternValidation($pattern,$message);
    }

    public function email($message = null){
        if(!isset($message)){
            $message = $this->messages['email'];
        }
        return new EmailValidation($message);
    }

    public function custom($callable, $message = null){
        if(!isset($message)){
            $message = $this->messages['custom'];
        }
        return new CustomValidation($callable,$message);
    }
}