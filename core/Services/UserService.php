<?php

namespace CarregMusic\Services;


class UserService
{
    public static function hasSession()
    {
        return isset($_SESSION['username']) || isset($_COOKIE['username']);
    }
}