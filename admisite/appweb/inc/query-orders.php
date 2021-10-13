<?php

/*
 *==================================
 *QUERY ORDERS GLOBAL
 *==================================
*/

//SELECT `id_account_empre`, `id_estado`, `ref_account_empre`, `nombre_account_empre`, `nit_empresa`, `logo_account_empre`, `mail_account_empre`, `pseudo_user_empresa`, `pass_account_empre`, `tel_account_empre1`, `tel_account_empre2`, `url_empre`, `dir_account_empre`, `ciudad_account_empre`, `pais_account_empre`, `nome_representante`, `cargo_repre_empresa`, `comentarios_empresa`, `recibe_order`, `cargo_recibe_order`, `fecha_alta_empresa` FROM `account_empresa` WHERE 1

//SELECT `id_account_user`, `id_account_empre`, `account_pseudo_user`, `cedula_user`, `nombre_account_user`, `mail_account_user`, `pass_account_user`, `tel_account_user`, `tel_account_user2`, `dir_account_user`, `ciudad_account_user`, `estado_account_user`, `pais_account_user`, `fecha_alta_account_user`, `foto_user`, `coleccion_user`, `tipo_kit_user`, `estado_cuenta` FROM `account_user` WHERE 1

//SELECT `id_solici_promo`, `id_account_empre`, `cod_orden_compra`, `cod_promocional`, `nome_cliente`, `tel_cliente`, `mail_cliente`, `nome_empresa`, `representante_empresa`, `tel_empresa`, `cel_cliente`, `ciudad_solicitud`, `dire_empresa`, `cc_nit_empresa`, `precio_venta_pedido`, `comision_venta`, `tipo_promocion`, `fecha_solicitud`, `hora_solicitud`, `ciudad_solicitud`, `id_account_user`, `estado_solicitud`, `metod_pago`, `datetime_publi`, `datetime_server` FROM `solicitud_pedido` WHERE 1

//SELECT `id_espci_prod_pedido`, `id_solici_promo`, `id_catego_prod`, `id_subcatego_producto`, `id_producto`, `id_prod_filing`, `cant_pedido`, `precio_costo`, `precio_venta`, `utilidad_porcien`, `utilidad`, `subtotal_list` FROM `especifica_prod_pedido` WHERE 1

//SELECT `id_espci_kit_pedido`, `id_solici_promo`, `id_catego_prod`, `id_subcatego_producto`, `id_color`, `id_talla`, `cant_pedido`, `tipo_prenda` FROM `especifica_kit_pedido` WHERE 1

//SELECT `id_pack_dot_user`, `id_account_user`, `kit`, `id_catego_product`, `id_subcatego_producto`, `cant_pz_kit` FROM `pack_dotacion_user` WHERE 1

//SELECT `id_subcatego_producto`, `id_catego_product`, `nome_subcatego_producto`, `descri_subcatego_prod`, `img_subcate_prod`, `nome_clean_subcatego_prod`, `tags_depatament_produsts`, `posi_sub_cate_prod`, `tipo_prenda`, `talla_tipo_prenda` FROM `sub_categorias_productos` WHERE 1

//SELECT `id_prod_filing`, `id_subcatego_producto`, `id_producto`, `id_estado_contrato`, `agotado_filing`, `cod_venta_prod_filing`, `cod_venta_descri_filing`, `nome_producto_filing`, `foto_producto_filing`, `txt_alt_img_prod_filing`, `ref_album_prod_filing`, `cant_exist_prod_filing`, `max_exist_prod_filing`, `min_exist_prod_filing`, `id_talla_letras`, `id_talla_numer`, `id_color` FROM `productos_filing` WHERE 1

//SELECT `id_catego_product`, `id_depart_prod`, `nome_catego_product`, `descri_catego_prod`, `tags_depatament_produsts`, `tipo_kit_4user` FROM `categorias_productos` WHERE 1


/*
 *==================================
 *QUERY ITEMS REFERENCIAS
 *==================================
*/

