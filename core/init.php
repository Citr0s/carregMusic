<?php
	session_start();
	
	require_once('config.php');
	require_once("functions\connection.funcs.php");
	require_once('functions\login.functions.php');

	if(loggedIn()){
		$username = $_SESSION['username'];
	}