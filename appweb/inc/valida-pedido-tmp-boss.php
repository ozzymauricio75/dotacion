<?php
$sellerID = $idSSUser;

/*
============================
//PEDIDOS TEMPORALES EN PROCESO
===========================
*/

$orderTmp_acti = array();
$orderTmp_actiOne = array();
$dataProdListTmp = array();

function queryOrderTmp(){
    global $db;
    global $sellerID;

    $db->where ("id_account_user", $sellerID);
    $db->where ("estado_solicitud", 5);
    $db->orderBy("representante_empresa","asc");									
    $orderActiTmp = $db->get('solicitud_pedido_temp', null, 'id_solici_promo, id_account_user, id_account_empre, representante_empresa, estado_solicitud');    
    $resuOrderActiTmp = count($orderActiTmp);
    if ($resuOrderActiTmp > 0){
        foreach ($orderActiTmp as $orderTmpkey) { 
            $orderTmp_acti[] = $orderTmpkey;
        }    
        return $orderTmp_acti;
    }    
}

/*
============================
//ORDEN PEDIDO ACTUAL
===========================
*/



function queryOrderTmpNOW($idOrderTmp_){
    global $db;
    global $sellerID;
    
    $orderActiTmp = $db->subQuery ("o");
    $orderActiTmp->where ("id_account_user", $sellerID);
    $orderActiTmp->where ("id_solici_promo", $idOrderTmp_);    
    $orderActiTmp->get("solicitud_pedido_temp");

    $db->join($orderActiTmp, "o.id_solici_promo = epl.id_solici_promo");        
    $db->orderBy("epl.id_espci_kit_pedido","desc");
    $listprodTmp = $db->get ("especifica_kit_pedido epl", null, "o.representante_empresa, o.id_solici_promo, epl.id_espci_kit_pedido, epl.id_subcatego_producto");
    
    //SELECT `id_espci_kit_pedido`, `id_solici_promo`, `id_catego_prod`, `id_subcatego_producto`, `id_color`, `id_talla`, `cant_pedido`, `tipo_prenda` FROM `especifica_kit_pedido` WHERE 1
    
    
    //SELECT `id_subcatego_producto`, `id_catego_product`, `nome_subcatego_producto`, `descri_subcatego_prod`, `img_subcate_prod`, `nome_clean_subcatego_prod`, `tags_depatament_produsts`, `posi_sub_cate_prod`, `tipo_prenda` FROM `sub_categorias_productos` WHERE 1
    
    $db->join($listprodTmp, "prod.id_subcatego_producto = epl.id_subcatego_producto");        
    //$db->orderBy("epl.id_espci_prod_pedido","desc");
    $prodsOrderTmp = $db->get ("sub_categorias_productos prod", null, "epl.id_solici_promo, epl.id_espci_prod_pedido , epl.id_catego_product, epl.cant_pedido, epl.id_color, epl.id_talla, prod.id_subcatego_producto, prod.nome_subcatego_producto, prod.descri_subcatego_prod, prod.img_subcate_prod");
    $resuProdsOrderTmp = count($prodsOrderTmp);
    
    if ($resuProdsOrderTmp > 0){
        foreach ($prodsOrderTmp as $potkey) { 
            $dataProdListTmp[] = $potkey;
        }    
        return $dataProdListTmp;
    } 
    
    
    $resuListProdTmp = count($listprodTmp);
    if ($resuListProdTmp > 0){
        foreach ($listprodTmp as $lptkey) {             
            $orderTmp_actiOne[] = $lptkey;    
            /*$orderTmp_actiOne[] = array(
                'orderdeta' => $lptkey,
                'proddeta' => queryListProdOrder($lptkey['id_producto'])
            );*/
        }
        return $orderTmp_actiOne;
    }
    
     
}



/*
============================
//PEDIDOS TEMPORALES ACTIVADO ITEM
===========================
*/


function queryOrderTmpItem($idOrderTmp_, $idCategoProd_){
    global $db;
    global $sellerID;
    
    $orderActiTmp = $db->subQuery ("o");
    $orderActiTmp->where ("id_account_user", $sellerID);
    $orderActiTmp->where ("id_solici_promo", $idOrderTmp_);        
    $orderActiTmp->get("solicitud_pedido_temp");

    $db->join($orderActiTmp, "o.id_solici_promo = epl.id_solici_promo");  
    $db->where ("id_catego_prod", $idCategoProd_);
    $db->orderBy("epl.id_espci_prod_pedido","desc");
    $listprodTmp = $db->get ("especifica_prod_pedido epl", null, "o.representante_empresa, o.id_solici_promo, epl.id_espci_prod_pedido , epl.id_producto, epl.cant_pedido, epl.precio_costo, epl.id_catego_prod, epl.id_subcatego_producto");
    
    $resuListProdTmp = count($listprodTmp);
    if ($resuListProdTmp > 0){
        foreach ($listprodTmp as $lptkey) {             
            $orderTmp_actiOne[] = $lptkey;            
        }
        return $orderTmp_actiOne;
    }
  
}







/*
============================
//PEDIDOS TEMPORALES ACTIVADO GLOBAL
===========================
*/



