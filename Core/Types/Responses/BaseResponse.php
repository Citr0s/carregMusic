<?php

namespace CarregMusic\Types\Responses;


class BaseResponse
{
    public $hasError;
    public $errors;

    function __construct()
    {
        $this->hasError = false;
        $this->errors = [];
    }

    public function addError($error)
    {
        $this->hasError = true;
        array_push($this->errors, $error);
    }

    public function addErrors($errors)
    {
        $this->hasError = true;

        foreach($errors as $error)
            array_push($this->errors, $error);
    }
}