<?php

namespace CarregMusic;

require __DIR__ . '/../credentials.php';

class Database
{
    public $connection;

    function __construct()
    {
        $this->connection = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
    }

    public function get($columns, $table, $conditions)
    {
        $columns = implode(', ', $columns);
        $conditions = implode(' = ', $conditions);

        return mysqli_query($this->connection, "SELECT {$columns} FROM {$table} WHERE {$conditions} LIMIT 1");
    }
}