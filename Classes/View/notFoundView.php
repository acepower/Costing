<?php

/**
 * Created by PhpStorm.
 * User: kostas
 * Date: 27-Aug-14
 * Time: 2:11 PM
 */
class NotFoundView extends WebTemplate
{


    public function __construct()
    {
        parent::__construct();
    }

    public function create404Page()
    {
        session_start();
        unset($_SESSION);
        session_destroy();
        $this->pageContent = <<< HTML
    <div class="page-header"><p class="text-danger" style="text-align: center;font-size: large">Ooops! the requested page cannot be found! We apologize for the inconvenience. </p>
    <form action="/Costing/" method="get"><button type="submit" class="btn btn-danger">home</button></form>
    </div>
HTML;
        $this->createPage();

        return $this->htmlOutput;
    }
}