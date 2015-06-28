<?php
/**
 * Created by PhpStorm.
 * User: kostas
 * Date: 28-Jun-15
 * Time: 3:23 AM
 */
class config
{
    public static function define(){
        define('DIR_SEP', DIRECTORY_SEPARATOR);
        define('DOC_ROOT', realpath($_SERVER["DOCUMENT_ROOT"] . DIR_SEP . 'Costing'));
        define('DOC_ROOT_URL', rtrim($_SERVER["PHP_SELF"], 'index.php'));
    }
}