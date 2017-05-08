<?php

namespace CarregMusic\Repositories;


class TrackRepository
{
    function __construct($database)
    {
        $this->database = $database;
    }

    public function getAllBasedOnGenreFor($genre)
    {
        return mysqli_query($this->database->connection, "SELECT tracks.trackID, tracks.trackTitle, GROUP_CONCAT(artists.artistName SEPARATOR ' & ') 
                                                    AS artists, tracks.coverPicture, COUNT(trackArtists.trackID) AS artistCount FROM tracks
                                                    INNER JOIN trackArtists USING (trackID)
                                                    INNER JOIN artists USING (artistID) 
                                                    INNER JOIN genres USING(genreID) 
                                                    WHERE genreNAME LIKE '%" . $genre . "%'
                                                    GROUP BY tracks.trackID
                                                    ORDER BY RAND()
                                                    LIMIT 5");
    }

    public function getAllRecommendedFor($genre, $requiredTracks)
    {
        return mysqli_query($this->database->connection, "SELECT tracks.trackID, tracks.trackTitle, GROUP_CONCAT(artists.artistName SEPARATOR ' & ') 
                                                        AS artists, tracks.coverPicture, COUNT(trackArtists.trackID) AS artistCount FROM tracks
                                                        INNER JOIN trackArtists USING (trackID)
                                                        INNER JOIN artists USING (artistID) 
                                                        INNER JOIN genres USING(genreID) 
                                                        WHERE genreNAME NOT LIKE '%" . $genre . "%'
                                                        GROUP BY tracks.trackID
                                                        ORDER BY RAND()
                                                        LIMIT " . $requiredTracks);
    }
}