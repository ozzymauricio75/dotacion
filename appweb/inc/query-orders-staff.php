<?php 

/*
 *==================================
 *QUERY STAFF
 *==================================
*/

//SELECT `id_account_empre`, `id_estado`, `ref_account_empre`, `nombre_account_empre`, `nit_empresa`, `logo_account_empre`, `mail_account_empre`, `pseudo_user_empresa`, `pass_account_empre`, `tel_account_empre1`, `tel_account_empre2`, `url_empre`, `dir_account_empre`, `ciudad_account_empre`, `pais_account_empre`, `nome_representante`, `cargo_repre_empresa`, `comentarios_empresa`, `recibe_order`, `cargo_recibe_order`, `fecha_alta_empresa` FROM `account_empresa` WHERE 1

//SELECT `id_account_user`, `id_account_empre`, `account_pseudo_user`, `cedula_user`, `nombre_account_user`, `mail_account_user`, `pass_account_user`, `tel_account_user`, `tel_account_user2`, `dir_account_user`, `ciudad_account_user`, `estado_account_user`, `pais_account_user`, `fecha_alta_account_user`, `foto_user`, `coleccion_user`, `tipo_kit_user`, `estado_cuenta` FROM `account_user` WHERE 1

//SELECT `id_solici_promo`, `id_account_empre`, `cod_orden_compra`, `cod_promocional`, `nome_cliente`, `tel_cliente`, `mail_cliente`, `nome_empresa`, `representante_empresa`, `tel_empresa`, `cel_cliente`, `ciudad_empresa`, `dire_empresa`, `cc_nit_empresa`, `precio_venta_pedido`, `comision_venta`, `tipo_promocion`, `fecha_solicitud`, `hora_solicitud`, `ciudad_solicitud`, `id_account_seller`, `estado_solicitud`, `metod_pago`, `datetime_publi`, `datetime_server` FROM `solicitud_pedido` WHERE 1



function staffCompany() {
    global $db;
    global $idSSUser;
    $dataStaff = array();
            
    $orderStaff = $db->subQuery ("ae");        
    $orderStaff->where('id_account_empre', $idSSUser);                     
    $orderStaff->get("account_empresa");

    $db->join($orderStaff, "ae.id_account_empre=user.id_account_empre");        
    $db->orderBy("user.nombre_account_user","asc");
    $userTBL = $db->get ("account_user user", null, "user.id_account_user, user.cedula_user, user.nombre_account_user, user.mail_account_user, user.tel_account_user, user.tel_account_user2, user.dir_account_user, user.coleccion_user, user.tipo_kit_user");
        
    $resuUserTbl = count($userTBL);
    if ($resuUserTbl > 0){
        foreach ($userTBL as $staffkey) { 
            $dataStaff[] = $staffkey;
        }    
        return $dataStaff;
    }
    
}

function ordersStaff(){
    global $db;
    global $idSSUser;
    //$totalOrderTbl = array();
            
          
    $db->where('id_account_empre', $idSSUser);                     
    $ordersStaff = $db->get("solicitud_pedido", null, 'count(id_account_empre) as tordersstaff');//count(id_account_empre) as tordersstaff
    
    $resuOrdersStaff = count($ordersStaff);
    if ($resuOrdersStaff > 0){
        foreach ($ordersStaff as $oskey) { 
            //$dataStaff[] = $staffkey;
            $totalOrderTbl = $oskey['tordersstaff'];
        }    
        return $totalOrderTbl;
    }
            
    //$totalOrderTbl = $ordersStaff['tordersstaff'];//count($ordersStaff);
    //return $totalOrderTbl;        
}

/*
 *==================================
 *QUERY ORDER USER
 *==================================
*/

function queryListProdOrder($idProdList_, $idOrderUser_){
    global $db;
    $dataProdListTmp = array();
       
    $orderActiTmp = $db->subQuery ("epl");
    //$orderActiTmp->where ("id_account_seller", $sellerID);
    $orderActiTmp->where ("id_solici_promo", $idOrderUser_);    
    $orderActiTmp->where ("id_prod_filing", $idProdList_);    
    $orderActiTmp->get("especifica_prod_pedido");
        
    $db->join($orderActiTmp, "prod.id_prod_filing = epl.id_prod_filing");        
    $prodsOrderTmp = $db->get ("productos_filing prod", null, "epl.id_solici_promo, epl.id_espci_prod_pedido, prod.id_producto, prod.id_prod_filing, prod.cod_venta_prod_filing, prod.cod_venta_descri_filing, prod.nome_producto_filing, prod.foto_producto_filing");
    $resuProdsOrderTmp = count($prodsOrderTmp);
    if ($resuProdsOrderTmp > 0){
        foreach ($prodsOrderTmp as $potkey) { 
            $dataProdListTmp[] = $potkey;
        }    
        return $dataProdListTmp;
    }      
} 


//SELECT `id_espci_prod_pedido`, `id_solici_promo`, `id_catego_prod`, `id_subcatego_producto`, `id_producto`, `id_prod_filing`, `cant_pedido`, `precio_costo`, `precio_venta`, `utilidad_porcien`, `utilidad`, `subtotal_list` FROM `especifica_prod_pedido` WHERE 1
function itemsOrder($idOrderUser_){
    global $db;
    $dataOrderUser = array();
    $db->where ("id_solici_promo", $idOrderUser_);//$idOrderUser_
    $orderUser = $db->get('especifica_prod_pedido', null, 'id_espci_prod_pedido,id_solici_promo,id_prod_filing');    
    $resuOrderUser = count($orderUser);
    if ($resuOrderUser > 0){
        foreach ($orderUser as $orderkey) { 
            //$dataOrderUser[] = $orderkey;
            
            //$idProdOrderGet = $eouKey['id_prod_filing'];
            //$idPedidoGet = $eouKey['id_solici_promo'];
            $dataOrderUser[] = queryListProdOrder($orderkey['id_prod_filing'], $orderkey['id_solici_promo']);//($idProdOrder, $idOrderUser);
            
        }    
        return $dataOrderUser;
                    
    }
 
}

