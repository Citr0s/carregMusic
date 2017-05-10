<?php

require_once __DIR__ . '/../../../bootstrap.php';

$data = mysqli_query($database->connection, "CREATE TABLE users ( id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, username VARCHAR(50) NOT NULL, nickname VARCHAR(50) NOT NULL, password VARCHAR(255), email VARCHAR(50) NOT NULL, genreId INT(6) NOT NULL, countryId INT(6) NOT NULL )");

if($data)
    echo 'Success';