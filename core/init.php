<?php
	session_start();
	
	require_once('config.php');
	//require_once('database/connect.php');
	require_once('functions/login.functions.php');

	$username = $_SESSION['username'];