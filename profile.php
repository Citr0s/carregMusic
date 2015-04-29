<?php 
    require_once 'core/init.php';
    include_once 'includes/header.php';

    if(!loggedIn()){
      header("Location: index.php");
    }

    $con = mysqli_connect($addr, $user, $password, $db);

    $data = mysqli_query($con, "SELECT nickname, email, country, genre FROM users WHERE username = '$username' LIMIT 1");

    while($row = mysqli_fetch_array($data)){
      $nickname = $row['nickname'];
      $email = $row['email'];
      $country = $row['country'];
      $genre = $row['genre'];
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
                  }else if($_GET){
                    echo '<div class="tipS">';
                      echo '<p>You have been registered successfully. You can now log in.</p>';
                    echo '</div>';
                  }else{
                    echo '<div class="tipP">To access extra features please <a href="register.php">register here</a>.</div>';
                  }
                ?>
                <form class="loginForm" action="#" method="post">
                   <table>
                        <th colspan="2" align="left">Update Your Information</th>
                       <tr>
                           <td>Nickname:</td><td><input type="text" name="username" value="<?php echo $nickname; ?>" placeholder="nickname"></td>
                        </tr>
                       <tr>
                           <td>Email:</td><td><input type="text" name="username" value="<?php echo $email; ?>" placeholder="nickname"></td>
                        </tr>
                       <tr>
                           <td>Country of Origin:</td><td class="tdR"><select name="country" class="country"><option value="<?php echo $country; ?>"><?php echo $country; ?></option><?php generateCountryList(); ?></select></td>
                        </tr>
                        <tr>
                           <td>Favourite Genre:</td><td class="tdR"><select name="genre" class="genre"><option value="<?php echo $genre; ?>"><?php echo $genre; ?></option><?php generateGenreList(); ?></select></td>
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