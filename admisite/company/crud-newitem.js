$(document).ready(function(){ 
                       
    //ADD ITEM
    $("#additembtn").click(function(){
        event.preventDefault();
        
        var form = document.getElementById('newitem');
                                               
        var field = $(this);
        var parent = $("#wrapadditem");
        var emtyvalue = $(this).val();
        var datafield = "additem";
        
        if($("#wrapadditem").find(".ok").length){
            $("#wrapadditem"+" .ok").remove();
            $("#wrapadditem"+" .loader").remove();
            $("#wrapadditem").append("<div class='loader'><img src='../../appweb/img/loadingcart.gif'/></div>").fadeIn("slow");
        }else{
            $("#wrapadditem").append("<div class='loader'><img src='../../appweb/img/loadingcart.gif'/></div>").fadeIn("slow");
        }
                                            
        var formData = new FormData(form);
        formData.append("fieldedit", "additem"); 
                        
        if (formData) {
          $.ajax({
            url: "../appweb/inc/valida-new-store.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                var response = JSON.parse(data);
                if (response["error"]) { 
                    $("#wrapadditem"+" .loader").fadeOut(function(){                         
                        var errresponse = response["error"];
                        $("#err"+datafield).html("<div class='alert alert-danger alert-dismissible pre-scrollable-md'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+errresponse+"</div>").fadeIn("slow"); 
                    }); 
                     //console.log(response);
                }else{
                    //console.log(response);
                    $("#wrapadditem"+" .loader").fadeOut(function(){
                                                 
                        $("#wrapadditem").html("<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><h4><i class='icon fa fa-check'></i> Tu publicaci&oacute;n fue guardada correctamente</h4</div>").fadeIn("slow");
                        location.reload();  
                                                                                                                                                                                              
                    });  
                    
                }
              
            }
          });
        }                                
    });
                
});