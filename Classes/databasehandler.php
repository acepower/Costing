<?php

/**
 * Created by PhpStorm.
 * User: kostas
 * Date: 27-Aug-14
 * Time: 7:19 PM
 */
class DatabaseHandler
{

    private $host;
    private $username;
    private $password;
    private $dbname;
    private $pdo_connection;
    private $dbConnectionMessage;
    private $PDOstmt;
    private $errorMessages;

    public function __construct()
    {
        $this->dbname = 'test';
        $this->host = '127.0.0.1';
        $this->username = 'maligras1';
        $this->password = 'kostas546';
        $this->PDOstmt = null;
        $this->errorMessages = "";
        $this->test_connection();
    }

    public function __destruct()
    {
        $this->pdo_connection = null;
    }

    private function test_connection()
    {
        try {
            $this->pdo_connection = new PDO(
                'mysql:host='.$this->host.';dbname='.$this->dbname,
                $this->username,
                $this->password
            );
            $this->dbConnectionMessage = "Connection successful";
            $this->pdo_connection = null;
        } catch (PDOException $e) {
            $this->dbConnectionMessage = 'databaseError';
            $this->displayErrors($this->dbConnectionMessage);
            exit();
        }
    }

    public function connect()
    {
        $this->pdo_connection = new PDO(
            'mysql:host='.$this->host.';dbname='.$this->dbname,
            $this->username,
            $this->password
        );
    }

    public function safeQuery($query, $params = null)
    {
        try {
            $this->pdo_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->PDOstmt = $this->pdo_connection->prepare($query);
            if (sizeof($params) > 0) {
                foreach ($params as $key => $value) {
                    $toBind[$key] = $value;
                    $this->PDOstmt->bindParam($key, $toBind[$key], PDO::PARAM_STR);
                }
            }
            $queryMessage = $this->PDOstmt->execute();
        } catch (PDOException $e) {
            $this->errorMessages = "queryError";
            $this->displayErrors($this->errorMessages);
            exit();
        }

        return $queryMessage;
    }

    public function countRows()
    {
        $rows = 0;
        if ($this->PDOstmt != null) {
            $rows = $this->PDOstmt->rowCount();
        }

        return $rows;
    }

    public function countFields()
    {
        $columns = 0;
        if ($this->PDOstmt != null) {
            $columns = $this->PDOstmt->columnCount();
        }

        return $columns;
    }

    /**
     * Return next row as an array indexed by numbers
     */
    public function safeFetchNumberedArray()
    {
        $records = null;
        $escapedRecords = '';
        if ($this->PDOstmt != null) {
            try {
                $records = $this->PDOstmt->fetch(PDO::FETCH_NUM);
                $escapedRecords = $this->escapeOutput($records);
            } catch (PDOException $e) {
                $this->errorMessages = "queryError";
                $this->displayErrors($this->errorMessages);
                exit();
            }
        }

        return $escapedRecords;
    }

    /**
     * Return next row as an array indexed by column name
     */
    public function safeFetchArray()
    {
        $records = null;
        $escapedRecords = '';
        if ($this->PDOstmt != null) {
            try {
                $records = $this->PDOstmt->fetch(PDO::FETCH_ASSOC);
                $escapedRecords = $this->escapeOutput($records);
            } catch (PDOException $e) {
                $this->errorMessages = "queryError";
                $this->displayErrors($this->errorMessages);
                exit();
            }
        }

        return $escapedRecords;
    }

    /**
     * Return next row as an array indexed by both numbers and column name
     */
    public function lazySafeFetch()
    {
        $records = null;
        $escapedRecords = '';
        if ($this->PDOstmt != null) {
            try {
                $records = $this->PDOstmt->fetch(PDO::FETCH_LAZY);
                $escapedRecords = $this->escapeOutput($records);
            } catch (PDOException $e) {
                $this->errorMessages = "queryError";
                $this->displayErrors($this->errorMessages);
                exit();
            }
        }

        return $escapedRecords;
    }

    /**
     * Returns all results or a specific column from all the results
     * @param null $column
     * @return array|string
     */
    public function safeFetchAll($column = null)
    {
        $records = null;
        $escapedRecords = '';
        if ($this->PDOstmt != null) {
            try {
                if ($column = null) {
                    $records = $this->PDOstmt->fetchAll(PDO::FETCH_COLUMN | PDO::FETCH_GROUP);
                    $escapedRecords = $this->escapeOutput($records);
                } else {
                    $records = $this->PDOstmt->fetchAll(PDO::FETCH_COLUMN, $column);
                    $escapedRecords = $this->escapeOutput($records);
                }
            } catch (PDOException $e) {
                $this->errorMessages = "queryError";
                $this->displayErrors($this->errorMessages);
                exit();
            }
        }

        return $escapedRecords;
    }

    /**
     * Returns the last inserted ID
     * @return mixed
     */
    public function lastInsertedID()
    {
        $sqlQuery = 'SELECT LAST_INSERT_ID()';
        $this->safeQuery($sqlQuery);
        $queryResult = $this->safeFetchArray();
        $lastInsertedID = $queryResult['LAST_INSERT_ID()'];

        return $lastInsertedID;
    }

    /**
     * @param $inputToEscape
     * @return array
     */
    public function displayErrors($errorMessageType)
    {
        $errorController = new ErrorController($errorMessageType);
    }

    private function escapeOutput($inputToEscape)
    {
        $escapedOutput = array();
        $encoding = 'UTF-8';
        $doubleEncoding = false;
        if (phpversion() >= 5.4) {
            $entityFlags = ENT_QUOTES | ENT_SUBSTITUTE;
        } else {
            $entityFlags = ENT_QUOTES;
        }
        if ($inputToEscape !== false) {
            foreach ($inputToEscape as $word => $value) {
                $escapedOutput[$word]
                    = htmlentities($value, $entityFlags, $encoding, $doubleEncoding);
            }
        }

        return $escapedOutput;
    }
}