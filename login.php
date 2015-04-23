<?php include_once 'includes/header.php'; ?>
        <div class="container">
            <div class="formContainer">
                <h2 class="bigH2">Log in</h2>
                <p class="tipP">To access extra features please <a href="register.php">register here</a>.</p>
                <form class="loginForm" action="loginForm.php" method="post">
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