$(document).ready(function(){ 
    //ADD PROD ORDER
    $("#additembtn").click(function(){
        
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
            $("#wrapadditem").append("<div class='loader'><img src='../../appweb/img/loadingcart.gif'/></div>").fadeIn("slow");
        }else{
            $("#wrapadditem").append("<div class='loader'><img src='../../appweb/img/loadingcart.gif'/></div>").fadeIn("slow");
        }

        var nameprod = $("input[name='nomeprod']").val();
        var skuprod = $("input[name='codventa']").val();
        var precioprod = $("input[name='precioprod']").val();
        var categoprod = $("select[name='categoitem']").val();
        //var l2prod = $(".categooption").attr("data-l2");
        var tagl1prod = $(".categooption").attr("data-tagl1");                
        var descriprod = $("textarea[name='descriprod']").val();
        var statusprod = $("input[name='statusprod']").val();
        var codeitemform = $("input[name='codeitemform']").val(); 
        
        //categoria LEVEL 2
        var l2prod;
        $(".categooption").each(function(){
            if($(this).is(":selected")){
                l2prod = $(this).attr("data-l2");
            }
        });
        
        //https://www.youtube.com/watch?v=lHLHxi60eo8
        var tallasprod = [];
        var codegrupotallas = "";
        $(".tallaslist").each(function(){
            if($(this).is(":checked")){
                tallasprod.push($(this).val());
                codegrupotallas = $(this).attr("data-gt");
            }
        });
        tallasprod = tallasprod.toString();
        
        var colorsprod = [];
        $(".tipocolor").each(function(){
            if($(this).is(":checked")){
                colorsprod.push($(this).val());
            }
        });
        colorsprod = colorsprod.toString();
        
        var materialprod = [];
        $(".tipomaterial").each(function(){
            if($(this).is(":checked")){
                materialprod.push($(this).val());
            }
        });
        materialprod = materialprod.toString();
                                               
        //FILE UPLOAD CON FILEINPUT
        //http://plugins.krajee.com/file-input/demo
        //http://webtips.krajee.com/ajax-based-file-uploads-using-fileinput-plugin/
        
        //FILE UPLOAD
        //https://www.youtube.com/watch?v=AZJfXr2LZXg
        //https://gist.github.com/optikalefx/4504947
        //https://www.youtube.com/watch?v=c4L4K7mRliM
        

        var dataString = "codeitem_data="+codeitemform+"&nameprod_data="+nameprod+"&skuprod_data="+skuprod+"&precioprod_data="+precioprod+"&categoprod_data="+categoprod+"&codegrupotallas_data="+codegrupotallas+"&tallas_data="+tallasprod+"&colors_data="+colorsprod+"&material_data="+materialprod+"&status_data="+statusprod+"&l2prod_data="+l2prod+"&tagl1prod_data="+tagl1prod+"&descriprod_data="+descriprod+"&fieldedit=additem"; 
        //alert(dataString);

        $.ajax({ 
            type: "POST", 
            url: "../appweb/inc/valida-new-prod.php", 
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
                                                 
                        $("#wrapadditem").html("<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><h4><i class='icon fa fa-check'></i> Tu publicación fue guarda correctamente</h4</div>").fadeIn("slow");
                        
                        $("#left-barbtn").append("<a href='"+pathfile+pathdir+"/tienda/new.php' class='btn btn-info margin-hori-xs'><i class='fa fa-plus fa-lg margin-right-xs'></i><span>Nuevo producto</span></a><a href='"+pathfile+pathdir+"/tienda/newrefitem.php?coditemget="+response+"' class='btn btn-success margin-hori-xs'><i class='fa fa-th-list fa-lg margin-right-xs'></i><span>Crear referencias</span></a><a href='"+pathfile+pathdir+"/tienda/new.php?coditemget="+response+"&trash=ok' class='btn btn-default trashtobtn' name='' title='Eliminar item' data-msj='Perderás toda la información para este producto. Deseas continuar?' data-remsj=''><i class='fa fa-trash fa-lg margin-right-xs'></i><span>Eliminar</span></a>").show();
                        
                        $("#right-bartbtn").remove();                                                                                                                                                                         
                    });                                                                                                                                                                                                                              
                } 
            } 
        });

    });
    
});