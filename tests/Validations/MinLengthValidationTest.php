<?php


use PHPValidator\Validations\MinLengthValidation;

class MinLengthValidationTest extends PHPUnit_Framework_TestCase
{
    function testMinLength_ReturnsValidation(){
        $validator = new MinLengthValidation(3,'error message');
        $this->assertTrue($validator instanceof  MinLengthValidation);
    }

    function testMinLength_WithNoValue_DontEvaluateAndReturnsTrue(){
        $validator = new MinLengthValidation(3,'error message');
        $success = $validator(null);
        $this->assertTrue($success);
    }

    function testMinLength_WithValueInf_ReturnsFalse(){
        $validator = new MinLengthValidation(3,'error message');
        $success = $validator('ab');
        $this->assertFalse($success);
    }

    function testMinLength_WithValueSup_ReturnsTrue(){
        $validator = new MinLengthValidation(3,'error message');
        $success = $validator('abcdefeg');
        $this->assertTrue($success);
    }
}