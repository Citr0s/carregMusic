<?php

namespace CarregMusic\Repositories;

use CarregMusic\Mappers\ConcertMapper;
use CarregMusic\Mappers\TrackMapper;

class ConcertRepository
{
    function __construct($database)
    {
        $this->database = $database;
    }

    public function getRandomConcerts(int $numberOfConcerts)
    {
        $response = [];

        $data = mysqli_query($this->database->connection, "SELECT concerts.concertID, concerts.concertName, venues.venueName, countries.countryName
                                                FROM concerts INNER JOIN venues USING (venueID) INNER JOIN countries USING (countryID)
                                                WHERE concertDate > CURDATE()
                                                ORDER BY RAND() 
                                                LIMIT {$numberOfConcerts}");

        if(!$data)
            return $response;

        while($row = mysqli_fetch_array($data))
            array_push($response, ConcertMapper::map($row));

        return $response;
    }
}