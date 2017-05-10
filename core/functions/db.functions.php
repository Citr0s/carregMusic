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
	$data = mysqli_query($database->connection, "SELECT genreID, genreName FROM genres");

	while($row = mysqli_fetch_array($data)){
		echo '<option value="'.$row['genreID'].'">'.$row['genreName'].'</option>';
	}
}