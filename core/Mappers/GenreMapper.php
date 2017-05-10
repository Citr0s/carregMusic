<?php

namespace CarregMusic\Mappers;

use CarregMusic\Types\Genre;

class GenreMapper
{
    public static function Map($record)
    {
        $genre = new Genre();
        $genre->id = $record['id'];
        $genre->name = $record['name'];

        return $genre;
    }
}