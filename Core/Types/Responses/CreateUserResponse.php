<?php

namespace CarregMusic\Types\Responses;

class CreateUserResponse extends BaseResponse
{
    public $username;
    public $nickname;
    public $email;
    public $password;
    public $country;
    public $genre;
}