<?php

/**
 * Created by PhpStorm.
 * User: kostas
 * Date: 02-Sep-14
 * Time: 7:17 PM
 */
class SqlQueries
{

    public static function insertUser()
    {
        $QUERY_STRING = "INSERT INTO";
        $QUERY_STRING .= " USERS ";
        $QUERY_STRING .= " (Username,Password,Email,Admin) ";
        $QUERY_STRING .= " Values (:Username,:Password,:Email,:Admin)";

        return $QUERY_STRING;
    }

    public static function checkUniqueness()
    {
        $QUERY_STRING = "SELECT * ";
        $QUERY_STRING .= " FROM USERS";
        $QUERY_STRING .= " WHERE Username=:Username ";
        $QUERY_STRING .= " OR Email=:Email";

        return $QUERY_STRING;
    }

    public static function getUser()
    {
        $QUERY_STRING = "SELECT Username,Password ";
        $QUERY_STRING .= "FROM Users ";
        $QUERY_STRING .= "WHERE Username= :Username";

        return $QUERY_STRING;
    }

    public static function checkAdmin()
    {
        $QUERY_STRING = "SELECT Admin ";
        $QUERY_STRING .= "FROM Users ";
        $QUERY_STRING .= "WHERE Username= :Username";

        return $QUERY_STRING;
    }

    public static function getNonAdmin()
    {
        $QUERY_STRING = "SELECT Username ";
        $QUERY_STRING .= "FROM Users ";
        $QUERY_STRING .= "WHERE Admin = 0";

        return $QUERY_STRING;
    }

    public static function searchOrders()
    {
        $QUERY_STRING = "SELECT * ";
        $QUERY_STRING .= " FROM Orders ";
        $QUERY_STRING .= " WHERE :field";
        $QUERY_STRING .= " REGEXP :value";

        return $QUERY_STRING;
    }

    public static function getConstants()
    {
        $QUERY_STRING = "SELECT * ";
        $QUERY_STRING .= " FROM constants ";

        return $QUERY_STRING;
    }

    public static function getSellers()
    {
        $QUERY_STRING = "SELECT Name ";
        $QUERY_STRING .= " FROM sellers ";

        return $QUERY_STRING;
    }

    public static function deleteSeller()
    {
        $QUERY_STRING = "DELETE ";
        $QUERY_STRING .= "FROM sellers ";
        $QUERY_STRING .= "WHERE Name= :Name";

        return $QUERY_STRING;
    }

    public static function insertSeller()
    {
        $QUERY_STRING = "INSERT INTO";
        $QUERY_STRING .= " Sellers ";
        $QUERY_STRING .= " (Name) ";
        $QUERY_STRING .= " Values (:Name)";

        return $QUERY_STRING;
    }

    public static function setConstants($column)
    {
        $QUERY_STRING = "UPDATE CONSTANTS ";
        $QUERY_STRING .= "SET ";
        $QUERY_STRING .= $column." = :value";
        $QUERY_STRING .= " WHERE ID = 1";

        return $QUERY_STRING;
    }

    public static function updatePrintingHours()
    {
        $QUERY_STRING = "UPDATE printing ";
        $QUERY_STRING .= " SET ";
        $QUERY_STRING .= " PrintingPerHour = :value";
        $QUERY_STRING .= " WHERE Type = :field";

        return $QUERY_STRING;
    }

    public static function promoteToAdmin()
    {
        $QUERY_STRING = "UPDATE Users";
        $QUERY_STRING .= " SET ADMIN = 1 ";
        $QUERY_STRING .= " WHERE Username = :Username";

        return $QUERY_STRING;
    }

    public static function getPrintingHours()
    {
        $QUERY_STRING = "SELECT printingPerHour ";
        $QUERY_STRING .= " FROM printing ";
        $QUERY_STRING .= " WHERE Type = :value";

        return $QUERY_STRING;
    }
}