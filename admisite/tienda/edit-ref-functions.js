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
            url: "../appweb/inc/edit-item-ref-functions.php",
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
    
    //DELETE ITEM LIST
    $('a.deleteitempto').each(function(){
        
        //var field = $(this);            
        //var emtyvalue = $(this).attr('data-post');
        //var datafield = "wrapitemplto";//$(this).attr('data-field');
        //var parent = $("#wrapitemplto"+emtyvalue);//field.parent().attr('id');
        //var priceunit = $(this).attr('data-unit');
                
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
            var dataString = 'fieldedit=deletefoto&post='+itemvarto+'&value='+itemtrashto;
            
             //alert(dataString);

                $.ajax({
                    type: "POST",
                    url: "../appweb/inc/edit-item-ref-functions.php",
                    data: dataString,
                    success: function(data) {

                        var response = JSON.parse(data);                        
                        if (response['error']) {                            
                            $("#err"+datafield+emtyvalue).html(response['error']).fadeIn('slow');                            
                        } else {
                                                                                
                            //if($("#img_"+).find("#"+datafield+emtyvalue).length){
                                $("#img_"+itemvarto).remove();
                                //location.reload();
                           // }
                                                
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
            var datafield = "weeditalbumref";
            var itemtrashto =  $(this).attr('data-field');
            var itemvarto =  $(this).attr('data-post');
            //var reMsjProd = $(this).attr("data-remsj");
            confiTrashItem(linkURL, nameProd, titleEv, msjProd, itemtrashto, itemvarto, emtyvalue, datafield);
        });
    });
    
});