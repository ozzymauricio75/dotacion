(function ($, window, document) {
    
    function siRespuesta(r){
                
        var rHtml ='';        
         jQuery.each(r, function(k,v1) {                
            idTalla = v1['codtalla'];
            nameTalla = v1['nametalla'];
                                                          
           //console.log(k, v1);
                
            rHtml += '<div class="col-xs-4">';            
            rHtml += '<label>';
            rHtml += '<input type="checkbox" name="tallaletras[]" class="flat-red" value="' + idTalla +'"/>&nbsp;&nbsp;';
            rHtml += nameTalla;
            rHtml += '</label>';
            rHtml += '</div>';                                            
         });
            
                                
        $('#ettp').html(rHtml); 
        //$('#ettp').load();
    }
 
    function siError(e){
        alert('Erro: '+e.statusText);
    }
       
    $('.grupotallalist').change(function(){
        var pathfile = $('#pathfile').html();
        var idsend=$(this).val();
        var fieldqsend='gtl';
                
        var post = $.post("../appweb/inc/query-selects.php", {idgt: idsend, fieldq: fieldqsend }, siRespuesta, 'json');
        //var post = $.post("new.php", {idgt: idsend, fieldq: fieldqsend });
        //console.log(post);
        post.error(siError);  
    });
    
}(jQuery, window, document));