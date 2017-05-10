<?php

namespace CarregMusic\Mappers;

use CarregMusic\Models\Genre;

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