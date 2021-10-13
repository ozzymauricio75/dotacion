$(document).ready(function(){
    $('input, textarea, select').focus(function() {
        $(this).css('background-color','#ffffff');
    });

    $('input, textarea, select').blur(function(){
        var field = $(this);
        var parent = field.parent().attr('id');
        var emtyvalue = $(this).val();
        var datafield = $(this).attr('data-field');
        field.css('background-color','#F3F3F3');
        

        if($('#'+parent).find(".okrow").length){
            $('#'+parent+' .okrow').remove();
            $('#'+parent+' .loaderrow').remove();
            $('#'+parent).append('<div class="loaderrow"><img src="../appweb/img/loader.gif"/></div>').fadeIn('slow');
        }else{
            $('#'+parent).append('<div class="loaderrow"><img src="../appweb/img/loader.gif"/></div>').fadeIn('slow');
        }

        var dataString = 'value='+$(this).val()+'&field='+$(this).attr('name')+'&post='+$(this).attr('data-post')+'&fieldedit='+$(this).attr('data-field');

        //console.log(dataString);

        $.ajax({
            type: "POST",
            url: "../appweb/inc/edit-store-functions.php",
            data: dataString,
            success: function(data) {
                //field.val(data);
                var response = JSON.parse(data);
                //console.log(response);
                if (response['error']) {

                    $('#err'+datafield).html(response['error']).fadeIn('slow');

                }else{

                    $('#'+parent+' .loaderrow').fadeOut(function(){
                        $('#'+parent).append('<div class="okrow"><img src="../appweb/img/ok.png"/></div>').fadeIn('slow');
                    });
                    field.val(response);

                }

            }
        });
        
    });
    
                                                                           
    //FUNCIONES EDITA TALLAS 
    $('#savetallasedit').click(function(){
        var field = $(this);
        var parent = $('#tallaitemform');
        var emtyvalue = $(this).val();
        var datafield = $(this).attr('data-field');
      

        if($('#savetallasedit').find(".okbtn").length){
            $('#savetallasedit'+' .okbtn').remove();
            $('#savetallasedit'+' .loaderbtn').remove();
            $('#savetallasedit').append('<div class="loaderbtn margin-left-xs"><img src="../appweb/img/loader.gif"/></div>').fadeIn('slow');
        }else{
            $('#savetallasedit').append('<div class="loaderbtn margin-left-xs"><img src="../appweb/img/loader.gif"/></div>').fadeIn('slow');
        }

        var tallasprod = [];
        var codegrupotallas = "";
        var nameinput = "";
        var datapost = "";
        var datafieldedit = "";
        $(".tallaslist").each(function(){
            if($(this).is(":checked")){
                tallasprod.push($(this).val());
                codegrupotallas = $(this).attr("data-gt");
                nameinput = $(this).attr("name");
                datapost = $(this).attr("data-post");
                datafieldedit = $(this).attr("data-field");
            }
        });
        tallasprod = tallasprod.toString();

        var dataString = 'value='+tallasprod+'&field='+nameinput+'&post='+datapost+'&fieldedit='+datafieldedit+"&tallas_data="+tallasprod+"&codegrupotallas_data="+codegrupotallas;
        //alert(dataString);

        $.ajax({
            type: "POST",
            url: "../appweb/inc/edit-item-functions.php",
            data: dataString,
            success: function(data) {                    
                var response = JSON.parse(data);
                //console.log(response);
                if (response['error']) {

                    $('#err'+datafield).html(response['error']).fadeIn('slow');

                } else {

                    $('#savetallasedit'+' .loaderbtn').fadeOut(function(){
                        $('#savetallasedit').append('<div class="okbtn margin-left-xs"><img src="../appweb/img/ok.png"/></div>').fadeIn('slow');
                        $("#canceltallaeditbtn").remove(); 
                    });                
                }
            }
        });

    });  
    
    
    //FUNCIONES EDITA COLORES
    $('#savecoloredit').click(function(){
        var field = $(this);
        var parent = $('#colorsitemform');
        var emtyvalue = $(this).val();
        var datafield = $(this).attr('data-field');
      

        if($('#savecoloredit').find(".okbtn").length){
            $('#savecoloredit'+' .okbtn').remove();
            $('#savecoloredit'+' .loaderbtn').remove();
            $('#savecoloredit').append('<div class="loaderbtn margin-left-xs"><img src="../appweb/img/loader.gif"/></div>').fadeIn('slow');
        }else{
            $('#savecoloredit').append('<div class="loaderbtn margin-left-xs"><img src="../appweb/img/loader.gif"/></div>').fadeIn('slow');
        }

        var colorsprod = [];
        var nameinput = "";
        var datapost = "";
        var datafieldedit = "";        
        $(".tipocolor").each(function(){
            if($(this).is(":checked")){
                colorsprod.push($(this).val());
                nameinput = $(this).attr("name");
                datapost = $(this).attr("data-post");
                datafieldedit = $(this).attr("data-field");
            }
        });
        colorsprod = colorsprod.toString();

        var dataString = 'value='+colorsprod+'&field='+nameinput+'&post='+datapost+'&fieldedit='+datafieldedit+"&colors_data="+colorsprod;
        //alert(dataString);

        $.ajax({
            type: "POST",
            url: "../appweb/inc/edit-item-functions.php",
            data: dataString,
            success: function(data) {                    
                var response = JSON.parse(data);
                //console.log(response);
                if (response['error']) {

                    $('#err'+datafield).html(response['error']).fadeIn('slow');

                } else {

                    $('#savecoloredit'+' .loaderbtn').fadeOut(function(){
                        $('#savecoloredit').append('<div class="okbtn margin-left-xs"><img src="../appweb/img/ok.png"/></div>').fadeIn('slow');
                        $("#cancelcolorseditbtn").remove(); 
                    });                
                }
            }
        });

    });
    
    
    
    //FUNCIONES EDITA MATERIALES
    $('#savematerialedit').click(function(){
        var field = $(this);
        var parent = $('#matersitemform');
        var emtyvalue = $(this).val();
        var datafield = $(this).attr('data-field');
      

        if($('#savematerialedit').find(".okbtn").length){
            $('#savematerialedit'+' .okbtn').remove();
            $('#savematerialedit'+' .loaderbtn').remove();
            $('#savematerialedit').append('<div class="loaderbtn margin-left-xs"><img src="../appweb/img/loader.gif"/></div>').fadeIn('slow');
        }else{
            $('#savematerialedit').append('<div class="loaderbtn margin-left-xs"><img src="../appweb/img/loader.gif"/></div>').fadeIn('slow');
        }

        var materialprod = [];
        var nameinput = "";
        var datapost = "";
        var datafieldedit = "";                
        $(".tipomaterial").each(function(){
            if($(this).is(":checked")){
                materialprod.push($(this).val());
                nameinput = $(this).attr("name");
                datapost = $(this).attr("data-post");
                datafieldedit = $(this).attr("data-field");
            }
        });
        materialprod = materialprod.toString();

        var dataString = 'value='+materialprod+'&field='+nameinput+'&post='+datapost+'&fieldedit='+datafieldedit+"&material_data="+materialprod;
        //alert(dataString);

        $.ajax({
            type: "POST",
            url: "../appweb/inc/edit-item-functions.php",
            data: dataString,
            success: function(data) {                    
                var response = JSON.parse(data);
                //console.log(response);
                if (response['error']) {

                    $('#err'+datafield).html(response['error']).fadeIn('slow');

                } else {

                    $('#savematerialedit'+' .loaderbtn').fadeOut(function(){
                        $('#savematerialedit').append('<div class="okbtn margin-left-xs"><img src="../appweb/img/ok.png"/></div>').fadeIn('slow');
                        $("#cancelmaterseditbtn").remove(); 
                    });                
                }
            }
        });

    });
    
    
});