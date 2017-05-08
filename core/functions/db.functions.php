<?php
function generateCountryList(){

	//very unsafe - will fix later
    $addr = "localhost";
    $user = "homestead";
    $password = "secret";
    $db = "carregMusic";

	$con = mysqli_connect($addr, $user, $password, $db);

	$data = mysqli_query($con, "SELECT countryID, countryName FROM countries");

	while($row = mysqli_fetch_array($data)){
		echo '<option value="'.$row['countryID'].'">'.$row['countryName'].'</option>';
	}
}
function generateGenreList(){

	//very unsafe - will fix later
    $addr = "localhost";
    $user = "homestead";
    $password = "secret";
    $db = "carregMusic";

	$con = mysqli_connect($addr, $user, $password, $db);

	$data = mysqli_query($con, "SELECT genreID, genreName FROM genres");

	while($row = mysqli_fetch_array($data)){
		echo '<option value="'.$row['genreID'].'">'.$row['genreName'].'</option>';
	}
}