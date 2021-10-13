<?php 
/*
 *==================================
 *QUERY STORES
 *==================================
*/

function queryStores() {
    global $db;
    
    $dataQuery = array();
    
    $db->orderBy("nombre_account_empre","asc");	     
    $queryTbl = $db->get ("account_empresa", null, "id_account_empre, id_estado, ref_account_empre, nombre_account_empre, nit_empresa, logo_account_empre, mail_account_empre, tel_account_empre1, tel_account_empre2, dir_account_empre, ciudad_account_empre, fecha_alta_empresa, nome_representante");
        
    $rowQueryTbl = count($queryTbl);
    if ($rowQueryTbl > 0){
        foreach ($queryTbl as $qKey) {
         $dataQuery[] = $qKey;
        }    
        return $dataQuery;
    }
            
}

/*
 *==================================
 *QUERY STORES EDIT
 *==================================
*/

function queryStoresEdit($idItem_) {
    global $db;
    
    $dataQuery = array();
    //SELECT `id_account_empre`, `id_estado`, `ref_account_empre`, `nombre_account_empre`, `nit_empresa`, `logo_account_empre`, `mail_account_empre`, `pseudo_user_empresa`, `pass_account_empre`, `tel_account_empre1`, `tel_account_empre2`, `url_empre`, `dir_account_empre`, `ciudad_account_empre`, `pais_account_empre`, `nome_representante`, `cargo_repre_empresa`, `comentarios_empresa`, `recibe_order`, `cargo_recibe_order`, `fecha_alta_empresa` FROM `account_empresa` WHERE 1
    $db->where('id_account_empre', $idItem_);        
    $queryTbl = $db->get ("account_empresa", 1, "id_account_empre, id_estado, ref_account_empre, nombre_account_empre, nit_empresa, logo_account_empre, mail_account_empre, tel_account_empre1, tel_account_empre2, dir_account_empre, ciudad_account_empre, pseudo_user_empresa, pass_human, nome_representante, cargo_repre_empresa, comentarios_empresa, fecha_alta_empresa");
        
    $rowQueryTbl = count($queryTbl);
    if ($rowQueryTbl > 0){
        foreach ($queryTbl as $qKey) {
         $dataQuery[] = $qKey;
        }    
        return $dataQuery;
    }
            
}