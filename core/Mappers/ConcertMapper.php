<?php

namespace CarregMusic\Mappers;

use CarregMusic\Types\Concert;

class ConcertMapper
{
    public static function Map($record)
    {
        $concert = new Concert();
        $concert->id = $record['concertID'];
        $concert->country = $record['countryName'];
        $concert->venue = $record['venueName'];
        $concert->name = $record['concertName'];

        return $concert;
    }
}