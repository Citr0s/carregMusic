<?php

namespace CarregMusic\Mappers;

use CarregMusic\Types\User;

class UserMapper
{
    public static function Map($record)
    {
        $user = new User();
        $user->username = $record['username'];
        $user->password = $record['password'];

        return $user;
    }
}