//QUERY DETALLES PEDIDO
function queryEspeciPedido($idOrder_){
    global $db;    
    $dataQuery = array();
    
    $subQ = $db->subQuery ('ep');     
    $smCatDot = $db->subQuery ('cd'); 
    $resuAK =  $db->subQuery ('scd'); 
    
    $subQ->where('id_solici_promo', $idOrder_);            
    $subQ->get('especifica_prod_pedido');
                 
    $smCatDot->join($subQ, 'ep.id_catego_prod = cd.id_catego_product'); 
    $smCatDot->get('categorias_productos cd', null, 'ep.id_solici_promo, ep.cant_pedido, ep.id_subcatego_producto, ep.id_prod_filing, cd.id_catego_product, cd.nome_catego_product, cd.descri_catego_prod, cd.tags_depatament_produsts, cd.tipo_kit_4user');

    $resuAK->join($smCatDot, 'cd.id_subcatego_producto = scd.id_subcatego_producto');    
    $resuAK->get ('sub_categorias_productos scd', null, 'cd.id_solici_promo, cd.cant_pedido, cd.id_catego_product, cd.nome_catego_product, cd.descri_catego_prod, cd.tags_depatament_produsts, cd.tipo_kit_4user, cd.id_prod_filing, scd.id_subcatego_producto, scd.nome_subcatego_producto'); 
    
    $db->join($resuAK, 'scd.id_prod_filing = pref.id_prod_filing');              
    $queryTbl = $db->get ("productos_filing pref", null, "scd.id_solici_promo, scd.cant_pedido, scd.nome_catego_product, scd.descri_catego_prod, scd.tags_depatament_produsts, scd.tipo_kit_4user, scd.nome_subcatego_producto, pref.id_prod_filing, pref.cod_venta_prod_filing, pref.cod_venta_descri_filing, pref.foto_producto_filing, pref.id_talla_letras, pref.id_talla_numer, pref.id_color");
        
    $rowQueryTbl = count($queryTbl);
    if ($rowQueryTbl > 0){
        foreach ($queryTbl as $qKey) {                                                                 
            $dataQuery[] = $qKey;
        }    
        return $dataQuery;
    }
    
}

function queryPacKitUser($idUserOrder_){
    global $db;    
    $dataQuery = array();
    
    $pacKit = $db->subQuery ('pk'); 
    //$subCat = $db->subQuery ('sc'); 
    
    $pacKit->where('id_account_user', $idUserOrder_);            
    $pacKit->get('pack_dotacion_user');
    
    $db->join($pacKit, 'pk.kit = cat.tipo_kit_4user', 'RIGHT');
    $db->where('pk.tags_depatament_produsts = cat.tags_depatament_produsts');
    //$db->where('pk.id_catego_product = cat.id_catego_product');
    $queryTbl = $db->get ('categorias_productos cat', null,'pk.kit, pk.cant_pz_kit, pk.id_subcatego_producto, pk.id_catego_product, cat.tags_depatament_produsts, cat.nome_catego_product, cat.tags_depatament_produsts');
                    
    $rowQueryTbl = count($queryTbl);
    if ($rowQueryTbl > 0){
        foreach ($queryTbl as $qKey) {
            $idCat = $qKey['id_catego_product'];
            $idSubCat = $qKey['id_subcatego_producto'];
            $nameCat = $qKey['nome_catego_product'];
            $generoKit = $qKey['tags_depatament_produsts'];
            $nameKit = $qKey['kit'];
            $cantPz = $qKey['cant_pz_kit'];
            
            //sobre las subcategorias asignadas
            $idSCKit = array();
            $dataSubCatKit = array();
            $db->where('id_subcatego_producto', $idSubCat);
            $subCatKit = $db->get('sub_categorias_productos', null, 'id_subcatego_producto, nome_subcatego_producto');
            $rowSubCatKit = count($subCatKit);
            if($rowSubCatKit>0){
                foreach($subCatKit as $sckKey){
                    $idSCKit = $sckKey['id_subcatego_producto'];
                    //$nameSubCatKit = $sckKey['nome_subcatego_producto'];
                    $dataSubCatKit = $sckKey;                    
                }    
            }
            /*if(!is_array($dataSubCatKit) && count($dataSubCatKit)==0){                
                $dataSubCatKit = null;
            }*/
            
            //sobre las categorias asignadas
            $idCatKit = array(); 
            $dataCatKit = array();
            $db->where('id_catego_product', $idCat);
            $catKit = $db->get('categorias_productos', null, 'id_catego_product, nome_catego_product');
            $rowCatKit = count($catKit);
            if($rowCatKit>0){
                foreach($catKit as $ckKey){
                    $idCatKit = $ckKey['id_catego_product'];
                    //$nameCatKit = $ckKey['nome_catego_product'];
                    $dataCatKit = $ckKey;                                        
                }    
            }
            /*if(!is_array($dataCatKit) && count($dataCatKit)==0){                
                $dataCatKit = null;
            }*/
            
                                    
            $dataQuery[] = array(
                'kit'=> $nameKit,
                'cant_pz_kit'=> $cantPz,
                'tags_depatament_produsts'=> $generoKit,
                'id_catego_product' => $idCat,
                'nome_catego_product'=> $nameCat,
                'datacategos' => ($idCat == $idCatKit)? $dataCatKit : "",
                'id_subcatego_producto'=> $idSubCat,
                'datasubcategos'=> ($idSCKit == $idSubCat)? $dataSubCatKit : "",                
            );                
            
            //$dataQuery[] = $qKey;
        }    
        return $dataQuery;
    }
}

