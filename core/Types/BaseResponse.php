<?php

namespace CarregMusic\Types;


class BaseResponse
{
    public $hasError;
    public $errors;

    public function addError($error)
    {
        $this->hasError = true;
        array_push($errors, $error);
    }
}