<?php

namespace CarregMusic\Mappers;


use CarregMusic\Models\Country;

class CountryMapper
{
    public static function Map($record)
    {
        $country = new Country();
        $country->id = $record['id'];
        $country->name = $record['name'];

        return $country;
    }
}