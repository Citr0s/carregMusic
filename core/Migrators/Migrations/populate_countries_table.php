<?php

require_once __DIR__ . '/../../bootstrap.php';

$data = mysqli_query($database->connection, "INSERT INTO countries (name) VALUES ('United Kingdom')");

if($data)
    echo 'Success';