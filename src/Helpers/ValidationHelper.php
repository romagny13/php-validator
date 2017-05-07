<?php


namespace PHPValidator\Helpers;


class ValidationHelper
{
    public static function formatMessage($message, $searchValue, $replaceValue) {
        return str_replace($searchValue, $replaceValue, $message);
    }
    
    public static function isNullOrEmptyOrFalse($value) {
        return  is_null($value) || (is_string($value) && trim($value) === '') || (is_bool($value) && $value === false);
    }
    
    public static function hasValidations($validations, $propertyName){
        return array_key_exists($propertyName, $validations);
    }

    public static function getValidations($propertyNameAndValidationArrayPairs, $propertyName){
        return $propertyNameAndValidationArrayPairs[$propertyName];
    }

    public static function getError(array $validations, $value){
        foreach($validations as $validation)
        {
            if(!$validation($value)){
                // return first error message
                return $validation->getMessage();
            }
        }
        return null;
    }

    public static  function validateModel(array $propertyNameAndValidationArrayPairs,$model){
        $hasError = false;
        $errors = [];
        foreach ($model as $propertyName => $value) {
            if(self::hasValidations($propertyNameAndValidationArrayPairs,$propertyName)){
                $validations = self::getValidations($propertyNameAndValidationArrayPairs,$propertyName);
                $error = self::getError($validations,$value);
                if($error){
                    $errors[$propertyName] = $error;
                    $hasError = true;
                }
            }
        }
        return (object) [
            'hasError' => $hasError,
            'errors'=> $errors
        ];
    }
}