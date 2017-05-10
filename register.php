<?php

require __DIR__ . '/vendor/autoload.php';
require_once('bootstrap.php');

use CarregMusic\Controllers\RegisterController;

RegisterController::registerUser($_POST);

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
                           <td>Username:</td><td><input required id="registerUserName" type="text" name="username" placeholder="username" value="<?php if($_POST){HtmlText($_POST['username']);} ?>"></td>
                        </tr>
                      
                       <tr>
                           <td>Nickname:</td><td><input required id="nickName" type="text" name="nickname" placeholder="nickname" value="<?php if($_POST){HtmlText($_POST['nickname']);} ?>"></td>
                        </tr>
                       <tr>
                           <td>Email:</td><td><input required id="Email" type="email" name="email" placeholder="email" value="<?php if($_POST){HtmlText($_POST['email']);} ?>"></td>
                        </tr>
                        <tr>
                           <td>Password:</td><td><input required id="Password1" type="password" name="password" placeholder="password"></td>
                       </tr>
                       <tr>
                           <td>Password Again:</td><td><input required id="PasswordCheck" type="password" name="passwordCheck" required placeholder="password"></td>
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