<?php
/**
 * Created by PhpStorm.
 * User: kostas
 * Date: 28-Aug-14
 * Time: 4:27 PM
 */

class RegisterView extends WebTemplate
{


    public function __construct()
    {
        parent::__construct();
    }

    public function createRegisterPage()
    {
        if(isset($_GET['errorType']))
        {
            $this->displayErrors($_GET['errorType']);
        }

        $this->pageContent = <<< HTML


    <div class="container-fluid">
        <div class="row" style="background:#f5f5f5; margin-top:40px;">

                  <form class="col-md-4" style="text-align:center; float:none; margin: 0 auto;" role="form" action="/Costing/register" method="post">
                     <input type="hidden" name="Credentials"><br>
                     <div class="form-group" style="">
                            <label>Username</label>
                                 <input  type="text" name="Username" class="form-control" placeholder="Username">
                    </div>
                     <div class="form-group">
                             <label>Password</label>
                                  <input type="password" name="Password" class="form-control" placeholder="Password">
                    </div>
                    <div class="form-group">
                             <label>Repeat Password</label>
                                  <input type="password" name="PasswordCheck" class="form-control">
                    </div>
                    <div class="form-group">
                             <label>E-mail</label>
                                  <input type="email" name="Email" class="form-control" placeholder="example@something.com">
                    </div>
                      <button type="submit" class="btn btn-default">Submit</button>
                 </form>
                 <form class="cold-md-4" action="/Costing/" method="get">
                     <button type="submit" class="btn btn-danger">Back</button>
                </form>
                <form class="cold-md-4" action="/Costing/login" method="get">
                     <button type="submit" class="btn btn-success">Login</button>
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
    public function displaySuccess($successMessage)
    {
        $this->messages.= <<< HTML
        <div id="errors" class="alert-success" style="font-size: 17px;">$successMessage</div>

HTML;

        return $this->messages;
    }

}