<?php
/**
 * Created by PhpStorm.
 * User: kostas
 * Date: 25-Aug-14
 * Time: 5:07 PM
 */
$host = $_SERVER["HTTP_HOST"];
$path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
define ('COSTING/', $path);
define ('LOCALHOST/', $host);

class router
{


    private $routes = array();
    private $method = array();

    public function __construct(){}

    public function __destruct(){}


/**
 * Adds available routes to an array with their methods (strings, anonymous functions, etc.)
 */
    public function add($uri, $method = null)
    {

        $this->routes[] =trim($uri,'/');
        if ($method!= null)
            $this->method[]= $method;
        else
            throw new exception();

    }

    /**
     * Matches routes to controller actions.
     */
    public function submit()
    {

            $count = 0;
            if (isset($_GET['uri'])) {
                $uri = $_GET['uri'];
            }
            else $uri = '/home';

            foreach ($this->routes as $key => $value) {

                if (preg_match("#^$value$#", $uri)) {

                    if (is_string($this->method[$key])) {
                        $userMethod = $this->method[$key];
                        $display = new $userMethod();
                        $display->displayPage();
                    } else call_user_func($this->method[$key]);
                } else $count++;

            }

            if ($count == sizeof($this->routes)) {
                header('Location: /Costing/404');
                exit();
            }

    }
}