<?php

namespace CarregMusic\Controllers;

use CarregMusic\Services\UserService;

class UserController
{

    public static function register($request)
    {
        if(UserService::hasSession())
        {
            header('Location: index.php');
            return;
        }

        if(empty($request))
            return;

        $registrationResponse = UserService::register($request);

        if(!$registrationResponse->hasError)
        {
            header('Location: register.php?success');
            return;
        }
    }
}