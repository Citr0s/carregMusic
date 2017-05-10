<?php require_once('bootstrap.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Carreg Music</title>
    <script type="text/javascript" src="js/modernizr.js"></script>
    <link rel="stylesheet" href="css/normalize.css" type="text/css">
    <link rel="stylesheet" href="css/styles.css" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
    <link rel="icon" href="css/images/favicon.ico?" type="image/x-icon" />
</head>
<body>
    <div id="wrapper">
        <div id="header">
           <div class="container">
            <div id="firstMenuContainer">
               <div class="floatLeft">
                    <a href="index.php"><img src="css/images/logo.png" alt="logo"></a>
                </div>
                <a id="threeLineButton" href="#menuContainer" class="menuButton">&equiv;</a>
                <div id="responsiveMenuContainer">
                <div class="floatLeft">
                    <ul>
                        <li><a href="index.php">HOME</a></li>
                        <li><a href="tracks.php">TRACKS</a></li>
                        <li><a href="artists.php">ARTISTS</a></li>
                        <li><a href="concerts.php">CONCERTS</a></li>
                        <li><a href="search.php">SEARCH</a></li>
                    </ul>
                </div>
                <div class="floatRight">
                    <ul>
                        <?php
                            if(loggedIn()){
                                echo '
                                    <li><a href="profile.php?'.$username.'&activity">'.$username.'</a></li>
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
            </div>
        </div>