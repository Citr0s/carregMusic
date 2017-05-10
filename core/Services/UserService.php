<?php

namespace CarregMusic\Services;


use CarregMusic\Repositories\UserRepository;
use CarregMusic\Types\CreateUserRequest;
use CarregMusic\Types\Error;
use CarregMusic\Types\RegisterResponse;

class UserService
{
    private $repository;

    function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public static function hasSession()
    {
        return isset($_SESSION['username']) || isset($_COOKIE['username']);
    }

    public function register($request)
    {
        $registerResponse = new RegisterResponse();

        $expected = array('username', 'nickname', 'email', 'password', 'passwordCheck', 'country', 'genre');
        $required = array('username', 'nickname', 'email', 'password', 'passwordCheck', 'country', 'genre');

        foreach($expected as $field)
        {
            $fieldValue = trim($_POST[$field]);
            if(empty($fieldValue))
            {
                if(isRequired($field, $required))
                {
                    $registerResponse->addError(new Error(ucfirst($field).' is a required field'));
                }
            }
            else
            {
                if($msg = validateFormField($fieldValue, $field))
                {
                    $registerResponse->addError(new Error($msg));
                }
            }
        }

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