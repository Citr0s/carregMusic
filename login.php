<?php
  require_once('bootstrap.php');

  if(loggedIn())
      header('Location: index.php');

  $errorMessages = array();

  if($_POST){
      $expected = array('username', 'password');
      $required = array('username', 'password');

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
        $password = sanitise(trim($_POST['password']));

        $usernameDB = '';
        $passwordDB = '';

        $data = mysqli_query($con, "SELECT username, userPassword, userDeleted FROM users WHERE username = '$username' LIMIT 1");

        while($row = mysqli_fetch_array($data)){
          $usernameDB = $row['username'];
          $passwordDB = $row['userPassword'];
          $userDeleted = $row['userDeleted'];
        }

        if($username === $usernameDB && $password === $passwordDB){
          if($userDeleted == 1){
              header("Location: login.php?deleted");
          }else{
            $_SESSION['username'] = $username;
            setcookie('username', $username, 3600, '/');
            header('Location: index.php');
          }
        }else{
            $errorMessages['form'] = 'Username or Password incorrect';
        }
      }
    }
  
  include_once 'includes/header.php'; 
?>
        <div class="container">
            <div class="formContainer">
                <h2 class="bigH2">Log in</h2>
                <?php
                  if($_POST){
                    echo '<div class="tipE">';
                    foreach($errorMessages as $error){
                      echo '<p>'.$error.'</p>';
                    }
                    echo '</div>';
                  }elseif($_GET){
                    if(isset($_GET['deleted'])){
                      echo '<div class="tipE">';
                        echo '<p>This account has been closed.</p>';
                      echo '</div>';
                    }else{
                      echo '<div class="tipS">';
                        echo '<p>You have been registered successfully. You can now log in.</p>';
                      echo '</div>';
                    }
                  }else{
                    echo '<div class="tipP"><p>To access extra features please <a href="register.php">register here</a>.</p></div>';
                  }
                ?>
                <form class="loginForm" action="#" method="post">
                   <table>
                       <tr>
                           <td>Username:</td><td><input type="text" name="username" value="<?php if($_POST){HtmlText($_POST['username']);} ?>" placeholder="username"></td>
                        </tr>
                        <tr>
                           <td>Password:</td><td><input type="password" name="password" value="<?php if($_POST){HtmlText($_POST['password']);} ?>" placeholder="password"></td>
                       </tr>
                       <tr>
                           <td></td><td><button class="loginRegisterButton">LOG IN</button></td>
                       </tr>
                   </table>
                </form>
                
            </div>
        </div>
<?php include_once 'includes/footer.php'; ?>