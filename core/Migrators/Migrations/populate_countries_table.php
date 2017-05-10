<?php

require_once __DIR__ . '/../../init.php';

$data = mysqli_query($database->connection, "INSERT INTO countries (name) VALUES ('United Kingdom')");

if($data)
    echo 'Success';