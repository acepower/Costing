<?php
/**
 * Created by PhpStorm.
 * User: kostas
 * Date: 02-Jul-15
 * Time: 1:19 AM
 */


class funcValidator
{

    private static $pass = True;
    private static $not_pass = False;

    public static function validateString($f3,$username){
        if(!ctype_alnum($username)) {
            $f3->set('ValidationError','Input field can only contain alphanumeric characters.');
            return self::$not_pass;
        }
        else if (strlen($username)>20 || strlen($username)<5) {
            $f3->set('ValidationError','Input field cannot contain more than 20 characters and less than 5.');
            return self::$not_pass;
        }

        return self::$pass;

    }
    public static function validateEmail($f3,$email){
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $f3->set('ValidationError','Email invalid format');
        }

        return self::$pass;
    }

    public static function stringComparator($f3,$string1, $string2,$category){
        if (strcmp($string1, $string2) !== 0) {
            switch($category) {
                case 0: $f3->set('ValidationError', "Input fields do not match! Please make sure your passwords are the same");break;
                case 1: return self::$pass; break; //username is unique
                case 2: return self::$pass; break; //email is unique
                default: $f3->set('ValidationError', "Input fields do not match! Please make sure your input fields are the same");
            }
            return self::$not_pass;
        }
        else{
            switch($category) {
                case 0: return self::$pass; break;//passwords are the same
                case 1: $f3->set('ValidationError', "Username already in use"); break;
                case 2: $f3->set('ValidationError', "Email already in use"); break;
                default: $f3->set('ValidationError', "Input field is already in use"); break;
            }
            return self::$not_pass;
        }

    }
}