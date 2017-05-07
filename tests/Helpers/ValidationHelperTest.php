<?php

use PHPValidator\Helpers\ValidationHelper;
use PHPValidator\Helpers\Validations;

class ValidationHelperTest extends PHPUnit_Framework_TestCase
{
    // test is null or empty or false
    
    function testIsNullOrEmptyOrFalse_WithNull_ReturnsFalse() {
        $result = ValidationHelper::isNullOrEmptyOrFalse(null);
        $this->assertTrue($result);
    }

    function testIsNullOrEmptyOrFalse_WithStringEmpty_ReturnsFalse() {
        $result = ValidationHelper::isNullOrEmptyOrFalse('');
        $this->assertTrue($result);
    }

    function testIsNullOrEmptyOrFalse_WithWithespaces_ReturnsFalse() {
        $result = ValidationHelper::isNullOrEmptyOrFalse('    ');
        $this->assertTrue($result);
    }

    function testIsNullOrEmptyOrFalse_WithBoolFalse_ReturnsFalse() {
        $result = ValidationHelper::isNullOrEmptyOrFalse(false);
        $this->assertTrue($result);
    }

    function testIsNullOrEmptyOrFalse_WithStringNotEmpty_ReturnsTrue() {
        $result = ValidationHelper::isNullOrEmptyOrFalse('Ok');
        $this->assertFalse($result);
    }

    function testIsNullOrEmptyOrFalse_WithBoolTrue_ReturnsTrue() {
        $result = ValidationHelper::isNullOrEmptyOrFalse(true);
        $this->assertFalse($result);
    }
    
    // test format message

    function testFormatMessage_Success() {
        $result = ValidationHelper::formatMessage('Please enter at least than {0} characters.','{0}', 3);
        $this->assertEquals('Please enter at least than 3 characters.', $result);
    }
    
    // test has Validations
    
    function testHasValidations_WithNoValidation_Returnsfalse(){
        $validations = [
            'a' => [],
            'b' => []
        ];
        $result = ValidationHelper::hasValidations($validations,'c');
        $this->assertFalse($result);
    }

    function testHasValidations_WithValidation_ReturnsTrue(){
        $validations = [
            'a' => [],
            'b' => []
        ];
        $result = ValidationHelper::hasValidations($validations,'b');
        $this->assertTrue($result);
    }

    
    // test get Validations
    
    function testGetValidations(){
        $validations = [
            'a' => ['validation a 1', 'validation a 2'],
            'b' => ['validation b 1', 'validation b 2']
        ];
        $result = ValidationHelper::getValidations($validations,'b');
        $this->assertSame(['validation b 1', 'validation b 2'],$result);
    }
    
    // test get error 

    function testGetError_ReturnsFirstErrorMessage(){
        $validations = [Validations::required('username required'),Validations::minLength(3,'username minlength')];
        $result = ValidationHelper::getError($validations,'');
        $this->assertEquals('username required',$result);
    }

    function testGetError_ReturnsSecondError(){
        $validations = [Validations::required('username required'),Validations::minLength(3,'username minlength')];
        $result = ValidationHelper::getError($validations,'ab');
        $this->assertEquals('username minlength',$result);
    }

    function testGetError_ReturnsFirstDefaultErrorMessage(){
        $validations = [Validations::required(),Validations::minLength()];
        $result = ValidationHelper::getError($validations,'');
        $this->assertEquals('This field is required.',$result);
    }

    function testGetError_ReturnsSecondDefaultErrorMessage(){
        $validations = [Validations::required(),Validations::minLength()];
        $result = ValidationHelper::getError($validations,'ab');
        $this->assertEquals('Please enter at least than 3 characters.',$result);
    }

    function testGetError_WithValidValue_ReturnsNull(){
        $validations = [Validations::required(),Validations::minLength()];
        $result = ValidationHelper::getError($validations,'abcdefg');
        $this->assertNull($result);
    }
    
    // test validate model

    function testValidateModel_ReturnsFirstErrorMessage(){
        $validations = [
            'username' => [Validations::required('username required'),Validations::minLength(3,'username minlength')],
            'email' => [Validations::required('email required'),Validations::email('email invalid')]
        ];
        $model = [
            'username' => '',
            'email' => 'example@domain.com'
        ];
        $result = ValidationHelper::validateModel($validations,$model);
        $this->assertTrue($result->hasError);
        $this->assertEquals('username required',$result->errors['username']);
        $this->assertEquals(1, count($result->errors));
    }

    function testValidateModel_ReturnsSecondErrorMessage(){
        $validations = [
            'username' => [Validations::required('username required'),Validations::minLength(3,'username minlength')],
            'email' => [Validations::required('email required'),Validations::email('email invalid')]
        ];
        $model = [
            'username' => 'ab',
            'email' => 'example@domain.com'
        ];
        $result = ValidationHelper::validateModel($validations,$model);
        $this->assertTrue($result->hasError);
        $this->assertEquals('username minlength',$result->errors['username']);
        $this->assertEquals(1, count($result->errors));
    }

    function testValidateModel_ReturnsEmailRequired(){
        $validations = [
            'username' => [Validations::required('username required'),Validations::minLength(3,'username minlength')],
            'email' => [Validations::required('email required'),Validations::email('email invalid')]
        ];
        $model = [
            'username' => 'abcdefg',
            'email' => ''
        ];
        $result = ValidationHelper::validateModel($validations,$model);
        $this->assertTrue($result->hasError);
        $this->assertEquals('email required',$result->errors['email']);
        $this->assertEquals(1, count($result->errors));
    }

    function testValidateModel_ReturnsEmailInvalid(){
        $validations = [
            'username' => [Validations::required('username required'),Validations::minLength(3,'username minlength')],
            'email' => [Validations::required('email required'),Validations::email('email invalid')]
        ];
        $model = [
            'username' => 'abcdefg',
            'email' => 'abc'
        ];
        $result = ValidationHelper::validateModel($validations,$model);
        $this->assertTrue($result->hasError);
        $this->assertEquals('email invalid',$result->errors['email']);
        $this->assertEquals(1, count($result->errors));
    }

    function testValidateModel_WithValidModel_ReturnsNoError(){
        $validations = [
            'username' => [Validations::required('username required'),Validations::minLength(3,'username minlength')],
            'email' => [Validations::required('email required'),Validations::email('email invalid')]
        ];
        $model = [
            'username' => 'abcdefg',
            'email' => 'abc@domain.com'
        ];
        $result = ValidationHelper::validateModel($validations,$model);
        //$this->assertFalse($result->hasError);
        $this->assertEquals(0,count($result->errors));
    }

    function testValidateModel_ReturnsMultipleErrors(){
        $validations = [
            'username' => [Validations::required('username required'),Validations::minLength(3,'username minlength')],
            'email' => [Validations::required('email required'),Validations::email('email invalid')]
        ];
        $model = [
            'username' => 'ab',
            'email' => 'abc'
        ];
        $result = ValidationHelper::validateModel($validations,$model);
        $this->assertTrue($result->hasError);
        $this->assertEquals('username minlength',$result->errors['username']);
        $this->assertEquals('email invalid',$result->errors['email']);
        $this->assertEquals(2, count($result->errors));
    }
    
}