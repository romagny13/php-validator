<?php

use PHPValidator\Validations\PatternValidation;
use PHPValidator\Validations\CustomValidation;
use PHPValidator\Validations\MaxLengthValidation;
use PHPValidator\Validations\MinLengthValidation;
use PHPValidator\Validations\RequiredValidation;
use PHPValidator\Services\ValidationStrategy;

class StrategyTest extends PHPUnit_Framework_TestCase
{

    // required
    
    function testRequired_HasDefaultMessage()
    {
        $strategy = new ValidationStrategy();
        $result = $strategy->required();
        $this->assertTrue($result instanceof RequiredValidation);
        $this->assertEquals('This field is required.', $result->getMessage());
    }

    function testRequired_HasMessage()
    {
        $strategy = new ValidationStrategy();
        $result = $strategy->required('error message');
        $this->assertTrue($result instanceof RequiredValidation);
        $this->assertEquals('error message', $result->getMessage());
    }
    
    // min length

    function testMinLength_HasDefaultMessage()
    {
        $strategy = new ValidationStrategy();
        $result = $strategy->minLength();
        $this->assertTrue($result instanceof MinLengthValidation);
        $this->assertEquals('Please enter at least than 3 characters.', $result->getMessage());
    }

    function testMinLength_HasDefaultMessageWithValue()
    {
        $strategy = new ValidationStrategy();
        $result = $strategy->minLength(10);
        $this->assertTrue($result instanceof MinLengthValidation);
        $this->assertEquals('Please enter at least than 10 characters.', $result->getMessage());
    }

    function testMinLength_HasMessage()
    {
        $strategy = new ValidationStrategy();
        $result = $strategy->minLength(3,'error message');
        $this->assertTrue($result instanceof MinLengthValidation);
        $this->assertEquals('error message', $result->getMessage());
    }

    // max length
    
    function testMaxLength_HasDefaultMessage()
    {
        $strategy = new ValidationStrategy();
        $result = $strategy->maxLength();
        $this->assertTrue($result instanceof MaxLengthValidation);
        $this->assertEquals('Please enter no more than 30 characters.', $result->getMessage());
    }

    function testMaxLength_HasDefaultMessageWithValue()
    {
        $strategy = new ValidationStrategy();
        $result = $strategy->maxLength(50);
        $this->assertTrue($result instanceof MaxLengthValidation);
        $this->assertEquals('Please enter no more than 50 characters.', $result->getMessage());
    }

    function testMaxLength_HasMessage()
    {
        $strategy = new ValidationStrategy();
        $result = $strategy->maxLength(20,'error message');
        $this->assertTrue($result instanceof MaxLengthValidation);
        $this->assertEquals('error message', $result->getMessage());
    }
    
    // pattern

    function testPattern_HasDefaultMessage()
    {
        $strategy = new ValidationStrategy();
        $result = $strategy->pattern('/[a-z]+/');
        $this->assertTrue($result instanceof PatternValidation);
        $this->assertEquals('Please fix this field.', $result->getMessage());
    }

    function testPattern_HasMessage()
    {
        $strategy = new ValidationStrategy();
        $result = $strategy->pattern('/[a-z]+/', 'error message');
        $this->assertTrue($result instanceof PatternValidation);
        $this->assertEquals('error message', $result->getMessage());
    }
    
    // custom

    function testCustom_HasDefaultMessage()
    {
        $strategy = new ValidationStrategy();
        $result = $strategy->custom(function(){});
        $this->assertTrue($result instanceof CustomValidation);
        $this->assertEquals('Please fix this field.', $result->getMessage());
    }

    function testCustom_HasMessage()
    {
        $strategy = new ValidationStrategy();
        $result = $strategy->custom(function(){},'error message');
        $this->assertTrue($result instanceof CustomValidation);
        $this->assertEquals('error message', $result->getMessage());
    }

    // required

    function testRequired_WithNull_ReturnsFalse(){
        $strategy = new ValidationStrategy();
        $validator = $strategy->required();
        $success = $validator(null);
        $this->assertFalse($success);
    }

    function testRequired_WithEmptyString_ReturnsFalse(){
        $strategy = new ValidationStrategy();
        $validator = $strategy->required();
        $success = $validator('');
        $this->assertFalse($success);
    }

