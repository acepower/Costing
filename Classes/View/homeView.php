<?php

/**
 * Created by PhpStorm.
 * User: kostas
 * Date: 26-Aug-14
 * Time: 5:47 PM
 */
class HomeView extends WebTemplate
{
    public function __construct()
    {
        parent::__construct();
    }

    public function createHomePage()
    {
        if (isset($_GET['errorType'])) {
            $this->displayErrors($_GET['errorType']);
        }
        $this->pageContent = <<< HTML
    <div class="container-fluid">
        <div class="row">
            <div class ="col-md-12">
                <h2 style="text-align:center;">Κοστολογηση παραγγελιών Βιοκυτ</h2>
            </div>
        </div>
        <div class="row" style="text-align: center; margin-top:40px;">
            <div class ="col-md-12">
                  <form action="/Costing/register" method="get">
                     <button type="submit" style="width: 120px" class="btn-lg btn btn-primary">Register</button>
                 </form>
            </div>
            <div class ="col-md-12">
                 <form action="/Costing/login" method="get">
                    <button type="submit" style="width: 120px;" class="btn btn-lg btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>
HTML;
        $this->createPage();

        return $this->htmlOutput;
    }

    public function displayErrors($errorMessages)
    {
        $this->messages .= <<< HTML
        <div id="errors" class="alert-warning" style="font-size: 17px;">$errorMessages</div>

HTML;
        echo $this->messages;
    }
}