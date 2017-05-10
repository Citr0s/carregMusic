<?php

require_once __DIR__ . '/../../init.php';

$data = mysqli_query($database->connection, "CREATE TABLE countries ( id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, name VARCHAR(50) NOT NULL )");

if($data)
    echo 'Success';