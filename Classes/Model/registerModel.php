<?php
/**
 * Created by PhpStorm.
 * User: kostas
 * Date: 01-Sep-14
 * Time: 5:35 PM
 */


class registerModel
{
    private $userCredentials;

    public function __construct($credentials=array())
    {
        $this->userCredentials = array();
        $this->userCredentials['Username']= $credentials['Username'];
        $this->userCredentials['Password']=$credentials['Password'];
        $this->userCredentials['Email']=$credentials['Email'];
        $this->userCredentials['Admin']=false;

    }

    public function save()
    {

        $password = $this->hashPassword();
        $this->userCredentials['Password'] = $password;
        $this->storeData();
    }

    private function hashPassword()
    {
        $hash_format = "$2y$10$";
        $salt = $this->createSalt();
        $saltFormat = $hash_format . $salt;
        $hash = crypt($this->userCredentials['Password'],$saltFormat);
        return $hash;

    }

    private function createSalt() {
        $uniqueRandomString = md5(uniqid(mt_rand(), true));
        $base64string = base64_encode($uniqueRandomString);
        $modifiedBase64string = str_replace('*','.',$base64string);
        $salt = substr($modifiedBase64string,0,22);
        return $salt;
    }

    private function storeData()
    {
        $databaseConnection = new databasehandler();
        $databaseConnection->connect();
        $databaseConnection->safeQuery(sqlQueries::insertUser(),$this->userCredentials);


    }

    public function checkUniqueness()
    {
        $uniqueVariables= array();
        $uniqueVariables["Username"] = $this->userCredentials["Username"];
        $uniqueVariables["Email"]= $this->userCredentials["Email"];

        $databaseConnection = new databasehandler();
        $databaseConnection->connect();
        $databaseConnection->safeQuery(sqlQueries::checkUniqueness(),$uniqueVariables);
        $result = $databaseConnection->safeFetchArray();
        return $result;

    }
}