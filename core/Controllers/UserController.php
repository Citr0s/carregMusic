<?php

namespace CarregMusic\Controllers;

use CarregMusic\Services\UserService;
use CarregMusic\Types\RegisterResponse;

class UserController
{
    private $service;

    function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function register($request) : RegisterResponse
    {
        if(UserService::hasSession())
        {
            header('Location: index.php');
            return new RegisterResponse();
        }

        if(empty($request))
            return new RegisterResponse();

        $registrationResponse = $this->service->register($request);

        if($registrationResponse->hasError)
            return $registrationResponse;

        header("Location: login.php?success");
    }
}