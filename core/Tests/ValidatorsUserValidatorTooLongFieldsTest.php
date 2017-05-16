<?php

use CarregMusic\Validators\UserValidator;

require __DIR__ . '/../../vendor/autoload.php';

class ValidatorsUserValidatorTooLongFieldsTest extends PHPUnit\Framework\TestCase
{
    private $result;

    public function setUp()
    {
        $subject = new UserValidator();

        $expected = array('username', 'nickname', 'email', 'password', 'passwordCheck', 'country', 'genre');
        $required = array('username', 'nickname', 'email', 'password', 'passwordCheck', 'country', 'genre');

        $validationRequest = [
            'username' => 'thisUsernameIsWayTooLongToBeAllowedInOurValidation',
            'nickname' => 'thisNicknameIsWayTooLongToBeAllowedInOurValidation',
            'email' => 'thisEmailIsWayTooLongToBeAllowedInOurValidation',
            'password' => 'thisPasswordIsWayTooLongToBeAllowedInOurValidation',
            'passwordCheck' => 'thisPasswordIsWayTooLongToBeAllowedInOurValidation',
            'country' => 'thisCountryIsWayTooLongToBeAllowedInOurValidation',
            'genre' => 'thisCountryIsWayTooLongToBeAllowedInOurValidation'
        ];
        $this->result = $subject->validate($validationRequest, $expected, $required);

    }

    public function test_error_is_returned_when_username_is_too_short()
    {
        $this->assertEquals("Username must have between 3 and 25 characters and must be a string.", $this->result->errors[0]->message);
    }

    public function test_error_is_returned_when_nickname_is_too_short()
    {
        $this->assertEquals("Nickname must have between 3 and 25 characters and must be a string.", $this->result->errors[1]->message);
    }

    public function test_error_is_returned_when_email_is_not_valid()
    {
        $this->assertEquals("Invalid email address.", $this->result->errors[2]->message);
    }

    public function test_error_is_returned_when_email_is_too_short()
    {
        $this->assertEquals("Email must have between 3 and 50 characters and must be a string.", $this->result->errors[3]->message);
    }

    public function test_error_is_returned_when_password_is_too_short()
    {
        $this->assertEquals("Password must have between 3 and 25 characters and must be a string.", $this->result->errors[4]->message);
    }

    public function test_error_is_returned_when_country_is_too_short()
    {
        $this->assertEquals("Please choose country from drop-down list.", $this->result->errors[5]->message);
    }

    public function test_error_is_returned_when_genre_is_too_short()
    {
        $this->assertEquals("Please choose your favorite genre from drop-down list.", $this->result->errors[6]->message);
    }
}