//QUERY INFO USUARIO
function queryUser($idUserOrder_){
    global $db;    
    $dataQuery = array();
    
    $db->where('id_account_user', $idUserOrder_);        
    $queryTbl = $db->get ("account_user", 1, "id_account_user, cedula_user, nombre_account_user, mail_account_user, tel_account_user, tel_account_user2, dir_account_user, ciudad_account_user, coleccion_user, tipo_kit_user");
        
    $rowQueryTbl = count($queryTbl);
    if ($rowQueryTbl > 0){
        foreach ($queryTbl as $qKey) {
         $dataQuery[] = $qKey;
        }    
        return $dataQuery;
    }
}

//QUERY INFO EMPRESA
function queryStore($idStoreOrder_){
    global $db;    
    $dataQuery = array();
    
    $db->where('id_account_empre', $idStoreOrder_);        
    $queryTbl = $db->get ("account_empresa", 1, "id_account_empre, ref_account_empre, nombre_account_empre, nit_empresa, logo_account_empre, mail_account_empre, tel_account_empre1, tel_account_empre2, dir_account_empre, ciudad_account_empre");
        
    $rowQueryTbl = count($queryTbl);
    if ($rowQueryTbl > 0){
        foreach ($queryTbl as $qKey) {
         $dataQuery[] = $qKey;
        }    
        return $dataQuery;
    }
}


//QUERY LIST ORDER FULL
function ordersQuery($idOrder_){
    global $db;    
    $dataQuery = array();
    
    if($idOrder_){ $db->where('id_solici_promo', $idOrder_); }
    $db->orderBy("datetime_publi","desc");    
    $queryTbl = $db->get ("solicitud_pedido", null, "estado_solicitud, id_solici_promo, id_account_empre, cod_orden_compra, nome_cliente, tel_cliente, mail_cliente, nome_empresa, representante_empresa, ciudad_solicitud, id_account_user, fecha_solicitud, hora_solicitud");
        
    $rowQueryTbl = count($queryTbl);
    if ($rowQueryTbl > 0){
        foreach ($queryTbl as $qKey) {
            $idOrder = $qKey['id_solici_promo'];
            $idStoreOrder = $qKey['id_account_empre'];
            $idUserOrder = $qKey['id_account_user'];
            
            //SOBRE LA EMPRESA
            $dataStore = queryStore($idStoreOrder);
            if(!is_array($dataStore) && count($dataStore)==0){                
                $dataStore = null;
            }
            
            //SOBRE EL USUARIO
            $dataUser = queryUser($idUserOrder);
            if(!is_array($dataUser) && count($dataUser)==0){                
                $dataUser = null;
            }
            
            //OBRE PACKETES DE KIT ASIGNADOS AL USUARIO
            $dataPacKitUser = queryPacKitUser($idUserOrder);
            if(!is_array($dataPacKitUser) && count($dataPacKitUser)==0){                
                $dataPacKitUser = null;
            }
            
            //SOBRE LOS ITEMS DEL PEDIDO
            $dataEspePedido = queryEspeciPedido($idOrder);
            if(!is_array($dataEspePedido) && count($dataEspePedido)==0){                
                $dataEspePedido = null;
            }
            
            //SOBRE LA SOLICITUD DE PEDIDO
            $refOrder = $qKey['cod_orden_compra'];
            $nameClientOrder = $qKey['nome_cliente'];
            $telClientOrder = $qKey['tel_cliente'];
            $mailCLientOrder = $qKey['mail_cliente'];
            $nameSotreOrder = $qKey['nome_empresa'];
            $repreStoreOrder = $qKey['representante_empresa'];
            $cityDeliveryOrder = $qKey['ciudad_solicitud'];
            $dateOrder = $qKey['fecha_solicitud'];
            $timeOrder = $qKey['hora_solicitud'];
            $statusOrder = $qKey['estado_solicitud'];
            
            $dataQuery[] = array(
                'estado_solicitud' => $statusOrder,
                'id_solici_promo' => $idOrder,
                'id_account_empre' => $idStoreOrder,
                'id_account_user' => $idUserOrder,
                'cod_orden_compra' => $refOrder,
                'nome_cliente' => $nameClientOrder,
                'tel_cliente' => $telClientOrder,
                'mail_cliente' => $mailCLientOrder,
                'nome_empresa' => $nameSotreOrder,
                'representante_empresa' => $repreStoreOrder,
                'ciudad_solicitud' => $cityDeliveryOrder,
                'fecha_solicitud' => $dateOrder,
                'hora_solicitud' => $timeOrder,
                'datastore' => $dataStore,
                'datauser' => $dataUser,
                'datapackit' => $dataPacKitUser,
                'datadetaorder' => $dataEspePedido,
                
            );
            
            //$dataQuery[] = $qKey;
        }    
        return $dataQuery;
    }
    
}
/*$arr = array();
$arr = ordersQuery();
echo "<pre>";
print_r($arr);*/
    