<?php

namespace CarregMusic\Repositories;


use CarregMusic\Mappers\CountryMapper;

class CountryRepository
{
    function __construct($database)
    {
        $this->database = $database;
    }

    public function getAll()
    {
        $response = [];

        $data = mysqli_query($this->database->connection, "SELECT * FROM countries");

        while($row = mysqli_fetch_array($data)){
            array_push($response, CountryMapper::map($row));
        }

        return $response;
    }
}