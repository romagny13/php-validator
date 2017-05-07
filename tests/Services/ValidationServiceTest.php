<?php

use PHPValidator\Helpers\Validations;
use PHPValidator\Services\ValidationService;

class ValidationServiceTest  extends PHPUnit_Framework_TestCase
{

    function testHasValidations(){
        $service = new ValidationService();
        $validations = [
            'username' => [Validations::required(), Validations::minLength()],
            'email' => [Validations::required(), Validations::email()]
        ];
        $service->addValidations('user',$validations);
        $result = $service->hasValidations('user');
        $this->assertTrue($result);
    }

    function testHasValidations_WithNoRegistered_ReturnsFalse(){
        $service = new ValidationService();
        $validations = [
            'username' => [Validations::required(), Validations::minLength()],
            'email' => [Validations::required(), Validations::email()]
        ];
        $service->addValidations('user',$validations);
        $result = $service->hasValidations('post');
        $this->assertFalse($result);
    }

    function testGetValidations(){
        $service = new ValidationService();
        $validations = [
            'username' => [Validations::required(), Validations::minLength()],
            'email' => [Validations::required(), Validations::email()]
        ];
        $service->addValidations('user',$validations);
        $result = $service->getValidations('user');
        $this->assertSame($validations, $result);
    }

    function testValidate_WithInvalidModel_ReturnsErrors(){
        $service = new ValidationService();
        $validations = [
            'username' => [Validations::required(), Validations::minLength()],
            'email' => [Validations::required(), Validations::email()]
        ];
        $model = [
            'username'=>'',
            'email'=>'abc'
        ];
        $service->addValidations('user',$validations);
        $result = $service->validate('user',$model);
        $this->assertTrue($result->hasError);
        $this->assertEquals(2, count($result->errors));
        $this->assertEquals('This field is required.',$result->errors['username']);
        $this->assertEquals('Please enter a valid email address.',$result->errors['email']);
    }

    function testValidate_WithValidModel_RetrunsTrue(){
        $service = new ValidationService();
        $validations = [
            'username' => [Validations::required(), Validations::minLength()],
            'email' => [Validations::required(), Validations::email()]
        ];
        $model = [
            'username'=>'abcdefg',
            'email'=>'example@domain.com'
        ];
        $service->addValidations('user',$validations);
        $result = $service->validate('user',$model);
        $this->assertFalse($result->hasError);
        $this->assertEquals(0, count($result->errors));
    }
}