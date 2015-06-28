<?php

/**
 * Created by PhpStorm.
 * User: kostas
 * Date: 26-Aug-14
 * Time: 5:25 PM
 */
class LoginController
{


    private $validator_message;
    private $credentials = array();
    private $loginPage;
    private $f3;

    public function __construct($f3)
    {
        $this->f3=$f3;
        session_start();
        unset($_SESSION);
        session_destroy();

        $this->loginPage= new loginView();
        $this->validator_message="";
        if ($f3->exists('POST.Credentials'))
            $this->handleLoginData();
=======
        $this->loginPage = new LoginView();
        $this->validator_message = "";
        if (isset($_POST["Credentials"])) {
            $this->handleLoginData();
        }
    }

    public function __destruct()
    {
    }

    public function displayPage()
    {
        $loginPage = $this->loginPage->createLoginPage();
        echo $loginPage;
    }

    public function displayErrors($errorMessage)
    {
        $errors = $this->loginPage->displayErrors($errorMessage);
        echo $errors;
    }

    private function handleLoginData()
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
        if ($this->validator_message == "") {
            $sanitized_credentials = array();
            $sanitized_credentials['Username'] = filter_var($this->credentials['Username'], FILTER_SANITIZE_STRING);
            $sanitized_credentials['Password'] = filter_var($this->credentials['Password'], FILTER_SANITIZE_STRING);
            $User = new LoginModel($sanitized_credentials);
            $User->loginAttempt();
            if(sessionClass::get('Username')!= false)
            {

                $this->f3->reroute('/invoicing');
=======
            if (sessionClass::get('Username') != false) {
                header('Location: /Costing/invoicing');
                exit();
            } else {
                $this->validator_message .= "Invalid log in credentials";
                $this->displayErrors($this->validator_message);
            }
        } else {
            $this->displayErrors($this->validator_message);
        }
    }
}