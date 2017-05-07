# PHP Validator


## Installation

```
composer require romagny13\php-validator
```

## Presentation

**Validation classes** (extends Validation base class) => with message (error message) and __invoke (magic function) to validate the received value:
* RequiredValidation
* MinLengthValidation
* MaxLengthValidation
* PatternValidation
* EmailValidation
* CustomValidation

**Services**:
* ValidationStrategy (implements ValidationStrategyInterface) => returns Validation class instances (RequiredValidation, MinLengthValidation, etc.)
* ValidationService (implements ValidationServiceInterface) => allows to register validations by models and validate model values

**Helpers**:
* Validations => Provides shortcuts (static functions) to create instances of Validations (**required**, **minLength**, **maxLength**, **pattern**, **email**, **custom**)
* Validator => Allows to validate easily (static functions) a model with validations  (**valide model** and **validateValue**)


## Example

```php
<?php

use PHPValidator\Helpers\Validations;
use PHPValidator\Helpers\Validator;

require __DIR__.'/../vendor/autoload.php';


$password = 'abc';

$model = [
    'username' => '',
    'email' => 'abc',
    'password' => $password,
    'confirm_password' => 'xyz'
];

$validations = [
    'username' => [Validations::required(), Validations::minLength()],
    'email' => [Validations::required(), Validations::email()],
    'password' => [Validations::required('Please enter a password')],
    'confirm_password' => [Validations::custom(function($value) use($password){
        return $value === $password;
    },'Password and confirm password do not match.')]
];

$result = Validator::validateModel($validations, $model);
var_dump($result->hasError, $result->errors);

```

## Extend

Create a class that inherits from 'Validation'.

```php
class NumberValidation extends Validation
{
    public function __construct($message)
    {
        $this->message = $message;
    }

    public function __invoke($value)
    {
        // if has no value => don't evaluate (this is the job of required validation)
        if(!$this->hasValue($value)){
            return true;
        }
        return is_numeric($value);
    }
}
```

Extend **Validators** class **helper**

```php
class MyValidations extends Validations
{
    public static function isNumeric($message='Please fix this field.'){
      return new NumberValidation($message);
    }
}
```

Usage (example with age)

```php
$model = [
    'username' => 'abcdefg',
    'age' => 'my age'
];

$validations = [
    'username' => [Validations::required(), Validations::minLength()],
    'age' => [Validations::required(), MyValidations::isNumeric()],
];

$result = Validator::validateModel($validations, $model);
```

## ValidationService

A better way to use validation from a service class for example and have a code more testable.

Example :

Create a service that receive the ValidationService to use.

```php
class MyApplicationValidationService
{
    protected $validationService;
    protected $strategy;

    public function __construct(ValidationServiceInterface $validationService, ValidationStrategyInterface $strategy)
    {
        // allows to register validations by models and validate model values
        $this->validationService = $validationService;

        // returns Validation class instances (RequiredValidation, MinLengthValidation, etc.)
        $this->strategy = $strategy;

        // init
        $this->addPostValidations(); // post
        // other model Validations  (example category, user, ....)
    }

    public function addModelValidations($modelName,$validations){
        $this->validationService->addValidations($modelName,$validations);
    }

    public function addPostValidations(){
        $validations = [
            'title' => [$this->strategy->required('Please enter a title'),$this->strategy->minLength()],
            'content' => [$this->strategy->required()]
        ];
        $this->validationService->addValidations('post',$validations);
    }

    public function validatePost($post){
       return $this->validationService->validate('post',$post);
    }

    // other models validation functions ...
}
```

Usage

```php
// inject the services
$service = new MyApplicationValidationService(new ValidationService(), new ValidationStrategy());

// the model to validate
$post = [
    'title' => '',
    'content' => 'My content'
];
// and finally validate with the service
$result = $service->validatePost($post);
//
var_dump($result->hasError,$result->errors);
// easy to inject the errors in view
// for this example we have an error => $result->errors['title'] = 'This field is required.'
```