function queryOrderTmpOne($idOrderTmp_){
    global $db;
    global $sellerID;
    
    $orderActiTmp = $db->subQuery ("o");
    $orderActiTmp->where ("id_account_empre", $sellerID);
    $orderActiTmp->where ("id_solici_promo", $idOrderTmp_);    
    $orderActiTmp->get("solicitud_pedido_temp");
    
    //SELECT `id_espci_kit_pedido`, `id_solici_promo`, `id_catego_prod`, `id_subcatego_producto`, `id_color`, `id_talla`, `cant_pedido`, `tipo_prenda` FROM `especifica_kit_pedido` WHERE 1

    $db->join($orderActiTmp, "o.id_solici_promo = epl.id_solici_promo");        
    $db->orderBy("epl.id_espci_kit_pedido","desc");
    $listprodTmp = $db->get ("especifica_kit_pedido epl", null, "o.id_account_empre, o.representante_empresa, o.id_solici_promo, o.id_account_user, o.cod_orden_compra, o.fecha_solicitud, epl.id_espci_kit_pedido, epl.id_catego_prod, epl.id_subcatego_producto, epl.cant_pedido, epl.id_color, epl.id_talla, epl.tipo_prenda");
    
    /*$orderTmp_actiOne['repre'] = $listprodTmp['representante_empresa'];
    $orderTmp_actiOne['idpedido'] = $listprodTmp['id_solici_promo'];
        
        queryListProdOrder($idProdList_)*/
    

    $resuListProdTmp = count($listprodTmp);
    if ($resuListProdTmp > 0){
        foreach ($listprodTmp as $lptkey) {             
            $orderTmp_actiOne[] = $lptkey;    
            /*$orderTmp_actiOne[] = array(
                'orderdeta' => $lptkey,
                'proddeta' => queryListProdOrder($lptkey['id_producto'])
            );*/
        }
        return $orderTmp_actiOne;
    }
    
    
    
    

    /*$db->where ("id_account_user", $sellerID);
    $db->where ("id_solici_promo", $idOrderTmp_);    
    $orderActiTmp = $db->get('solicitud_pedido_temp');    
    $resuOrderActiTmp = count($orderActiTmp);
    if ($resuOrderActiTmp > 0){
        foreach ($orderActiTmp as $orderTmpkey) { 
            $orderTmp_actiOne[] = $orderTmpkey;
        }    
        return $orderTmp_actiOne;
    } */   
}

/*$loqsea = array();
$loqsea = queryOrderTmpOne("114");
print_r($loqsea);*/


function queryListProdOrder($idProdList_){
    global $db;
    global $otNOW;
        
    $orderActiTmp = $db->subQuery ("epl");
    //$orderActiTmp->where ("id_account_user", $sellerID);
    $orderActiTmp->where ("id_solici_promo", $otNOW);    //
    $orderActiTmp->where ("id_subcatego_producto",$idProdList_ );    //
    $orderActiTmp->get("especifica_kit_pedido");
    
   //SELECT `id_subcatego_producto`, `id_catego_product`, `nome_subcatego_producto`, `descri_subcatego_prod`, `img_subcate_prod`, `nome_clean_subcatego_prod`, `tags_depatament_produsts`, `posi_sub_cate_prod`, `tipo_prenda` FROM `sub_categorias_productos` WHERE 1
    
    ////SELECT `id_espci_kit_pedido`, `id_solici_promo`, `id_catego_prod`, `id_subcatego_producto`, `id_color`, `id_talla`, `cant_pedido`, `tipo_prenda` FROM `especifica_kit_pedido` WHERE 1

    $db->join($orderActiTmp, "prod.id_subcatego_producto = epl.id_subcatego_producto");        
    //$db->orderBy("epl.id_espci_prod_pedido","desc");
    $prodsOrderTmp = $db->get ("sub_categorias_productos prod", null, "epl.id_espci_kit_pedido, epl.id_solici_promo, epl.id_color, epl.id_talla, epl.cant_pedido, epl.tipo_prenda, prod.id_catego_product, prod.id_subcatego_producto, prod.nome_subcatego_producto, prod.descri_subcatego_prod, prod.img_subcate_prod");
    $resuProdsOrderTmp = count($prodsOrderTmp);
    if ($resuProdsOrderTmp > 0){
        foreach ($prodsOrderTmp as $potkey) { 
            $dataProdListTmp[] = $potkey;
        }    
        return $dataProdListTmp;
    }  
    
    
    /*$orderActiTmp = $db->subQuery ("epl");
    //$orderActiTmp->where ("id_account_user", $sellerID);
    $orderActiTmp->where ("id_solici_promo", $otNOW);    
    $orderActiTmp->where ("id_producto", $idProdList_);    
    $orderActiTmp->get("especifica_prod_pedido");

    $db->join($orderActiTmp, "prod.id_producto = epl.id_producto");        
    //$db->orderBy("epl.id_espci_prod_pedido","desc");
    $prodsOrderTmp = $db->get ("productos prod", null, "epl.id_solici_promo, epl.id_espci_prod_pedido , epl.id_producto, epl.cant_pedido, epl.precio_costo, epl.precio_venta, epl.subtotal_list, prod.id_producto, prod.cod_venta_prod, prod.stock, prod.nome_producto, prod.foto_producto, prod.precio_producto");
    $resuProdsOrderTmp = count($prodsOrderTmp);
    if ($resuProdsOrderTmp > 0){
        foreach ($prodsOrderTmp as $potkey) { 
            $dataProdListTmp[] = $potkey;
        }    
        return $dataProdListTmp;
    }  */
    
}    
    
/*
============================
//PRINT ORDER DE PEDIDO
===========================
*/

/*
LISTA DE PEDIDOS EN PROCESO
*/
$cantOrderTmp = array();
$cantOrderTmp = queryOrderTmp();
$totalCantOrderTmp = 0;
if(is_array($cantOrderTmp)){
    $totalCantOrderTmp = count($cantOrderTmp);
}
    
function printOrderListTmp(){
    global $pathmm;
    $printOrderTmp = array();
    $printOrderTmp = queryOrderTmp();
    $listPedidosTmpl = "";
    global $takeOrderDir;
    
    if(is_array($printOrderTmp)){
        foreach($printOrderTmp as $potKey){

            $idOrderTmp = $potKey['id_solici_promo'];
            $clienteOrderTmp = $potKey['representante_empresa'];
 
            $listPedidosTmpl .= "<li>";    
            $listPedidosTmpl .= "<a href='".$pathmm.$takeOrderDir."/browse/?orderdelet=ok&ordernow=".$idOrderTmp."' class='cancelOrder trashtobtn' name='".$clienteOrderTmp."' title='Cancelar pedido' data-msj='Estas seguro que deseas eliminar este pedido?'><i class='fa fa-trash fa-lg'></i></a>";
            $listPedidosTmpl .= "<a href='".$pathmm.$takeOrderDir."/browse/?otmp=".$idOrderTmp."'>";
            $listPedidosTmpl .= "<i class='fa fa-user text-aqua margin-hori-xs'></i> ".$clienteOrderTmp;
            $listPedidosTmpl .= "</a>";
            $listPedidosTmpl .= "</li>";

        }
        return $listPedidosTmpl;
    }
    

}// fin function printOrderListTmp()


