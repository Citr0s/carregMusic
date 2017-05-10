<?php

namespace CarregMusic\Types;


class Error
{
    public $message;

    function __construct($message)
    {
        $this->message = $message;
    }
}