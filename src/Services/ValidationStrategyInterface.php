<?php

namespace PHPValidator\Services;

interface ValidationStrategyInterface
{
    public function required($message = null);
    public function minLength($minLength=3, $message = null);
    public function maxLength($maxLength=30, $message = null);
    public function pattern($pattern, $message = null);
    public function email($message = null);
    public function custom($callable, $message = null);
}