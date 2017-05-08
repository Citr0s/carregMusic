<?php

namespace CarregMusic;

use CarregMusic\Repositories\GenreRepository;

require __DIR__ . '/../vendor/autoload.php';

session_start();

define('loginMaxLength', 14);
define('passwdMaxLength', 32);
define('nicknameMaxLength', 25);
define('emailMaxLength', 50);
define('minLength', 3);
define('sexMaxValue', 2);
define('genreMaxValue', 20);
define('countryMaxValue', 11);
define('commentMaxLength', 120);

require_once('functions/conn.functions.php');
require_once('functions/login.functions.php');
require_once('functions/db.functions.php');

if(loggedIn()){
    $username = $_SESSION['username'];
}

$host = "localhost";
$user = "homestead";
$password = "secret";
$username = "carregMusic";

$database = new Database(mysqli_connect($host, $user, $password, $username));
$genreRepository = new GenreRepository($database);