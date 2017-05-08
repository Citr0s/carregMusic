<?php

namespace CarregMusic;

class Database
{
    public $connection;

    function __construct($connection){
        $this->connection = $connection;
    }
}