<?php

/**
 * @param $className
 * bootstrap file for autoload function and router calling
 *
 */


function my_autoloader($class) {

    if (file_exists(realpath(__DIR__). DIRECTORY_SEPARATOR . $class . '.php'))
    include realpath(__DIR__). DIRECTORY_SEPARATOR . $class . '.php';
    else if (file_exists(realpath(__DIR__). '\\Classes\\' . $class . '.php'))
    include realpath(__DIR__). '\\Classes\\' . $class . '.php';
    else if (file_exists(realpath(__DIR__). '\\Classes\\Controller\\' . $class. '.php'))
    include realpath(__DIR__). '\\Classes\\Controller\\' . $class. '.php';
    else if (file_exists(realpath(__DIR__). '\\Classes\\Model\\' . $class. '.php'))
    include realpath(__DIR__). '\\Classes\\Model\\' . $class. '.php';
    else if (file_exists(realpath(__DIR__). '\\Classes\\View\\' . $class. '.php'))
    include realpath(__DIR__). '\\Classes\\View\\' . $class. '.php';

    else
    {
       $error = new errorController('classNotFound');
    }
}

spl_autoload_register('my_autoloader');


$routes = new router();
$routes->add('/home', 'homeController');
$routes->add('/login', 'loginController');
$routes->add('/register', 'registerController');
$routes->add('/index.php', 'homeController');
$routes->add('/invoicing','invoiceController');
$routes->add('/admin','adminController');
$routes->add('/404','errorController');
$routes->submit();






