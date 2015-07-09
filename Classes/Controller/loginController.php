<?php
/**
 * Created by PhpStorm.
 * User: kostas
 * Date: 26-Aug-14
 * Time: 5:25 PM
 */

class loginController{



    private $credentials = array();
    private $loginPage;
    private $m_f3;

    public function __construct($f3)
    {
        session_start();
        $this->loginPage= new loginView();
        $this->m_f3 = $f3;

        if ($this->m_f3->exists('POST.Credentials')) {
            $this->handleLoginData();
        }
        if(isset($_SESSION['ValidationError'])){
            $this->displayErrors($_SESSION['ValidationError']);
        }
        unset($_SESSION);
        session_destroy();
    }
    public function __destruct(){}

    public function displayPage()
    {
        $loginPage = $this->loginPage->createLoginPage();
        echo $loginPage;
    }
    public function displayErrors($errorMessage)
    {
        session_unset();
        $errors= $this->loginPage->displayErrors($errorMessage);

        echo $errors;
    }

    private function handleLoginData()
    {

        foreach($_POST as $key=> $data) {
            if ($key != "Credentials") {
                $this->credentials[$key] = $data;
            }
        }
        if(funcValidator::validateString($this->m_f3,$this->credentials['Username']) && funcValidator::validateString($this->m_f3,$this->credentials['Password'])){
            $sanitized_credentials= array();
            $sanitized_credentials['Username']=filter_var($this->credentials['Username'],FILTER_SANITIZE_STRING);
            $sanitized_credentials['Password']=filter_var($this->credentials['Password'],FILTER_SANITIZE_STRING);

            $User = new loginModel($sanitized_credentials);
            $User->loginAttempt();
            if(sessionClass::get('Username')!= false) {
                $this->m_f3->reroute('/invoicing');
            }
            else{
                sessionClass::set('ValidationError',"Incorrect Username or Password");
                $this->m_f3->reroute('/login');
            }
        }
        else{
            sessionClass::set('ValidationError',$this->m_f3->get('ValidationError'));
            $this->m_f3->reroute('/login');
        }

    }
}