<?php

namespace CarregMusic;

class Database
{
    public $connection;

    public function __construct(){
        $host = "localhost";
        $user = "homestead";
        $password = "secret";
        $username = "carregMusic";

        $this->connection = mysqli_connect($host, $user, $password, $username);
    }
}