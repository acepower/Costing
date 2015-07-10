<?php

/**
 * Created by PhpStorm.
 * User: kostas
 * Date: 03-Sep-14
 * Time: 4:15 PM
 */
class InvoiceView extends WebTemplate
{
    public function __construct()
    {
        parent::__construct();
    }

    public function displayInvoicePage()
    {
        if (isset($_GET['errorType'])) {
            $this->displayErrors($_GET['errorType']);
        }
        $this->pageContent = <<< HTML

        <div class="panel panel-default">
             <div class="panel-heading" ><h3>Order Information</h3></div>
                <div class="panel-body">
                 <form id="orderCreation" class="form-horizontal " role="form" action="/Costing/invoicing" method="post">
                 <input type="hidden" name="invoice" value="postAttempt">
                    <div class="col-md-2">
                    <label style="font-size: x-large">Order context</label>
                        <div class="form-group   custom-form" id="Invoicing">
                            <label>Salesperson</label>
                                 <input type="text" name="Seller" class="form-control input-sm ">
                            </select>
                        </div>
                        <div class="form-group custom-form">
                             <label>Customer name</label>
                                  <input type="text" name="Customer" class="form-control input-sm ">
                        </div>
                        <div class="form-group custom-form">
                             <label>Product</label>
                                <input type="text" name="Product" class="form-control input-sm">
                        </div>
                    </div>

                    <div class="col-md-4 box" style="margin-bottom:3.5px;">
                        <label style="font-size: x-large">Order details</label>
                            <div class="form-group custom-form" style="margin-left: 2px;">
                                <label style="margin-left: 15px;">Amount of product pieces to calculate the cost for</label>
                                    <div class="col-md-6" style="margin:inherit">
                                        <input type="text" name="Pieces1" class="form-control input-sm">
                                        <input type="text" name="Pieces2" class="form-control input-sm" style="margin-top:4px;">
                                     </div>
                                    <div class="col-md-6" style="margin:inherit; margin-left: 2px;">
                                        <input type="text" name="Pieces3" class="form-control input-sm">
                                        <input type="text" name="Pieces4" class="form-control input-sm" style="margin-top:4px;">
                                    </div>
                            </div>
                         <div class="col-md-6" style="margin: inherit; padding: inherit">
                            <div class="form-group custom-form" style="margin: inherit;">
                                <label>Order material amount</label>
                                    <select id="materialAmount"  name="materialAmount" class="form-control form-horizontal input-sm">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option  selected="selected"  value="6">6</option>
                                    </select>
                            </div>
                         </div>
                        <div class="col-md-6" style="margin: inherit;">
                            <div class="form-group custom-form" style="margin: inherit;">
                                <label>Shoddy</label>
                                    <input type="text" name="Shoddy" class="form-control input-sm">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6"">
                        <div class="col-md-4" style="margin: inherit;">
                            <div class="form-group custom-form">
                                <label>Glue meters</label>
                                    <input type="text" name="GlueMeters" class="form-control input-sm">
                            </div>
                            <div class="form-group custom-form">
                                <label> <input type="checkbox" id="bagging" class="checkbox-inline">Bagging meters</label>
                                    <input type="text" id="baggingLength" name="baggingLength" class="form-control input-sm">
                            </div>
                            <div class="form-group custom-form">
                                <label><input type="checkbox" id="boxing"  class="checkbox-inline"> Boxing price </label>
                                     <input type="text" id="boxingPrice" name="boxingPrice" class="form-control input-sm">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-6">
                                <div class="form-group custom-form">
                                    <label>Designing hours</label>
                                    <input type="text" name="DesignHours" class="form-control col-md-1 input-sm">
                                </div>
                                <div class="form-group custom-form">
                                    <label>Run cost hours</label>
                                    <input type="text" name="RunHours" class="form-control input-sm">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group custom-form">
                                    <label>Pieces per pallet</label>
                                    <input type="text" name="PiecesPerPallet" class="form-control input-sm">
                                </div>
                                <div class="form-group custom-form">
                                    <label>Pallet cost</label>
                                    <input type="text" name="PalletCost" class="form-control input-sm">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12 form-horizontal">
                    <label class="page-header" style="font-size: large; margin:5px;"> Υλικά </label>
                        <div id="jsAppendHere" class="row"></div>
                     </div>
                 </div>

                     <div class="panel-footer"><button  type="submit" class="btn btn-info">Υποβολή Φόρμας</button>
                                               <button id="reset" type="button" class="btn btn-warning">Reset</button>
                                                <button id="set" type="button" class="btn btn-warning">set</button>
                     </div>



                <script src="/Costing/public/js/myscripts.js"></script>
</form>
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

    public function displaySuccess($successMessage)
    {
        $this->messages .= <<< HTML
        <div id="errors" class="alert-success" style="font-size: 17px;">$successMessage</div>

HTML;
        echo $this->messages;
    }
}