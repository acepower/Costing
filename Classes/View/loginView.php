<?php
/**
 * Created by PhpStorm.
 * User: kostas
 * Date: 03-Sep-14
 * Time: 2:18 AM
 */

class loginView extends WebTemplate
{
    public function __construct()
    {
        parent::__construct();
    }

    public function createLoginPage()
    {
        if(isset($_GET['errorType']))
        {
            $this->displayErrors($_GET['errorType']);
        }

        $this->pageContent = <<< HTML


    <div class="container-fluid">
        <div class="row" style="background:#f5f5f5; margin-top:40px;">

                  <form class="col-md-4" style="text-align:center; float:none; margin: 0 auto;" role="form" action="/Costing/login" method="post">
                     <input type="hidden" name="Credentials"><br>
                     <div class="form-group" style="">
                            <label>Username</label>
                                 <input  type="text" name="Username" class="form-control" placeholder="Username">
                    </div>
                     <div class="form-group">
                             <label>Password</label>
                                  <input type="password" name="Password" class="form-control" placeholder="Password">
                    </div>
                      <button type="submit" class="btn btn-default">Submit</button>
                 </form>
                 <form class="cold-md-4" action="/Costing/home" method="get">
                     <button type="submit" class="btn btn-danger">Back</button>
                </form>
                <form class="cold-md-4" action="/Costing/register" method="get">
                     <button type="submit" class="btn btn-success">Register</button>
                </form>

        </div>



    </div>
HTML;

        $this->createPage();

        return $this->htmlOutput;
    }
    public function displayErrors($errorMessages)
    {

        $this->messages.= <<< HTML
        <div id="errors" class="alert-warning" style="font-size: 17px;">$errorMessages</div>

HTML;
        return $this->messages;
    }
}