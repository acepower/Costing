<?php
/**
 * Created by PhpStorm.
 * User: kostas
 * Date: 11-Sep-14
 * Time: 1:58 AM
 */


class adminController
{
    private $postData;
    public function __construct()
    {
        $this->postData=array();
        session_start();
        if(sessionClass::get('Username')== false || loginModel::checkAdmin()== false)
        {
            header('Location: /CostingRev/login');
            exit();
        }


        if(($_POST)) {
            $this->handlePostData();
        }

    }
    public function __destruct(){ }

    public function displayPage()
    {
        $admin = new adminModel();
        $nonAdminUsers = $admin->databaseInteract(sqlQueries::getNonAdmin());
        if(is_string($nonAdminUsers))
        {
            $nonAdminUsers= null;
        }
        $constants = $admin->databaseInteract(sqlQueries::getConstants());
        $sellers = $admin->databaseInteract(sqlQueries::getSellers());

        $adminView = new adminView();
        $adminView = $adminView->createAdminPage($nonAdminUsers,$constants,$sellers);

        echo $adminView;

    }

    private function handlePostData()
    {

        foreach($_POST as $key => $value)
        {
            if(!empty($value)) {

                $sanitized_value = filter_var($value,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $sanitized_value = filter_var($sanitized_value,FILTER_SANITIZE_STRING);
                $sanitized_value = filter_var($sanitized_value,FILTER_SANITIZE_MAGIC_QUOTES);
                $this->postData[$key] = $sanitized_value;
                }
        }
        if(!empty($this->postData))
        {
            $message= "";
            $errors = "";
            $admin = new adminModel();
            $adminView = new adminView();
            foreach ($this->postData as $key => $value)
            {
                if($key == 'nonAdmins')
                {
                    $adminQuery = sqlQueries::promoteToAdmin();
                    $tempArray['Username']=$value;
                    $result = $admin->databaseInteract($adminQuery,$tempArray);
                    $adminView->displayErrors($result);

                }
                else if ($key =='pop' || $key=='printingHours')
                {
                        if($key=='pop') {
                            if(is_numeric($this->postData['printingHours']))
                            {
                                $tempArray['field'] = $key.$this->postData[$key];
                                $tempArray['value'] = $this->postData['printingHours'];
                                $adminQuery = sqlQueries::updatePrintingHours();
                                $message = $admin->databaseInteract($adminQuery,$tempArray);
                            }
                            else
                                $errors = "Error, sheets per hour were not numeric and were not updated";
                        }
                }
                else if($key == 'deleteSellers') {

                    $adminQuery = sqlQueries::deleteSeller();
                    $tempArray['Name']=$value;
                    $result=$admin->databaseInteract($adminQuery,$tempArray);
                    $adminView->displayErrors($result);
                }
                else if($key == "addSeller")
                {
                    if(ctype_alpha($value)) {
                        $adminQuery = sqlQueries::insertSeller();
                        $tempArray['Name'] = $value;
                        $result = $admin->databaseInteract($adminQuery, $tempArray);
                        $adminView->displayErrors($result);
                    }
                    else
                        $errors = "Error, Seller is not alphabetic characters";
                }
                else
                {
                    if(is_numeric($value)) {
                        $tempArray['value'] = $value;
                        $adminQuery = sqlQueries::setConstants($key);
                        $message = $admin->databaseInteract($adminQuery, $tempArray);
                        
                    }
                    else
                    {
                       $errors = "Error, some inputs were not numeric and were not updated";
                    }

                }
            }
            if(!empty($errors))
                $adminView->displayErrors($errors);
            if(!empty($message))
                $adminView->displayErrors($message);

        }


    }
}