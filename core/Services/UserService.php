<?php

namespace CarregMusic\Services;


use CarregMusic\Types\RegisterResponse;

class UserService
{
    public static function hasSession()
    {
        return isset($_SESSION['username']) || isset($_COOKIE['username']);
    }

    public static function register($request)
    {
        $registerResponse = new RegisterResponse();

        return $registerResponse;
    }
}