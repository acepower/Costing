<?php

/**
 * Created by PhpStorm.
 * User: kostas
 * Date: 26-Aug-14
 * Time: 5:43 PM
 */
class HomeController
{
    public function __construct($f3){
        session_start();
        //security vulnerability
        if(sessionClass::get('Username')!= false) {
            $f3->reroute('/invoicing');
        }
        else {
            unset($_SESSION);
            session_destroy();
        }
    }
    /**
     * creates and displays the home page
     */
    public function displayPage()
    {
        $homePage = new HomeView();
        $homePage = $homePage->createHomePage();
        echo $homePage;
    }
}