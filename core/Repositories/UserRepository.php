<?php

namespace CarregMusic\Repositories;

use CarregMusic\Mappers\UserMapper;
use CarregMusic\Types\Error;
use CarregMusic\Types\Requests\CreateUserRequest;
use CarregMusic\Types\Requests\LoginUserRequest;
use CarregMusic\Types\Responses\CreateUserResponse;
use CarregMusic\Types\Responses\LoginUserResponse;

class UserRepository
{
    function __construct($database)
    {
        $this->database = $database;
    }

    public function create(CreateUserRequest $request) : CreateUserResponse
    {
        $response = new CreateUserResponse();

        $data = mysqli_query($this->database->connection, "SELECT username, password FROM users WHERE username = '$request->username' LIMIT 1");

        if($data->num_rows > 0)
        {
            $response->addError(new Error('User with this username already exists.'));
            return $response;
        }

        $data = mysqli_query($this->database->connection, "INSERT INTO users (username, password, nickname, email, genreId, countryId) VALUES('$request->username', '$request->password', '$request->nickname', '$request->email', '$request->genre', '$request->country')");

        if(!$data)
        {
            $response->addError(new Error('Something went wrong during registration. Please try again later.'));
            return $response;
        }

        return $response;
    }

    public function login(LoginUserRequest $request) : LoginUserResponse
    {
        $response = new LoginUserResponse();

        $data = mysqli_query($this->database->connection, "SELECT username, password FROM users WHERE username = '$request->username' LIMIT 1");

        if(!$data)
        {
            $response->addError(new Error('Something went wrong during registration. Please try again later.'));
            return $response;
        }

        if($data->num_rows === 0)
        {
            $response->addError(new Error('User with this username does not exist.'));
            return $response;
        }

        $row = mysqli_fetch_array($data);
        $user = UserMapper::Map($row);

        if(!password_verify($request->password, $user->password))
        {
            $response->addError(new Error('Username or password is incorrect.'));
            return $response;
        }

        $_SESSION['user'] = $user;

        return $response;
    }
}