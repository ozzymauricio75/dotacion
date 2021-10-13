$(document).ready(function(){
    $('input.infoedit, textarea.infoedit, select.infoedit').focus(function() {
        $(this).css('background-color','#ffffff');
    });

    $('input.infoedit, textarea.infoedit, select.infoedit').blur(function(){
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
            url: "../appweb/inc/edit-users-functions.php",
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
                    field.css('border-color','#2eed70');

                }

            }
        });
        
    });
});