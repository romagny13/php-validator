<?php


use PHPValidator\Validations\MaxLengthValidation;

class MaxLengthValidationTest extends PHPUnit_Framework_TestCase
{

    function testMaxLength_WithNoValue_DontEvaluateAndReturnsTrue(){
        $validator = new MaxLengthValidation(30,'error message');
        $success = $validator(null);
        $this->assertTrue($success);
    }

    function testMaxLength_WithValueSup_ReturnsFalse(){
        $validator = new MaxLengthValidation(30,'error message');
        $success = $validator('1234567890_1234567890_1234567890_1234567890');
        $this->assertFalse($success);
    }

    function testMaxLength_WithValueInf_ReturnsTrue(){
        $validator = new MaxLengthValidation(30,'error message');
        $success = $validator('1234567890_1234567890');
        $this->assertTrue($success);
    }
}