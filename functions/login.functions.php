<?php
function sanitise($value) {
    return htmlentities($value);
}

function isRequired($needle, $haystack) {
    return in_array($needle, $haystack);
}

function validStringMaxLength($value, $max) {
    $isOkay = false;
    if(strlen($value) <= $max && !is_numeric($value)) {
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

    switch($field) {
        case 'username':
            if(!validStringMaxLength($value, 25)) {
                $errorMessage = 'Name must be 5 characters or less and must be a string';
            }
            break;
        case 'password':
            if(!validStringMaxLength($value, 25)) {
                $errorMessage = 'Password must be 5 characters or less and must be a string';
            }
            break;
        default:
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