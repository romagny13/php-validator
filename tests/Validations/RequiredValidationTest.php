<?php

use PHPValidator\Validations\RequiredValidation;

class RequiredValidationTest extends PHPUnit_Framework_TestCase
{
    function testRequired_ReturnsValidation(){
        $validator = new RequiredValidation('error message');
        $this->assertTrue($validator instanceof  RequiredValidation);
    }

    function testRequired_WithNull_ReturnsFalse(){
        $validator = new RequiredValidation('error message');
        $success = $validator(null);
        $this->assertFalse($success);
    }

    function testRequired_WithEmptyString_ReturnsFalse(){
        $validator = new RequiredValidation('error message');
        $success = $validator('');
        $this->assertFalse($success);
    }

    function testRequired_WithWhiteSpace_ReturnsFalse(){
        $validator = new RequiredValidation('error message');
        $success = $validator('     ');
        $this->assertFalse($success);
    }

    function testRequired_WithFalse_ReturnsFalse(){
        $validator = new RequiredValidation('error message');
        $success = $validator(false);
        $this->assertFalse($success);
    }

    function testRequired_WithValue_ReturnsTrue(){
        $validator = new RequiredValidation('error message');
        $success = $validator('mu value');
        $this->assertTrue($success);
    }

    function testRequired_WithTrue_ReturnsTrue(){
        $validator = new RequiredValidation('error message');
        $success = $validator(true);
        $this->assertTrue($success);
    }

    function testReturnsMessage(){
        $message = 'error message';
        $validator = new RequiredValidation($message);
        $result = $validator->getMessage();
        $this->assertEquals($message,$result);
    }
}