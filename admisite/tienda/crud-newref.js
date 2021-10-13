$(document).ready(function(){ 
        
    
   
        
    //ADD PROD ORDER
    $("#additembtn").click(function(){
    
    var form = document.getElementById('file-form');
    //var fileSelect = document.getElementById('file-select');
    //var uploadButton = document.getElementById('upload-button');
    var fileSelect = document.getElementById('imgmutifile');
    
        //form.onsubmit = function(event) {
        event.preventDefault();
        
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
                            
        var fileMulti = fileSelect.files;
        
        var formData = new FormData(form);
        
        // Loop through each of the selected files.
        for (var i = 0; i < fileMulti.length; i++) {
            var file = fileMulti[i];

            // Check the file type.
            if (!file.type.match('image.*')) {
                continue;
            }

            // Add the file to the request.
            formData.append('multifileimg[]', file);//, file.name
            
            
        }
        //alert(file);
        var tipotalla = $(".tallaslist").attr("data-tipotalla"); 
        
        formData.append("tipotalla_data", tipotalla); 
        formData.append("fieldedit", "additem"); 
        
        /*// Set up the request.
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../appweb/inc/valida-new-prodref.php', true);
        // Set up a handler for when the request finishes.
        xhr.onload = function () {
          if (xhr.status === 200) {
                                        
              $("#wrapadditem"+" .loader").fadeOut(function(){
                                                 
                $("#wrapadditem").html("<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><h4><i class='icon fa fa-check'></i> Tu publicación fue guarda correctamente</h4</div>").fadeIn("slow");

                $("#left-barbtn").append("<a href='"+pathfile+pathdir+"/tienda/new.php' class='btn btn-info margin-hori-xs'><i class='fa fa-plus fa-lg margin-right-xs'></i><span>Nuevo producto</span></a><a href='"+pathfile+pathdir+"/tienda/newrefitem.php?coditemget="+response+"' class='btn btn-success margin-hori-xs'><i class='fa fa-th-list fa-lg margin-right-xs'></i><span>Crear referencias</span></a><a href='"+pathfile+pathdir+"/tienda/new.php?coditemget="+response+"&trash=ok' class='btn btn-default trashtobtn' name='' title='Eliminar item' data-msj='Perderás toda la información para este producto. Deseas continuar?' data-remsj=''><i class='fa fa-trash fa-lg margin-right-xs'></i><span>Eliminar</span></a>").show();

                //$("#right-bartbtn").remove();  
                location.reload();                                
            }); 
            
              
          } else {
            
            $("#wrapadditem"+" .loader").fadeOut(function(){                         
                var errresponse = response["error"];
                $("#err"+datafield).html("<div class='alert alert-danger alert-dismissible pre-scrollable-md'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+errresponse+"</div>").fadeIn("slow"); 
            }); 
          }
        };
        
        // Send the Data.
        xhr.send(formData);*/
        
        
        
        if (formData) {
          $.ajax({
            url: "../appweb/inc/valida-new-prodref.php",
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
                                                 
                        $("#wrapadditem").html("<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><h4><i class='icon fa fa-check'></i> Tu publicación fue guarda correctamente</h4</div>").fadeIn("slow");
                        location.reload();  
                        //$("#left-barbtn").append("<a href='"+pathfile+pathdir+"/tienda/new.php' class='btn btn-info margin-hori-xs'><i class='fa fa-plus fa-lg margin-right-xs'></i><span>Nuevo producto</span></a><a href='"+pathfile+pathdir+"/tienda/newrefitem.php?coditemget="+response+"' class='btn btn-success margin-hori-xs'><i class='fa fa-th-list fa-lg margin-right-xs'></i><span>Crear referencias</span></a><a href='"+pathfile+pathdir+"/tienda/new.php?coditemget="+response+"&trash=ok' class='btn btn-default trashtobtn' name='' title='Eliminar item' data-msj='Perderás toda la información para este producto. Deseas continuar?' data-remsj=''><i class='fa fa-trash fa-lg margin-right-xs'></i><span>Eliminar</span></a>").show();
                        
                       // $("#right-bartbtn").remove();                                                                                                                                                                         
                    });  
                    
                }
              
            }
          });
        }
                        
        /*var dataString = "codeitem_data="+codeitemform+"&nameprod_data="+nameprod+"&skuprod_data="+skuprod+"&precioprod_data="+precioprod+"&categoprod_data="+categoprod+"&codegrupotallas_data="+codegrupotallas+"&tallas_data="+tallasprod+"&colors_data="+colorsprod+"&material_data="+materialprod+"&status_data="+statusprod+"&l2prod_data="+l2prod+"&tagl1prod_data="+tagl1prod+"&descriprod_data="+descriprod+"&fieldedit=additem"; 
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
        });*/

    });
    
    
    var $inputMultiImg = $("#imgmutifile");
    $inputMultiImg.fileinput({
        theme: "fa",
        language: 'es',        
        maxFileCount: 5,
        fileTypeSettings: 'image',        
        maxFileSize: 1700,
        maxImageWidth: 1600,
        maxImageHeight: 1600,  
        showUpload: false,
        showRemove: false,       
        showBrowse: false,
        browseOnZoneClick: true,
        //layoutTemplates: {main2: '{preview}  {remove} {browse}'},
        allowedFileExtensions: ["jpg", "png", "png"],                                 
        uploadAsync: false,
        uploadUrl: "../appweb/inc/upload-imgref.php", 
        
    });/*.on("filebatchselected", function(event, files) {        
        $inputMultiImg.fileinput("upload");
    });*/
    
});