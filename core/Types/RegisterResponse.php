<?php

namespace CarregMusic\Types;


class RegisterResponse
{
    public $hasError;
    public $error;

    public function addError($error)
    {
        $this->hasError = true;
        $this->error = $error;
    }
}