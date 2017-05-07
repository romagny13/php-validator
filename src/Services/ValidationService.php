<?php


namespace PHPValidator\Services;

use \Exception;
use PHPValidator\Helpers\ValidationHelper;

class ValidationService implements ValidationServiceInterface
{
    protected $modelAndValidations=[];
    
    public function addValidations($modelName,$propertyNameAndValidationArrayPairs){
        $this->modelAndValidations[$modelName] = $propertyNameAndValidationArrayPairs;
    }

    public  function hasValidations($modelName){
        return isset($this->modelAndValidations[$modelName]);
    }

    public  function getValidations($modelName){
        return $this->modelAndValidations[$modelName];
    }

    public function validate($modelName,$model){
        if(!$this->hasValidations($modelName)) { throw new Exception('No Validations registered for model '. $modelName);}
        $validations = $this->getValidations($modelName);
        return ValidationHelper::validateModel($validations,$model);
    }
}