<?php

/**
 * Created by PhpStorm.
 * User: kostas
 * Date: 26-Aug-14
 * Time: 5:25 PM
 */
class RegisterController
{


    private $credentials = array();
    private $registerPage;
    private $m_f3;

    public function __construct($f3)
    {
        session_start();
        $this->m_f3=$f3;
        $this->registerPage = new RegisterView();
        if ($this->m_f3->exists('POST.Credentials')) {
            $this->handleRegisterData();
        }
        if(isset($_SESSION['ValidationError'])){
            $this->displayErrors($_SESSION['ValidationError']);
        }
        else if(isset($_SESSION['RegistrationMessage'])){
            $this->displaySuccess($_SESSION['RegistrationMessage']);
        }

        unset($_SESSION);
        session_destroy();
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
        if(funcValidator::validateString($this->m_f3,$this->credentials['Username'])
            && funcValidator::validateString($this->m_f3,$this->credentials['Password'])
            && funcValidator::stringComparator($this->m_f3,$this->credentials['Password'],$this->credentials['PasswordCheck'],0)
            && funcValidator::validateEmail($this->m_f3,$this->credentials['Email'])){

            $sanitized_credentials = array();
            $sanitized_credentials['Username'] = filter_var($this->credentials['Username'], FILTER_SANITIZE_STRING);
            $sanitized_credentials['Password'] = filter_var($this->credentials['Password'], FILTER_SANITIZE_STRING);
            $sanitized_credentials['Email'] = filter_var($this->credentials['Email'], FILTER_SANITIZE_EMAIL);

            $newUser = new RegisterModel($sanitized_credentials);
            $unique = $newUser->checkUniqueness();

            if ($unique == null) {
                $newUser->save();
                sessionClass::set('RegistrationMessage',"Successfully registered");
                $this->m_f3->reroute("/register");
            }
            else {
                funcValidator::stringComparator($this->m_f3,$sanitized_credentials['Email'], $unique['Email'],2);
                funcValidator::stringComparator($this->m_f3,$sanitized_credentials['Username'], $unique['Username'],1);

                sessionClass::set('ValidationError',$this->m_f3->get('ValidationError'));
                $this->m_f3->reroute("/register");

            }
        }
        else{
            sessionClass::set('ValidationError',$this->m_f3->get('ValidationError'));
            $this->m_f3->reroute("/register");
        }


    }
}