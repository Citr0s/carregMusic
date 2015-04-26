<?PHP

require_once("core\config.php");
require_once("core\functions\connection.funcs.php");
require_once("core\functions\login.funcs.php");
	
if (!$_POST && !loggedIn())
{
	connect($addr, $user, $password, $db);
	$required = array('password', 'email', 'login', 'nickname', 'countries', 'genres');

	foreach($required as $field) {
		$fieldValue = trim($_POST[$field]);
		if(empty($fieldValue)) 
		{
			$errorMessages[$field] = 'This is a required field';		
		} 
		else 
		{
			if($msg = validateRegFormField($fieldValue, $field)) 
			{
				$errorMessages[$field] = $msg;
			}
		}
	}

	if (isThisLoginInDB($_POST['login'])) {     
		errorMessages['login'] = "Login already taken - choose other one."
		die("");
	} 

	if (!$messages)
	{
		$login = $safePOST('login');
		$password = safePOST('password');
		$nickname = safePOST('nickname');
		$email = safePOST('email');
		$genre = $_POST['genres'];
		$country $_POST['countries'];

		mysql_query("INSERT INTO users 
						(username, userPassword, userNickname, userEmail, genreID, countryID) 
						VALUES('$login', '$password', '$nickname', '$email', '$genre', '$country')") 
				
		or die("Query adding new user failed:" . mysql_error()); 


		echo "Account successfully created. Please wait for redirection.";  

		// simple curl to milosz's login script*/
	}
}

?>


<form name="register" action="" method="post">
Login: <input title="Please Enter Login" id="login" name="login" value="<?php if ($_POST) { HtmlText($_POST['login']); } ?>" type="text" /> <?php HtmlErrorMessage('login', $errorMessages); ?>
<p/>Password: <input title="Please Enter Password" id="password" name="password" type="password" /><?php HtmlErrorMessage('password', $errorMessages); ?>
<p/>Nickname: <input title="Please Enter Nickname" id="nickname" name="nickname" value="<?php if ($_POST) { HtmlText($_POST['nickname']); } ?>" type="text" /><?php HtmlErrorMessage('nickname', $errorMessages); ?>
<p/>E-mail: <input title="Please Enter E-mail" id="email" name="email" value="<?php if ($_POST) { HtmlText($_POST['email']); } ?>" type="text" /><?php HtmlErrorMessage('email', $errorMessages); ?>
<p/> <?PHP dropdown("countryId", "countryName", "countries", "countries", "country"); ?>
<p/> <?PHP dropdown("genreID", "genreName", "genres", "genre", "fav. genre"); ?>
<p/><input type="submit" value="Register!" />
</form>