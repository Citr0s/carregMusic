<?php 
    require_once 'core/init.php';
    include_once 'includes/header.php';

    if(!loggedIn()){
      header("Location: index.php");
    }

    $con = mysqli_connect($addr, $user, $password, $db);

    $data = mysqli_query($con, "SELECT userNickname, userEmail, countries.countryName, genres.genreName, countryID, genreID FROM users INNER JOIN countries USING (countryID) INNER JOIN genres USING (genreID) WHERE username = '$username' LIMIT 1");

    while($row = mysqli_fetch_array($data)){
      $nickname = $row['userNickname'];
      $email = $row['userEmail'];
      $countryID = $row['countryID'];
      $country = $row['countryName'];
      $genreID = $row['genreID'];
      $genre = $row['genreName'];
    }

    $errorMessages = array();

    if($_POST){
      if(isset($_POST['password']) || isset($_POST['passwordCheck'])){
        $expected = array('password', 'passwordCheck');
        $required = array('password', 'passwordCheck');

        foreach($expected as $field) {
          $fieldValue = trim($_POST[$field]);
          if(empty($fieldValue)){
            if(isRequired($field, $required)) {
                $errorMessages[$field] = ucfirst($field).' is a required field';
            }
          }else{
            if($msg = validateFormField($fieldValue, $field)){
                $errorMessages[$field] = $msg;
            }
          }
        }

        if(!$errorMessages){
            
          $con = mysqli_connect($addr, $user, $password, $db);

          $password = sanitise(trim($_POST['password']));
          $passwordCheck = sanitise(trim($_POST['passwordCheck']));

          if($password !== $passwordCheck){
            $errorMessages['form'] = 'Passwords don\'t match';
          }else{
            mysqli_query($con, "UPDATE users SET userPassword = '$password' WHERE username = '$username'") or die("Query adding new user failed:" . mysql_error()); 
            header("Location: profile.php?".$username."&success");
          }
        }
      }else{
        $expected = array('nickname', 'email', 'country', 'genre');
        $required = array('nickname', 'email', 'country', 'genre');

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

        if(!$errorMessages){
            
          $con = mysqli_connect($addr, $user, $password, $db);

          $nickname = sanitise(trim($_POST['nickname']));
          $email = sanitise(trim($_POST['email']));
          $country = sanitise(trim($_POST['country']));
          $genre = sanitise(trim($_POST['genre']));

          mysqli_query($con, "UPDATE users SET userNickname = '$nickname', userEmail = '$email', countryID = '$country', genreID = '$genre' WHERE username = '$username'") or die("Query adding new user failed:" . mysql_error()); 
          header("Location: profile.php?".$username."&success");
        }
      }
    }
?>
        <div class="container">
            <div class="formContainer">
                <h2 class="bigH2"><?php echo $username; ?></h2>
                <?php
                  if($_POST){
                    echo '<div class="tipE">';
                    foreach($errorMessages as $error){
                      echo '<p>'.$error.'</p>';
                    }
                    echo '</div>';
                  }else if(isset($_GET['success'])){
                    echo '<div class="tipS">';
                      echo '<p>Your details have been saved successfully.</p>';
                    echo '</div>';
                  }else{
                    echo '<div class="tipP"><p>Welcome to your profile. Here you can edit or close your account.</p></div>';
                  }
                ?>
                <form class="loginForm" action="#" method="post">
                   <table>
                        <th colspan="2" align="left">Update Your Information</th>
                       <tr>
                           <td>Nickname:</td><td><input type="text" name="nickname" value="<?php echo $nickname; ?>" placeholder="nickname"></td>
                        </tr>
                       <tr>
                           <td>Email:</td><td><input type="text" name="email" value="<?php echo $email; ?>" placeholder="nickname"></td>
                        </tr>
                       <tr>
                           <td>Country of Origin:</td><td class="tdR"><select name="country" class="country"><option value="<?php echo $countryID; ?>"><?php echo $country; ?></option><?php generateCountryList(); ?></select></td>
                        </tr>
                        <tr>
                           <td>Favourite Genre:</td><td class="tdR"><select name="genre" class="genre"><option value="<?php echo $genreID; ?>"><?php echo $genre; ?></option><?php generateGenreList(); ?></select></td>
                        </tr>
                       <tr>
                           <td></td><td><button class="loginRegisterButton">SAVE</button></td>
                       </tr>
                   </table>
                </form>
                <form class="loginForm" action="#" method="post">
                   <table>
                        <th colspan="2" align="left">Change Your Password</th>

                        <tr>
                           <td>Password:</td><td><input id="Password1" type="password" name="password" placeholder="password"></td>
                       </tr>
                       <tr>
                           <td>Password Again:</td><td><input id="PasswordCheck" type="password" name="passwordCheck" placeholder="password"></td>
                       </tr>
                       <tr>
                           <td></td><td><button class="loginRegisterButton">SAVE</button></td>
                       </tr>
                   </table>
                </form>
            </div>
        </div>
<?php include_once 'includes/footer.php'; ?>