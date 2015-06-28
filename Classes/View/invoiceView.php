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
             <div class="panel-heading" >Δελτίο κοστολόγησης</div>
                <div class="panel-body">
                 <form id="orderCreation" class="form-horizontal " role="form" action="/Costing/invoicing" method="post">
                 <input type="hidden" name="invoice" value="postAttempt">
                    <div class="col-md-2">
                     <label class="page-header" style="font-size: large"> Πληροφοριες παραγγελίας</label>
                        <div class="form-group   custom-form" id="Invoicing">
                            <label>Πωλητής</label>
                                <select name="Seller" class="form-control form-horizontal input-sm">
                                <option selected="selected" value="Eksarxos"> Έξαρχος 1</option>
                                <option value="2">Έξαρχος 2</option>
                                <option value="3">Έξαρχος 3</option>
                                <option value="4">Έξαρχος 4</option>
                                <option value="5">Έξαρχος 5</option>
                                <option value="6">Έξαρχος 6</option>
                            </select>
                        </div>
                        <div class="form-group custom-form">
                             <label>Πελατης</label>
                                  <input type="text" name="Customer" class="form-control input-sm ">
                        </div>
                        <div class="form-group custom-form">
                             <label>Προϊόν</label>
                                  <input type="text" name="Product" class="form-control input-sm">
                        </div>
                    </div>

                    <div class="col-md-1">
                    <label class="page-header" style="font-size: large">Προϊόν</label>
                     <div class="form-group custom-form">
                         <label>Αριθμός τεμαχίων</label>
                             <input type="text" name="Pieces1" class="form-control input-sm">
                             <input type="text" name="Pieces2" class="form-control input-sm">
                             <input type="text" name="Pieces3" class="form-control input-sm">
                             <input type="text" name="Pieces4" class="form-control input-sm">
                     </div>
                      <div class="form-group custom-form">
                         <label>Ποσότητα Υλικών</label>
                            <select id="materialAmount"  name="materialAmount" class="form-control form-horizontal input-sm">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option  selected="selected"  value="6">6</option>
                            </select>
                     </div>
                     <div class="form-group custom-form">
                         <label>Σκάρτα</label>
                            <input type="text" name="Shoddy" class="form-control input-sm">
                     </div>
                    </div>
                    <div class="col-md-1" style=" margin-left: 20px; margin-right:20px;">
                        <label class="page-header" style="font-size: large">Κόλληση</label>
                            <div class="form-group custom-form">
                                <label>Λεπτά ανα τεμάχιο</label>
                                <input type="text" name="GluingMinutesPerPiece" class="form-control input-sm">
                             </div>

                    </div>
                    <div class="col-md-1" style=" margin-left: 20px;">
                        <label class="page-header" style="font-size: large">Άλλα</label>
                            <div class="form-group custom-form">
                                <label>Ωρες σχεδιασμού</label>
                                <input type="text" name="DesignHours" class="form-control col-md-1 input-sm">
                            </div>
                            <div class="form-group custom-form">
                                <label>Λειτουργικές ώρες</label>
                                <input type="text" name="RunHours" class="form-control input-sm">
                            </div>
                            <div class="form-group custom-form">
                                <label>Μέτρα κόλλας</label>
                                <input type="text" name="GlueMeters" class="form-control input-sm">
                            </div>
                    </div>

                    <div class="col-md-1" style=" margin-left: 20px; margin-right:20px;">
                        <label class="page-header" style="font-size: large"> <input type="checkbox" id="bagging" class="checkbox-inline"> Σακούλα</label>
                            <div class="form-group custom-form">
                                <label>Μέτρα Σακούλας</label>
                                <input type="text" id="baggingLength" name="baggingLength" class="form-control input-sm">
                            </div>
                    </div>
                    <div class="col-md-1" style=" margin-left: 20px; margin-right:20px;">
                        <label class="page-header" style="font-size: large">
                            <input type="checkbox" id="boxing"  class="checkbox-inline"> Κιβώτιο </label>
                            <div class="form-group custom-form">
                                <label>Τιμή</label>
                                <input type="text" id="boxingPrice" name="boxingPrice" class="form-control input-sm">
                            </div>
                    </div>
                    <div class="col-md-1" style=" margin-left: 20px; margin-right:20px;">
                        <label class="page-header" style="font-size: large"> Μεταφορικά </label>
                            <div class="form-group custom-form">
                                <label>Τεμάχια/παλέτα</label>
                                <input type="text" name="PiecesPerPallet" class="form-control input-sm">
                            </div>
                            <div class="form-group custom-form">
                                <label><input type="checkbox" id="Pallet" class="checkbox-inline"> Κόστος παλέτας </label>
                                <input type="text" name="PalletCost" id="PalletCost" class="form-control input-sm">
                            </div>
                            <div class="form-group custom-form">
                                <label>Κόστος παλέτας </label>
                                    <select name="PalletCostDropdown" id="PalletCostDropdown" class="form-control form-horizontal input-sm">
                                        <option selected="selected" value="15">15€</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                    </select>
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