<?php

require_once __DIR__ . '/../../../bootstrap.php';

$data = mysqli_query($database->connection, "INSERT INTO genres (name) VALUES ('Rock')");

if($data)
    echo 'Success';