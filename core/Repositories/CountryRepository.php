<?php

namespace CarregMusic\Repositories;


use CarregMusic\Database;
use CarregMusic\Mappers\CountryMapper;

class CountryRepository
{
    function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function getAll()
    {
        $response = [];

        $data = $this->database->getAll('countries');

        while($row = mysqli_fetch_array($data)){
            array_push($response, CountryMapper::map($row));
        }

        return $response;
    }
}