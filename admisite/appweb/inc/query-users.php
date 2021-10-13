<?php 

/*
 *==================================
 *QUERY CATEGORIA CATALOGO
 *==================================
*/
function queryDotCategoCatalogo($pzsLevel2, $coleccionLevel2){
    global $db;
    $dataQuery = array();    
    //SELECT `id_categoria_catalogo`, `id_depart_prod`, `nombre_categoria_catalogo`, `descripcion_categoria_catalogo`, `portada_categoria_catalogo`, `tag_nombre_categoria_catalogo`, nome_clean_coleccion_categoria_catalogo FROM `categoria_catalogo` WHERE 1
    $db->where('tag_nombre_categoria_catalogo',$pzsLevel2);
    $db->where('nome_clean_coleccion_categoria_catalogo',$coleccionLevel2);
    $queryTbl = $db->get ('categoria_catalogo', null, 'id_categoria_catalogo, tag_nombre_categoria_catalogo'); 
    
    $rowQueryTbl = count($queryTbl);
    if($rowQueryTbl>0){
        foreach($queryTbl as $qKey){                        
            $dataQuery[] = $qKey;    
        }
        return $dataQuery;
    }
}

/*
 *==================================
 *QUERY LEVEL 3
 *==================================
*/

function queryDotLevel3($idLevel3DOT){
    global $db;
    $dataQuery = array();    
    //SELECT `id_subcatego_producto`, `id_catego_product`, `nome_subcatego_producto`, `descri_subcatego_prod`, `img_subcate_prod`, `nome_clean_subcatego_prod`, `tags_depatament_produsts`, `posi_sub_cate_prod`, `tipo_prenda`, `talla_tipo_prenda` FROM `sub_categorias_productos` WHERE 1
    $db->where('id_catego_product',$idLevel3DOT);
    $db->orderBy('nome_subcatego_producto','asc');
    $queryTbl = $db->get ('sub_categorias_productos', null, 'id_subcatego_producto, nome_subcatego_producto, descri_subcatego_prod, nome_clean_subcatego_prod, posi_sub_cate_prod, tipo_prenda, talla_tipo_prenda, img_subcate_prod'); 
    
    $rowQueryTbl = count($queryTbl);
    if($rowQueryTbl>0){
        foreach($queryTbl as $qKey){                        
            $dataQuery[] = $qKey;    
        }
        return $dataQuery;
    }
}

/*
 *==================================
 *QUERY LEVEL 2
 *==================================
*/

function queryDotLevel2($idLevel2DOT, $idLevel3DOT, $tagsLevel1DOT){
    global $db;
    $dataQuery = array();    
    //SELECT `id_catego_product`, `id_depart_prod`, `nome_catego_product`, `descri_catego_prod`, `tags_depatament_produsts`, `tipo_kit_4user`, `cant_pz_kit` FROM `categorias_productos` WHERE 1
    $db->where('id_catego_product',$idLevel2DOT);
    $db->where('tags_depatament_produsts',$tagsLevel1DOT);
    //$db->where('tipo_kit_4user','adicional', '!=');
    $db->orderBy('tipo_kit_4user','asc');
    $queryTbl = $db->get ('categorias_productos'); 
    
    $rowQueryTbl = count($queryTbl);
    if($rowQueryTbl>0){
        foreach($queryTbl as $qKey){
            $idLevel2 = $qKey['id_catego_product'];
            $nameLevel2 = $qKey['nome_catego_product'];
            $descriLevel2 = $qKey['descri_catego_prod'];
            $kitLevel2 = $qKey['tipo_kit_4user'];
            $pzsLevel2 = $qKey['cant_pz_kit'];
            $coleccionLevel2 = $qKey['tags_depatament_produsts'];
            
            $dataL3 = queryDotLevel3($idLevel3DOT);
            $data_categoria = queryDotCategoCatalogo($kitLevel2, $coleccionLevel2);
            
            $dataQuery[] = array(
                'idlevel2' => $idLevel2,
                'namelevel2' => $nameLevel2,
                'descrilevel2' => $descriLevel2,
                'kitlevel2' => $kitLevel2,
                'cantlevel2' => $pzsLevel2,                
                'datal3' => $dataL3,  
                'datacategoria' => $data_categoria,  
            );    
        }
        return $dataQuery;
    }
}

