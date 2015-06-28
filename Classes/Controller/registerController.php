<?php

/**
 * Created by PhpStorm.
 * User: kostas
 * Date: 26-Aug-14
 * Time: 5:25 PM
 */
class RegisterController
{

    private $validator_message;
    private $credentials = array();
    private $registerPage;

    public function __construct()
    {
        $this->registerPage = new RegisterView();
        $this->validator_message = "";
        if (isset($_POST["Credentials"])) {
            $this->handleRegisterData();
        }
        session_start();
        unset($_SESSION);
        session_destroy();
    }

    public function __destruct()
    {
    }


    public function displayPage()
    {
        $register_Page = $this->registerPage->createRegisterPage();
        echo $register_Page;
    }

    public function displayErrors($errorMessage)
    {
        $errors = $this->registerPage->displayErrors($errorMessage);
        echo $errors;
    }

    public function displaySuccess($successMessage)
    {
        $message = $this->registerPage->displaySuccess($successMessage);
        echo $message;
    }

    private function handleRegisterData()
    {
        foreach ($_POST as $key => $data) {
            if ($key != "Credentials") {
                $this->credentials[$key] = $data;
            }
        }
        if (!ctype_alnum($this->credentials['Username'])) {
            $this->validator_message .= " Username can only contain alphanumeric characters. </br> ";
        } else {
            if (strlen($this->credentials['Username']) > 20 || strlen($this->credentials['Username']) < 5) {
                $this->validator_message .= " Username cannot be more than 20 characters and less than 5. </br> ";
            }
        }
        if (strlen($this->credentials['Password']) > 20 || strlen($this->credentials['Password']) < 5) {
            $this->validator_message .= " Password cannot be more than 20 characters and less than 5. </br> ";
        }
        if (strcmp($this->credentials['Password'], $this->credentials['PasswordCheck']) !== 0) {
            $this->validator_message .= " Passwords do not match. </br> ";
        }
        if (!filter_var($this->credentials['Email'], FILTER_VALIDATE_EMAIL)) {
            $this->validator_message .= " Email not valid.";
        }
        if ($this->validator_message == "") {
            $sanitized_credentials = array();
            $sanitized_credentials['Username'] = filter_var($this->credentials['Username'], FILTER_SANITIZE_STRING);
            $sanitized_credentials['Password'] = filter_var($this->credentials['Password'], FILTER_SANITIZE_STRING);
            $sanitized_credentials['Email'] = filter_var($this->credentials['Email'], FILTER_SANITIZE_EMAIL);
            $newUser = new RegisterModel($sanitized_credentials);
            $unique = $newUser->checkUniqueness();
            if ($unique == null) {
                $newUser->save();
                $this->validator_message .= "Successfully registered";
                $this->displaySuccess($this->validator_message);
            } else {
                if (strcmp($sanitized_credentials['Username'], $unique['Username']) == 0 && strcmp(
                        $sanitized_credentials['Email'],
                        $unique['Email']
                    ) == 0
                ) {
                    $this->validator_message .= "Email and username already used";
                } else {
                    if (strcmp($sanitized_credentials['Email'], $unique['Email']) == 0) {
                        $this->validator_message .= "Email already used";
                    } else {
                        $this->validator_message .= "Username already used";
                    }
                }
                $this->displayErrors($this->validator_message);
            }
        } else {
            $this->displayErrors($this->validator_message);
        }
    }
}