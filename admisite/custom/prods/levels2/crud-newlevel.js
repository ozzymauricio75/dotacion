$(document).ready(function(){ 
                       
    //ADD PROD ORDER
    $("#additembtn").click(function(){
    
        var form = document.getElementById('levels-form');
        //var fileSelect = document.getElementById('file-select');
        //var uploadButton = document.getElementById('upload-button');
        //var fileSelect = document.getElementById('imgmutifile');

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
            $("#wrapadditem").append("<div class='loader'><img src='../../../appweb/img/loadingcart.gif'/></div>").fadeIn("slow");
        }else{
            $("#wrapadditem").append("<div class='loader'><img src='../../../appweb/img/loadingcart.gif'/></div>").fadeIn("slow");
        }
                            
        //var fileMulti = fileSelect.files;
        
        var formData = new FormData(form);
        
        /*// Loop through each of the selected files.
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
        
        formData.append("tipotalla_data", tipotalla);*/ 
        formData.append("fieldedit", "additem"); 
                                
        if (formData) {
          $.ajax({
            url: "../../../appweb/inc/valida-new-levels.php",
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
                                                                                                                                                                                    
                    });  
                    
                }
              
            }
          });
        }
                                
    });
    
    
    var labelNewLevel3 = $(".fileimg");
   // $(".fileimg").fileinput({
    labelNewLevel3.fileinput({
        theme: "fa",
        language: 'es',
        fileTypeSettings: 'image',        
        maxFileSize: 1700,
        maxImageWidth: 1600,
        maxImageHeight: 1600,            
        maxFilesNum: 1,        
        //overwriteInitial: true,           
        showClose: false,
        showCaption: false,        
        showUpload: false,
        showRemove: false,       
        showBrowse: false,                        
        browseOnZoneClick: true,
        removeLabel: '',
        removeTitle: 'Cancel or reset changes',
        elErrorContainer: '#kv-avatar-errors-2',
        msgErrorClass: 'alert alert-block alert-danger',
        defaultPreviewContent: '<img src="../../../../img/camera-icon.png" style="width:90px; margin-bottom:4px;">',
        allowedFileExtensions: ["jpg", "jpeg", "png"],                                 
        uploadAsync: false,
        uploadUrl: "../../../appweb/inc/upload-imgfile-level.php" 
        
    });/*on("filebatchselected", function(event, files) {        
        labelNewLevel3.fileinput("upload");
    });*/
    
    
    
    //EDITAR IMAGEN SUBCATEGORIA
    //ADD PROD ORDER
    $(".editlabell3btn").each(function(){
        $(this).click(function(){
            event.preventDefault();
            
            var codeLevel3 = $(this).attr("data-post");    
            var nameportadaitem = $(this).attr("data-namefile"); 
            var form = document.getElementById('editlabell3form_'+codeLevel3);            
            var fileSelect = document.getElementById('labell3'+codeLevel3);
            
            var field = $(this);
            var parent = $("#wrapadditem");
            var emtyvalue = $(this).val();
            var datafield = "wraplabell3"+codeLevel3;
                        
            var fileMulti = fileSelect.files;
            var formData = new FormData(form);
                    
            formData.append('labell3', fileMulti);
            formData.append("nameportadaitem", nameportadaitem); 
            formData.append("codeitem", codeLevel3); 
            formData.append("datafield", "editlabelsubcate"); 
            
            if($("#wraplabell3"+codeLevel3).find(".ok").length){
                $("#wraplabell3"+codeLevel3+" .ok").remove();
                $("#wraplabell3"+codeLevel3+" .loader").remove();
                $("#wraplabell3"+codeLevel3).append("<div class='loader'><img src='../../../appweb/img/loadingcart.gif'/></div>").fadeIn("slow");
            }else{
                $("#wraplabell3"+codeLevel3).append("<div class='loader'><img src='../../../appweb/img/loadingcart.gif'/></div>").fadeIn("slow");
            }
            
            if(!fileMulti){
                $("#wraplabell3"+codeLevel3+" .loader").fadeOut(function(){                     
                    $("#err"+datafield).html("<div class='alert alert-danger alert-dismissible pre-scrollable-md'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Selecciona una imágen para esta categoría</div>").fadeIn("slow"); 
                });             
            }else{

                if(formData){
                  $.ajax({
                    url: "../../../appweb/inc/edit-levels-functions.php",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        var response = JSON.parse(data);
                        if (response["error"]) { 
                            $("#wraplabell3"+codeLevel3+" .loader").fadeOut(function(){                         
                                var errresponse = response["error"];
                                $("#err"+datafield).html("<div class='alert alert-danger alert-dismissible pre-scrollable-md'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+errresponse+"</div>").fadeIn("slow"); 
                            }); 
                             //console.log(response);
                        }else{
                            //console.log(response);
                            $("#wraplabell3"+codeLevel3+" .loader").fadeOut(function(){

                                $("#successwraplabell3"+codeLevel3).html("<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><h4><i class='icon fa fa-check'></i> Imágen fue guardada correctamente</h4</div>").fadeIn("slow");
                                location.reload();  

                            });  
                        }
                    }
                  });
                }
            }
        });
     });

    var inputLabelImg = $(".editlabel");                
    inputLabelImg.fileinput({
        theme: "fa",
        language: 'es',
        fileTypeSettings: 'image',        
        maxFileSize: 1700,
        maxImageWidth: 1600,
        maxImageHeight: 1600,            
        maxFilesNum: 1,                        
        showClose: false,
        showCaption: false,        
        showUpload: false,
        showRemove: false,       
        showBrowse: false,
        browseOnZoneClick: true,
        removeLabel: '',        
        removeTitle: 'Cancel or reset changes',
        elErrorContainer: '#kv-avatar-errors-2',
        //msgErrorClass: 'alert alert-block alert-danger',
        defaultPreviewContent: '<img src="../../../../img/camera-icon.png" style="width:90px; margin-bottom:4px;">',
        allowedFileExtensions: ["jpg", "png", "png"],                                 
        uploadAsync: false,
        uploadUrl: "../../../appweb/inc/upload-imgfile-level.php",        
    }); 
    
    
    //EDITAR INFO DE CATEGORIAS
    $('input.domedit, textarea.domedit, select.domedit').focus(function() {
        $(this).css('background-color','#ffffff');
    });

    $('input.domedit, textarea.domedit, select.domedit').blur(function(){
        var field = $(this);
        var parent = field.parent().attr('id');
        var emtyvalue = $(this).val();
        var datafield = $(this).attr('data-field');
        var codePost =$(this).attr('data-post'); 
        field.css('background-color','#F3F3F3');
        

        if($('#'+parent).find(".okrow").length){
            $('#'+parent+' .okrow').remove();
            $('#'+parent+' .loaderrow').remove();
            $('#'+parent).append('<div class="loaderrow"><img src="../../../appweb/img/loader.gif"/></div>').fadeIn('slow');
        }else{
            $('#'+parent).append('<div class="loaderrow"><img src="../../../appweb/img/loader.gif"/></div>').fadeIn('slow');
        }

        var dataString = 'value='+$(this).val()+'&field='+$(this).attr('name')+'&post='+$(this).attr('data-post')+'&fieldedit='+$(this).attr('data-field');
        //console.log(dataString);

        $.ajax({
            type: "POST",
            url: "../../../appweb/inc/edit-levels-functions.php",
            data: dataString,
            success: function(data) {
                //field.val(data);
                var response = JSON.parse(data);
                //console.log(response);
                if (response['error']) {

                    $('#err'+datafield+codePost).html(response['error']).fadeIn('slow');

                }else{

                    $('#'+parent+' .loaderrow').fadeOut(function(){
                        $('#'+parent).append('<div class="okrow"><img src="../../../appweb/img/ok.png"/></div>').fadeIn('slow');                        
                        $("#wrapp"+datafield+codePost).html(response);
                        //$(".closeeditfieldbtn").fadeIn('slow'); 
                        //field.val(response);
                    });
                    

                }

            }
        });
        
    });
    
    
    
    //DELETE ITEM LIST
    $('a.deletelevel').each(function(){
                                
        function confiTrashItem(linkURL, nameProd, titleEv, msjProd, itemtrashto, itemvarto, emtyvalue, datafield) {
            swal({
              title: titleEv, 
              text: "<span style='color:#DB4040; font-weight:bold;'>" + nameProd + "</span><br>" + msjProd, 
              type: 'warning',
              showCancelButton: true,
              confirmButtonText: "Eliminar",
              cancelButtonText: "Cancelar",
              closeOnConfirm: true,
              closeOnCancel: true,
              animation: false,
              html: true
            }, function(isConfirm){
                  if (isConfirm) {
                    tarshProdListTO(itemtrashto, itemvarto, emtyvalue, datafield);
                  } else {
                    return false;	
                  }
                });
          }
                
        //$(this).click(function(){ 
        function tarshProdListTO(itemtrashto, itemvarto, emtyvalue, datafield){
            //var dataString = 'deleteilpto=ok&post='+$(this).attr('data-post')+'&fieldedit='+$(this).attr('data-field');
            var dataString = 'deletelevel=ok&post='+itemvarto+'&fieldedit='+itemtrashto;
                         
            $.ajax({
                type: "POST",
                url: "../../../appweb/inc/edit-levels-functions.php",
                data: dataString,
                success: function(data) {
                    //field.val(data);


                    var response = JSON.parse(data);
                    //console.log(response);
                    if (response['error']) {
                        
                        $("#err"+itemtrashto+emtyvalue).html(response['error']).fadeIn('slow');
                        
                    } else {

                        //$("#wraporder").html(response);
                        //if($("#wraporder").find("#"+datafield+emtyvalue).length){
                            $("#wrapp"+datafield+emtyvalue).remove();
                            //location.reload();
                        //}
                        
                    }

                }
            });    
        };
        
        $(this).click(function(e) {
            e.preventDefault(); 
            var linkURL = $(this).attr("href");
            var nameProd = $(this).attr("name");
            var titleEv = $(this).attr("title");
            var msjProd = $(this).attr("data-msj");
            var emtyvalue = $(this).attr('data-post');
            var datafield = $(this).attr('data-thislevel');
            var itemtrashto =  $(this).attr('data-field');
            var itemvarto =  $(this).attr('data-post');
            //var reMsjProd = $(this).attr("data-remsj");
            confiTrashItem(linkURL, nameProd, titleEv, msjProd, itemtrashto, itemvarto, emtyvalue, datafield);
        });
    });
            
});