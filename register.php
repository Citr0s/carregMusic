<?php include_once 'includes/header.php'; ?>
        <div class="container">
            <div class="formContainer">
                <h2 class="bigH2">Register</h2>
                <p class="tipP">Already have an account? <a href="login.php">Login here</a>.</p>
                <form class="loginForm" action="loginForm.php" method="post">
                   <table>
                       <tr>
                           <td>Username:</td><td><input id="registerUserName" type="text" name="username" value="username"></td>
                        </tr>
                       <tr>
                           <td>Email:</td><td><input id="Email" type="email" name="email" value="email"></td>
                        </tr>
                        <tr>
                           <td>Password:</td><td><input id="Password1" type="password" name="loginPassword" value="password"></td>
                       </tr>
                       <tr>
                           <td>Password Again:</td><td><input id="PasswordCheck" type="password_r" name="loginPassword" value="password"></td>
                       </tr>
                       <tr>
                           <td>Country of Origin:</td><td class="tdR"><select name="country" class="loginPassword"><option name="UK" >United Kingdom</option></select></td>
                        </tr
                        <tr>
                           <td>Favourite Genre:</td><td class="tdR"><select name="genre" class="loginPassword"><option name="pop" >Pop</option></select></td>
                        </tr
                       <tr>
                           <td></td><td><button class="loginRegisterButton">LOG IN</button></td>
                       </tr>
                   </table>
                </form>
                
            </div>
        </div>
<?php include_once 'includes/footer.php'; ?>