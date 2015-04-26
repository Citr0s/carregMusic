<?php require_once('core/init.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Carreg Music 22</title>
    <link rel="stylesheet" href="css/normalize.css" type="text/css">
    <link rel="stylesheet" href="css/styles.css" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
</head>
<body>
    <div id="wrapper">
        <div id="header">
           <div class="container">
               <div class="floatLeft">
                    <a href="index.php"><img src="css/images/logo.png" alt="logo"></a>
                </div>
                <div class="floatLeft">
                    <ul>
                        <li><a href="index.php">HOME</a></li>
                        <li><a href="">TRACKS</a></li>
                        <li><a href="">ARTISTS</a></li>
                        <li><a href="">CONCERTS</a></li>
                    </ul>
                </div>
                <div class="floatRight">
                    <ul>
                        <?php
                            if(loggedIn()){
                                echo '
                                    <li><a href="profile.php?'.$username.'">'.$username.'</a></li>
                                    <li><a href="logout.php">Logout</a></li>
                                    ';
                            }else{
                        ?>
                            <li><a href="login.php">LOGIN</a></li>
                            <li><a href="register.php" class="register">REGISTER</a></li>
                        <?php
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>