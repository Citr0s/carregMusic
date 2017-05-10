<?php

use CarregMusic\Validators\UserValidator;

require __DIR__ . '/../../vendor/autoload.php';

class ValidatorsUserValidatorMissingFieldsTest extends PHPUnit\Framework\TestCase
{
    private $result;

    public function setUp()
    {
        $subject = new UserValidator();

        $validationRequest = [
            'username' => '',
            'nickname' => '',
            'email' => '',
            'password' => '',
            'passwordCheck' => '',
            'country' => '',
            'genre' => ''
        ];
        $this->result = $subject->validate($validationRequest);

    }

    public function test_error_is_returned_when_username_is_not_provided()
    {
        $this->assertEquals("Username is a required field", $this->result->errors[0]->message);
    }

    public function test_error_is_returned_when_nickname_is_not_provided()
    {
        $this->assertEquals("Nickname is a required field", $this->result->errors[1]->message);
    }

    public function test_error_is_returned_when_email_is_not_provided()
    {
        $this->assertEquals("Email is a required field", $this->result->errors[2]->message);
    }

    public function test_error_is_returned_when_password_is_not_provided()
    {
        $this->assertEquals("Password is a required field", $this->result->errors[3]->message);
    }

    public function test_error_is_returned_when_password_check_is_not_provided()
    {
        $this->assertEquals("PasswordCheck is a required field", $this->result->errors[4]->message);
    }

    public function test_error_is_returned_when_country_is_not_provided()
    {
        $this->assertEquals("Country is a required field", $this->result->errors[5]->message);
    }

    public function test_error_is_returned_when_genre_is_not_provided()
    {
        $this->assertEquals("Genre is a required field", $this->result->errors[6]->message);
    }
}
