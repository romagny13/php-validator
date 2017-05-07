<?php


use PHPValidator\Validations\PatternValidation;

class PatternValidationTest extends PHPUnit_Framework_TestCase
{
    function testPattern_WithNoValue_DontEvaluateAndReturnsTrue(){
        $validator = new PatternValidation('/[0-9]+/','error message');
        $success = $validator(null);
        $this->assertTrue($success);
    }

    function testPattern_WithInvalidValue_ReturnsFalse(){
        $validator = new PatternValidation('/[0-9]+/','error message');
        $success = $validator('abcde');
        $this->assertFalse($success);
    }

    function testPattern_WithValidValue_ReturnsTrue(){
        $validator = new PatternValidation('/[0-9]+/','error message');
        $success = $validator('123');
        $this->assertTrue($success);
    }
}