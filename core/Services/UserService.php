<?php

namespace CarregMusic\Services;


use CarregMusic\Repositories\UserRepository;
use CarregMusic\Types\CreateUserRequest;
use CarregMusic\Types\Error;
use CarregMusic\Types\RegisterResponse;
use CarregMusic\Validators\UserValidator;

class UserService
{
    private $repository;
    private $validator;

    function __construct(UserRepository $repository, UserValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public static function hasSession()
    {
        return isset($_SESSION['username']) || isset($_COOKIE['username']);
    }

    public function register($request) : RegisterResponse
    {
        $registerResponse = new RegisterResponse();

        $validationResponse = $this->validator->validate($request);

        if($validationResponse->hasError)
            $registerResponse->addErrors($validationResponse->errors);

        if($request['password'] !== $request['passwordCheck'])
            $registerResponse->addError(new Error('Passwords don\'t match'));

        if($registerResponse->hasError)
            return $registerResponse;

        $createUserRequest = new CreateUserRequest();
        $createUserRequest->username = sanitise(trim($request['username']));
        $createUserRequest->nickname = sanitise(trim($request['nickname']));
        $createUserRequest->email = sanitise(trim($request['email']));
        $createUserRequest->password = sanitise(trim($request['password']));
        $createUserRequest->country = sanitise(trim($request['country']));
        $createUserRequest->genre = sanitise(trim($request['genre']));

        $createUserResponse = $this->repository->create($createUserRequest);

        if($createUserResponse->hasError)
            $registerResponse->addError(new Error($createUserResponse->errors[0]->message));

        return $registerResponse;
    }
}