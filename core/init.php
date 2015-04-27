<?php
	session_start();
	
	require_once('config.php');
	require_once("functions\connection.funcs.php");
	require_once('functions\login.functions.php');
	require_once('functions\db.functions.php');

	if(loggedIn()){
		$username = $_SESSION['username'];

		$con = mysqli_connect($addr, $user, $password, $db);

		$data = mysqli_query($con, "SELECT nickname, email, country, genre FROM users WHERE '$username' = username LIMIT 1");

		while($row = mysqli_fetch_array($data)){
			$nickname = $row['nickname'];
			$email = $row['email'];
			$country = $row['country'];
			$genre = $row['genre'];
		}
	}