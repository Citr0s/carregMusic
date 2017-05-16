<?php

require __DIR__ . '/vendor/autoload.php';
require_once('bootstrap.php');

use CarregMusic\Controllers\UserController;
use CarregMusic\Database;
use CarregMusic\Repositories\UserRepository;
use CarregMusic\Services\UserService;
use CarregMusic\Validators\UserValidator;

$controller = new UserController(new UserService(new UserRepository(new Database()), new UserValidator()));
$loginResponse = $controller->login($_POST);

include_once 'includes/header.php';
?>
        <div class="container">
            <div class="formContainer">
                <h2 class="bigH2">Log in</h2>
                <?php
                    if($loginResponse->hasError)
                    {
                        echo '<div class="tipE">';
                        foreach($loginResponse->errors as $error)
                        {
                            echo '<p>'.$error->message.'</p>';
                        }
                        echo '</div>';
                    }
                    elseif($_GET)
                    {
                        if(isset($_GET['deleted']))
                        {
                            echo '<div class="tipE">';
                            echo '<p>This account has been closed.</p>';
                            echo '</div>';
                        }
                        else
                        {
                            echo '<div class="tipS">';
                            echo '<p>You have been registered successfully. You can now log in.</p>';
                            echo '</div>';
                        }
                    }
                    else
                    {
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