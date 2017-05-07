<?php

use PHPValidator\Helpers\Validations;
use PHPValidator\Helpers\Validator;

class ValidatorTest extends PHPUnit_Framework_TestCase
{
    function testValidateValue_WithStringEmpty_ReturnsRequiredMessage() {
        
        $result = Validator::validateValue([Validations::required(),Validations::email()],'');
        $this->assertEquals('This field is required.', $result);
    }

    function testValidateValue_WithInvalidEmail_ReturnsEmailMessage() {
        $result =  Validator::validateValue([Validations::required(),Validations::email()],'aa');
        $this->assertEquals('Please enter a valid email address.', $result);
    }

    function testValidateValue_WithValidEmail_ReturnsTrue() {
        $result =  Validator::validateValue([Validations::required(),Validations::email()],'example@domain.com');
        $this->assertTrue($result);
    }

    function testValidate_WithRequiredUserNameAndInvalidEmail_ReturnsHasErrorAndErrors() {

        $validators = [
            'username' => [Validations::required(), Validations::minLength()],
            'email' => [Validations::required(), Validations::email()]
        ];

        $model = [
            'username' => '',
            'email' => 'aa',
            'id' => 1
        ];

        $result =  Validator::validateModel($validators, $model);
        $this->assertTrue($result->hasError);
        $this->assertEquals(2, count($result->errors));
        $this->assertEquals('This field is required.', $result->errors['username']);
        $this->assertEquals('Please enter a valid email address.', $result->errors['email']);
    }

    function testValidate_WithUserNameAndValidEmail_ReturnsHasErrorFalse() {

        $validators = [
            'username' => [Validations::required(), Validations::minLength()],
            'email' => [Validations::required(), Validations::email()]
        ];

        $model = [
            'username' => 'abcde',
            'email' => 'example@doma.com',
            'id' => 1
        ];

        $result =  Validator::validateModel($validators, $model);
        $this->assertFalse($result->hasError);
        $this->assertEquals(0, count($result->errors));
    }

}