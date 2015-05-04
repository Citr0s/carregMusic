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
  
  include_once 'includes/header.php'; 
?>
        <div class="container">
            <div class="formContainer">
                <h2 class="bigH2">Register</h2>
                <?php
                  if($_POST){
                    echo '<div class="tipE">';
                    foreach($errorMessages as $error){
                      echo '<p>'.$error.'</p>';
                    }
                    echo '</div>';
                  }else{
                    echo '<div class="tipP"><p>Already have an account? <a href="login.php">Login here</a>.</p></div>';
                  }
                ?>
                <form id="appendHere" class="loginForm" action="#" method="post">
                   <table>
                       <tr>
                           <td>Username:</td><td><input id="registerUserName" type="text" name="username" placeholder="username" value="<?php if($_POST){HtmlText($_POST['username']);} ?>"></td>
                        </tr>
                      
                       <tr>
                           <td>Nickname:</td><td><input id="nickName" type="text" name="nickname" placeholder="nickname" value="<?php if($_POST){HtmlText($_POST['nickname']);} ?>"></td>
                        </tr>
                       <tr>
                           <td>Email:</td><td><input id="Email" type="email" name="email" placeholder="email" value="<?php if($_POST){HtmlText($_POST['email']);} ?>"></td>
                        </tr>
                        <tr>
                           <td>Password:</td><td><input id="Password1" type="password" name="password" placeholder="password"></td>
                       </tr>
                       <tr>
                           <td>Password Again:</td><td><input id="PasswordCheck" type="password" name="passwordCheck" placeholder="password"></td>
                       </tr>
                       <tr>
                           <td>Country of Origin:</td><td class="tdR"><select name="country" class="country"><?php generateCountryList(); ?></select></td>
                        </tr>
                        <tr>
                           <td>Favourite Genre:</td><td class="tdR"><select name="genre" class="genre"><?php generateGenreList(); ?></select></td>
                        </tr>
                       <tr>
                           <td></td><td><button class="loginRegisterButton">REGISTER</button></td>
                       </tr>
                   </table>
                </form>
                
            </div>
        </div>
            <script src="js/scripts.js"></script>
<?php include_once 'includes/footer.php'; ?>