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

    public function get($columns, $table, $conditions, $limit = 1)
    {
        $columns = implode(', ', $columns);
        $conditions = implode(' = ', $conditions);

        return mysqli_query($this->connection, "SELECT {$columns} FROM {$table} WHERE {$conditions} LIMIT {$limit}");
    }

    public function insert($table, $columns, $values)
    {
        $columns = implode(', ', $columns);
        $values = implode(', ', $values);

        return mysqli_query($this->connection, "INSERT INTO {$table} ({$columns}) VALUES({$values})");
    }

    public function getAll($table)
    {
        return mysqli_query($this->connection, "SELECT * FROM {$table}");
    }
}