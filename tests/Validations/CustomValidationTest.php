<?php


use PHPValidator\Validations\CustomValidation;

class CustomValidationTest extends PHPUnit_Framework_TestCase
{
    function testCustom_WithNoValue_DontEvaluateAndReturnsTrue(){
        $validator = new CustomValidation(function($value){
            return $value === 'abc';
        },'error message');
        $success = $validator(null);
        $this->assertTrue($success);
    }

    function testCustom_WithCallableReturnsFalse_ReturnsFalse(){
        $validator = new CustomValidation(function($value){
            return $value === 'abc';
        },'error message');
        $success = $validator('123');
        $this->assertFalse($success);
    }

    function testCustom_WithCallableReturnsTrue_ReturnsTrue(){
        $validator = new CustomValidation(function($value){
            return $value === 'abc';
        },'error message');
        $success = $validator('abc');
        $this->assertTrue($success);
    }
    
}