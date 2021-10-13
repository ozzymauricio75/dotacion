$(document).ready(function(){ 
                       
    //ADD ITEM
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
                /*idCategoCatalogo = $(this).attr("data-idkit");
                idkitRopa = $(this).attr("data-l2");
                tipokitRopa = $(this).attr("data-tkit");
                tipoColeccionRopa = $(this).attr("data-tagl1");
                cantkitRopa = $(this).attr("data-numepzs");
                subcatekitRopa = $(this).val(); */
                
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
        /*formData.append("idCategoCatalogo_ropa", idCategoCatalogo);
        formData.append("idkit_ropa", idkitRopa);
        formData.append("kitcheck_ropa", tipokitRopa); 
        formData.append("tipocoleccicheck_ropa", tipoColeccionRopa); 
        formData.append("cantpzakitcheck_ropa", cantkitRopa); 
        formData.append("subcatekit_ropa", subcatekitRopa); */
        
        
        
        /*//para kit zapatos       
        var tipokitZapato;
        var tipoColeccionZapato;
        var cantkitZapato;
        var subcatekitZapato;
        $(".zapuserkit").each(function(){
            if($(this).is(":checked")){
                tipokitZapato = $(this).attr("data-tkit");
                tipoColeccionZapato = $(this).attr("data-tagl1");
                cantkitZapato = $(this).attr("data-numepzs");
                subcatekitZapato = $(this).val(); 
            }
        });

        formData.append("kitcheck_zapt", tipokitZapato); 
        formData.append("tipocoleccicheck_zapt", tipoColeccionZapato); 
        formData.append("cantpzakitcheck_zapt", cantkitZapato); 
        formData.append("subcatkitcheck_zapt", subcatekitZapato);*/ 
        
        
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
                
                        
                /*idCategoCatalogoAdd = $(this).attr("data-idkit");
                idkitAdd = $(this).attr("data-l2");
                tipokitAdd = $(this).attr("data-tkit");
                tipoColeccionAdd = $(this).attr("data-tagl1");
                cantkitAdd = $(this).attr("data-numepzs");
                subcatekitAdd = $(this).val();
                
                unitariokituser = idCategoCatalogoAdd;
                unitariokituser += tipokitAdd;
                unitariokituser += idkitAdd;
                unitariokituser += subcatekitAdd;
                unitariokituser += cantkitAdd;
                unitariokituser += tipoColeccionAdd;*/
                
            }
        });
        
        formData.append("unitariokituser", JSON.stringify(unitariokituser)); 
        /*formData.append("idCategoCatalogo_add", idCategoCatalogoAdd);
        formData.append("idkit_add", idkitAdd);
        formData.append("kitcheck_add", tipokitAdd); 
        formData.append("tipocoleccicheck_add", tipoColeccionAdd); 
        formData.append("cantpzakitcheck_add", cantkitAdd); 
        formData.append("subcatkitcheck_add", subcatekitAdd);*/
        //formData.append("unitariokituser", unitariokituser);
                                                              
        //console.log(ropakituser);    
        
        /*for (var pair of formData.entries()) {
            console.log(pair[0]+ ', ' + pair[1]); 
        }*/
        
        
        
        if (formData) {
          $.ajax({
            url: "../appweb/inc/valida-new-user.php",
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
                   /* $("#wrapadditem"+" .loader").fadeOut(function(){
                                                 
                        $("#wrapadditem").html("<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><h4><i class='icon fa fa-check'></i> Tu publicación fue guarda correctamente</h4</div>").fadeIn("slow");
                        //location.reload();  
                                                                                                                                                                                              
                    }); */ 

                    $("#wrapadditem"+" .loader").fadeOut(function(){
                                                 
                        $("#wrapadditem").html("<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><h4><i class='icon fa fa-check'></i> Tu publicación fue guarda correctamente</h4</div>").fadeIn("slow");
                        
                        //$("#left-barbtn").append("<a href='"+pathfile+pathdir+"/users/new.php' class='btn btn-info margin-hori-xs'><i class='fa fa-plus fa-lg margin-right-xs'></i><span>Nuevo usuario</span></a><a href='"+pathfile+pathdir+"/users/' class='btn btn-success margin-hori-xs'><i class='fa fa-th-list fa-lg margin-right-xs'></i><span>Lista de usuarios</span></a><a href='"+pathfile+pathdir+"/users/new.php?coditemget="+response+"&trash=ok' class='btn btn-default trashtobtn' name='' title='Eliminar item' data-msj='Perder&aacute;s toda la informaci&oacute;n para este usuario. Deseas continuar?' data-remsj=''><i class='fa fa-trash fa-lg margin-right-xs'></i><span>Eliminar</span></a>").show();
                        $("#left-barbtn").show();
                        $("#right-bartbtn").remove();                                                                                                                                                                         
                    });
                    
                }
              
            }
          });
        }                                
    });
                
});