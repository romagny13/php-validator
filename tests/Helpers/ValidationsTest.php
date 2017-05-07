<?php

use PHPValidator\Helpers\Validations;
use PHPValidator\Validations\CustomValidation;
use PHPValidator\Validations\EmailValidation;
use PHPValidator\Validations\MaxLengthValidation;
use PHPValidator\Validations\MinLengthValidation;
use PHPValidator\Validations\PatternValidation;
use PHPValidator\Validations\RequiredValidation;

class ValidationsTest extends PHPUnit_Framework_TestCase
{
    // required

    function testRequired_ReturnsValidation(){
        $validator =  Validations::required();
        $this->assertTrue($validator instanceof  RequiredValidation);
    }

    function testRequired_InitializedWithNoMessage_ReturnsDefaultMessage(){
        $validator =  Validations::required();
        $this->assertEquals('This field is required.',$validator->getMessage());
    }

    function testRequired_InitializedWithMessage_ReturnsDefaultMessage(){
        $validator =  Validations::required('error message');
        $this->assertEquals('error message',$validator->getMessage());
    }

    // minlength

    function testMinLength_ReturnsValidation(){
        $validator =  Validations::minLength();
        $this->assertTrue($validator instanceof  MinLengthValidation);
    }

    function testMinLength_InitializedWithNoMessage_ReturnsDefaultMessage(){
        $validator =  Validations::minLength();
        $this->assertEquals('Please enter at least than 3 characters.',$validator->getMessage());
    }

    function testMinLength_InitializedWithNoMessageWithValue_ReturnsValue(){
        $validator =  Validations::minLength(10);
        $this->assertEquals('Please enter at least than 10 characters.',$validator->getMessage());
    }
    
    function testMinLength_InitializedWithMessage_ReturnsDefaultMessage(){
        $validator =  Validations::minLength(10,'error message');
        $this->assertEquals('error message',$validator->getMessage());
    }


    // maxlength

    function testMexLength_ReturnsValidation(){
        $validator =  Validations::maxLength();
        $this->assertTrue($validator instanceof  MaxLengthValidation);
    }

    function testMaxLength_InitializedWithNoMessage_ReturnsDefaultMessage(){
        $validator =  Validations::maxLength();
        $this->assertEquals('Please enter no more than 30 characters.',$validator->getMessage());
    }

    function testMaxLength_InitializedWithNoMessageWithValue_ReturnsValue(){
        $validator =  Validations::maxLength(10);
        $this->assertEquals('Please enter no more than 10 characters.',$validator->getMessage());
    }

    function testMaxLength_InitializedWithMessage_ReturnsDefaultMessage(){
        $validator =  Validations::maxLength(10,'error message');
       $this->assertEquals('error message',$validator->getMessage());
    }

    // email

    function testEmail_ReturnsValidation(){
        $validator =  Validations::email();
        $this->assertTrue($validator instanceof  EmailValidation);
    }

    function testEmail_InitializedWithNoMessage_ReturnsDefaultMessage(){
        $validator =  Validations::email();
        $this->assertEquals('Please enter a valid email address.',$validator->getMessage());
    }

    function testEmail_InitializedWithMessage_ReturnsDefaultMessage(){
        $validator =  Validations::email('error message');
        $this->assertEquals('error message',$validator->getMessage());
    }

    // pattern

    function testPattern_ReturnsValidation(){
        $validator =  Validations::pattern('/[a-z]+');
        $this->assertTrue($validator instanceof  PatternValidation);
    }

    function testPattern_InitializedWithNoMessage_ReturnsDefaultMessage(){
        $validator =  Validations::pattern('/[a-z]+');
       $this->assertEquals('Please fix this field.',$validator->getMessage());
    }

    function testPattern_InitializedWithMessage_ReturnsDefaultMessage(){
        $validator =  Validations::pattern('/[a-z]+','error message');
       $this->assertEquals('error message',$validator->getMessage());
    }

    // custom
    function testCustom_ReturnsValidation(){
        $validator =  Validations::custom(function(){});
        $this->assertTrue($validator instanceof  CustomValidation);
    }

    function testCustom_InitializedWithNoMessage_ReturnsDefaultMessage(){
        $validator =  Validations::custom(function(){});
       $this->assertEquals('Please fix this field.',$validator->getMessage());
    }

    function testCustom_InitializedWithMessage_ReturnsDefaultMessage(){
        $validator =  Validations::custom(function(){},'error message');
       $this->assertEquals('error message',$validator->getMessage());
    }


}