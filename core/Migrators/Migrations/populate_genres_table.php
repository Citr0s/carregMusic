<?php

require_once __DIR__ . '/../../bootsrap.php';

$data = mysqli_query($database->connection, "INSERT INTO genres (name) VALUES ('Rock')");

if($data)
    echo 'Success';