/*
LISTA DE PRODUCTOS PEDIDO ACTIVADO
*/


//INFO PEDIDO
$db->where ("id_solici_promo", $otNOW);    
$listprodTmp = $db->getOne ("solicitud_pedido_temp", "representante_empresa, id_solici_promo, id_account_empre");
$idClienteOrderNow = $listprodTmp['id_account_empre'];
$idOrderNow = $listprodTmp['id_solici_promo'];
$nomeClienteOrder = $listprodTmp['representante_empresa'];

//LAYOUT HEAD CLIENTE ACTIVO
$headClienteActi_tmpl = "";
if(isset($otNOW) && $otNOW != ""){    
    $headClienteActi_tmpl .= "<div class='row margin-bottom-xs bg-black headClienteActi'>";
    $headClienteActi_tmpl .= "<div class='media maxwidth-layout padd-verti-xs padd-hori-md'>";
    $headClienteActi_tmpl .= "<div class='media-left '>";
    $headClienteActi_tmpl .= "<span class='fa-stack fa-lg'>";
    $headClienteActi_tmpl .= "<i class='fa fa-circle fa-stack-2x'></i>";
    $headClienteActi_tmpl .= "<i class='fa fa-user fa-stack-1x text-black'></i>";
    $headClienteActi_tmpl .= "</span>";
    $headClienteActi_tmpl .= "</div>";
    $headClienteActi_tmpl .= "<div class='media-body media-middle'>";
    //$headClienteActi_tmpl .= "<a href='?orderdelet=ok&ordernow=".$otNOW."' class='cancelOrder trashtobtn' name='".$nomeClienteOrder."' title='Cancelar pedido' data-msj='Estas seguro que deseas eliminar este pedido?'><i class='fa fa-trash fa-lg'></i></a>";
    $headClienteActi_tmpl .= "<h4 class='media-heading'>".$nomeClienteOrder;    
    $headClienteActi_tmpl .= "<span class='media-object' style='color:#cfcfcf; font-size:0.9112132em;'>".$companySSUser."&nbsp;&nbsp;-&nbsp;&nbsp;".$cityCompanySSUser."</span>";    
    $headClienteActi_tmpl .= "</h4>";    
    $headClienteActi_tmpl .= "</div>";
    $headClienteActi_tmpl .= "</div>";
    $headClienteActi_tmpl .= "</div>";
}



