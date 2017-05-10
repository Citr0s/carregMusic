<?php

namespace CarregMusic\Controllers;

use CarregMusic\Services\UserService;

class UserController
{
    private $service;

    function __construct($service)
    {
        $this->service = $service;
    }

    public function register($request)
    {
        if(UserService::hasSession())
        {
            header('Location: index.php');
            return;
        }

        if(empty($request))
            return;

        $registrationResponse = $this->service->register($request);

        if(!$registrationResponse->hasError)
        {
            header('Location: register.php?error');
            return;
        }

        header("Location: login.php?success");
    }
}