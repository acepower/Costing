<?php

/**
 * Created by PhpStorm.
 * User: kostas
 * Date: 11-Sep-14
 * Time: 1:58 AM
 */
class AdminView extends WebTemplate
{
    private $nonAdminUsers;
    private $searchResults;
    private $constants;
    private $sellers;

    public function __construct($results = null)
    {
        parent::__construct();
        if ($results != null) {
            $this->searchResults = $results;
        }
    }

    public function __destruct()
    {
    }

    public function createAdminPage($users = null, $constants, $sellers)
    {
        $this->constants = json_encode($constants);
        $this->sellers = json_encode($sellers);
        if ($users != null) {
            $this->nonAdminUsers = json_encode($users);
        } else {
            $this->nonAdminUsers = 0;
        }
        if (isset($_GET['errorType'])) {
            $this->displayErrors($_GET['errorType']);
        }
        $this->pageContent = <<< HTML
    <div class="panel panel-default">
        <div class="panel-heading"> <h3 class="panel-heading" style="text-align: center">Administrator mode</h3></div>
           <div class ="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <label>Αναζητηση καταχώρησης με όνομα πωλητή</label>
                        <form  action="/Costing/admin" method="post">
                        <input type="text" name="Seller" id="seller" class="form-control ajax input-sm">
                         </form>
                    </div>
                    <div class="col-md-4">
                        <label>Αναζητηση καταχώρησης με όνομα πελάτη</label>
                        <form  action="/Costing/admin" method="post">
                        <input type="text" name="Customer" id="customer" class="form-control ajax input-sm">

                        </form>
                    </div>
                    <div class="col-md-4">
                        <label>Αναζητηση καταχώρησης με ονομα προϊόντος</label>
                        <form action="/Costing/admin" method="post">
                        <input type="text" name="Product" id="product" class="form-control ajax  input-sm">

                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 " style="margin-top:5px;">
                        <label>Προώθηση χρηστη σε admin</label>
                            <form action="/Costing/admin" method="post">
                                <select name="nonAdmins" id="nonAdmins" class="form-control form-horizontal input-sm"></select>
                                    <button type="submit" style="width: 120px" class="btn-sm btn btn-primary">προώθηση</button>
                            </form>
                    </div>
                    <div class="col-md-4 " style="margin-top:5px;">
                        <label>Προσθήκη πωλητή</label>
                            <form action="/Costing/admin" method="post">
                                    <input type="text" name="addSeller" id="addSeller" class="form-control input-sm">
                                    <button type="submit" style="width: 120px" class="btn-sm btn btn-primary">προσθήκη</button>
                            </form>
                    </div>
                    <div class="col-md-4 " style="margin-top:5px;">
                        <label>Διαγραφή πωλητή</label>
                            <form action="/Costing/admin" method="post">
                                <select name="deleteSellers" id="deleteSellers" class="form-control form-horizontal input-sm"></select>
                                    <button type="submit" style="width: 120px" class="btn-sm btn btn-primary">διαγραφή</button>
                            </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2" style="margin-top:10px;">
                        <label class="panel-heading">Αλλαγή σταθερών μεταβλητών</label>
                            <form action="/Costing/admin" method="post">
                                <label>Κόστος μελανιού/τ.μ.</label>
                                <input type="text" name="inkCost" id="inkCost" class="form-control input-sm">
                                <label>Κόστος κόλλας/μέτρο</label>
                                <input type="text" name="glueCost" id="glueCost" class="form-control input-sm">
                                <label>Κόστος σακούλας/μέτρο</label>
                                <input type="text" name="bagCost" id="bagCost" class="form-control input-sm">
                                <label>Κόστος κοπής/ώρα</label>
                                <input type="text" name="cuttingCost" id="cuttingCost" class="form-control input-sm">
                                <label>Κόστος εκτύπωσης/ώρα</label>
                                <input type="text" name="printingCost" id="printingCost" class="form-control input-sm">
                                <label>Κόστος κόλλησης/ώρα</label>
                                <input type="text" name="gluingCost" id="gluingCost" class="form-control input-sm">
                                 <label>Κοστος σχεδιασμου/ώρα</label>
                                <input type="text" name="designCost" id="designCost" class="form-control input-sm">
                                 <label>Κόστος λειτουργικό/ώρα</label>
                                <input type="text" name="runCost" id="runCost" class="form-control input-sm">
                            <button type="submit" style="width: 120px" class="btn-sm btn btn-primary">αλλαγή</button>
                            </form>
                    </div>
                    <div class="col-md-2" style="margin-top: 10px;">
                        <label class="panel-heading">Αλλαγη μεταβλητών εκτυπωσης</label>
                                <form action="/Costing/admin" method="post">
                                <label>Ταχύτητα εκτύπωσης</label>
                                <select name="pop" class="form-control form-horizontal input-sm">'+
                                     <option selected="selected" value="70">pop70</option>
                                     <option value="40">pop40</option>
                                     <option value="36">pop36</option>
                                </select>
                                <label>Φύλλα/ώρα</label>
                                <input type="text" name="printingHours" id="printingHours" class="form-control input-sm">
                                  <button type="submit" style="width: 120px" class="btn-sm btn btn-primary">αλλαγή</button>
                            </form>
                            <table class="table table-striped">
                                <thead class="page-header">
                                    <tr>
                                        <th>μεταβλητή</th>
                                        <th>τιμή</th>
                                    </tr>
                                </thead>
                                <tbody id="constantDisplay">

                                </tbody>
                            </table>
                    </div>
                    <div class="col-md-8">
                        <h3 style="text-align: center;">Αποτελέσματα αναζήτησης</h3>
                            <div class="panel-body" id="searchResults">

                            </div>
                    </div>
                </div>
           </div>
           <div class = "panel-footer"> <form action="/Costing/invoicing" method="get"><button type="submit" class="btn btn-danger">back</button></form></div>
        </div>
        <script>
        $(function(){


        var users = $this->nonAdminUsers;

            if(users)
            {

                jQuery.each(users,function(i,value)
                    {
                        $("#nonAdmins").append('<option value="'+value+'">'+value+'</option>')
                    });
            }
            var constants = $this->constants
            jQuery.each(constants,function(i,value)
            {
                if(i!='ID')
                $("#constantDisplay").append('<tr><td>'+i.split(/(?=[A-Z])/)+'</td><td>'+value+'</td> </tr>')
            });
            var sellers = $this->sellers;
            jQuery.each(sellers,function(i,value)
                    {
                        $("#deleteSellers").append('<option value="'+value+'">'+value+'</option>')
                    });
        });
        $(".ajax").blur(function(){



            $.ajax({

                     type: "POST",
                     url : "http://localhost/Costing/ajax/ajaxHandler.php",
                     data : {
                     searchInput: $(this).val(),
                     searchID: $(this).attr('id')
                     },
                     dataType : "json",
                     context : $("#searchResults"),

                    success: function(responseData)
                         {
                            $('#ajaxResults').remove();
                            if(responseData.ajaxResult==false)
                             $(this).append('<div id="ajaxResults" class="panel-body"><div class="row">'+responseData.searchInput+responseData.message+'</div></div>');
                            else if(responseData.ajaxResult==true)
                            {
                                $(this).append('<div id="ajaxResults" class="panel-body">');
                                jQuery.each(responseData,function(key,value)
                                {
                                $(this).append('<div class=row>'+key+value+'</div>');
                                });
                                $(this).append('</div>')
                            }

                         },
                    error: function (xhr,textStatus,err)
                         {
                            console.log("readyState: " + xhr.readyState);
                            console.log("responseText: "+ xhr.responseText);
                            console.log("status: " + xhr.status);
                            console.log("text status: " + textStatus);
                            console.log("error: " + err);
                         }
});
        });

        </script>

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