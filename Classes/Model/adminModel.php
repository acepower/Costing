<?php
/**
 * Created by PhpStorm.
 * User: kostas
 * Date: 11-Sep-14
 * Time: 1:58 AM
 */

class adminModel
{


    public function __construct(){}
    public function __destruct(){}



    public function databaseInteract($pdoQuery, $param = null)
    {

        $databaseConnection = new databasehandler();
        $databaseConnection->connect();
        $databaseConnection->safeQuery($pdoQuery,$param);
        if(!$databaseConnection->countFields()>0)
            $result= 'The query was executed correctly. No results came back';
        else if($databaseConnection->countRows()>1)
            $result = $databaseConnection->safeFetchAll();
        else if($databaseConnection->countRows()==1)
            $result = $databaseConnection->safeFetchArray();
        else
            $result= 'The query was executed correctly. No results came back';
        return $result;
    }
}