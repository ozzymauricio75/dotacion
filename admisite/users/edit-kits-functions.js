$(document).ready(function(){
    
    /*
    *MODIFICAR KIT USUARIO
    */
    $("#additembtn").click(function(){
        event.preventDefault();
        
        var pathfile = $("#pathfile").val();
        var pathdir = $("#pathdir").val();
        
        var form = document.getElementById('newitem');
                                               
        var field = $(this);
        var parent = $("#wrapadditem");
        var emtyvalue = $(this).val();
        var datafield = "additem";
        //var iduser = $("#codeitemform");
        
        if($("#wrapadditem").find(".ok").length){
            $("#wrapadditem"+" .ok").remove();
            $("#wrapadditem"+" .loader").remove();
            $("#wrapadditem").append("<div class='loader'><img src='../../appweb/img/loadingcart.gif'/></div>").fadeIn("slow");
        }else{
            $("#wrapadditem").append("<div class='loader'><img src='../../appweb/img/loadingcart.gif'/></div>").fadeIn("slow");
        }
                                            
        var formData = new FormData(form);
        formData.append("fieldedit", "additem");
        //formData.append("codeitemform", iduser);
        
                                
        //para kit de ropa 
        var ropakituser = [];
        var pr = 0;
        var idCategoCatalogo;
        var idkitRopa;
        var tipokitRopa;
        var tipoColeccionRopa;
        var cantkitRopa;
        var subcatekitRopa;
        $(".ropuserkit").each(function(){
            if($(this).is(":checked")){
                
                ropakituser[pr] = {};
                
                ropakituser[pr]["idcatecatalogo"] = $(this).attr("data-idkit");
                ropakituser[pr]["nomekit"] = $(this).attr("data-tkit");
                ropakituser[pr]["idcatego"] = $(this).attr("data-l2");
                ropakituser[pr]["idsubcatego"] = $(this).val();
                ropakituser[pr]["cantpzs"] = $(this).attr("data-numepzs");
                ropakituser[pr]["coleccion"] = $(this).attr("data-tagl1");
                
                pr++;
                
                
                
            }
            
            
            
        });
        
    
        formData.append("ropakituser", JSON.stringify(ropakituser)); 
        
        //para kit adiconal - unitario 
        var unitariokituser = [];
        var pu = 0;
        var idCategoCatalogoAdd;
        var idkitAdd;
        var tipokitAdd;
        var tipoColeccionAdd;
        var cantkitAdd;
        var subcatekitAdd;
        $(".adduserkit").each(function(){
            if($(this).is(":checked")){
                
                unitariokituser[pu] = {};
                
                unitariokituser[pu]["idcatecatalogo_add"] = $(this).attr("data-idkit");
                unitariokituser[pu]["nomekit_add"] = $(this).attr("data-tkit");
                unitariokituser[pu]["idcatego_add"] = $(this).attr("data-l2");
                unitariokituser[pu]["idsubcatego_add"] = $(this).val();
                unitariokituser[pu]["cantpzs_add"] = $(this).attr("data-numepzs");
                unitariokituser[pu]["coleccion_add"] = $(this).attr("data-tagl1");
                
                pu++;

            }
        });
        
        formData.append("unitariokituser", JSON.stringify(unitariokituser)); 

        if (formData) {
          $.ajax({
            url: "../appweb/inc/edit-users-functions.php",
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
                    
                }else{

                    $("#wrapadditem"+" .loader").fadeOut(function(){
                                                 
                        $("#wrapadditem").html("<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><h4><i class='icon fa fa-check'></i> Tu publicación fue guarda correctamente</h4</div>").fadeIn("slow");

                        //$("#left-barbtn").show();
                       // $("#right-bartbtn").remove();                                                                                                                                                                         
                    });
                    
                    location.reload();
                    
                }
              
            }
          });
        }                                
    });
    
    
});