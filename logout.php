<?php
	require_once('bootsrap.php');

    setcookie('username', '', time() - 3600, '/');    
    session_destroy();

    header('Location: index.php');

