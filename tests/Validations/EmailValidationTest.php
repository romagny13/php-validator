<?php

use PHPValidator\Validations\EmailValidation;

class EmailValidationTest  extends PHPUnit_Framework_TestCase
{

    function testEmail_WithNoValue_DontEvaluateAndReturnsTrue(){
        $validator = new EmailValidation('/[a-z]+/','error message');
        $success = $validator(null);
        $this->assertTrue($success);
    }

    function testEmail_WithInvalidMatch_ReturnsFalse(){
        $validator = new EmailValidation('/[a-z]+/','error message');
        $success = $validator('123');
        $this->assertFalse($success);
    }

    function testCustom_WithValidMatch_ReturnsTrue(){
        $validator = new EmailValidation('/[a-z]+/','error message');
        $success = $validator('abc');
        $this->assertFalse($success);
    }
}