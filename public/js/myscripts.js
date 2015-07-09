
$(function(){
    document.getElementById("bagging").checked = true;
    document.getElementById("boxing").checked = true;
    $('#bagging').on("click",function()
        {
             if (!$( this ).prop( "checked" ))
                {
                    $("#baggingLength").prop('disabled',true);
                    $("#baggingPrice").prop('disabled',true);
                }
            else
                {
                    $("#baggingLength").prop('disabled',false);
                    $("#baggingPrice").prop('disabled',false);
                }
        });
    $('#boxing').on("click",function()
        {
            if (!$( this ).prop( "checked" ))
                {
                    $("#boxingLength").prop('disabled',true);
                    $("#boxingPrice").prop('disabled',true);
                }
            else
                {
                    $("#boxingLength").prop('disabled',false);
                    $("#boxingPrice").prop('disabled',false);
                }

        });

    $("#PalletCost").prop('disabled',true);

    $('#Pallet').on("click",function()
    {
            if ($( this ).prop( "checked" ))
                {
                    $("#PalletCostDropdown").prop('disabled',true);
                    $("#PalletCost").prop('disabled',false);
                }
            else
                {
                    $("#PalletCostDropdown").prop('disabled',false);
                    $("#PalletCost").prop('disabled',true);
                }
    });
    $("#materialAmount").change(function ()
    {
        $(".removable").remove();
        var selectedValue = $("#materialAmount").val();
        for(i=0; i<selectedValue; i++)
        {
            var index = i+1;
            $("#jsAppendHere").append(
                '<div  class ="col-md-2 removable"> ' +
                '<label id=Material'+index+'>Υλικό '+ index + '</label> ' +
                '<div class=" form-group custom-form removable"> <label>Τεμάχια ανα φύλλο </label> <input type="text" name="Quantity'+index+'" class="form-control input-sm"></div>'+
                '<div class ="form-group custom-form removable ">  <label>Μήκος</label> <select name="Length'+index+'" id="Length'+index+'"class="form-control form-horizontal input-sm">'+
                '<option selected="selected" value="1">1600</option>'+
                '<option value="2">2</option>'+
                '<option value="3">3</option>'+
                '<option value="4">4</option>'+
                '<option value="5">5</option>'+
                '<option value="6">6</option>'+
                '</select> </div>'+
                '<div class ="form-group custom-form removable"> <label>Πλατος</label> <select name="Width'+index+'"class="form-control form-horizontal input-sm">'+
                '<option selected="selected" value="1">3200</option>'+
                '<option value="2">2</option>'+
                '<option value="3">3</option>'+
                '<option value="4">4</option>'+
                '<option value="5">5</option>'+
                '<option value="6">6</option>' +
                '</select> </div>'+
                '<div class ="form-group custom-form removable"> <label>Ποιοτητα</label> <select name="Quality'+index+'"class="form-control form-horizontal input-sm">'+
                '<option selected="selected" value="1">EB</option>'+
                '<option value="2">2</option>'+
                '<option value="3">3</option>'+
                '<option value="4">4</option>'+
                '<option value="5">5</option>'+
                '<option value="6">6</option>' +
                '</select> </div>'+
                '<div class ="form-group custom-form removable"> <label>Τυπος</label> <select name="Type'+index+'"class="form-control form-horizontal input-sm">'+
                '<option selected="selected" value="CSW">CSW</option>'+
                '<option value="2">2</option>'+
                '<option value="3">3</option>'+
                '<option value="4">4</option>'+
                '<option value="5">5</option>'+
                '<option value="6">6</option>' +
                '</select> </div>'+
                '<div class ="form-group custom-form removable"> <label>Βάρος</label> <select name="Weight'+index+'"class="form-control form-horizontal input-sm">'+
                '<option selected="selected" value="85">85g</option>'+
                '<option value="2">2</option>'+
                '<option value="3">3</option>'+
                '<option value="4">4</option>'+
                '<option value="5">5</option>'+
                '<option value="6">6</option>' +
                '</select> </div>'+
                '<label>Κοπή</label> '+
                '<div class=" form-group custom-form removable"> <label>Δευτερόλεπτα/φύλλο </label> <input type="text" name="MinutesPerPiece'+index+'" class="form-control input-sm"></div>'+
                '<div class ="custom-form removable"> <label>Χωρίς εκτύπωση</label> <input type="checkbox" value='+index+' class="checkbox-inline"> </div>'+
                '<div class ="form-group custom-form removable"> <label>Τυπος εκτύπωσης</label> <select  name ="PrintType'+index+'" id="PrintType'+index+'"class="form-control form-horizontal input-sm">'+
                '<option selected="selected" value="pop40">Pop 40</option>'+
                '<option value="2">2</option>'+
                '<option value="3">3</option>'+
                '<option value="4">4</option>'+
                '<option value="5">5</option>'+
                '<option value="6">6</option>'+
                '</select></div>'+

                '</div>');
        //<div class="form-group custom-form">
        //<label>Gluing minutes per piece</label>
        //<input type="text" name="GluingMinutesPerPiece" class="form-control input-sm">
        //</div>
        }

        $('.checkbox-inline').on("click",function(){
            var elementToDisable = $(this).val();
            if ($( this ).prop( "checked" ))
            {
                $("#PrintType"+elementToDisable).prop('disabled',true);

            }
            else
            {
                $("#PrintType"+elementToDisable).prop('disabled',false);
            }
        });

    });
        $("#orderCreation").submit(function(){
            $("input").each(function () {
                if (!$(this).val() && !$(this).is(':disabled'))
                    {
                        $(this).removeClass( "success").addClass("warning");
                        event.preventDefault();
                    }
            });
        });
        $("#reset").on("click",function(){
            location.reload(true);

        });
    $("#set").on("click",function(){
        $("input").each(function () {$(this).val(1);});

    });
    $("input").blur(function() {

        if(!$(this).val())
        {
            $(this).removeClass( "success").addClass("warning");
        }
        else
        {
            $(this).removeClass( "warning").addClass("success");
        }
    });
});






