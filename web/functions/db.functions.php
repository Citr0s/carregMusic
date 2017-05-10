<?php

use CarregMusic\Database;

require __DIR__ . '/../../vendor/autoload.php';

function generateCountryList()
{
    $countryRepository = new \CarregMusic\Repositories\CountryRepository(new Database());
    $countries = $countryRepository->getAll();

    foreach($countries as $country)
    {
        echo '<option value="'.$country->id.'">'.$country->name.'</option>';
    }
}
function generateGenreList()
{
    $genreRepository = new \CarregMusic\Repositories\GenreRepository(new Database());
    $genres = $genreRepository->getAll();

    foreach($genres as $genre)
    {
        echo '<option value="'.$genre->id.'">'.$genre->name.'</option>';
    }
}