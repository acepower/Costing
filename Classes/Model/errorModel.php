<?php

/**
 * Created by PhpStorm.
 * User: kostas
 * Date: 12-Sep-14
 * Time: 11:42 AM
 */
class ErrorModel
{

    private $errorType;
    private $errorMessage;

    public function __construct()
    {
        $this->errorType = '';
        $this->errorMessage = '';
    }


    public function setErrorType($errorType)
    {
        $this->errorType = $errorType;
    }

    public function assignErrorHandling()
    {
        switch ($this->errorType) {
            case 'classNotFound':
                $this->errorMessage = 'The requested file/class could not be found.';
                break;
            case 'databaseError':
                $this->errorMessage = 'There was a problem connecting with the database. Please seek assistance';
                break;
            case 'queryError':
                $this->errorMessage = 'The executed query resulted in an error';
                break;
            default:
                $this->errorMessage = 'Unknown error';
        }

        return $this->errorMessage;
    }
}