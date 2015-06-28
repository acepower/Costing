<?php
$f3 = require ("fatfree/lib/base.php");
include_once "Classes/config.php";


$f3->set('DEBUG',1);
$f3->config('config.ini');
config::define();

function myAutoloader($className){
    $fileName = $className.".php";
    $fileDirectories = array("classes","classes/model","classes/view","classes/controller");
    foreach ($fileDirectories as $directory){
        $fileNamePath = DOC_ROOT.DIR_SEP.$directory.DIR_SEP.$fileName;
        if(file_exists($fileNamePath)) require_once $fileNamePath;
    }
}
spl_autoload_register('myAutoloader');

$f3->config('classes/Routes.ini');

$f3->run();