<?php
/**
 * Created by PhpStorm.
 * User: kostas
 * Date: 26-Aug-14
 * Time: 5:51 PM
 */

class WebTemplate{

    protected $htmlOutput;
    private $pageHeader;
    private $pageFooter;
    protected $pageContent;
    protected $messages;

    public function __construct()
    {
        $this->htmlOutput = "";
        $this->pageHeader = "";
        $this->pageFooter = "";
        $this->pageContent= "";
        $this->messages="";
    }

    protected function createPage()
    {
        $this->createMetaHeaders();
        $this->createContent();
        if(!is_a($this,'invoiceView') && !is_a($this,'adminView'))
            $this->createFooter();
    }
    protected function createLogOut()
    {
        if(sessionClass::get('Username')!= false)
        {
            $logout = <<< HTML
             <form style="float:left; position: relative; left:1%; margin: 5px;" action="/Costing/login" method="get">
                     <button type="submit" class="btn btn-success">Logout</button>
                </form>
HTML;
            return $logout;
        }


        return false;
    }
    protected function adminMode()
    {
        if(loginModel::checkAdmin() && !is_a($this,'adminView'))
        {
            $admin = <<< HTML
             <form style="float:right; position: relative; right:1%; margin: 5px;" action="/Costing/admin" method="get">
                     <button type="submit" class="btn btn-success">Admin Mode</button>
                </form>
HTML;
            return $admin;
        }
        return false;
    }


    protected final function createMetaHeaders()
    {
        $logout = $this->createLogOut();
        $admin = $this->adminMode();
        $this -> pageHeader = <<< HTML
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml">
	                <head>
                     <link rel="stylesheet" type="text/css" href="/Costing/public/css/bootstrap.min.css">
                      <link rel="stylesheet" type="text/css" href="/Costing/public/css/custom.css">

		                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	                 <title>Κοστολόγηση παραγγελιών ψηφιακής μηχανής</title>
	                </head>
	            <body>
	            <div class="row header"> $logout $admin </div>
	            <script type="text/javascript" src="/Costing/public/js/bootstrap.min.js"></script>
	            <script type="text/javascript" src="/Costing/public/js/jquery-1.11.1.js"></script>
HTML;

        $this->htmlOutput.= $this->pageHeader;
    }

    protected final function createFooter()
    {

        $this->pageFooter =<<< HTML
        <div class="panel-footer footer"><div class="text-left" style="font-size: medium; font-style: oblique; color: #ffffff;"> Developed by Konstantinos Daskalopoulos.<br/> Copyright @ 2014. All rights reserved.</div></div>
                            </body>
                            </html>
HTML;
        $this->htmlOutput .= $this->pageFooter;
    }

    protected function createContent()
    {
        $this->htmlOutput .= $this->pageContent;
    }
}