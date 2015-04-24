<?php
  require_once('core/init.php');

  if($_POST){
    echo $_POST['username'];
    echo $_POST['password'];
  }

  /*
  if(loggedIn()){
      header('Location: index.php');
  }

  $errorMessages = array();

  if($_POST) {
      $expected = array('username', 'password');
      $required = array('username', 'password');

      foreach($expected as $field) {
          $fieldValue = trim($_POST[$field]);
          if(empty($fieldValue)) {
              if(isRequired($field, $required)) {
                  $errorMessages[$field] = 'This is a required field';
              }
          } else {
              if($msg = validateFormField($fieldValue, $field)) {
                  $errorMessages[$field] = $msg;
              }
          }
      }

      if($errorMessages) {
          $errorMessages['form'] = 'There were errors please review and correct';
      } else {
          //pull username and password from db
          $usernameDB = 'john';
          $passwordDB = 'snow';

          $username = sanitise(trim($_POST['username']));
          $password = sanitise(trim($_POST['password']));

          if($username === $usernameDB && $password === $passwordDB){
              $_SESSION['username'] = $username;
              setcookie('username', $username, 3600, '/');
              header('Location: index.php');
          }else{
              $errorMessages['form'] = 'Username or Password incorrect';
          }
      }
  } */
  
  include_once 'includes/header.php'; 
?>
        <div class="container">
            <div class="formContainer">
                <h2 class="bigH2">Log in</h2>
                <p class="tipP">To access extra features please <a href="register.php">register here</a>.</p>
                <form class="loginForm" action="#" method="post">
                   <table>
                       <tr>
                           <td>Username:</td><td><input type="text" name="username" value="username"></td>
                        </tr>
                        <tr>
                           <td>Password:</td><td><input type="password" name="loginPassword" value="password"></td>
                       </tr>
                       <tr>
                           <td></td><td><button class="loginRegisterButton">LOG IN</button></td>
                       </tr>
                   </table>
                </form>
                
            </div>
        </div>
<?php include_once 'includes/footer.php'; ?>