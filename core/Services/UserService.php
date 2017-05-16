<?php

namespace CarregMusic\Services;

use CarregMusic\Helpers\ValidationHelpers;
use CarregMusic\Repositories\UserRepository;
use CarregMusic\Types\Error;
use CarregMusic\Types\Requests\CreateUserRequest;
use CarregMusic\Types\Requests\LoginUserRequest;
use CarregMusic\Types\Responses\LoginResponse;
use CarregMusic\Types\Responses\RegisterResponse;
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
        return isset($_SESSION['user']);
    }

    public function register($request) : RegisterResponse
    {
        $registerResponse = new RegisterResponse();

        $expected = array('username', 'nickname', 'email', 'password', 'passwordCheck', 'country', 'genre');
        $required = array('username', 'nickname', 'email', 'password', 'passwordCheck', 'country', 'genre');

        $validationResponse = $this->validator->validate($request, $expected, $required);

        if($validationResponse->hasError)
            $registerResponse->addErrors($validationResponse->errors);

        if($request['password'] !== $request['passwordCheck'])
            $registerResponse->addError(new Error('Passwords don\'t match'));

        if($registerResponse->hasError)
            return $registerResponse;

        $createUserRequest = new CreateUserRequest();
        $createUserRequest->username = ValidationHelpers::sanitise(trim($request['username']));
        $createUserRequest->nickname = ValidationHelpers::sanitise(trim($request['nickname']));
        $createUserRequest->email = ValidationHelpers::sanitise(trim($request['email']));
        $createUserRequest->password = password_hash(ValidationHelpers::sanitise(trim($request['password'])), PASSWORD_BCRYPT);
        $createUserRequest->country = ValidationHelpers::sanitise(trim($request['country']));
        $createUserRequest->genre = ValidationHelpers::sanitise(trim($request['genre']));

        $createUserResponse = $this->repository->create($createUserRequest);

        if($createUserResponse->hasError)
            $registerResponse->addErrors($createUserResponse->errors);

        return $registerResponse;
    }

    public function login($request) : LoginResponse
    {
        $loginResponse = new LoginResponse();

        $expected = array('username', 'password');
        $required = array('username', 'password');

        $validationResponse = $this->validator->validate($request, $expected, $required);

        if($validationResponse->hasError)
            $loginResponse->addErrors($validationResponse->errors);

        if($loginResponse->hasError)
            return $loginResponse;

        $loginUserRequest = new LoginUserRequest();
        $loginUserRequest->username = ValidationHelpers::sanitise(trim($request['username']));
        $loginUserRequest->password = ValidationHelpers::sanitise(trim($request['password']));

        $loginUserResponse = $this->repository->login($loginUserRequest);

        if($loginUserResponse->hasError)
            $loginResponse->addErrors($loginUserResponse->errors);

        return $loginResponse;
    }
}