<?php

/**
 * Created by PhpStorm.
 * User: kostas
 * Date: 03-Sep-14
 * Time: 3:05 AM
 */
if (!isset($_SESSION)) {
    session_start();
}

class LoginModel
{

    private $userCredentials;
    private $queryUsername;

    public function __construct($credentials = array())
    {
        $this->userCredentials = array();
        $this->queryUsername = array();
        $this->queryUsername['Username'] = $credentials['Username'];
        $this->userCredentials['Username'] = $credentials['Username'];
        $this->userCredentials['Password'] = $credentials['Password'];
    }

    public function __destruct()
    {
    }

    public function loginAttempt()
    {
        $databaseConnection = new Databasehandler();
        $databaseConnection->connect();
        $databaseConnection->safeQuery(SqlQueries::getUser(), $this->queryUsername);
        $user = $databaseConnection->safeFetchArray();
        if (!empty($user)) {
            $inputPass = crypt($this->userCredentials['Password'], $user['Password']);
            if (strcmp($inputPass, $user['Password']) == 0) {
                sessionClass::set('Username', $user['Username']);
            }
        }
    }

    public static function checkAdmin()
    {
        if (sessionClass::get('Username') != false) {
            $Credentials['Username'] = sessionClass::get('Username');
            $databaseConnection = new Databasehandler();
            $databaseConnection->connect();
            $databaseConnection->safeQuery(SqlQueries::checkAdmin(), $Credentials);
            $state = $databaseConnection->safeFetchArray();
        } else {
            $state['Admin'] = 0;
        }

        return $state['Admin'];
    }
}