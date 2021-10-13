$(document).ready(function(){ 
    var monedasite = $("#currencysite").html();
    var pathfile = $("#pathfile").html();
    var clientNow = $("#clientnow").html();
    //alert(pathfile);
    //ADD PROD ORDER
    $("#addprodorder").click(function(){
        var field = $(this);
        var parent = $("#addpot");// field.parent().attr("id");
        var emtyvalue = $(this).val();
        var datafield = "addpot";//$(this).attr("data-field");                
        field.css("background-color","#F3F3F3");


        //if(emtyvalue != ""){

        if($("#wrapaddpot").find(".ok").length){
            $("#wrapaddpot"+" .ok").remove();
            $("#wrapaddpot"+" .loader").remove();
            $("#wrapaddpot").append("<div class='loader'><img src='../../appweb/img/loadingcart.gif'/></div>").fadeIn("slow");
        }else{
            $("#wrapaddpot").append("<div class='loader'><img src='../../appweb/img/loadingcart.gif'/></div>").fadeIn("slow");
        }

        var pedido_var = $("#ordernow").val();
        var prod_var = $("#prodbuyed").val();
        var cant_var = $("#cantcart").val();
        var costo_var = $("#priceCostListEdit").val();                
        var venta_var = $("#priceVentaListAdd").val();
        var utilidad_percenvar = 100 - ((costo_var/venta_var)*100);
        var utilidad_var = venta_var - costo_var;
        var subtotal_var = cant_var*venta_var;//$("#subTotalList").val();


        var dataString = "pedido_data="+pedido_var+"&prod_data="+prod_var+"&cant_data="+cant_var+"&costo_data="+costo_var+"&venta_data="+venta_var+"&utilidad_percendata="+utilidad_percenvar+"&utilidad_data="+utilidad_var+"&subtotal_data="+subtotal_var+"&fieldedit=addpot"; 
        //alert(dataString);

        $.ajax({
            type: "POST",
            url: "crud-order.php",
            data: dataString,
            success: function(data) {                    
                var response = JSON.parse(data);
                //console.log(response);
                if (response["error"]) {

                    //$("#err"+datafield).html(response["error"]).fadeIn("slow");
                    
                    //$("#result").html(error);
                    $("#wrapaddpot"+" .loader").fadeOut(function(){
                        //$('#'+parent).append('<div class="errors"></div>').html(error).fadeIn('slow');
                        $("#err"+datafield).html(response["error"]).fadeIn("slow");
                    });

                } else {
                    
                    
                    /*function refreshorder() {
                        location.reload();
                    }*/

                    $("#wrapaddpot"+" .loader").fadeOut(function(){
                        //$("#addpot").append("<div class='ok'><img src='../../appweb/img/ok.png'/></div>").fadeIn("slow");
                         $("#wrapaddpot #addpot").remove(); 
                        $("#wrapaddpot").append("<a class='btn btn-block btn-social btn-success' type='reset' data-dismiss='modal' ><i class='fa fa-check'></i> Continuar comprando</a>").fadeIn("slow");
                        //$("#wrapaddpot").append("<button class='btn btn-block btn-social btn-success' type='button' onclick='refreshorder();'><i class='fa fa-check'></i> Continuar comprando</button>").fadeIn("slow");
                        
                        location.reload();
                    });
                    
                    
                    //$("#wraporder").append(response);
                    
                    //$("#wraporder").eq(0).load(pathfile+"takeorder/browse/reload-pedido-tmp.php");
                    
                    //$("#tolsidebar").load("reload-pedido-tmp.php #wraporder");
                    
                    
                     
                    //$("#wrapperbrowse").load(pathfile+'order-list-tomapedido.php');                                                                                        
                    //$("#wrapperbrowse").load(pathfile+"appweb/tmplt/order-list-tomapedido.php");
                    
                    //$("#wraporder").load(window.location +" #wraporder");
                    //$("#wraporder").html(response);
                    
                    /*$("#wrapaddpot .control-sidebar-itemoreder").fadeOut(function(){
                        $("#wraporder").append(response).fadeIn("slow");
                    });*/
                    //$("#wraporder").remove();
                    
                    
                    
                    $(function() { 
                        var sumaSubTotal = 0;
                        $('input[name=subTotalTO]').each(function(){
                            var subTotalTO = $(this).val();                
                            sumaSubTotal += parseFloat(subTotalTO);
                        });

                      //http://stackoverflow.com/questions/149055/how-can-i-format-numbers-as-money-in-javascript
                        Number.prototype.format = function(n, x, s, c) {
                            var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
                                num = this.toFixed(Math.max(0, ~~n));

                            return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
                        };

                        //var granTotal = format2(sumaSubTotal, "$");
                        var granTotal = sumaSubTotal.format(2, 3, '.', ',');
                        //alert(granTotal);

                        $("#totalTO").html(granTotal).fadeIn("slow");

                    }); 
                                                                                
                }
            }
        });

    });  
    
   
    
    //ADD PROD ORDER DESDE SHOWROOM
    //$(".addprodsr").each(function(){
    //$(".addorderform").each(function(){
        
        
        
                
                
    $(".addprodsr").click(function(){
        
        var actionform = $("#actionform").val();
        var tipokit = $('#tipokit').val();
        
        var linkURL = actionform+'?l2='+tipokit;
        //alert(linkURL);
        
        var field = $(this).attr("data-this");  
        //var parent = $("#addpot");// field.parent().attr("id");
        //var emtyvalue = $(this).val();
        var datafield = "addpot"+field;//$(this).attr("data-field");                
        //field.css("background-color","#F3F3F3");


        //if(emtyvalue != ""){

        if($("#wrapaddpot"+field).find(".ok").length){
            $("#wrapaddpot"+field+" .ok").remove();
            $("#wrapaddpot"+field+" .loader").remove();
            $("#wrapaddpot"+field).append("<div class='loader'><img src='../../appweb/img/loadingcart.gif'/></div>").fadeIn("slow");
        }else{
            $("#wrapaddpot"+field).append("<div class='loader'><img src='../../appweb/img/loadingcart.gif'/></div>").fadeIn("slow");
        }

        var pedido_var = $("#ordernow").val();
        var prod_var = $("#prodbuyed"+field).val();
        var prodfiling_var = $("#prodfiling"+field).val();
        var kitcode_var = $("#kitcod"+field).val();
        var itemkit_var = $("#itemkit"+field).val();
        
                        
        var cant_var = 1;//$("#cantcart"+field).val();
        //var costo_var = $("#priceCostListEdit"+field).val();                
        //var venta_var = $("#priceVentaListAdd"+field).val();
        //var utilidad_percenvar = 100 - ((costo_var/venta_var)*100);
        //var utilidad_var = venta_var - costo_var;
        //var subtotal_var = cant_var*venta_var;//$("#subTotalList").val();


        var dataString = "pedido_data="+pedido_var+"&prod_data="+prod_var+"&prodfiling_data="+prodfiling_var+"&kitcode_data="+kitcode_var+"&itemkit_data="+itemkit_var+"&cant_data="+cant_var+"&fieldedit=addpotsr"; 
        //alert(dataString);
        console.log(dataString);
        $.ajax({
            type: "POST",
            url: "crud-order.php",
            data: dataString,
            success: function(data) {                    
                var response = JSON.parse(data);
                //console.log(response);
                if (response["error"]) {

                    $("#wrapaddpot"+field+" .loader").fadeOut(function(){                        
                        $("#err"+datafield).html(response["error"]).fadeIn("slow");
                    });

                } else {


                    $("#wrapaddpot"+field+" .loader").fadeOut(function(){
                        $("#wrapaddpot"+field+" #addpot").remove(); 
                        $("#wrapaddpot"+field).append("<div class='info-boxsmall bg-green'><span class='info-box-iconsmall'><i class='fa fa-check'></i></span><div class='info-box-content'><h4>Producto agregado</h4></div>").fadeIn("slow");
                        //location.reload();
                        window.location.href = linkURL;
                    });
                    
                    //$("#wraporder").append(response);
                    
                    /*var itemActual = 0;
                    $('input[name=subTotalTO]').each(function(){
                        itemActual++;                
                        //sumaSubTotal += parseFloat(subTotalTO);
                    });*/
                    
                    //$("#wraporder").append(response); 
                    //var tmpHTML = $("#wraporder").html(response);//"<input type=\"file\" name=\"file1\" onchange=\"changed()\">";
                    //$("#wraporder").append(tmpHTML);
                    
                    
                    //$("#wraporder").append(response);
                    
                    
                    /*/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    //var addProdHTML = response[0].address_components;
                    var addProdHTML={}; 
                    var idOrderTmpItem = "";
                    var portadaFileItemOrder = "";
                    var nomeProdItem = "";
                    var SKUProdItem = "";
                    var cantProdItem = "";
                    var costoProdItem = "";
                    var precioVentaItem = "";
                    var ventaProdItem = "";
                    var subTotalProdItem = "";
                    var subTotalSumatoria = "";
                    
                    jQuery.each(response, function(k,v1) {
                        //console.log(response['idEspeciProdItemTOadd']);
                        //console.log("entro aqui");
//                        jQuery.each(v1.types, function(k2, v2){
//                            idOrderTmpItem[v2] = v1.idEspeciProdItemTOadd;
//                        });
                        var portadaFileItemOrder = v1.portadaItemTOadd;
                        var nomeProdItem = v1.nomeItemTOadd
                        var SKUProdItem = v1.skuItemTOadd
                        var cantProdItem = v1.cantProdTOadd
                        var costoProdItem = v1.costoProdTOadd
                        var precioVentaItem = v1.precioVentaTOadd
                        var ventaProdItem = v1.ventaProdTOadd
                        var subTotalProdItem = v1.subTotalProdTOadd
                        var subTotalSumatoria = v1.subTotalSumatoriaTOadd
                                                                                                 
//                        jQuery.each(v1.types, function(k2, v2){
//                            components[v2]=v1.long_name
//                        }); 
                        idOrderTmpItem = response['idEspeciProdItemTOadd'];
                        portadaFileItemOrder = response['portadaItemTOadd'];
                        nomeProdItem = response['nomeItemTOadd'];
                        SKUProdItem = response['skuItemTOadd'];
                        cantProdItem = response['cantProdTOadd'];
                        costoProdItem = response['costoProdTOadd'];
                        precioVentaItem = response['precioVentaTOadd'];
                        ventaProdItem =response['ventaProdTOadd']; 
                        subTotalProdItem = response['subTotalProdTOadd'];
                        subTotalSumatoria = response['subTotalSumatoriaTOadd']; 
                        
                    }) */
                    //console.log(idOrderTmpItem);
                    
                    
                    //layaout item pedido 
                    /*var prodListTmpl ="<div class='control-sidebar-itemoreder' id='wrapitemplto"+idOrderTmpItem+"'>";

                    prodListTmpl +="<div class='control-sidebar-itemoreder-left'>";
                    prodListTmpl +="<a href='#'>";
                    prodListTmpl +="<img class='control-sidebar-itemoreder-object' src='"+portadaFileItemOrder+"' alt=''>";
                    prodListTmpl +="</a>";
                    prodListTmpl +="</div>";

                    prodListTmpl +="<div class='control-sidebar-itemoreder-body'>";
                    prodListTmpl +="<div class='row itemorder-top'>";                    
                    prodListTmpl +="<a class='btn control-sidebar-itemoreder-deleteitem deleteitempto' data-post='"+idOrderTmpItem+"' data-field='cpe"+idOrderTmpItem+"' type='button'><i class='fa fa-times'></i></a>";
                    prodListTmpl +="<h4 class='control-sidebar-itemoreder-ref'>"+nomeProdItem;
                    prodListTmpl +="<small>Ref: "+SKUProdItem+"</small>";                                        
                    prodListTmpl +="</h4>";
                    prodListTmpl +="</div>";

                    prodListTmpl +="<div class='row itemorder-down'>";

                    prodListTmpl +="<div class='col-xs-3 '>";
                    prodListTmpl +="<input type='text' class='cpe form-control' name='cantlistpot"+idOrderTmpItem+"' data-field='cpe"+idOrderTmpItem+"' data-post='"+idOrderTmpItem+"' value='"+cantProdItem+"'  data-precio='"+costoProdItem+"' data-unit='"+precioVentaItem+"'>";
                    prodListTmpl +="</div>";//col-xs-4

                    prodListTmpl +="<div class='col-xs-4 unlateralpadding'>";
                    prodListTmpl +="<span class='control-sidebar-itemoreder-unitprice'>$ "+ventaProdItem+"</span>";
                    prodListTmpl +="</div>";//col-xs-6

                    prodListTmpl +="<div class='col-xs-5 unlateralpadding'>";
                    prodListTmpl +="<span class='control-sidebar-itemoreder-price'>$ "+subTotalProdItem+"</span>";
                    prodListTmpl +="<input type='hidden' class='subTotalTO' name='subTotalTO' value='"+subTotalSumatoria+"'>";
                    //prodListTmpl +="<a href='' class='control-sidebar-itemoreder-deleteitem'><i class='fa fa-times'></i></a>"; 
                    prodListTmpl +="</div>";//col-xs-2 

                    prodListTmpl +="</div>";//itemorder-down
                    prodListTmpl +="<div id='errwrapitemplto"+idOrderTmpItem+"'></div>";

                    prodListTmpl +="</div>";//control-sidebar-itemoreder-body
                    prodListTmpl +="</div>";//control-sidebar-itemoreder*/ 
                    
                    
                    
                    
                    //var prodListTmpl ="<div class='control-sidebar-itemoreder' id='wrapitemplto"+idOrderTmpItem+"'><div class='control-sidebar-itemoreder-left'><a href='#'><img class='control-sidebar-itemoreder-object' src='"+portadaFileItemOrder+"' alt=''></a></div><div class='control-sidebar-itemoreder-body'><div class='row itemorder-top'><a class='btn control-sidebar-itemoreder-deleteitem deleteitempto' data-post='"+idOrderTmpItem+"' data-field='cpe"+idOrderTmpItem+"' type='button'><i class='fa fa-times'></i></a><h4 class='control-sidebar-itemoreder-ref'>"+nomeProdItem+"<small>Ref: "+SKUProdItem+"</small></h4></div><div class='row itemorder-down'><div class='col-xs-3 '><input type='text' class='cpe form-control' name='cantlistpot"+idOrderTmpItem+"' data-field='cpe"+idOrderTmpItem+"' data-post='"+idOrderTmpItem+"' value='"+cantProdItem+"'  data-precio='"+costoProdItem+"' data-unit='"+precioVentaItem+"'></div><div class='col-xs-4 unlateralpadding'><span class='control-sidebar-itemoreder-unitprice'>$ "+ventaProdItem+"</span></div><div class='col-xs-5 unlateralpadding'><span class='control-sidebar-itemoreder-price'>$ "+subTotalProdItem+"</span><input type='hidden' class='subTotalTO' name='subTotalTO' value='"+subTotalSumatoria+"'></div></div><div id='errwrapitemplto"+idOrderTmpItem+"'></div></div></div>";
                    
                    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    /*if(itemActual==0){
                        //location.reload();
                        $("#wraplto").html("<div class='control-sidebar-cliente' ><div class='media'><div class='media-left '><span class='fa-stack fa-lg'><i class='fa fa-circle fa-stack-2x'></i><i class='fa fa-user fa-stack-1x fa-inverse'></i></span></div><div class='media-body media-middle'><h4 class='media-heading'>"+clientNow+"</h4></div></div></div><div class='control-sidebar-totalorder'><span id='totalTO'>0</span></div><div id='wraporder' class='padd-bottom-xs margin-verti-xs'><div class='control-sidebar-itemoreder' id='wrapitemplto"+idOrderTmpItem+"'><div class='control-sidebar-itemoreder-left'><a href='#'><img class='control-sidebar-itemoreder-object' src='"+portadaFileItemOrder+"' alt=''></a></div><div class='control-sidebar-itemoreder-body'><div class='row itemorder-top'><a class='btn control-sidebar-itemoreder-deleteitem deleteitempto' data-post='"+idOrderTmpItem+"' data-field='cpe"+idOrderTmpItem+"' type='button'><i class='fa fa-times'></i></a><h4 class='control-sidebar-itemoreder-ref'>"+nomeProdItem+"<small>Ref: "+SKUProdItem+"</small></h4></div><div class='row itemorder-down'><div class='col-xs-3 '><input type='text' class='cpe form-control' name='cantlistpot"+idOrderTmpItem+"' data-field='cpe"+idOrderTmpItem+"' data-post='"+idOrderTmpItem+"' value='"+cantProdItem+"'  data-precio='"+costoProdItem+"' data-unit='"+precioVentaItem+"'></div><div class='col-xs-4 unlateralpadding'><span class='control-sidebar-itemoreder-unitprice'>$ "+ventaProdItem+"</span></div><div class='col-xs-5 unlateralpadding'><span class='control-sidebar-itemoreder-price'>$ "+subTotalProdItem+"</span><input type='hidden' class='subTotalTO' name='subTotalTO' value='"+subTotalSumatoria+"'></div></div><div id='errwrapitemplto"+idOrderTmpItem+"'></div></div></div></div><div class='msjzero box25 padd-verti-md padd-hori-xs text-center margin-bottom-lg'><h5>- Fin pedido -</h5</div>").fadeIn("slow");
                        
                    }else{
                    
                        $("#wraporder").append("<div class='control-sidebar-itemoreder' id='wrapitemplto"+idOrderTmpItem+"'><div class='control-sidebar-itemoreder-left'><a href='#'><img class='control-sidebar-itemoreder-object' src='"+portadaFileItemOrder+"' alt=''></a></div><div class='control-sidebar-itemoreder-body'><div class='row itemorder-top'><a class='btn control-sidebar-itemoreder-deleteitem deleteitempto' data-post='"+idOrderTmpItem+"' data-field='cpe"+idOrderTmpItem+"' type='button'><i class='fa fa-times'></i></a><h4 class='control-sidebar-itemoreder-ref'>"+nomeProdItem+"<small>Ref: "+SKUProdItem+"</small></h4></div><div class='row itemorder-down'><div class='col-xs-3 '><input type='text' class='cpe form-control' name='cantlistpot"+idOrderTmpItem+"' data-field='cpe"+idOrderTmpItem+"' data-post='"+idOrderTmpItem+"' value='"+cantProdItem+"'  data-precio='"+costoProdItem+"' data-unit='"+precioVentaItem+"'></div><div class='col-xs-4 unlateralpadding'><span class='control-sidebar-itemoreder-unitprice'>$ "+ventaProdItem+"</span></div><div class='col-xs-5 unlateralpadding'><span class='control-sidebar-itemoreder-price'>$ "+subTotalProdItem+"</span><input type='hidden' class='subTotalTO' name='subTotalTO' value='"+subTotalSumatoria+"'></div></div><div id='errwrapitemplto"+idOrderTmpItem+"'></div></div></div>").fadeIn("slow");
                    }*/

                    /*$(function() { 
                        var sumaSubTotal = 0;
                        $('input[name=subTotalTO]').each(function(){
                            var subTotalTO = $(this).val();                
                            sumaSubTotal += parseFloat(subTotalTO);
                        });

                        Number.prototype.format = function(n, x, s, c) {
                            var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
                                num = this.toFixed(Math.max(0, ~~n));

                            return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
                        };
                        
                        var granTotal = sumaSubTotal.format(2, 3, '.', ',');
                       
                        $("#totalTO").html(granTotal).fadeIn("slow");

                    });*/ 

                }
            }
        });
    });
  
    
    
    ////EDITAR  PROD ORDER    
    /*$('input').focus(function() {
        $(this).css('background-color','#ffffff');
    });*/
    $('input.cpe').each(function(){
        //$('input').blur(function(){
        
        var field = $(this);
            
            var emtyvalue = $(this).attr('data-post');//$(this).val();
            var datafield = "wrapitemplto";//$(this).attr('data-field');
            var parent = $("#wrapitemplto"+emtyvalue);//field.parent().attr('id');
            var priceunit = $(this).attr('data-unit');
        //alert(priceunit);
       
       $(this).blur(function(){
            
            //field.css('background-color','#F3F3F3');

 
            //if(emtyvalue != ""){

                if($("#"+datafield+emtyvalue).find(".ok").length){
                    $("#"+datafield+emtyvalue+' .ok').remove();
                    $("#"+datafield+emtyvalue+' .loader').remove();
                    $("#"+datafield+emtyvalue).append('<div class="loader"><img src="../../appweb/img/loadingcart.gif"/></div>').fadeIn('slow');
                }else{
                    $("#"+datafield+emtyvalue).append('<div class="loader"><img src="../../appweb/img/loadingcart.gif"/></div>').fadeIn('slow');
                }

            //data-field='cplto' data-post='".$idProdItem."' data-order='".$idOrderTmpItem."' data-precio='".$costoProdItem."' data-unit='".$precioVentaItem."'

                var dataString = 'editlpto=ok&value='+$(this).val()+'&field='+$(this).attr('name')+'&post='+$(this).attr('data-post')+'&priceedit='+$(this).attr('data-precio')+'&unitedit='+$(this).attr('data-unit')+'&fieldedit='+$(this).attr('data-field');
            
             //alert("#"+datafield+emtyvalue);

                $.ajax({
                    type: "POST",
                    url: "crud-order.php",
                    data: dataString,
                    success: function(data) {
                        //field.val(data);


                        var response = JSON.parse(data);
                        //console.log(response);
                        if (response['error']) {
                            /*$('#'+parent+' .loader').fadeOut(function(){
                                $('#'+parent).append('<div class="wrong"><img src="../../../appweb/img/error.png"/></div>').fadeIn('slow');
                            });*/
                            $("#err"+datafield+emtyvalue).html(response['error']).fadeIn('slow');
                            /*var wraperr = $('#err'+datafield);
                            jQuery.each(response['error'], function(k,v1) {                
                                errprint = v1;
                                wraperr.html(errprint).fadeIn('slow');                                                                             
                            }); */
                        } else {
                            
                            //http://stackoverflow.com/questions/149055/how-can-i-format-numbers-as-money-in-javascript
                            Number.prototype.format = function(n, x, s, c) {
                                var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
                                    num = this.toFixed(Math.max(0, ~~n));

                                return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
                            };
                            //$("#error").html(response['error']);

                            //if(!$("#error").hasClass("alert alert-danger"))
                              //  $("#error").toggleClass("alert alert-danger");
                            //$('#'+parent+' .loader').fadeOut(function(){
                                //$('#'+parent+' .loader').append('<div class="errors"></div>').html(response['error']).fadeIn('slow');
                            //});
                            //$('#err'+datafield).html(response['error']).fadeIn('slow');
                            /*$('#'+parent+' .loader').fadeOut(function(){
                                $('#'+parent).append('<div class="ok"><img src="../../../appweb/img/ok.png"/></div>').fadeIn('slow');
                            });*/
                            $("#"+datafield+emtyvalue+' .loader').remove();
                            field.val(response);
                            
                            //if($("#"+datafield+emtyvalue).find(".control-sidebar-itemoreder-price").length){
                                var newcant = response;
                                var newsubtotal = priceunit*newcant;
                                var newsubtotalformat = newsubtotal.format(2, 3, '.', ',');
                                var printnewsubtotal = monedasite +"&nbsp;" + newsubtotalformat;
                                $("#"+datafield+emtyvalue+" .control-sidebar-itemoreder-price" ).html(printnewsubtotal).fadeIn('slow');  
                                $("#"+datafield+emtyvalue+' input[name=subTotalTO]').val(newsubtotal);  
                            
                            //}
                            //alert(newcant);
                            //alert(newsubtotal);

                            /*$("#wraporder").html(response);*/

                            $(function() { 
                                var sumaSubTotal = 0;
                                $('input[name=subTotalTO]').each(function(){
                                    var subTotalTO = $(this).val();                
                                    sumaSubTotal += parseFloat(subTotalTO);
                                });                              

                                //var granTotal = format2(sumaSubTotal, "$");
                                var granTotal = sumaSubTotal.format(2, 3, '.', ',');
                                //alert(granTotal);

                                $("#totalTO").html(granTotal).fadeIn("slow");

                            }); 

                        }

                    }/*,
                    error: function(error) {
                        //$("#result").html(error);
                        $('#'+parent+' .loader').fadeOut(function(){
                            $('#'+parent).append('<div class="errors"></div>').html(error).fadeIn('slow');
                        }); 
                    }*/
                });
            //}
        });
    });//input.cep
    
    
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
            var dataString = 'deleteilpto=ok&post='+itemvarto+'&fieldedit='+itemtrashto;
            
             //alert(dataString);

                $.ajax({
                    type: "POST",
                    url: "crud-order.php",
                    data: dataString,
                    success: function(data) {
                        //field.val(data);


                        var response = JSON.parse(data);
                        //console.log(response);
                        if (response['error']) {
                            /*$('#'+parent+' .loader').fadeOut(function(){
                                $('#'+parent).append('<div class="wrong"><img src="../../../appweb/img/error.png"/></div>').fadeIn('slow');
                            });*/
                            $("#err"+datafield+emtyvalue).html(response['error']).fadeIn('slow');
                            /*var wraperr = $('#err'+datafield);
                            jQuery.each(response['error'], function(k,v1) {                
                                errprint = v1;
                                wraperr.html(errprint).fadeIn('slow');                                                                             
                            }); */
                        } else {
                                                    
                            //$("#wraporder").html(response);
                            if($("#wraporder").find("#"+datafield+emtyvalue).length){
                                $("#"+datafield+emtyvalue).remove();
                                location.reload();
                            }
                    
                            $(function() { 
                                var sumaSubTotal = 0;
                                $('input[name=subTotalTO]').each(function(){
                                    var subTotalTO = $(this).val();                
                                    sumaSubTotal += parseFloat(subTotalTO);
                                });

                              //http://stackoverflow.com/questions/149055/how-can-i-format-numbers-as-money-in-javascript
                                Number.prototype.format = function(n, x, s, c) {
                                    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
                                        num = this.toFixed(Math.max(0, ~~n));

                                    return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
                                };

                                //var granTotal = format2(sumaSubTotal, "$");
                                var granTotal = sumaSubTotal.format(2, 3, '.', ',');
                                //alert(granTotal);

                                $("#totalTO").html(granTotal).fadeIn("slow");

                            });

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
            var datafield = "wrapitemplto";
            var itemtrashto =  $(this).attr('data-field');
            var itemvarto =  $(this).attr('data-post');
            //var reMsjProd = $(this).attr("data-remsj");
            confiTrashItem(linkURL, nameProd, titleEv, msjProd, itemtrashto, itemvarto, emtyvalue, datafield);
        });
    });
    
    
    
            
});






    

