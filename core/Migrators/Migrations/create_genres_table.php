<?php

require_once __DIR__ . '/../../bootsrap.php';

$data = mysqli_query($database->connection, "CREATE TABLE genres ( id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, name VARCHAR(50) NOT NULL )");

if($data)
    echo 'Success';