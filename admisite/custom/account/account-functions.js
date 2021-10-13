$(document).ready(function(){ 
    
    var editpseudouser = "";
    $("#editaliasuser").click(function(){
        editpseudouser = "ok";
    });
    
    //ADD PROD ORDER
    $("#edititembtn").click(function(){
        
        var pathfile = $("#pathfile").val();
        var pathdir = $("#pathdir").val();
        
        var field = $(this);
        var parent = $("#wrapadditem");// field.parent().attr("id");
        var emtyvalue = $(this).val();
        var datafield = "additem";//$(this).attr("data-field");                
        //field.css("background-color","#F3F3F3");


        //if(emtyvalue != ""){

        if($("#wrapadditem").find(".ok").length){
            $("#wrapadditem"+" .ok").remove();
            $("#wrapadditem"+" .loader").remove();
            $("#wrapadditem").append("<div class='loader'><img src='../../../appweb/img/loadingcart.gif'/></div>").fadeIn("slow");
        }else{
            $("#wrapadditem").append("<div class='loader'><img src='../../../appweb/img/loadingcart.gif'/></div>").fadeIn("slow");
        }

        var nameuser = $("input[name='nameuser']").val();
        var lastnameuser = $("input[name='lastnameuser']").val();
        var companyuser = $("input[name='companyuser']").val();     
        var pseudouser = $("input[name='pseudouser']").val();
        var passuser = $("input[name='passuser']").val();        
        var replypassuser = $("input[name='replypassuser']").val();        
        var datapass = $("input[name='replypassuser']").attr("data-pass");
        var datapost = $("#codeitemform").val();//$("input[name='codeitemform']").val();      
        
        
                
        var dataString = "nameuser_data="+nameuser+"&lastnameuser_data="+lastnameuser+"&companyuser_data="+companyuser+"&pseudouser_data="+pseudouser+"&passuser_data="+passuser+"&replypassuser_data="+replypassuser+"&datapass_data="+datapass+"&datapost_data="+datapost+"&fieldedit=edititem"+"&editalias="+editpseudouser; 
        //alert(dataString);

        $.ajax({ 
            type: "POST", 
            url: "../../appweb/inc/manager-functions.php", 
            data: dataString,
            success: function(data){                     
                var response = JSON.parse(data);
                //console.log(response);
                if (response["error"]) { 
                    
                    $("#wrapadditem"+" .loader").fadeOut(function(){                         
                        var errresponse = response["error"];
                        $("#err"+datafield).html("<div class='alert alert-danger alert-dismissible pre-scrollable-md'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+errresponse+"</div>").fadeIn("slow"); 
                    }); 

                } else { 
                                        
                    $("#wrapadditem"+" .loader").fadeOut(function(){
                                                 
                        $("#wrapadditem").html("<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><h4><i class='icon fa fa-check'></i> Tus cambios fueron guardados exitosamente.<br><br> Podrás ver estas modificaciones la proxima vez que inicies session</h4</div>").fadeIn("slow");
                                                                                                                                                                                                                  
                    });                                                                                                                                                                                                                              
                } 
            } 
        });

    });
    
});