<?php
function sanitise($value) {
    return htmlentities($value);
}

function isRequired($needle, $haystack) {
    return in_array($needle, $haystack);
}

function safePOST($variable)  {
    return mysql_real_escape_string($_POST[$variable]);
}

function validEmail($value) {
    return filter_var($value, FILTER_VALIDATE_EMAIL);
}

function validIntegerRange($value, $min, $max) {
    $options = array(
        'options'=>array(
            'min_range'=>$min,
            'max_range'=>$max
        )
    );
    return filter_var($value, FILTER_VALIDATE_INT, $options);
}

function validStringMaxLength($value, $min, $max) {
    $isOkay = false;
    if(strlen($value) >= $min && strlen($value) <= $max && !is_numeric($value)) {
        $isOkay = true;
    }
    return $isOkay;
}

function HtmlErrorMessage($field, $errorMessages) {
    if(isset($errorMessages[$field])) {
        echo '<span class="error_msg">' . sanitise($errorMessages[$field]) . '</span>';
    }
}

function HtmlText($value) {
    if(!empty($value)) {
        echo sanitise($value);
    }
}

function validateFormField($value, $field) {
    $errorMessage = '';

	require_once('\..\init.php');
	
    switch($field) {
        case 'username':
             if(!validStringMaxLength($value, minLength, nicknameMaxLength)) {
                $errorMessage = 'Username must have between '.minLength.' and '.nicknameMaxLength.' characters and must be a string';
            }
            break;
        case 'nickname':
            if(!validStringMaxLength($value, minLength, nicknameMaxLength)) {
                $errorMessage = 'Nickname must have between '.minLength.' and '.nicknameMaxLength.' characters and must be a string';
            }
            break;
		case 'email':
			if(!validEmail($value) || strlen($value) > emailMaxLength) {
				$errorMessage = 'Invalid email address';
			}
			break;
        case 'password':
            if (!validStringMaxLength($value, minLength, passwdMaxLength)) {
                $errorMessage = 'Password must be between '.minLength.' and '.passwdMaxLength.' characters long.';
            }
            break;
        case 'passwordCheck':
            if (!validStringMaxLength($value, minLength, passwdMaxLength)) {
                $errorMessage = 'Password must be between '.minLength.' and '.passwdMaxLength.' characters long.';
            }
            break;
		case 'country':
            if(!validIntegerRange($value, 1, countryMaxValue)) {
                $errorMessage = 'Please choose country from dropdown list.';
            }
			break;
        case 'genre':
            if(!validIntegerRange($value, 1, genreMaxValue)) {
                $errorMessage = 'Please choose your favorite genre from dropdown list.';
            }
            break;
        case 'comment':
            if(!validStringMaxLength($value, minLength, commentMaxLength)) {
                $errorMessage = 'Comment must have between '.minLength.' and '.commentMaxLength.' characters and must be a string';
            }
            break; 
    }
    return $errorMessage;
}


function loggedIn(){
    $loggedIn = false;

    if(isset($_SESSION['username']) || isset($_COOKIE['username'])){
        $loggedIn = true;
    }
    return $loggedIn;
}



function isThisLoginInDB($login)
{
    $sameNick = mysql_query("SELECT username from users WHERE username = '".$login."'");

    if (!$sameNick) {
        die('Query checking login failed.');
    }

    if (mysql_num_rows($sameNick) > 0) {
        return true;
    } else {
	    return false;
    }
}


