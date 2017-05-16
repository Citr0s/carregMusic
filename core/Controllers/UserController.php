<?php

namespace CarregMusic\Controllers;

use CarregMusic\Services\UserService;
use CarregMusic\Types\Responses\LoginResponse;
use CarregMusic\Types\Responses\RegisterResponse;

class UserController
{
    private $service;

    function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function login($request) : LoginResponse
    {
        if(UserService::hasSession())
        {
            header('Location: index.php');
            return new LoginResponse();
        }

        if(empty($request))
            return new LoginResponse();

        $loginResponse = $this->service->login($request);

        if($loginResponse->hasError)
            return $loginResponse;

        header("Location: login.php?success");
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

        header("Location: profile.php");
    }
}