//LISTA PRODUCTOS
function printProdsListTmp($idOrderTmp_){
    global $db;
    global $pathmm;
    $prodList = array();
    $pathFileNoPicture = $pathmm."img/nopicture.png";


    $prodList = queryListProdOrder($idOrderTmp_);
    $prodListTmpl = "";
    
    $subTotalTO = 0;

    foreach($prodList as $iplotemKey){
        
        //epl.id_solici_promo, epl.id_espci_prod_pedido, epl.id_color, epl.id_talla, epl.cant_pedido, epl.tipo_prenda, prod.id_subcatego_producto, prod.nome_subcatego_producto, prod.descri_subcatego_prod, prod.img_subcate_prod
        
        $idOrderTmpItem = $iplotemKey['id_espci_kit_pedido'];
        $idProdItem = $iplotemKey['id_subcatego_producto'];
        //$SKUProdItem = $iplotemKey['cod_venta_prod_filing'];
        $nomeProdItem = $iplotemKey['nome_subcatego_producto'];
        //$costoProdItem = $iplotemKey['precio_producto'];
        $labelProdItem = $iplotemKey['img_subcate_prod'];
        $descriRefProdItem = $iplotemKey['descri_subcatego_prod'];
        
        $idcateTmpItem = $iplotemKey['id_catego_product'];
                
        $idColorItem = $iplotemKey['id_color'];
        $tipoPrendaItem = $iplotemKey['tipo_prenda'];
        $idTallaItem = $iplotemKey['id_talla'];
        
        $cantProdItem = $iplotemKey['cant_pedido'];
        //$ventaProdItem = number_format($iplotemKey['precio_venta'],2,",",".");
        //$subTotalProdItem = number_format($iplotemKey['subtotal_list'],2,",",".");
        
        //$subTotalTO += $subTotalProdItem;
        //$precioVentaItem = $iplotemKey['precio_venta'];
        //$subTotalSumatoria = $iplotemKey['subtotal_list'];
                        
        //COLOR   
        //SELECT `id_color`, `nome_color`, `color_hexa` FROM `tipo_color` WHERE 1        
        $db->where ("id_color", $idColorItem);    
        $colorQ = $db->getOne ("tipo_color", "id_color, nome_color, color_hexa");
        $nameColor = $colorQ['nome_color'];
        $hexaColor = $colorQ['color_hexa'];
        
        //TALLA   
        //SELECT `id_talla_numer`, `talla_numer`, `posi_talla` FROM `talla_numerico` WHERE 1
        //SELECT `id_talla_letras`, `nome_talla_letras`, `posi_talla` FROM `talla_letras` WHERE 1
        if($tipoPrendaItem == "tl"){
            $db->where ("id_talla_letras", $idTallaItem);    
            $tallaQ = $db->getOne ("talla_letras", "nome_talla_letras");
            $nameTalla = $tallaQ['nome_talla_letras'];            
        }elseif($tipoPrendaItem == "tn"){
            $db->where ("id_talla_numer", $idTallaItem);    
            $tallaQ = $db->getOne ("talla_numerico", "talla_numer");
            $nameTalla = $tallaQ['talla_numer'];
        }
        
        //CATEGORIA - KIT
        //SELECT `id_catego_product`, `id_depart_prod`, `nome_catego_product`, `descri_catego_prod`, `tags_depatament_produsts`, `tipo_kit_4user` FROM `categorias_productos` WHERE 1
        $db->where ("id_catego_product", $idcateTmpItem);    
        $kitQ = $db->getOne ("categorias_productos", "id_catego_product, nome_catego_product, descri_catego_prod, tipo_kit_4user, tags_depatament_produsts");
        $nameKit = $kitQ['nome_catego_product'];  
        $descriKit = $kitQ['descri_catego_prod'];  
        $tipoKit = $kitQ['tipo_kit_4user']; 
        $tagCateTmpItem = $kitQ['tags_depatament_produsts']; 
        $tagKitFormat = "<span style='text-transform: uppercase;'>".$tagCateTmpItem."</span>"; 
        $tipoKitFormat = "<span style='text-transform: capitalize;'>".$tipoKit."</span>";
                                           

        $pathPortadaItemOrder = "../../files-display/tienda/img-catego/".$labelProdItem;

        if (file_exists($pathPortadaItemOrder)) {
            $portadaFileItemOrder = $pathPortadaItemOrder;
        } else {
            $portadaFileItemOrder = $pathFileNoPicture;
        }

        //layaout item pedido
        $prodListTmpl .="<div class='control-sidebar-itemoreder' id='wrapitemplto".$idOrderTmpItem."'>";

        $prodListTmpl .="<div class='control-sidebar-itemoreder-left'>";
        $prodListTmpl .="<a href='#'>";
        $prodListTmpl .="<img class='control-sidebar-itemoreder-object' src='".$portadaFileItemOrder."' alt=''>";
        $prodListTmpl .="</a>";
        $prodListTmpl .="</div>";

        $prodListTmpl .="<div class='control-sidebar-itemoreder-body'>";
        $prodListTmpl .="<div class='row itemorder-top'>";                    
        $prodListTmpl .="<a class='btn control-sidebar-itemoreder-deleteitem deleteitempto' data-post='".$idOrderTmpItem."' data-field='cpe".$idOrderTmpItem."' type='button' name='".$nomeProdItem."' title='Eliminar item' data-msj='Deseas eliminar este producto de tu lista de pedido?'><i class='fa fa-times'></i></a>";
        $prodListTmpl .="<h4 class='control-sidebar-itemoreder-ref'>".$nomeProdItem;
        //$prodListTmpl .="<small>".$descriRefProdItem."</small>";                                        
        $prodListTmpl .="</h4>";
        $prodListTmpl .="</div>";
                
        $prodListTmpl .="<div class='row itemorder-down'>";
        $prodListTmpl .="<div class='col-xs-12 '>";
        $prodListTmpl .="<p style='font-size:13px;''>";
        $prodListTmpl .= "<strong>".$tagKitFormat."&nbsp; ".$tipoKitFormat."&nbsp;</strong><br/>";
        $prodListTmpl .= $nameKit."&nbsp;".$descriKit."&nbsp;<br/>Talla: ".$nameTalla."&nbsp;Color: ".$nameColor;
        $prodListTmpl .="</p>";
        $prodListTmpl .="</div>";//col-xs-4

        $prodListTmpl .="<div class='col-xs-12 '>";
        $prodListTmpl .="<div class='input-group'>";
        $prodListTmpl .="<input type='text' class='cpe form-control' name='cantlistpot".$idOrderTmpItem."' data-field='cpe".$idOrderTmpItem."' data-post='".$idOrderTmpItem."' value='".$cantProdItem."'  >";
        $prodListTmpl .="<span class='input-group-addon'>UNID.</span></div></div>";//col-xs-4

        /*$prodListTmpl .="<div class='col-xs-4 unlateralpadding'>";
        $prodListTmpl .="<span class='control-sidebar-itemoreder-unitprice'>$ ".$ventaProdItem."</span>";
        $prodListTmpl .="</div>";//col-xs-6

        $prodListTmpl .="<div class='col-xs-5 unlateralpadding'>";
        $prodListTmpl .="<span class='control-sidebar-itemoreder-price'>$ ".$subTotalProdItem."</span>";
        $prodListTmpl .="<input type='hidden' class='subTotalTO' name='subTotalTO' value='".$subTotalSumatoria."'>";
        //$prodListTmpl .="<a href='' class='control-sidebar-itemoreder-deleteitem'><i class='fa fa-times'></i></a>"; 
        $prodListTmpl .="</div>";//col-xs-2*/ 

        $prodListTmpl .="</div>";//itemorder-down
        $prodListTmpl .="<div id='errwrapitemplto".$idOrderTmpItem."'></div>";

        $prodListTmpl .="</div>";//control-sidebar-itemoreder-body
        $prodListTmpl .="</div>";//control-sidebar-itemoreder    
    }

    return $prodListTmpl;                            
        
}// fin function printOrderListTmp()




