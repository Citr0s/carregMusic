<?php
  require_once('core/init.php');

  if(loggedIn()){
      header('Location: index.php');
  }

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

        if($username === $usernameDB && $password === $passwordDB){
            $_SESSION['username'] = $username;
            setcookie('username', $username, 3600, '/');
            header('Location: index.php');
        }else{
            $errorMessages['form'] = 'Username or Password incorrect';
        }
      }
    }
  
  include_once 'includes/header.php'; 
?>
<?php 
/*
  if($_POST){
    connect($addr, $user, $password, $db);
    $required = array('password', 'email', 'username', 'nickname', 'countries', 'genres');

    foreach($required as $field){
      $fieldValue = trim($_POST[$field]);
      if(empty($fieldValue)){
        $errorMessages[$field] = 'This is a required field';    
      } 
      else{
        if($msg = validateRegFormField($fieldValue, $field)){
          $errorMessages[$field] = $msg;
        }
      }
    }

    if(isThisLoginInDB($_POST['username'])){     
      $errorMessages['username'] = "Login already taken - choose other one.";
      die();
    } 

    if(!$messages){
      $username = safePOST('username');
      $password = safePOST('password');
      $passwordCheck = safePOST('passwordCheck');
      $nickname = safePOST('nickname');
      $email = safePOST('email');
      $genre = $_POST['genres'];
      $country = $_POST['countries'];

      mysql_query("
        INSERT INTO users (username, userPassword, userNickname, userEmail, genreID, countryID) 
        VALUES('$username', '$password', '$nickname', '$email', '$genre', '$country')
        ") 
      or die("Query adding new user failed:" . mysql_error()); 


      echo "Account successfully created. Please wait for redirection.";
      header("Location: login.php");
    }
  }
*/
?>
        <div class="container">
            <div class="formContainer">
                <h2 class="bigH2">Register</h2>
                <p class="tipP">Already have an account? <a href="login.php">Login here</a>.</p>
                <form id="appendHere" class="loginForm" action="#" method="post">
                   <table>
                       <tr>
                           <td>Username:</td><td><input id="registerUserName" type="text" name="username" placeholder="username"></td>
                        </tr>
                       <tr>
                       <tr>
                           <td>Nickname:</td><td><input id="registerUserName" type="text" name="nickname" placeholder="nickname"></td>
                        </tr>
                       <tr>
                           <td>Email:</td><td><input id="Email" type="email" name="email" placeholder="email"></td>
                        </tr>
                        <tr>
                           <td>Password:</td><td><input id="Password1" type="password" name="password" placeholder="password"></td>
                       </tr>
                       <tr>
                           <td>Password Again:</td><td><input id="PasswordCheck" type="password" name="passwordCheck" placeholder="password"></td>
                       </tr>
                       <tr>
                           <td>Country of Origin:</td><td class="tdR"><select name="country" class="country"><option name="UK" >United Kingdom</option></select></td>
                        </tr
                        <tr>
                           <td>Favourite Genre:</td><td class="tdR"><select name="genre" class="genre"><option name="pop" >Pop</option></select></td>
                        </tr
                       <tr>
                           <td></td><td><button class="loginRegisterButton">LOG IN</button></td>
                       </tr>
                   </table>
                </form>
                
            </div>
        </div>
<?php include_once 'includes/footer.php'; ?>