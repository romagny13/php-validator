<?php
namespace PHPValidator\Services;

interface ValidationServiceInterface
{
    public function addValidations($modelName,$propertyNameAndValidationArrayPairs);
    public  function hasValidations($modelName);
    public  function getValidations($modelName);
    public function validate($modelName, $model);
}