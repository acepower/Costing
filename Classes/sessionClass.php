<?php

/**
 * Created by PhpStorm.
 * User: kostas
 * Date: 03-Sep-14
 * Time: 3:24 AM
 */
class SessionClass
{
    public function __construct()
    {
    }

    public static function set($variable, $value)
    {
        if (session_id() != null) {
            if (!empty($value)) {
                $_SESSION[$variable] = $value;
            }
        }
        if (isset($_SESSION[$variable])) {
            $newValue = $_SESSION[$variable];
            if (strcmp($newValue, $value) == 0) {
                return true;
            }
        }

        return false;
    }

    public static function get($variable)
    {
        if (session_id() != null) {
            if (isset($_SESSION[$variable])) {
                return $_SESSION[$variable];
            }
        }

        return false;
    }
    public static function clear($id)
    {
        if(session_id()!=null){
            if(isset($_SESSION[$id])){
                unset($_SESSION[$id]);
                return true;
            }
        }
        return false;
    }
}
