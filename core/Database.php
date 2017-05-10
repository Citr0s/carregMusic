<?php

namespace CarregMusic;

require __DIR__ . '/../credentials.php';

class Database
{
    public $connection;

    function __construct(){
        $this->connection = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
    }
}