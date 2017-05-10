<?php

namespace CarregMusic\Repositories;

use CarregMusic\Types\CreateUserRequest;
use CarregMusic\Types\CreateUserResponse;
use CarregMusic\Types\Error;

class UserRepository
{
    function __construct($database)
    {
        $this->database = $database;
    }

    public function create(CreateUserRequest $request) : CreateUserResponse
    {
        $response = new CreateUserResponse();

        $data = mysqli_query($this->database->connection, "SELECT username, userPassword FROM users WHERE username = '$request->username' LIMIT 1");

        if($data)
        {
            $response->addError(new Error('User with this username already exists.'));
            return $response;
        }

        $data = mysqli_query($this->database->connection, "INSERT INTO users (username, userPassword, userNickname, userEmail, genreID, countryID) VALUES('$request->username', '$request->password', '$request->nickname', '$request->email', '$request->genre', '$request->country')");

        if(!$data)
        {
            $response->addError(new Error('Something went wrong during registration. Please try again later.'));
            return $response;
        }

        return $response;
    }
}