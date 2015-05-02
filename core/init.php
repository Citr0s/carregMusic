<?php
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

	$addr = "localhost";
	$user = "l017063e";
	$password = "l017063e";
	$db = "l017063e";

	require_once("functions\conn.functions.php");
	require_once('functions\login.functions.php');
	require_once('functions\db.functions.php');

	if(loggedIn()){
		$username = $_SESSION['username'];
	}