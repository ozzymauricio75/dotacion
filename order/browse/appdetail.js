(function ($, window, document) {
    function siRespuesta(r){
        
        var actionform = $('#actionform').val();
        var ordernow = $('#ordernow').val();
        
        
        var rHtml = '<div class="modal fade" id="addShopModal" tabindex="-1" role="dialog" aria-labelledby="addShopModalLabel" >';
        rHtml += '<div class="modal-dialog box25">';
        rHtml += '<div class="modal-content">';
        rHtml += '  <form action="" method="post">'; 
        rHtml += '      <div class="modal-header">';
        rHtml += '          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        //rHtml += '          <h4 class="modal-title" id="addShopModalLabel">'+r.nameprod+'<small class="margin-left-xs">Ref: &nbsp;&nbsp;'+r.skuprod+'</small></h4>';
                        
        rHtml += '          <div class="media">';
        rHtml += '              <div class="media-left">';
        rHtml += '                  <img src="'+r.labelprod+'"  style="width:50px;" />';
        rHtml += '              </div>';
        rHtml += '              <div class="media-body media-middle">';        
        rHtml += '                  <h4 class="media-heading" id="addShopModalLabel">'+r.nameprod+'<br>';    
        rHtml += '                      <small>Ref: &nbsp;&nbsp;'+r.skuprod+'</small>'; 
        rHtml += '                  </h4>';
        rHtml += '              </div>';
        rHtml += '          </div>';
        
        rHtml += '      </div><!--/modal-header-->';

        rHtml += '      <div class="modal-body">';

        rHtml += '          <div class="addprodlist" >';
        rHtml += '              <ul class="list-unstyled">';
                                    if(r.precioHistory != "0"){
        rHtml += '                  <li>';
        rHtml += '                      <div class="form-group">';
        rHtml += '                          <label>Historico</label>';
        rHtml += '                          <div class="badge bg-gray margin-left-xs" >';
        rHtml += '                              <strong><span class="margin-right-xs">$</span>'+r.precioHistoryFormat+'</strong>';
        rHtml += '                          </div>';  
        rHtml += '                      </div>';
        rHtml += '                  </li>';
                                    }                            
        rHtml += '                  <li>';
        rHtml += '                      <div class="form-group">';
        rHtml += '                          <label class="margin-right-xs">Precios</label>';
                                            if(r.precioNal > 0 || r.precioImp > 0){
                                                if(r.precioNal > 0 && r.precioImp > 0){
        rHtml += '                                  <div class="badge bg-green margin-right-xs" >';
        rHtml += '                                      <strong><span class="margin-right-xs">$</span>'+r.precioNalFormat+'</strong>';
        rHtml += '                                  </div>';
        rHtml += '                                  <div class="badge bg-blue">';
        rHtml += '                                      <strong><span class="margin-right-xs">$</span>'+r.precioImpFormat+'</strong>';
        rHtml += '                                  </div>';    
                                                }else if(r.precioNal > 0 ){
        rHtml += '                                  <div class="badge bg-green" >';
        rHtml += '                                      <strong><span class="margin-right-xs">$</span>'+r.precioNalFormat+'</strong>';
        rHtml += '                                  </div>';
                                                }else if(r.precioImp > 0 ){
        rHtml += '                                  <div class="badge bg-blue">';
        rHtml += '                                      <strong><span class="margin-right-xs">$</span>'+r.precioImpFormat+'</strong>';
        rHtml += '                                  </div>'; 
                                                }                                    
                                            }                                                                             
        rHtml += '                      </div>';
        rHtml += '                  </li>';
        rHtml += '                  <li>';
        rHtml += '                  <div class="form-group">';
        rHtml += '                      <div class="input-group">';
        rHtml += '                          <span class="input-group-addon">Cant.</span>';
        rHtml += '                          <input id="cantcart" type="text" name="cantListAdd" value ="" class="form-control" autocomplete="off">';
        rHtml += '                      </div>';
        rHtml += '                  </div>';										                                
        rHtml += '                  </li>';                                    
        rHtml += '                  <li>';
        rHtml += '                  <div class="form-group">';  
        rHtml += '                      <div class="input-group">';                                            
        rHtml += '                          <span class="input-group-addon"><i class="fa fa-usd"></i></span>';
        rHtml += '                          <input type="text" name="priceVentaListAdd" id="priceVentaListAdd" value ="0" class="form-control" autocomplete="off">';        
        rHtml += '                          <input type="hidden" name="dctoList" value="0">';
                                            if(r.precioNal > 0.00  ){
        rHtml += '                              <input type="hidden" name="priceCostListEdit" id="priceCostListEdit" value="'+r.precioNal+'">';
                                            }else if(r.precioImp > 0.00 ){
        rHtml += '                              <input type="hidden" name="priceCostListEdit" id="priceCostListEdit" value="'+r.precioImp+'">';
                                            }          
        rHtml += '                      </div>';
        rHtml += '                  </div>';										                                
        rHtml += '                  </li>';
        rHtml += '                  <li>';
        rHtml += '                  <div class="form-group">';
        rHtml += '                      <label>Val. Unit</label>';
        rHtml += '                      <div class="input-group">';
                                        if(r.precioNal != 0 ){
        rHtml += '                          <div class="badge bg-green" >';
        rHtml += '                              <span class="margin-right-xs">$</span><span class="valorVentaList">0</span>';
        rHtml += '                          </div>';
                                        }else{
        rHtml += '                          <div class="badge bg-blue">';
        rHtml += '                              <span class="margin-right-xs">$</span><span class="valorVentaList">0</span>';
        rHtml += '                          </div>';
                                        }                                                                              
        rHtml += '                      </div>';
        rHtml += '                      <div class="input-group">';
        rHtml += '                          <span class="valorVentaListMsj" style="font-size:15px; font-weight:bold; color:#900;">&nbsp;</span>';
        rHtml += '                      </div>';
        rHtml += '                  </div>';
        rHtml += '                  </li>';
        rHtml += '                  <li>';
        rHtml += '                  <div class="form-group">';
        rHtml += '                      <label>Sub Total</label>';
        rHtml += '                      <div class="input-group">';        
        rHtml += '                          <div class="badge bg-black">';
        rHtml += '                              <span class="margin-right-xs">$</span><span class="subTotalList" >0</span>';
        rHtml += '                          </div>';
        rHtml += '                      </div>';
        rHtml += '                  </div>';
        rHtml += '                  </li>';
        rHtml += '              </ul>';
        rHtml += '          </div><!--/addprodlist---->';

        rHtml += '      </div><!-- /modal-body -->';          		

        rHtml += '      <div class="modal-footer" id="wrapaddpot" >';                                                              
        rHtml += '          <div id="addpot" class="btn-group btn-group-justified">';
        rHtml += '              <div class="btn-group">';
        rHtml += '                  <button type="reset" class="btn btn-app" data-dismiss="modal"><i class="fa fa-times"></i>Cancelar</button>';
        rHtml += '              </div>';
        rHtml += '              <div class="btn-group">';
        rHtml += '                  <button id="addprodorder" type="button" class="btn btn-app"><i class="fa fa-shopping-cart"></i>Agregar</button>';
        rHtml += '              </div>';
        rHtml += '          </div>';
        rHtml +=            '<div id="erraddpot"></div>';
        rHtml += '          <input type="hidden" name="prodbuyed" id="prodbuyed" value="'+r.idprod+'">';  
        rHtml += '          <input type="hidden" name="ordernow" id="ordernow" value="'+ordernow+'">';
        rHtml += '          <input type="hidden" name="addform" id="addform" value="ok">'; 
        rHtml += '      </div><!---/modal-footer--->';
        rHtml += '  </form>';
        rHtml += '</div><!---/modal-content--->';
        rHtml += '</div><!--/modal-dialog-->';
        rHtml += '</div><!--/wrapmodal-->';        
        
        rHtml += '<script type="text/javascript" src="../../appweb/plugins/jquery.number.js"></script>';  
        rHtml += '<script type="text/javascript" src="crud-order.js"></script>';
        
        rHtml += '<script type="text/javascript">';    
        //ACTI MODAL
        rHtml += '$(function() { $("#addShopModal").modal({ show: true }); setTimeout(function (){ $("#cantcart").focus(); }, 1000); });';
        
        //CALCULA VALORES
        rHtml += '$(document).ready(function(){';

        rHtml += '$(".addprodlist").keyup(function() {';

                //cubicaje
        rHtml += 'var cantList=$(this).find("input[name=cantListAdd]").val();'; 
        rHtml += 'var VentaList=$(this).find("input[name=priceVentaListAdd]").val();';
        rHtml += 'var dctoList=$(this).find("input[name=dctoList]").val();';//
        rHtml += 'var priceCostListEdit=$(this).find("input[name=priceCostListEdit]").val();';
        rHtml += 'var dctListFormat=(100-parseFloat(dctoList))/100;';

        rHtml += 'if(VentaList > 0){';

        rHtml += '$(this).find("input[name=dctoList]").val(((parseFloat(VentaList)-parseFloat(priceCostListEdit))/parseFloat(VentaList))*100);'; 
        rHtml += 'var dctoListInsert = ((parseFloat(VentaList)-parseFloat(priceCostListEdit))/parseFloat(VentaList))*100;'; 
        rHtml += 'var dctListInsertFormat=(100-parseFloat(dctoListInsert))/100;';

        rHtml += '$(this).find("[class=valorVentaList]").html(parseFloat(priceCostListEdit)/parseFloat(dctListInsertFormat)).number( true, 2 );'; 
        rHtml += 'var valUnitListInsert=parseFloat(priceCostListEdit)/parseFloat(dctListInsertFormat);';

        rHtml += '$(this).find("[class=subTotalList]").html(parseInt(cantList)*parseFloat(valUnitListInsert)).number( true, 2 );';

        rHtml += '$(this).find("[class=valorVentaListMsj]").text( parseFloat(dctoListInsert) < 0 ? "El precio de venta esta por debajo del costo!!!" : "" );';

        rHtml += '}else{';
                    //$(this).find("input[name=dctoList]").val().number( false ); 

        rHtml += '$(this).find("[class=valorVentaList]").html(parseFloat(priceCostListEdit)/parseFloat(dctListFormat)).number( true, 2 );'; 
        rHtml += 'var valUnitList=parseFloat(priceCostListEdit)/parseFloat(dctListFormat);'; 

        rHtml += '$(this).find("[class=subTotalList]").html(parseInt(cantList)*parseFloat(valUnitList)).number( true, 2 );';

        rHtml += '$(this).find("[class=valorVentaListMsj]").text( parseFloat(dctoList) < 0 ? "El precio de venta esta por debajo del costo!!!" : "" );';
        rHtml += '}';


        rHtml += '}); ';

        rHtml += '});';
                                                
        rHtml += '</script>';
        
        

        $('#respuesta').html(rHtml); 
    }
 
    function siError(e){
        alert('Erro: '+e.statusText);
    }
 
    function peticion(e,idfull){
        
		//var var1 = $('input[name="iditem"]').val(); 
        var var1 = idfull; 
        /*$('input[name="iditem"]').on('change', function(){
            var1 = $(this).val();           
        });*/
        
        
        /*var var1 = $('.iditem').each(function(){
            $(this).val();                   
        });*/
		
		var post = $.post("detailtmpl.php", {variable1: var1}, siRespuesta, 'json');
 
    	post.error(siError);  
    }
 
    //$('.viewfull').each(function(){
    //$('button[name="viewfull"]').each(function(){
    $('a.viewfull').each(function(){
        var idfull = $(this).attr("data-id");
        var idstore = $(this).attr("data-store");
        
        //$(this).click(peticion(idfull));                    
        //alert(idfull);
        
        $(this).click(function(){
            var var1 = idfull;
            var var2 = idstore;
            var post = $.post("detailtmpl.php", {variable1: var1, variable2: var2 }, siRespuesta, 'json');
            //var post = $.post("detailtmpl.php", {variable1: var1}, detaFull);
            
            /////////////////////////////////////////////////////////////
            
            //var detaFull = angular.module('morphDemo', ['ngMorph']);//angular.module('myApp.emailModal', ['ui.bootstrap', 'ui.bootstrap.tpls']);                        
            ////////////////////////////////////////////////////////////
            post.error(siError);  
        });    
    });
    
}(jQuery, window, document));