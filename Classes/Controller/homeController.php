<?php
/**
 * Created by PhpStorm.
 * User: kostas
 * Date: 26-Aug-14
 * Time: 5:43 PM
 */

class homeController
{
    public function __construct(){
        session_start();

        if(sessionClass::get('Username')!= false)
        {

            header ('Location: /Costing/invoicing');
            exit();
        }
        else
        {
            unset($_SESSION);
            session_destroy();
        }
    }
    public function __destruct(){}

    /**
     * creates and displays the home page
     */
    public function displayPage()
    {
        $homePage = new homeView();
        $homePage= $homePage->createHomePage();

        echo $homePage;
    }

}