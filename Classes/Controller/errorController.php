<?php
/**
 * Created by PhpStorm.
 * User: kostas
 * Date: 27-Aug-14
 * Time: 2:11 PM
 */

class errorController{

    public function __construct($errorMessageType = null){

        if(!$errorMessageType==null)
            $this->categorizeErrors($errorMessageType);
    }
    public function __destruct(){}

    public function displayPage()
    {
        $notFoundPage = new notFoundView();
        $notFoundPage = $notFoundPage->create404Page();

        echo $notFoundPage;
    }

    public function categorizeErrors($messageType)
    {

        $errorModel = new errorModel();
        $errorModel->setErrorType($messageType);

        $result = $errorModel->assignErrorHandling();
        if($messageType!="queryError")
            header("Location: /Costing/home?errorType=$result");
        else
            header("Location: /Costing/invoicing?errorType=$result");

    }
}