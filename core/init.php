<?php

namespace CarregMusic;

use CarregMusic\Repositories\GenreRepository;
use CarregMusic\Repositories\TrackRepository;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../credentials.php';

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

$database = new Database(mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE));
$genreRepository = new GenreRepository($database);
$trackRepository = new TrackRepository($database);