/*
 *==================================
 *QUERY LEVELS FULL
 *==================================
*/

//GENERO PERSONA
function queryDotacionFull($idUserDot){
    global $db;
            
    $dataQuery = array();
    //SELECT `id_depart_prod`, `nome_depart_prod`, `descri_depart_prod`, `nome_clean_depa_prod` FROM `departamento_prods` WHERE 1    
    //$db->orderBy('nome_depart_prod','asc');
    $queryTbl = $db->get ('departamento_prods'); 
    
    $rowQueryTbl = count($queryTbl);
    if($rowQueryTbl>0){
        foreach($queryTbl as $qKey){
            $idLevel1 = $qKey['id_depart_prod'];
            $nameLevel1 = $qKey['nome_depart_prod'];
            $descriLevel1 = $qKey['descri_depart_prod'];
            $tagLevel1 = $qKey['nome_clean_depa_prod'];
            
            $dataL2 = queryDotLevel2($idLevel1, $idUserDot);
            
            $dataQuery[] = array(
                'idlevel1' => $idLevel1,
                'namelevel1' => $nameLevel1,
                'descrilevel1' => $descriLevel1,
                'taglevel1' => $tagLevel1,
                'datal2' => $dataL2,                
            );    
        }
        return $dataQuery;
    }
    
}



/*
 *==================================
 *QUERY USUARIOS
 *==================================
*/