//IMPRIME LAST ITEM ADD
function printLastItemAdd($idLastItemAdd_){
    global $db;
    global $pathmm;
    global $otNOW;
                    
    $prodList = array();
    $pathFileNoPicture = $pathmm."img/nopicture.png";
    
        
    $orderActiTmp = $db->subQuery ("epl");
    //$orderActiTmp->where ("id_account_user", $sellerID);
    $orderActiTmp->where ("id_solici_promo", $otNOW);    //
    $orderActiTmp->where ("id_espci_kit_pedido",$idLastItemAdd_ );    //
    $orderActiTmp->get("especifica_kit_pedido");
       
    $db->join($orderActiTmp, "prod.id_subcatego_producto = epl.id_subcatego_producto");        
    //$db->orderBy("epl.id_espci_prod_pedido","desc");
    $prodsOrderTmp = $db->get ("sub_categorias_productos prod", 1, "epl.id_espci_kit_pedido, epl.id_solici_promo, epl.id_color, epl.id_talla, epl.cant_pedido, epl.tipo_prenda, prod.id_catego_product, prod.id_subcatego_producto, prod.nome_subcatego_producto, prod.descri_subcatego_prod, prod.img_subcate_prod");
    /*$resuProdsOrderTmp = count($prodsOrderTmp);
    if ($resuProdsOrderTmp > 0){
        foreach ($prodsOrderTmp as $potkey) { 
            $prodList[] = $potkey;
        }    
        //return $dataProdListTmp;
    } */


    //$prodList = queryListProdOrder($idOrderTmp_);
    $prodListTmpl = "";
    
    $subTotalTO = 0;

    foreach($prodsOrderTmp as $iplotemKey){
        
        //epl.id_solici_promo, epl.id_espci_prod_pedido, epl.id_color, epl.id_talla, epl.cant_pedido, epl.tipo_prenda, prod.id_subcatego_producto, prod.nome_subcatego_producto, prod.descri_subcatego_prod, prod.img_subcate_prod
        
        $idOrderTmpItem = $iplotemKey['id_espci_kit_pedido'];
        $idProdItem = $iplotemKey['id_subcatego_producto'];
        //$SKUProdItem = $iplotemKey['cod_venta_prod_filing'];
        $nomeProdItem = $iplotemKey['nome_subcatego_producto'];
        //$costoProdItem = $iplotemKey['precio_producto'];
        $labelProdItem = $iplotemKey['img_subcate_prod'];
        $descriRefProdItem = $iplotemKey['descri_subcatego_prod'];
        
        $idcateTmpItem = $iplotemKey['id_catego_product'];
                
        $idColorItem = $iplotemKey['id_color'];
        $tipoPrendaItem = $iplotemKey['tipo_prenda'];
        $idTallaItem = $iplotemKey['id_talla'];
        
        $cantProdItem = $iplotemKey['cant_pedido'];
        //$ventaProdItem = number_format($iplotemKey['precio_venta'],2,",",".");
        //$subTotalProdItem = number_format($iplotemKey['subtotal_list'],2,",",".");
        
        //$subTotalTO += $subTotalProdItem;
        //$precioVentaItem = $iplotemKey['precio_venta'];
        //$subTotalSumatoria = $iplotemKey['subtotal_list'];
                        
        //COLOR   
        //SELECT `id_color`, `nome_color`, `color_hexa` FROM `tipo_color` WHERE 1        
        $db->where ("id_color", $idColorItem);    
        $colorQ = $db->getOne ("tipo_color", "id_color, nome_color, color_hexa");
        $nameColor = $colorQ['nome_color'];
        $hexaColor = $colorQ['color_hexa'];
        
        //TALLA   
        //SELECT `id_talla_numer`, `talla_numer`, `posi_talla` FROM `talla_numerico` WHERE 1
        //SELECT `id_talla_letras`, `nome_talla_letras`, `posi_talla` FROM `talla_letras` WHERE 1
        if($tipoPrendaItem == "tl"){
            $db->where ("id_talla_letras", $idTallaItem);    
            $tallaQ = $db->getOne ("talla_letras", "nome_talla_letras");
            $nameTalla = $tallaQ['nome_talla_letras'];            
        }elseif($tipoPrendaItem == "tn"){
            $db->where ("id_talla_numer", $idTallaItem);    
            $tallaQ = $db->getOne ("talla_numerico", "talla_numer");
            $nameTalla = $tallaQ['talla_numer'];
        }
        
        //CATEGORIA - KIT
        //SELECT `id_catego_product`, `id_depart_prod`, `nome_catego_product`, `descri_catego_prod`, `tags_depatament_produsts`, `tipo_kit_4user` FROM `categorias_productos` WHERE 1
        $db->where ("id_catego_product", $idcateTmpItem);    
        $kitQ = $db->getOne ("categorias_productos", "id_catego_product, nome_catego_product, descri_catego_prod, tipo_kit_4user, tags_depatament_produsts");
        $nameKit = $kitQ['nome_catego_product'];  
        $descriKit = $kitQ['descri_catego_prod'];  
        $tipoKit = $kitQ['tipo_kit_4user']; 
        $tagCateTmpItem = $kitQ['tags_depatament_produsts']; 
        $tagKitFormat = "<span style='text-transform: uppercase;'>".$tagCateTmpItem."</span>"; 
        $tipoKitFormat = "<span style='text-transform: capitalize;'>".$tipoKit."</span>";
                                           

        $pathPortadaItemOrder = "../../files-display/tienda/img-catego/".$labelProdItem;

        if (file_exists($pathPortadaItemOrder)) {
            $portadaFileItemOrder = $pathPortadaItemOrder;
        } else {
            $portadaFileItemOrder = $pathFileNoPicture;
        }

        //layaout item pedido
        $prodListTmpl .="<div class='control-sidebar-itemoreder' id='wrapitemplto".$idOrderTmpItem."'>";

        $prodListTmpl .="<div class='control-sidebar-itemoreder-left'>";
        $prodListTmpl .="<a href='#'>";
        $prodListTmpl .="<img class='control-sidebar-itemoreder-object' src='".$portadaFileItemOrder."' alt=''>";
        $prodListTmpl .="</a>";
        $prodListTmpl .="</div>";

        $prodListTmpl .="<div class='control-sidebar-itemoreder-body'>";
        $prodListTmpl .="<div class='row itemorder-top'>";                    
        $prodListTmpl .="<a class='btn control-sidebar-itemoreder-deleteitem deleteitempto' data-post='".$idOrderTmpItem."' data-field='cpe".$idOrderTmpItem."' type='button' name='".$nomeProdItem."' title='Eliminar item' data-msj='Deseas eliminar este producto de tu lista de pedido?'><i class='fa fa-times'></i></a>";
        $prodListTmpl .="<h4 class='control-sidebar-itemoreder-ref'>".$nomeProdItem;
        //$prodListTmpl .="<small>".$descriRefProdItem."</small>";                                        
        $prodListTmpl .="</h4>";
        $prodListTmpl .="</div>";
                
        $prodListTmpl .="<div class='row itemorder-down'>";
        $prodListTmpl .="<div class='col-xs-12 '>";
        $prodListTmpl .="<p style='font-size:13px;''>";
        $prodListTmpl .= "<strong>".$tagKitFormat."&nbsp; ".$tipoKitFormat."&nbsp;</strong><br/>";
        $prodListTmpl .= $nameKit."&nbsp;".$descriKit."&nbsp;<br/>Talla: ".$nameTalla."&nbsp;Color: ".$nameColor;
        $prodListTmpl .="</p>";
        $prodListTmpl .="</div>";//col-xs-4

        $prodListTmpl .="<div class='col-xs-12 '>";
        $prodListTmpl .="<div class='input-group'>";
        $prodListTmpl .="<input type='text' class='cpe form-control' name='cantlistpot".$idOrderTmpItem."' data-field='cpe".$idOrderTmpItem."' data-post='".$idOrderTmpItem."' value='".$cantProdItem."'  >";
        $prodListTmpl .="<span class='input-group-addon'>UNID.</span></div></div>";//col-xs-4

        /*$prodListTmpl .="<div class='col-xs-4 unlateralpadding'>";
        $prodListTmpl .="<span class='control-sidebar-itemoreder-unitprice'>$ ".$ventaProdItem."</span>";
        $prodListTmpl .="</div>";//col-xs-6

        $prodListTmpl .="<div class='col-xs-5 unlateralpadding'>";
        $prodListTmpl .="<span class='control-sidebar-itemoreder-price'>$ ".$subTotalProdItem."</span>";
        $prodListTmpl .="<input type='hidden' class='subTotalTO' name='subTotalTO' value='".$subTotalSumatoria."'>";
        //$prodListTmpl .="<a href='' class='control-sidebar-itemoreder-deleteitem'><i class='fa fa-times'></i></a>"; 
        $prodListTmpl .="</div>";//col-xs-2*/ 

        $prodListTmpl .="</div>";//itemorder-down
        $prodListTmpl .="<div id='errwrapitemplto".$idOrderTmpItem."'></div>";

        $prodListTmpl .="</div>";//control-sidebar-itemoreder-body
        $prodListTmpl .="</div>";//control-sidebar-itemoreder    
    }

    return $prodListTmpl; 
        
}//IMPRIME LAST ITEM ADD

