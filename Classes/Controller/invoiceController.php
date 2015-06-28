<?php
/**
 * Created by PhpStorm.
 * User: kostas
 * Date: 03-Sep-14
 * Time: 4:14 PM
 */

class invoiceController{

    private $invoicePage;
    private $postData;
    public function __construct()
    {

        session_start();
        session_regenerate_id();
        $this->postData= array();
        if(sessionClass::get('Username')==false) {
            header('Location: /CostingRev/login');
            exit();
        }
        if(isset($_POST["invoice"])) {
            if($this->validatePostData()) {
                $this->organizePostData();
            }
        }
    }

    public function displayPage(){
        $this->invoicePage = new invoiceView();
        $this->invoicePage = $this->invoicePage->displayInvoicePage();
        echo $this->invoicePage;
    }

    private function validatePostData(){
        $flag = true;
        $piecesQuantity = array("Pieces1" => 1, "Pieces2" => 2, "Pieces3"=>3,"Pieces4"=>4,"Shoddy"=>5);

        if(!array_key_exists("Quantity1",$_POST))
        {
            $flag=false;
            $error=" You need to at least select 1 material";
            $this->displayError($error);
        }
        foreach ($_POST as $key => $value)
        {
            if(array_key_exists($key,$piecesQuantity))
            {
                $value+=0;
                if(!is_integer($value))
                {
                    $error="Quantity of pieces must be integer";
                    $this->displayError($error);
                }
            }
            if(is_numeric($value) && $value==0 && !array_key_exists($key,$piecesQuantity))
            {
                $flag=false;
                $error=" Input values except quantity of pieces cannot be 0";
                $this->displayError($error);
            }
            else if($key=="Customer" || $key=="Product" || $key=="Seller")
            {

                if(!ctype_alpha($value))
                {
                    $flag=false;
                    $error="Only Customer and Product input can take alphabetical characters";
                    $this->displayError($error);
                }
            }
            else if (ctype_alpha($key))
            {
                if(!is_numeric($value))
                {
                    $flag=false;
                    $error="All input besides Customer and Product must be numeric";
                    $this->displayError($error);
                }
            }
            else
            {
                $pattern1 = "/\bQuality\d?/";
                $pattern2 = "/\bType\d?/";
                $pattern3 = "/\bPrintType\d?/";
                if(!array_key_exists($key,$piecesQuantity) && (!(preg_match($pattern1,$key) || preg_match($pattern2,$key) || preg_match($pattern3,$key)))) {
                    if(!is_numeric($value)) {
                    $flag=false;
                    $error="All material input must be numeric";
                    $this->displayError($error);
                    }
                }
            }

        }


        return $flag;
    }

    private function organizePostData()
    {
        $this->postData= $_POST;
        $invoice = new invoiceModel();
        $invoice->processData($this->postData);

        $metaData = $invoice->getOrderMetaData();
        $constants = $invoice->getConstants();
        $generals = $invoice->getOrderGenerals();
        $materials = $invoice->getOrderMaterials();
        $repeat = $invoice->getOrderRepeat();


        $this->doCalculations($repeat,$generals, $constants,$materials);

    }

    private function doCalculations($repeat,$generals,$constants,$materials)
    {
        foreach($repeat as $key => $value)
        {
            $invoicing = new invoiceModel();
            $cost = $invoicing->processCost($value, $generals, $constants, $materials);
           // var_dump($cost);

        }
    }
    private function displayError($errorMessage)
    {

        header("Location: /Costing/invoicing?errorType=$errorMessage");
        exit();
    }
}