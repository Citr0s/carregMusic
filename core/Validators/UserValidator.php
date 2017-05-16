<?php

namespace CarregMusic\Validators;

use CarregMusic\Types\Error;
use CarregMusic\Types\Responses\UserValidationResponse;

class UserValidator extends BaseValidator
{
    private $usernameMaxLength;
    private $usernameMinLength;
    private $emailMinLength;
    private $emailMaxLength;
    private $countryMinLength;
    private $countryMaxLength;

    function __construct()
    {
        $this->usernameMinLength = 3;
        $this->usernameMaxLength = 25;
        $this->emailMinLength = 3;
        $this->emailMaxLength = 50;
        $this->countryMinLength = 0;
        $this->countryMaxLength = 11;

    }

    public function validate($request, $expected, $required) : UserValidationResponse
    {
        $response = new UserValidationResponse();

        foreach($expected as $field)
        {
            $fieldValue = trim($request[$field]);
            if(empty($fieldValue) && in_array($field, $required))
                $response->addError(new Error(ucfirst($field).' is a required field'));
        }

        if($response->hasError)
            return $response;

        if(array_key_exists('username', $request) && !self::checkStringLength($request['username'], $this->usernameMinLength, $this->usernameMaxLength))
            $response->addError(new Error("Username must have between {$this->usernameMinLength} and {$this->usernameMaxLength} characters and must be a string."));

        if(array_key_exists('nickname', $request) && !self::checkStringLength($request['nickname'], $this->usernameMinLength, $this->usernameMaxLength))
            $response->addError(new Error("Nickname must have between {$this->usernameMinLength} and {$this->usernameMaxLength} characters and must be a string."));

        if(array_key_exists('email', $request) && !self::checkEmail($request['email']))
            $response->addError(new Error("Invalid email address."));

        if(array_key_exists('email', $request) && !self::checkStringLength($request['email'], $this->usernameMinLength, $this->usernameMaxLength))
            $response->addError(new Error("Email must have between {$this->emailMinLength} and {$this->emailMaxLength} characters and must be a string."));

        if(array_key_exists('password', $request) && !self::checkStringLength($request['password'], $this->usernameMinLength, $this->usernameMaxLength))
            $response->addError(new Error("Password must have between {$this->usernameMinLength} and {$this->usernameMaxLength} characters and must be a string."));

        if(array_key_exists('country', $request) && !self::checkIntegerRange($request['country'], $this->countryMinLength, $this->countryMaxLength))
            $response->addError(new Error("Please choose country from drop-down list."));

        if(array_key_exists('genre', $request) && !self::checkIntegerRange($request['genre'], $this->countryMinLength, $this->countryMaxLength))
            $response->addError(new Error("Please choose your favorite genre from drop-down list."));

        return $response;
    }
}