/*
============================
//CANCEL - ELIMINA ORDER DE PEDIDO
===========================
*/ 
$codTrashOrderTmp = (!isset($_GET['orderdelet']))? "" : $_GET['orderdelet'];
$idOrderTmp = (!isset($_GET['ordernow']))? "" : $_GET['ordernow'];
$errValidaTrashOrder = "";
$statusTrashOrder = "";

/*
$idDeleteList = $_GET['varProd'];
	
	if(isset($_SESSION['car'][$idDeleteList])){
		unset($_SESSION['car'][$idDeleteList]);
	}
*/

if(isset($codTrashOrderTmp) && $codTrashOrderTmp == "ok"){
    $idOrderTmp = $db->escape($idOrderTmp); 
    
    $checkID = validaInteger($idOrderTmp, $idOrderTmp);
    
    if($checkID === true){
        
         //INFO LISTA PEDIDO
        $listPedidoTO = queryOrderTmpOne($idOrderTmp);
        
        if(is_array($listPedidoTO) && count($listPedidoTO)>0){

            $db->where('id_solici_promo', $idOrderTmp);
            $trassListOrder = $db->delete('especifica_prod_pedido');
            if($trassListOrder){

                $db->where('id_solici_promo', $idOrderTmp);
                $trashOrderTmp = $db->delete('solicitud_pedido_temp');

                unset($_SESSION['carin']);

                if($trashOrderTmp){

                    $statusTrashOrder = $takeOrderDir."/browse/?trashto=ok"; 
                    gotoRedirect($statusTrashOrder);

                }else{
                    $erroOrderTmp = $db->getLastError();

                    $errValidaTrashOrder .= "<section class='box50 padd-verti-xs'>";
                    $errValidaTrashOrder .= "<ul class='list-group text-left'>";
                    $errValidaTrashOrder .= "<li class='list-group-item list-group-item-danger'><b>Algo salio mal</b>
                        <br>Opciones:
                        <br>Error: ".$erroOrderTmp ."
                        <br>Puedes intentarlo de nuevo
                        <br>Si el error continua, por favor contacta con soporte</li>";
                    $errValidaTrashOrder .= "</ul>";
                    $errValidaTrashOrder .= "</section>";

                }
            }else{
                $erroTrassListOrder = $db->getLastError();

                $errValidaTrashOrder .= "<section class='box50 padd-verti-xs'>";
                $errValidaTrashOrder .= "<ul class='list-group text-left'>";
                $errValidaTrashOrder .= "<li class='list-group-item list-group-item-danger'><b>Algo salio mal</b>
                    <br>Opciones:
                    <br>Error: ".$erroTrassListOrder."
                    <br>Puedes intentarlo de nuevo
                    <br>Si el error continua, por favor contacta con soporte</li>";
                $errValidaTrashOrder .= "</ul>";
                $errValidaTrashOrder .= "</section>";
            }
        }else{
            $db->where('id_solici_promo', $idOrderTmp);
            $trashOrderTmp = $db->delete('solicitud_pedido_temp');

            unset($_SESSION['carin']);

            if($trashOrderTmp){

                $statusTrashOrder = $takeOrderDir."/browse/?trashto=ok"; 
                gotoRedirect($statusTrashOrder);

            }else{
                $erroOrderTmp = $db->getLastError();

                $errValidaTrashOrder .= "<section class='box50 padd-verti-xs'>";
                $errValidaTrashOrder .= "<ul class='list-group text-left'>";
                $errValidaTrashOrder .= "<li class='list-group-item list-group-item-danger'><b>Algo salio mal</b>
                    <br>Opciones:
                    <br>Error: ".$erroOrderTmp ."
                    <br>Puedes intentarlo de nuevo
                    <br>Si el error continua, por favor contacta con soporte</li>";
                $errValidaTrashOrder .= "</ul>";
                $errValidaTrashOrder .= "</section>";

            }
            
        }
                           
    }else{
        $tituERR = "CANCELAR PEDIDO";
        $ruleERR = "Debes ingresar un Cod. Pedido Valido";
        $exERR = "";                
        $errValidaTrashOrder .= printErrValida($checkID, $tituERR, $ruleERR, $exERR);
    }            
}

