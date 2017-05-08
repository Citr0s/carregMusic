<?php

namespace CarregMusic\Repositories;

class GenreRepository
{
    function __construct($database)
    {
        $this->database = $database;
    }

    public function getFavouriteGenreFor($username)
    {
        $data = mysqli_query($this->database->connection, "SELECT genres.genreName FROM genres INNER JOIN users USING(genreID) WHERE username = '$username' LIMIT 1");
        $row = mysqli_fetch_array($data);

        return $row['genreName'];
    }
}