    function testRequired_WithWhiteSpace_ReturnsFalse(){
        $strategy = new ValidationStrategy();
        $validator = $strategy->required();
        $success = $validator('     ');
        $this->assertFalse($success);
    }

    function testRequired_WithFalse_ReturnsFalse(){
        $strategy = new ValidationStrategy();
        $validator = $strategy->required();
        $success = $validator(false);
        $this->assertFalse($success);
    }

    function testRequired_WithValue_ReturnsTrue(){
        $strategy = new ValidationStrategy();
        $validator = $strategy->required();
        $success = $validator('my value');
        $this->assertTrue($success);
    }

    function testRequired_WithTrue_ReturnsTrue(){
        $strategy = new ValidationStrategy();
        $validator = $strategy->required();
        $success = $validator(true);
        $this->assertTrue($success);
    }

    // minlength

    function testMinLength_WithNoValue_DontEvaluateAndReturnsTrue(){
        $strategy = new ValidationStrategy();
        $validator = $strategy->minLength(3);
        $success = $validator(null);
        $this->assertTrue($success);
    }

    function testMinLength_WithValueInf_ReturnsFalse(){
        $strategy = new ValidationStrategy();
        $validator = $strategy->minLength(3);
        $success = $validator('ab');
        $this->assertFalse($success);
    }

    function testMinLength_WithValueSup_ReturnsTrue(){
        $strategy = new ValidationStrategy();
        $validator = $strategy->minLength(3);
        $success = $validator('abcdefeg');
        $this->assertTrue($success);
    }

    // maxlength

    function testMaxLength_WithNoValue_DontEvaluateAndReturnsTrue(){
        $strategy = new ValidationStrategy();
        $validator = $strategy->maxLength(30);
        $success = $validator(null);
        $this->assertTrue($success);
    }

    function testMaxLength_WithValueSup_ReturnsFalse(){
        $strategy = new ValidationStrategy();
        $validator = $strategy->maxLength(30);
        $success = $validator('1234567890_1234567890_1234567890_1234567890');
        $this->assertFalse($success);
    }

    function testMaxLength_WithValueInf_ReturnsTrue(){
        $strategy = new ValidationStrategy();
        $validator = $strategy->maxLength(30);
        $success = $validator('1234567890_1234567890');
        $this->assertTrue($success);
    }

    // pattern

    function testPattern_WithNoValue_DontEvaluateAndReturnsTrue(){
        $strategy = new ValidationStrategy();
        $validator = $strategy->pattern('/[0-9]+/');
        $success = $validator(null);
        $this->assertTrue($success);
    }

    function testPattern_WithInvalidValue_ReturnsFalse(){
        $strategy = new ValidationStrategy();
        $validator = $strategy->pattern('/[0-9]+/');
        $success = $validator('abcde');
        $this->assertFalse($success);
    }

    function testPattern_WithValidValue_ReturnsTrue(){
        $strategy = new ValidationStrategy();
        $validator = $strategy->pattern('/[0-9]+/');
        $success = $validator('123');
        $this->assertTrue($success);
    }

    // custom

    function testCustom_WithNoValue_DontEvaluateAndReturnsTrue(){
        $strategy = new ValidationStrategy();
        $validator = $strategy->custom(function($value){
            return $value === 'abc';
        },'error message');
        $success = $validator(null);
        $this->assertTrue($success);
    }

    function testCustom_WithCallableReturnsFalse_ReturnsFalse(){
        $strategy = new ValidationStrategy();
        $validator = $strategy->custom(function($value){
            return $value === 'abc';
        },'error message');
        $success = $validator('123');
        $this->assertFalse($success);
    }

    function testCustom_WithCallableReturnsTrue_ReturnsTrue(){
        $strategy = new ValidationStrategy();
        $validator = $strategy->custom(function($value){
            return $value === 'abc';
        },'error message');
        $success = $validator('abc');
        $this->assertTrue($success);
    }

    function testReturnsMessage(){
        $message = 'error message';
        $strategy = new ValidationStrategy();
        $validator = $strategy->required('error message');
        $result = $validator->getMessage();
        $this->assertEquals($message,$result);
    }
}