<?php

namespace CarregMusic;

use CarregMusic\Repositories\ConcertRepository;
use CarregMusic\Repositories\GenreRepository;
use CarregMusic\Repositories\TrackRepository;
use CarregMusic\Services\ConcertService;
use CarregMusic\Services\TrackService;

require __DIR__ . '/vendor/autoload.php';

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

require_once('web/functions/login.functions.php');
require_once('web/functions/db.functions.php');

if(loggedIn()){
    $username = $_SESSION['username'];
}

$database = new Database();

$genreRepository = new GenreRepository($database);

$trackRepository = new TrackRepository($database);
$trackService = new TrackService($trackRepository);

$concertRepository = new ConcertRepository($database);
$concertService = new ConcertService($concertRepository);