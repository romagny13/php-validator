<?php


namespace PHPValidator\Helpers;

/**
 * Validator helper
 * 
 * Class Validator
 * @package PHPValidator
 */
class Validator
{
    public static function validateValue($validations,$value){
        $error = ValidationHelper::getError($validations,$value);
        if($error){
            return $error;
        }
        return true;
    }
    
    public static function validateModel($propertyNameAndValidationArrayPairs,$model){
        return ValidationHelper::validateModel($propertyNameAndValidationArrayPairs,$model);
    }
}