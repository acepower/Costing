<?php
/**
 * Created by PhpStorm.
 * User: kostas
 * Date: 07-Jul-15
 * Time: 7:23 AM
 */
class orderValidator{


    private static $pass = true;
    private static $notPass = false;

    public static function validateOrderMetaData($f3,$metaData = array())
    {
        foreach($metaData as $key => $value) {
            if(!ctype_alnum($value)){
                $f3->set('ValidationError',$value.' is not correctly formatted. Only alphanumeric characters allowed');
                return self::$notPass;
            }
            if(strlen($value)<=2 || strlen($value)>=18) {
                $f3->set('ValidationError','Alphanumeric input cannot be more than 18 characters and less than 2');
                return self::$notPass;
            }
        }
        return self::$pass;
    }
    public static function validateArrayIntegers($f3,$arrayInt = array())
    {
        foreach($arrayInt as $key => $value)
        {
            if(!is_numeric($value)){
                $f3->set('ValidationError',$value.' should be a numeric value.');
                return self::$notPass;
            }
            $temp = (int)$value;
            if(!is_integer($temp)){
                $f3->set('ValidationError',$temp.' should be an integer');
                return self::$notPass;
            }
        }
        return self::$pass;
    }
    public static function validateArrayNumeric($f3,$arrayNum = array())
    {
        foreach($arrayNum as $key => $value)
        {
            if(!is_numeric($value)){
                $f3->set('ValidationError',$value.' should be a numeric value.');
                return self::$notPass;
            }
        }
        return self::$pass;
    }
    public static function validateMaterial($f3,$material = array())
    {
        $materialMetaData = array();
        $materialIntData = array();

        foreach ($material as $key => $value) {
            $pattern1 = "/\bQuality\d?/";
            $pattern2 = "/\bType\d?/";
            $pattern3 = "/\bPrintType\d?/";
            if (((preg_match($pattern1, $key) || preg_match($pattern2, $key) || preg_match($pattern3, $key)))) {
                $materialMetaData[$key]=$value;
            }
            else{
                $materialIntData[$key]=$value;
            }
        }
        if(!self::validateArrayIntegers($f3,$materialIntData)) return self::$notPass;
        if(!self::validateOrderMetaData($f3,$materialMetaData)) return self::$notPass;

        return self::$pass;
    }

}