function queryUsers() {
    global $db;
    
    $dataQuery = array();
    
    $db->orderBy("nombre_account_user","asc");	     
    $queryTbl = $db->get ("account_user", null, "id_account_user, estado_cuenta, nombre_account_user, cedula_user, account_pseudo_user, pass_account_user, foto_user, mail_account_user, tel_account_user, tel_account_user2, dir_account_user, ciudad_account_user, fecha_alta_account_user");
        
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
 *QUERY USUARIOS EDIT
 *==================================
*/


//PACKETE KITS DOTACION
function queryPacKitUser($idUserOrder_){
    global $db;    
    $dataQuery = array();
    
    /*$pacKit = $db->subQuery ('pk'); 
    //$subCat = $db->subQuery ('sc'); 
    
    $pacKit->where('id_account_user', $idUserOrder_);            
    $pacKit->get('pack_dotacion_user');
    
    $db->join($pacKit, 'pk.kit = cat.tipo_kit_4user', 'RIGHT');
    $db->where('pk.tags_depatament_produsts = cat.tags_depatament_produsts');
    //$db->where('pk.id_catego_product = cat.id_catego_product');
    $queryTbl = $db->get ('categorias_productos cat', null,'pk.kit, pk.cant_pz_kit, pk.id_subcatego_producto, pk.id_catego_product, cat.tags_depatament_produsts, cat.nome_catego_product, cat.tags_depatament_produsts');*/
    
    //SELECT `id_pack_dot_user`, `id_categoria_catalogo`, `id_account_user`, `kit`, `id_catego_product`, `id_subcatego_producto`, `cant_pz_kit`, `tags_depatament_produsts` FROM `pack_dotacion_user` WHERE 1
    $db->where('id_account_user', $idUserOrder_);            
    $queryTbl = $db->get ("pack_dotacion_user");
        
    $rowQueryTbl = count($queryTbl);
    if ($rowQueryTbl > 0){
        foreach ($queryTbl as $qKey) {
         //$dataQuery[] = $qKey;
            $idLevel2DOT = $qKey['id_catego_product'];
            $idLevel3DOT = $qKey['id_subcatego_producto'];
            $tagsLevel1DOT = $qKey['tags_depatament_produsts'];
            $tagsCateCatalogoDOT = $qKey['kit'];
            
            
            $db->where('nome_clean_depa_prod', $tagsLevel1DOT);    
            $queryLevel1Tbl = $db->get ('departamento_prods'); 
    
            $rowQueryLevel1Tbl = count($queryLevel1Tbl);
            if($rowQueryLevel1Tbl>0){
                foreach($queryLevel1Tbl as $qL1Key){
                    $idLevel1 = $qL1Key['id_depart_prod'];
                    $nameLevel1 = $qL1Key['nome_depart_prod'];
                    $descriLevel1 = $qL1Key['descri_depart_prod'];
                    $tagLevel1 = $qL1Key['nome_clean_depa_prod'];

                    $dataL2 = queryDotLevel2($idLevel2DOT, $idLevel3DOT, $tagsLevel1DOT);

                    $dataQuery[] = array(
                        'nombrekitcatalogo' => $tagsCateCatalogoDOT,
                        'idlevel1' => $idLevel1,
                        'namelevel1' => $nameLevel1,
                        'descrilevel1' => $descriLevel1,
                        'taglevel1' => $tagLevel1,
                        'datal2' => $dataL2,                
                    );    
                }
                //return $dataQuery;
            } 
        }   
        return $dataQuery;
    }
           
    /*$rowQueryTbl = count($queryTbl); 
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
    }*/
}

//EMPRESA
function queryStore($idStore_){
    global $db;
    
    $dataQuery = array();
        
    $db->where('id_account_empre', $idStore_);             
    $queryTbl = $db->get ("account_empresa", 1, "id_account_empre, nombre_account_empre, nit_empresa, logo_account_empre, mail_account_empre, tel_account_empre1, dir_account_empre, ciudad_account_empre");
                
    $rowQueryTbl = count($queryTbl);
    if ($rowQueryTbl > 0){
        foreach ($queryTbl as $qKey) {
         $dataQuery[] = $qKey;
        }    
        return $dataQuery;
    }
}

//DATOS FULL
function queryUsersEdit($idItem_) {
    global $db;
    
    $dataQuery = array();
    //SELECT `id_account_user`, `id_account_empre`, `account_pseudo_user`, `cedula_user`, `nombre_account_user`, `mail_account_user`, `pass_account_user`, `pass_human`, `tel_account_user`, `tel_account_user2`, `dir_account_user`, `ciudad_account_user`, `estado_account_user`, `pais_account_user`, `fecha_alta_account_user`, `foto_user`, `coleccion_user`, `tipo_kit_user`, `estado_cuenta` FROM `account_user` WHERE 1
    $db->where('id_account_user', $idItem_);        
    $queryTbl = $db->get ("account_user", 1, "id_account_empre, id_account_user, account_pseudo_user, cedula_user, nombre_account_user, mail_account_user, pass_account_user, pass_human, tel_account_user, tel_account_user2, dir_account_user, ciudad_account_user, estado_cuenta, fecha_alta_account_user, foto_user, coleccion_user");
        
    $rowQueryTbl = count($queryTbl);
    if ($rowQueryTbl > 0){
        foreach ($queryTbl as $qKey) {
                        
            $idCompany = $qKey['id_account_empre'];
            $idItem = $qKey['id_account_user'];
            
            //SOBRE LA EMPRESA
            $dataStore = queryStore($idCompany);
            if(!is_array($dataStore) && count($dataStore)==0){                
                $dataStore = null;
            }
            
            //OBRE PACKETES DE KIT ASIGNADOS AL USUARIO
            //$dataPacKitUser = queryPacKitUser($idItem);
            $dataPacKitUser =  queryPacKitUser($idItem);
            if(!is_array($dataPacKitUser) && count($dataPacKitUser)==0){                
                $dataPacKitUser = null;
            }
            
            //SOBRE LA INFO DEL USUARIO            
            $statusItem = $qKey['estado_cuenta'];               
            $nameItem = $qKey['nombre_account_user'];
            $nitItem = $qKey['cedula_user'];        
            $emailItem = $qKey['mail_account_user'];
            $tel1Item = $qKey['tel_account_user'];
            $tel2Item = $qKey['tel_account_user2'];
            $dirItem  = $qKey['dir_account_user'];
            $cityItem  = $qKey['ciudad_account_user'];
            $fotoItem = $qKey['foto_user']; 
            $dateRegisItem  = $qKey['fecha_alta_account_user'];
            $userItem  = $qKey['account_pseudo_user'];
            $passItem  = $qKey['pass_human'];
            $colectionUser = $qKey['coleccion_user'];
            
            $dataQuery[] = array(
                'colectionuser' => $colectionUser,
                'id_account_empre' => $idCompany,
                'id_account_user' => $idItem,
                'estado_cuenta' => $statusItem,
                'nombre_account_user' => $nameItem,
                'cedula_user' => $nitItem,
                'mail_account_user' => $emailItem,
                'tel_account_user' => $tel1Item,
                'tel_account_user2' => $tel2Item,
                'dir_account_user' => $dirItem,
                'ciudad_account_user' => $cityItem,
                'foto_user' => $fotoItem,
                'fecha_alta_account_user' => $dateRegisItem,
                'account_pseudo_user' => $userItem,
                'pass_human' => $passItem,
                'datastore' => $dataStore,                
                'datapackit' => $dataPacKitUser                        
            );
                                    
         //$dataQuery[] = $qKey;
        }    
        return $dataQuery;
    }
            
}



/*
 *==================================
 *QUERY CATEGORIAS CATALOGO
 *==================================
*/

function getLevelsList($tipokit_){
    global $db;
    $dataLevelList = array();
    
    $depCat = $db->subQuery ('dc'); 
    $catDot = $db->subQuery ('cc'); 
    //$resuAK =  $db->subQuery ('scd'); 
                
    $depCat->get('departamento_prods');
    
    $catDot->join($depCat, 'dc.id_depart_prod=cc.id_depart_prod');  
    if(isset($tipokit_)){ $catDot->where('cc.tipo_kit_4user', $tipokit_); }
    $catDot->get('categorias_productos cc', null,'dc.nome_depart_prod, cc.id_depart_prod, cc.id_catego_product, cc.nome_catego_product, cc.descri_catego_prod, cc.tipo_kit_4user, cc.tags_depatament_produsts, cc.cant_pz_kit');

    $db->join($catDot, 'scc.id_catego_product=cc.id_catego_product');                        
    $db->orderBy('cc.nome_depart_prod','asc');
    $db->orderBy('cc.tipo_kit_4user','asc');        
    $levelListQ = $db->get ('sub_categorias_productos scc', null, 'cc.nome_depart_prod, cc.id_depart_prod, cc.id_catego_product, cc.nome_catego_product, cc.descri_catego_prod, cc.tipo_kit_4user, cc.tags_depatament_produsts, cc.cant_pz_kit, scc.id_subcatego_producto, scc.nome_subcatego_producto'); 
           
    if(count($levelListQ)>0){
    foreach($levelListQ as $llKey){
        $dataLevelList[] = $llKey;
       // $dataAddKit['tipo_kit_4user'] = "adicional";
    }
    return $dataLevelList;
    }
}

function getRopaKitList(){
    global $db;
    $dataLevelList = array();
    
    $depCat = $db->subQuery ('dc'); 
    $catDot = $db->subQuery ('cc'); 
    //$resuAK =  $db->subQuery ('scd'); 
                
    $depCat->get('departamento_prods');
    
    $catDot->join($depCat, 'dc.id_depart_prod=cc.id_depart_prod');  
    $catDot->where('cc.tipo_kit_4user', "zapatos", "!="); 
    //$catDot->where('cc.tipo_kit_4user', 'frio'); 
    $catDot->get('categorias_productos cc', null,'dc.nome_depart_prod, cc.id_depart_prod, cc.id_catego_product, cc.nome_catego_product, cc.descri_catego_prod, cc.tipo_kit_4user, cc.tags_depatament_produsts, cc.cant_pz_kit');

    $db->join($catDot, 'scc.id_catego_product=cc.id_catego_product');                        
    $db->orderBy('cc.nome_depart_prod','asc');
    $db->orderBy('cc.tipo_kit_4user','asc');        
    $levelListQ = $db->get ('sub_categorias_productos scc', null, 'cc.nome_depart_prod, cc.id_depart_prod, cc.id_catego_product, cc.nome_catego_product, cc.descri_catego_prod, cc.tipo_kit_4user, cc.tags_depatament_produsts, cc.cant_pz_kit, scc.id_subcatego_producto, scc.nome_subcatego_producto'); 
           
    if(count($levelListQ)>0){
    foreach($levelListQ as $llKey){
        $dataLevelList[] = $llKey;
       // $dataAddKit['tipo_kit_4user'] = "adicional";
    }
    return $dataLevelList;
    }
}


/*
 *==================================
 *QUERY CATALOGO FULL
 *==================================
*/


function getCalidoKit($dotKIT_, $varL2Prod_){
    global $db;
    $dataAddKit = array();
    
    $smCatDot = $db->subQuery ('cd'); 
    $resuAK =  $db->subQuery ('scd'); 
    
    $smCatDot->where('id_catego_product', $varL2Prod_);
    $smCatDot->where('tipo_kit_4user', $dotKIT_);        
    $smCatDot->get('categorias_productos');

    $resuAK->join($smCatDot, 'scd.id_catego_product=cd.id_catego_product');                        
    
    $resuAK->get ('sub_categorias_productos scd', null, 'cd.id_depart_prod, cd.id_catego_product, cd.nome_catego_product, cd.descri_catego_prod, scd.id_subcatego_producto, scd.nome_subcatego_producto, cd.tipo_kit_4user, cd.tags_depatament_produsts'); 
    
    $db->join($resuAK, 'scd.id_subcatego_producto=prod.id_subcatego_producto');                        
    $db->orderBy('prod.nome_producto','asc');        
    $resuProd = $db->get ('productos prod', null, 'scd.tags_depatament_produsts, scd.tipo_kit_4user, scd.nome_catego_product, scd.descri_catego_prod, scd.nome_subcatego_producto, prod.id_catego_product, prod.id_subcatego_producto, prod.id_producto, prod.nome_producto, prod.cod_venta_prod, prod.foto_producto, prod.id_estado_contrato, prod.agotado'); 
    
    if(count($resuProd)>0){
    foreach($resuProd as $rakKey){
        $dataAddKit[] = $rakKey;
       // $dataAddKit['tipo_kit_4user'] = "adicional";
    }
    return $dataAddKit;
    }
}


function getFrioKit($dotKIT_, $varL2Prod_){
    global $db;
    $dataAddKit = array();
    
    $smCatDot = $db->subQuery ('cd'); 
    $resuAK =  $db->subQuery ('scd'); 
    
    $smCatDot->where('id_catego_product', $varL2Prod_);
    $smCatDot->where('tipo_kit_4user', $dotKIT_);        
    $smCatDot->get('categorias_productos');

    $resuAK->join($smCatDot, 'scd.id_catego_product=cd.id_catego_product');                        
    
    $resuAK->get ('sub_categorias_productos scd', null, 'cd.id_depart_prod, cd.id_catego_product, cd.nome_catego_product, cd.descri_catego_prod, scd.id_subcatego_producto, scd.nome_subcatego_producto, cd.tipo_kit_4user, cd.tags_depatament_produsts'); 
    
    $db->join($resuAK, 'scd.id_subcatego_producto=prod.id_subcatego_producto');                        
    $db->orderBy('prod.nome_producto','asc');        
    $resuProd = $db->get ('productos prod', null, 'scd.tags_depatament_produsts, scd.tipo_kit_4user, scd.nome_catego_product, scd.descri_catego_prod, scd.nome_subcatego_producto, prod.id_catego_product, prod.id_subcatego_producto, prod.id_producto, prod.nome_producto, prod.cod_venta_prod, prod.foto_producto, prod.id_estado_contrato, prod.agotado');  
    
    if(count($resuProd)>0){
    foreach($resuProd as $rakKey){
        $dataAddKit[] = $rakKey;
       // $dataAddKit['tipo_kit_4user'] = "adicional";
    }
    return $dataAddKit;
    }
}


function getZapatoKit($dotKIT_,  $varL2Prod_){

    global $db;
    $dataAddKit = array();
    
    $smCatDot = $db->subQuery ('cd'); 
    $resuAK =  $db->subQuery ('scd'); 
    
    $smCatDot->where('id_catego_product', $varL2Prod_);
    $smCatDot->where('tipo_kit_4user', $dotKIT_);        
    $smCatDot->get('categorias_productos');

    $resuAK->join($smCatDot, 'scd.id_catego_product=cd.id_catego_product');                        
    
    $resuAK->get ('sub_categorias_productos scd', null, 'cd.id_depart_prod, cd.id_catego_product, cd.nome_catego_product, cd.descri_catego_prod, scd.id_subcatego_producto, scd.nome_subcatego_producto, cd.tipo_kit_4user, cd.tags_depatament_produsts'); 
    
    $db->join($resuAK, 'scd.id_subcatego_producto=prod.id_subcatego_producto');                        
    $db->orderBy('prod.nome_producto','asc');        
    $resuProd = $db->get ('productos prod', null, 'scd.tags_depatament_produsts, scd.tipo_kit_4user, scd.nome_catego_product, scd.descri_catego_prod, scd.nome_subcatego_producto, prod.id_catego_product, prod.id_subcatego_producto, prod.id_producto, prod.nome_producto, prod.cod_venta_prod, prod.foto_producto, prod.id_estado_contrato, prod.agotado'); 
    
    if(count($resuProd)>0){
    foreach($resuProd as $rakKey){
        $dataAddKit[] = $rakKey;
       // $dataAddKit['tipo_kit_4user'] = "adicional";
    }
    return $dataAddKit;
    }
}


function  getCatalogoFull(){
    global $db;
            
    $dataCatalogoFull = array();
    
    $db->where('tipo_kit_4user', 'adicional', '!=');
    $db->orderBy('id_depart_prod','asc');
    $db->orderBy('tipo_kit_4user','asc');
    $smCatProd = $db->get ('categorias_productos', null, 'id_depart_prod, id_catego_product, tipo_kit_4user'); 

    if(is_array($smCatProd)){

        foreach($smCatProd as $dmcpKey){
            $varL1Prod = $dmcpKey['id_depart_prod'];
            $varL2Prod = $dmcpKey['id_catego_product'];
            $dotKIT = $dmcpKey['tipo_kit_4user'];
            //$SubCateADDKIT = $dmcpKey['id_subcatego_producto'];

            if($dotKIT == "frio"){
                $dataCatalogoFull[] = getFrioKit($dotKIT, $varL2Prod);
    
            }
            
            if($dotKIT == "calido"){
                $dataCatalogoFull[] = getCalidoKit($dotKIT, $varL2Prod);
    
            }
            
            if($dotKIT == "zapatos"){
                $dataCatalogoFull[] = getZapatoKit($dotKIT, $varL2Prod);
    
            }

                              
        }
        
        //PARA MUJER
        
    }
    return $dataCatalogoFull;
}//fin function getCatalogoFull



/*
 *==================================
 *QUERY ESPECIFICAICONES GLOBALES
 *==================================
*/

//GENERO PERSONA
function forGenero(){
    global $db;
            
    $dataForGenero = array();
        
    $db->orderBy('nome_depart_prod','asc');
    $queryTbl = $db->get ('departamento_prods'); 
    
    $rowQueryTbl = count($queryTbl);
    if($rowQueryTbl>0){
        foreach($queryTbl as $qKey){
            $dataForGenero[] = $qKey;    
        }
        return $dataForGenero;
    }
    
}


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
