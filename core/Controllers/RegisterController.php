<?php

namespace CarregMusic\Controllers;

use CarregMusic\Services\UserService;

class RegisterController
{

    public static function registerUser($request)
    {
        if(UserService::hasSession())
            header('Location: index.php');

        $errorMessages = array();

        if($_POST){
            $expected = array('username', 'nickname', 'email', 'password', 'passwordCheck', 'country', 'genre');
            $required = array('username', 'nickname', 'email', 'password', 'passwordCheck', 'country', 'genre');

            foreach($expected as $field) {
                $fieldValue = trim($_POST[$field]);
                if(empty($fieldValue)){
                    if(isRequired($field, $required)) {
                        $errorMessages[$field] = ucfirst($field).' is a required field';
                    }
                }else{
                    if($msg = validateFormField($fieldValue, $field)) {
                        $errorMessages[$field] = $msg;
                    }
                }
            }

            if(!$errorMessages) {

                $con = mysqli_connect($addr, $user, $password, $db);

                $username = sanitise(trim($_POST['username']));
                $nickname = sanitise(trim($_POST['nickname']));
                $email = sanitise(trim($_POST['email']));
                $password = sanitise(trim($_POST['password']));
                $passwordCheck = sanitise(trim($_POST['passwordCheck']));
                $country = sanitise(trim($_POST['country']));
                $genre = sanitise(trim($_POST['genre']));

                $usernameDB = '';
                $passwordDB = '';

                $data = mysqli_query($con, "SELECT username, userPassword FROM users WHERE username = '$username' LIMIT 1");

                while($row = mysqli_fetch_array($data)){
                    $usernameDB = $row['username'];
                    $passwordDB = $row['userPassword'];
                }

                if($password !== $passwordCheck){
                    $errorMessages['form'] = 'Passwords don\'t match';
                }elseif($username == $usernameDB){
                    $errorMessages['form'] = 'User with this username already exists';
                }else{
                    mysqli_query($con, "INSERT INTO users (username, userPassword, userNickname, userEmail, genreID, countryID) VALUES('$username', '$password', '$nickname', '$email', '$genre', '$country')")
                    or die("Query adding new user failed:" . mysql_error());


                    echo "Account successfully created. Please wait for redirection.";
                    header("Location: login.php?registered");
                }
            }
        }
    }
}