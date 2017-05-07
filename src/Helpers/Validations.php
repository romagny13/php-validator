<?php


namespace PHPValidator\Helpers;

use PHPValidator\Services\ValidationStrategy;
use PHPValidator\Services\ValidationStrategyInterface;

class Validations
{
    private static $instance;
    public static function getInstance(ValidationStrategyInterface $strategy=null){
        if(!isset(self::$instance)){
            if(!isset($strategy)){
                $strategy = new ValidationStrategy();
            }
            self::$instance = new Validations($strategy);
        }
        return self::$instance;
    }

    protected $strategy;

    public function __construct(ValidationStrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    public static function required($message = null){
        return self::getInstance()->strategy->required($message);
    }

    public static function minLength($minLength = 3, $message = null){
        return self::getInstance()->strategy->minLength($minLength,$message);
    }

    public static function maxLength($maxLength = 30, $message = null){
        return self::getInstance()->strategy->maxLength($maxLength,$message);
    }

    /**
     * Check with pattern http://php.net/manual/fr/function.preg-match.php
     * Example : '/[0-9]+/'
     * @param $pattern
     * @param null $message
     * @return \Closure
     */
    public static function pattern($pattern, $message = null){
        return self::getInstance()->strategy->pattern($pattern,$message);
    }

    public static function email($message = null){
        return self::getInstance()->strategy->email($message);
    }

    public static function custom($callable, $message = null){
        return self::getInstance()->strategy->custom($callable,$message);
    }
}