$trashOrderOK = "";

if(isset($_GET['trashto']) && $_GET['trashto'] =="ok"){ 
    $trashOrderOK .="<div class='box50 padd-top-md'>";
    $trashOrderOK .="<div class='alert alert-success alert-dismissible' role='alert'>";
    $trashOrderOK .="<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
    $trashOrderOK .="<strong>Pedido eliminado correctamente</strong>";
    $trashOrderOK .="<div class='margin-verti-xs text-center'> <a href='".$pathmm.$takeOrderDir."/client/' class='btn btn-social btn-success' type='button' style='text-decoration:none;'><i class='fa fa-check'></i> Crear otro pedido</a></div>";
    $trashOrderOK .="</div>";//alert
    $trashOrderOK .="</div>";//box50       
}




/*
============================
//ENVIAR PEDIDO
===========================
*/ 
$codSendOrderTmp = (!isset($_GET['ordersend']))? "" : $_GET['ordersend'];
$idOrderTmp = (!isset($_GET['ordernow']))? "" : $_GET['ordernow'];
$errValidaSendOrder = "";
$statusSendOrder = "";

/*
$idDeleteList = $_GET['varProd'];
	
	if(isset($_SESSION['car'][$idDeleteList])){
		unset($_SESSION['car'][$idDeleteList]);
	}
*/
$statusSendOrder = "";
if(isset($codSendOrderTmp) && $codSendOrderTmp == "ok"){
    
    $idOrderTmp = $db->escape($idOrderTmp);     
    $checkID = validaInteger($idOrderTmp, $idOrderTmp);
    
    if($checkID === true){
        
        //INFO LISTA PEDIDO
        $listPedidoTO = queryOrderTmpOne($idOrderTmp);
        
        if(is_array($listPedidoTO) && count($listPedidoTO)>0){
        
            //INFO ORDER TEMPORAL
            //SELECT 'id_solici_promo', 'id_account_empre', 'cod_orden_compra', 'cod_promocional', 'nome_cliente', 'tel_cliente', 'mail_cliente', 'nome_empresa', 'representante_empresa', 'tel_empresa', 'cel_cliente', 'ciudad_empresa', 'dire_empresa', 'cc_nit_empresa', 'precio_venta_pedido', 'comision_venta', 'tipo_promocion', 'fecha_solicitud', 'hora_solicitud', 'ciudad_solicitud', 'id_account_user', 'estado_solicitud', 'metod_pago' FROM 'solicitud_pedido_temp'
            $db->where('id_solici_promo', $idOrderTmp);
            $orderTempDB = $db->getOne('solicitud_pedido_temp', 'id_solici_promo, id_account_empre, cod_orden_compra, id_account_user');
            
            $idTemOrder = $orderTempDB['id_solici_promo'];
            $idClienteTemOrder = $orderTempDB['id_account_empre'];
            $codPedidoTemOrder = $orderTempDB['cod_orden_compra'];
            $idVendedorTemOrder = $orderTempDB['id_account_user'];   
            
            
            //INFO USUARIO
            //SELECT `id_account_user`, `id_account_empre`, `account_pseudo_user`, `cedula_user`, `nombre_account_user`, `mail_account_user`, `pass_account_user`, `tel_account_user`, `tel_account_user2`, `dir_account_user`, `ciudad_account_user`, `estado_account_user`, `pais_account_user`, `fecha_alta_account_user`, `foto_user`, `coleccion_user`, `tipo_kit_user`, `estado_cuenta` FROM `account_user` WHERE 1
            $db->where('id_account_empre', $idClienteTemOrder);
            $clienteDB = $db->getOne('account_empresa', 'id_account_empre, nombre_account_empre, nit_empresa, mail_account_empre, tel_account_empre1, tel_account_empre2, dir_account_empre, ciudad_account_empre, nome_representante');

            $nameEmpresa = $clienteDB['nombre_account_empre'];
            $identiEmpresa = $clienteDB['nit_empresa'];
            $emailEmpresa = $clienteDB['mail_account_empre'];
            $tel1Empresa = $clienteDB['tel_account_empre1'];
            $tel2Empresa = $clienteDB['tel_account_empre2'];
            $dirEmpresa = $clienteDB['dir_account_empre'];
            $cityEmpresa = $clienteDB['ciudad_account_empre'];        
            $representanteEmpresa = $clienteDB['nome_representante'];
            
            
            

            /*$idTemOrder = $orderTempDB['id_solici_promo'];
            $idClienteTemOrder = $orderTempDB['id_account_empre'];
            $codPedidoTemOrder = $orderTempDB['cod_orden_compra'];
            $idVendedorTemOrder = $orderTempDB['id_account_user'];*/


            //INFO EMPRESA
            //'id_account_empre', 'id_mb_account_empre', 'id_account_user', 'nombre_account_empre', 'nit_empresa', 'categoria_account_empre', 'logo_account_empre', 'descri_account_empre', 'serv_prod_empre', 'mail_account_empre', 'pass_account_empre', 'tel_account_empre1', 'tel_account_empre2', 'keys_empre', 'dhaten_empre', 'tt_account_empre', 'fb_account_empre', 'ms_account_empre', 'skype_account_empre', 'yt_account_empre', 'url_empre', 'otraciudad_account_empre', 'dir_account_empre', 'ciudad_account_empre', 'pais_account_empre', 'maps_empresa', 'url_maps_empres', 'fecha_alta_empresa', 'nome_representante', 'comentarios_empresa', 'id_estado'
            /*$db->where('id_account_empre', $idClienteTemOrder);
            $clienteDB = $db->getOne('account_empresa', 'id_account_empre, nombre_account_empre, nit_empresa, mail_account_empre, tel_account_empre1, tel_account_empre2, dir_account_empre, ciudad_account_empre, nome_representante');

            $nomeEmpresa = $clienteDB['nombre_account_empre'];
            $identiEmpresa = $clienteDB['nit_empresa'];
            $emailEmpresa = $clienteDB['mail_account_empre'];
            $tel1Empresa = $clienteDB['tel_account_empre1'];
            $tel2Empresa = $clienteDB['tel_account_empre2'];
            $dirEmpresa = $clienteDB['dir_account_empre'];
            $cityEmpresa = $clienteDB['ciudad_account_empre'];        
            $representanteEmpresa = $clienteDB['nome_representante'];*/


            //INFO VENDEDOR
            //'id_account_user', 'id_mb_account_seller', 'account_pseudo_seller', 'cedula_seller', 'nombre_account_seller', 'mail_account_seller', 'pass_account_seller', 'tel_account_seller', 'tel_account_seller2', 'dir_account_seller', 'ciudad_account_seller', 'estado_account_seller', 'pais_account_seller', 'fecha_alta_account_seller', 'foto_seller', 'comsion_vende', 'cuenta_banco', 'tipo_cuenta_banco', 'banco', 'titular_cuenta', 'estado_cuenta'

            //DEFINE DATES
            //$timeStamp;
            //$dateFormatDB;
            //$horaFormatDB;
                       
            $orderSendDatas = array(
                'id_solici_promo' => $idTemOrder,
                'id_account_empre' => $idClienteTemOrder,
                'cod_orden_compra' => $codPedidoTemOrder,
                'nome_cliente' => $representanteEmpresa,            
                'mail_cliente' => $emailEmpresa,
                'nome_empresa' => $nameEmpresa,
                'tel_empresa' => $tel1Empresa,
                'cel_cliente' => $tel1Empresa,
                'ciudad_solicitud' => $cityCompanySSUser,
                'dire_empresa' => $dirEmpresa,
                'cc_nit_empresa' => $identiEmpresa,
                /*'precio_venta_pedido' => ,
                'comision_venta' => ,
                'tipo_promocion' => ,*/
                'fecha_solicitud'=> $dateFormatDB,
                'hora_solicitud' => $horaFormatDB,
                'datetime_publi' => $timeStamp,
                'id_account_user' => $idVendedorTemOrder
            );
                        
            $idOrderSend = $db->insert('solicitud_pedido', $orderSendDatas);

            if($idOrderSend){
                
//                //edita estatus orden temporal
//                $orderTmpFinish = Array (
//                    'estado_solicitud' => 1
//                );
//                
//                $db->where ('id_solici_promo', $idTemOrder);
//                if ($db->update ('solicitud_pedido_temp', $orderTmpFinish)){
//                    
//                    //suspende acceso de usuario
//                    $userSuspend = Array ('estado_cuenta' => 2);
//
//                    $db->where ('id_account_user', $idVendedorTemOrder);
//                    if ($db->update ('account_user', $userSuspend)){
//                        unset($_SESSION['carin']);
                        
                        $statusSendOrder = $bossDir."/send/?readysend=ok";//$takeOrderDir."/statusok/"; 
                        gotoRedirect($statusSendOrder);    
                    /*}                                    
                }    */                            
                
            }else{
                $erroSendOrderTmp = $db->getLastError();

                $errValidaSendOrder .= "<section class='box50 padd-verti-xs'>";
                $errValidaSendOrder .= "<ul class='list-group text-left'>";
                $errValidaSendOrder .= "<li class='list-group-item list-group-item-danger'><b>Algo salio mal</b>
                    <br>Opciones:
                    <br>Error: ".$erroSendOrderTmp ."
                    <br>Puedes intentarlo de nuevo
                    <br>Si el error continua, por favor contacta con soporte</li>";
                $errValidaSendOrder .= "</ul>";
                $errValidaSendOrder .= "</section>";
            }
        }else{
            $errValidaSendOrder .= "<section class='box50 padd-verti-xs'>";
            $errValidaSendOrder .= "<ul class='list-group text-left'>";
            $errValidaSendOrder .= "<li class='list-group-item list-group-item-danger'><b>CERO ITEMS</b>                
                <br>Opciones:
                <br>Debes seleccionar almenos un producto para enviar un pedido
                <br>Puedes intentarlo de nuevo
                <br>Si el error continua, por favor contacta con soporte</li>";
            $errValidaSendOrder .= "</ul>";
            $errValidaSendOrder .= "</section>";    
        }
                                          
    }else{
        $tituERR = "CANCELAR PEDIDO";
        $ruleERR = "Debes ingresar un Cod. Pedido Valido";
        $exERR = "";                
        $errValidaSendOrder .= printErrValida($checkID, $tituERR, $ruleERR, $exERR);
    }            
}

$sendOrderOK = "";

if(isset($_GET['sendto']) && $_GET['sendto'] =="ok"){ 
    $sendOrderOK .="<div class='box50 padd-top-md'>";
    $sendOrderOK .="<div class='alert alert-success alert-dismissible' role='alert'>"; 
    $sendOrderOK .="<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
    $sendOrderOK .="<strong>Pedido enviado correctamente</strong>";
    $sendOrderOK .="<div class='margin-verti-xs text-center'> <a href='".$pathmm.$takeOrderDir."/client/' class='btn btn-social btn-success' type='button' style='text-decoration:none;'><i class='fa fa-check'></i> Crear otro pedido</a></div>";
    $sendOrderOK .="</div>";//alert
    $sendOrderOK .="</div>";//box50       
}

