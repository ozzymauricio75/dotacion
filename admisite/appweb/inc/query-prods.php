<?php 
$dataCatalogoProds = array();
$dataSubCateCatalogoProds = array();
$dataProds = array();
$datafotosProds = array();

/*
 *==================================
 *QUERY SEARCH BOX
 *==================================
*/

if(isset($_GET['sb']) && $_GET['sb'] == "ok" && $_GET['search'] != ""){
//if(isset($_GET['search']) && $_GET['search'] != ""){    
    $buskString = formatConsuString($_GET['search']);
}

/*
 *==================================
 *QUERY CATEGORIAS CATALOGO
 *==================================
*/

function getLevelsList(){
    global $db;
    $dataLevelList = array();
    
    $depCat = $db->subQuery ('dc'); 
    $catDot = $db->subQuery ('cc'); 
    //$resuAK =  $db->subQuery ('scd'); 
                
    $depCat->get('departamento_prods');
    
    $catDot->join($depCat, 'dc.id_depart_prod=cc.id_depart_prod');         
    $catDot->get('categorias_productos cc', null,'dc.nome_depart_prod, cc.id_depart_prod, cc.id_catego_product, cc.nome_catego_product, cc.descri_catego_prod, cc.tipo_kit_4user, cc.tags_depatament_produsts');

    $db->join($catDot, 'scc.id_catego_product=cc.id_catego_product');                        
    $db->orderBy('cc.nome_depart_prod','asc');
    $db->orderBy('cc.tipo_kit_4user','asc');        
    $levelListQ = $db->get ('sub_categorias_productos scc', null, 'cc.nome_depart_prod, cc.id_depart_prod, cc.id_catego_product, cc.nome_catego_product, cc.descri_catego_prod, cc.tipo_kit_4user, cc.tags_depatament_produsts, scc.id_subcatego_producto, scc.nome_subcatego_producto'); 
           
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
    //$smCatDot->where('tipo_kit_4user', $dotKIT_);        
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

            //if($dotKIT == "frio"){
                $dataCatalogoFull[] = getFrioKit($dotKIT, $varL2Prod);
    
            //}
            
            /*if($dotKIT == "calido"){
                $dataCatalogoFull[] = getCalidoKit($dotKIT, $varL2Prod);
    
            }
            
            if($dotKIT == "zapatos"){
                $dataCatalogoFull[] = getZapatoKit($dotKIT, $varL2Prod);
    
            }*/

                              
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

//GRUPO DE TALLAS
function ettpQ(){ 
    global $db;
    //global $varGet;
    $dataForGenero = array();

    //$db->where('id_grupo_talla',$varGet);
    //$db->orderBy('posi_talla','asc');
    //$db->orderBy('name_talla_tipo_prenda','asc');
    //$db->orderBy('posi_talla','asc');
    $db->orderBy('genero_talla','desc');
    $db->orderBy('name_talla_tipo_prenda','asc');
    $db->orderBy('posi_talla','asc');
    $queryTbl = $db->get ('especifica_tallas_tipo_prenda'); 

    $rowQueryTbl = count($queryTbl);
    if($rowQueryTbl>0){
        foreach($queryTbl as $qKey){
    //                $idGrupoTalla = $qKey['id_talla_tablas'];
    //                $nameGrupoTalla = $qKey['talla_tipo_prenda'];
    //                $tagGrupoTalla = $qKey['genero_ropa'];        
    //
    //
    //                $optionList ="<div class='col-xs-4'>";            
    //                $optionList .="<label>";
    //                $optionList .="<input type='checkbox' name='tallaletras[]' class='flat-red' value='" .$idGrupoTalla ."'/>&nbsp;&nbsp;";
    //                $optionList .= $nameGrupoTalla;
    //                $optionList .="</label>";
    //                $optionList .="</div>";


            //$optionList = "<option value='".$idGrupoTalla."' class='txtCapitalice'>".$nameGrupoTalla."</option>";
            //echo $optionList;        

            $dataForGenero[] = $qKey;
             /*$dataForGenero[] = array(
                'codtalla' => $idGrupoTalla,
                'nametalla' => $nameGrupoTalla
            );*/

        }

        //echo json_encode($dataForGenero);
        return $dataForGenero;
    }else{
        echo "NO HAY ARRAY";
    }
}
   
//COLORES
function colorFeature(){
    global $db;
            
    $dataArr = array();
    
    $db->orderBy('nome_color','asc');
    $queryTbl = $db->get ('tipo_color'); 
    
    $rowQueryTbl = count($queryTbl);
    if($rowQueryTbl>0){
        foreach($queryTbl as $qKey){
            $dataArr[] = $qKey;    
        }
        return $dataArr;
    }
    
}

//MATERIALES
function materialFeature(){
    global $db;
            
    $dataArr = array();
    
    $db->orderBy('nome_material','asc');
    $queryTbl = $db->get ('tipo_material'); 
    
    $rowQueryTbl = count($queryTbl);
    if($rowQueryTbl>0){
        foreach($queryTbl as $qKey){
            $dataArr[] = $qKey;    
        }
        return $dataArr;
    }
    
}
    

/*
 *==================================
 *QUERY ITEMS REFERENCIAS
 *==================================
*/

//TALLAS LETRAS PARA ITEM REFERENCIA
function tallaLetraItemRef($idTallaLetraRef_){
    global $db;
    $dataQuery = array();
                                             
    $db->where('id_talla_letras',$idTallaLetraRef_);      
    $queryTbl = $db->get ('talla_letras', 1, 'id_talla_letras, nome_talla_letras'); 
    
    if(count($queryTbl)>0){
        foreach($queryTbl as $qKey){        
            $dataQuery = $qKey;       
        }
        return $dataQuery;
    }
    
}

//TALLAS NUMEROS PARA ITEM REFERENCIAS
function tallaNumItemRef($idTallaNumRef_){
    global $db;
    $dataQuery = array();
                                             
    $db->where('id_talla_numer',$idTallaNumRef_);            
    $queryTbl = $db->get ('talla_numerico', 1, 'id_talla_numer, talla_numer'); 
    
    if(count($queryTbl)>0){
        foreach($queryTbl as $qKey){        
            $dataQuery = $qKey;       
        }
        return $dataQuery;
    }
}

//COLORES PARA ITEM REFERENCIAS
function colorItemRef($idColorRef_){
    global $db;
    $dataQuery = array();
                                             
    $db->where('id_color',$idColorRef_);  
    $db->orderBy('nome_color','asc');        
    $queryTbl = $db->get ('tipo_color', 1, 'id_color, nome_color, color_hexa'); 
    
    if(count($queryTbl)>0){
        foreach($queryTbl as $qKey){        
            $dataQuery = $qKey;       
        }
        return $dataQuery;
    }
}


//ITEM CATALOGO FULL
function itemRefQuery($itemvar_){
    global $db;
    $dataQuery = array();
                                               
    $db->where('id_producto',$itemvar_);  
    $db->orderBy('id_prod_filing','desc');        
    $queryTbl = $db->get ('productos_filing', null, 'id_producto, id_prod_filing, id_estado_contrato, agotado_filing, cod_venta_prod_filing, cod_venta_descri_filing, nome_producto_filing, foto_producto_filing, ref_album_prod_filing, cant_exist_prod_filing, min_exist_prod_filing, id_talla_letras, id_talla_numer, id_color'); 
    
    if(count($queryTbl)>0){
        foreach($queryTbl as $qKey){        
            $idProdGb = $qKey['id_producto'];
            //$idProdRef = $qKey[''];
            $idColorRef = $qKey['id_color'];
            $idTallaNumRef = $qKey['id_talla_numer'];
            $idTallaLetraRef = $qKey['id_talla_letras'];
                            
            //TALLAS LETRAS        
            //$dataQuery[] = tallaLetraRef($idTallaLetraRef);
            $dataTL = tallaLetraItemRef($idTallaLetraRef);
            
            if(!is_array($dataTL) && count($dataTL)==0){                
                $dataTL = null;
            }

            //TALLAS NUMEROS
            //$dataQuery[] = tallaNumRef($idTallaNumRef);
            $dataTN = tallaNumItemRef($idTallaNumRef);
            if(!is_array($dataTN) && count($dataTN)==0){                
                $dataTN = null;
            }

            //COLORES
            //$dataQuery[] = colorRef($idColorRef);
            $dataColor = colorItemRef($idColorRef);
            if(!is_array($dataColor) && count($dataColor)==0){                
                $dataColor = null;
            }
            
            //MATERIALES
            //dataQuery[] = materialRef($idProdGb);

            //SOBRE EL PRODUCTO
            $idProdItemRef = $qKey['id_prod_filing'];
            $statusItemRef = $qKey['id_estado_contrato'];
            $actiStockItemRef = $qKey['agotado_filing'];
            $codVentaItemRef = $qKey['cod_venta_prod_filing'];
            $codVentaFullItemRef = $qKey['cod_venta_descri_filing'];
            $nameItemRef = $qKey['nome_producto_filing'];
            $fotoItemRef = $qKey['foto_producto_filing'];
            $refAlbumItemRef = $qKey['ref_album_prod_filing'];
            $cantItemRef = $qKey['cant_exist_prod_filing'];
            $minCantItemRef = $qKey['min_exist_prod_filing'];

            $dataQuery[] = array(
                'id_prod_filing' => $idProdItemRef, 
                'id_estado_contrato' => $statusItemRef,
                'agotado_filing' =>$actiStockItemRef,
                'cod_venta_prod_filing' => $codVentaItemRef,
                'cod_venta_descri_filing' =>$codVentaFullItemRef,
                'nome_producto_filing' => $nameItemRef,
                'foto_producto_filing' =>$fotoItemRef,
                'ref_album_prod_filing' =>$refAlbumItemRef,
                'cant_exist_prod_filing' => $cantItemRef,
                'min_exist_prod_filing' =>$minCantItemRef,
                'id_color' => $idColorRef,
                'id_talla_numer'=> $idTallaNumRef,
                'id_talla_letras' => $idTallaLetraRef,
                'tallaletraref' =>$dataTL,
                'tallanumeref' =>$dataTN,
                'colorref' =>$dataColor                
            );            

            //$dataQuery[] = $qKey;       
        }
        return $dataQuery;
    }
}

//recibe datos de catalgoo
//$dataCatalogo = array();
//$dataCatalogo = itemRefQuery('30');//getCatalogoFull();

//echo "<pre>";
//print_r($dataCatalogo);





/*
 *==================================
 *QUERY ESPECIFICAICONES PARA CREAR ITEMS REFERENCIAS
 *==================================
*/


//GRUPO TALLAS
function tallaFeatureREF($itemvar_){
    global $db;
    $dataArr = array();
    
    /*$sqArr = $db->subQuery ('egt');     
        
    $sqArr->where('id_producto', $itemvar_);        
    $sqArr->get('especifica_grupo_talla');

    $db->join($sqArr, 'egt.id_grupo_talla = egp.id_grupo_talla', 'LEFT');                        
    $db->where('egt.id_grupo_talla','egp.id_grupo_talla');  
    $db->orderBy('egp.posi_talla','asc'); 
    $queryTbl = $db->get ('especifica_tallas_tipo_prenda egp');*/ 
    
    $sqlTbl = "SELECT egt.id_producto, egt.id_grupo_talla, egp.id_grupo_talla, egp.id_talla_tablas, egp.talla_tipo_prenda, egp.tipo_talla, egp.genero_talla, egp.posi_talla, egp.name_talla_tipo_prenda, egt.id_talla_tablas, egp.id_talla_tablas FROM especifica_grupo_talla as egt, especifica_tallas_tipo_prenda egp WHERE egt.id_grupo_talla = egp.id_grupo_talla AND egt.id_talla_tablas = egp.id_talla_tablas AND egt.id_producto = ".$itemvar_." ORDER BY egp.posi_talla ASC";//egt.talla_tipo_prenda,
    //ORDER BY egp.posi_talla ASC";// AND egp.talla_tipo_prenda = egt.talla_tipo_prenda
    
    $queryTbl = $db->rawQuery ($sqlTbl); 
    
    $rowQueryTbl = count($queryTbl);
    if($rowQueryTbl>0){
        foreach($queryTbl as $qKey){
            $dataArr[] = $qKey;    
        }
        //$dataArr = unique_multidim_array($dataArr, 'id_talla_tablas');
        //$dataArr = unique_multidim_array($dataArr, 'id_talla_tablas');
        return $dataArr;
    }
}

//COLORES
function colorFeatureREF($itemvar_){
    global $db;
            
    $dataArr = array();
    
    $sqArr = $db->subQuery ('ecp');     
        
    $sqArr->where('id_producto', $itemvar_);        
    $sqArr->get('especifica_product_tipo_color');

    $db->join($sqArr, 'ecp.id_color=tc.id_color');  
    $db->orderBy('tc.nome_color','asc');        
    $queryTbl = $db->get ('tipo_color tc', null, 'tc.id_color, tc.nome_color, tc.color_hexa'); 
        
    /*$sqlTbl = "SELECT tc.id_color, tc.nome_color, tc.color_hexa, ecp.id_producto 
    FROM  tipo_color as tc, especifica_product_tipo_color ecp
    WHERE ecp.id_color=tc.id_color AND ecp.id_producto = '$itemvar_'
    ORDER BY tc.nome_color ASC";
    
    $queryTbl = $db->rawQuery ($sqlTbl); */
    
    $rowQueryTbl = count($queryTbl);
    if($rowQueryTbl>0){
        foreach($queryTbl as $qKey){
            $dataArr[] = $qKey; 
            
        }
        $dataArr = unique_multidim_array($dataArr, 'id_color');
        return $dataArr;
    }
    
}


//COLORES
function materialFeatureREF($itemvar_){
    global $db;
            
    $dataArr = array();
    
    $sqArr = $db->subQuery ('emp');     
        
    $sqArr->where('id_producto', $itemvar_);        
    $sqArr->get('especifica_prod_material');

    $db->join($sqArr, 'emp.id_material=tm.id_material');            
    $queryTbl = $db->get ('tipo_material tm', null, 'tm.id_material, tm.nome_material, tm.valor_material'); 
    
    $rowQueryTbl = count($queryTbl);
    if($rowQueryTbl>0){
        foreach($queryTbl as $qKey){
            $dataArr[] = $qKey; 
            
        }
        //$dataArr = unique_multidim_array($dataArr, 'id_material');
        return $dataArr;
    }
    
}


/*
 *==================================
 *QUERY DETALLES ITEM EDIT
 *==================================
*/

    
function categoFeatureREF($categoItem_, $subCateItem_){
    global $db;
    $dataLevelList = array();
    
    $depCat = $db->subQuery ('dc'); 
    $catDot = $db->subQuery ('cc'); 
    //$resuAK =  $db->subQuery ('scd'); 
                
    $depCat->get('departamento_prods');
    
    $catDot->join($depCat, 'dc.id_depart_prod=cc.id_depart_prod');   
    $catDot->where('cc.id_catego_product', $categoItem_);
    $catDot->get('categorias_productos cc', 1,'dc.nome_depart_prod, cc.id_depart_prod, cc.id_catego_product, cc.nome_catego_product, cc.descri_catego_prod, cc.tipo_kit_4user, cc.tags_depatament_produsts');

    $db->join($catDot, 'scc.id_catego_product=cc.id_catego_product');    
    $db->where('scc.id_subcatego_producto', $subCateItem_);
    $levelListQ = $db->get ('sub_categorias_productos scc', 1, 'cc.nome_depart_prod, cc.id_depart_prod, cc.id_catego_product, cc.nome_catego_product, cc.descri_catego_prod, cc.tipo_kit_4user, cc.tags_depatament_produsts, scc.id_subcatego_producto, scc.nome_subcatego_producto'); 
           
    if(count($levelListQ)>0){
    foreach($levelListQ as $llKey){
        $dataLevelList[] = $llKey;
       // $dataAddKit['tipo_kit_4user'] = "adicional";
    }
    return $dataLevelList;
    }
}


function queryDetallesItem($itemVarGET_){
    
    global $db;
    $dataQuery = array();
                                               
    $db->where('id_producto',$itemVarGET_);         
    $queryTbl = $db->get ('productos', 1, 'id_catego_product, id_subcatego_producto, id_producto, nome_producto, cod_venta_prod, foto_producto, id_estado_contrato, agotado, ref_album, precio_producto, caracteristicas_producto'); 
    
    if(count($queryTbl)>0){
        foreach($queryTbl as $qKey){        
            $categoItem = $qKey['id_catego_product'];
            $subCateItem = $qKey['id_subcatego_producto'];
            $idProdItem = $qKey['id_producto'];
                                        
            //TALLAS LETRAS                    
            $dataTL = tallaFeatureREF($idProdItem);
            
            if(!is_array($dataTL) && count($dataTL)==0){                
                $dataTL = null;
            }
            
            //COLORES            
            $dataColor = colorFeatureREF($idProdItem);
            if(!is_array($dataColor) && count($dataColor)==0){                
                $dataColor = null;
            }
            
            //MATERIALES
            $dataMaterial = materialFeatureREF($idProdItem);
            if(!is_array($dataMaterial) && count($dataMaterial)==0){                
                $dataMaterial = null;
            }
                
            //CATEGORIA
            $dataCatego = categoFeatureREF($categoItem, $subCateItem);

            //SOBRE EL PRODUCTO            
            $statusItem = $qKey['id_estado_contrato'];
            $actiStockItem = $qKey['agotado'];
            $codVentaItem = $qKey['cod_venta_prod'];            
            $nameItem = $qKey['nome_producto'];
            $fotoItem = $qKey['foto_producto'];
            $refAlbumItem = $qKey['ref_album'];
            $priceItem = $qKey['precio_producto'];
            $descriItem = $qKey['caracteristicas_producto'];

            $dataQuery[] = array(
                'id_catego_product' => $categoItem,
                'id_subcatego_producto' =>$subCateItem,
                'categoitem' => $dataCatego,                   
                'id_producto' => $idProdItem,                 
                'id_estado_contrato' => $statusItem,
                'agotado' =>$actiStockItem,
                'cod_venta_prod' => $codVentaItem,                
                'nome_producto' => $nameItem,
                'foto_producto' =>$fotoItem,
                'ref_album' =>$refAlbumItem,                
                'precio_producto' =>$priceItem,                
                'caracteristicas_producto' =>$descriItem,                
                'tallasitem' =>$dataTL,            
                'coloritem' =>$dataColor,           
                'materialitem' =>$dataMaterial
            );            

            //$dataQuery[] = $qKey;       
        }
        return $dataQuery;
    }
    
}


//GRUPO DE TALLAS ITEM EDIT
function grupoTallaItemEdit($tipoPrenda_, $generoPrenda_){ 
    global $db;    
    $dataForGenero = array();

    $db->where('genero_talla',$generoPrenda_);
    $db->where('name_talla_tipo_prenda',$tipoPrenda_);
    $db->orderBy('posi_talla','asc');
    $queryTbl = $db->get ('especifica_tallas_tipo_prenda'); 

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
 *QUERY DETALLES ITEM REFERENCIA EDIT
 *==================================
*/

//ALBUM FOTOS ITEM REFERENCIA
function fotosRef($refAlbumItemRef_){
    //SELECT `id_albun`, `nome_albun`, `portada_album`, `ref_album`, `ruta_publicacion` FROM `albun_db` WHERE 1
    
    //SELECT `id_albun`, `id_foto`, `nome_foto`, `descri_foto`, `img_foto` FROM `fotos_albun` WHERE 1
    
    global $db;
            
    $dataArr = array();
    
    $sqArr = $db->subQuery ('adb');     
        
    $sqArr->where('ref_album', $refAlbumItemRef_);        
    $sqArr->get('albun_db');

    $db->join($sqArr, 'adb.id_albun=fa.id_albun');            
    $queryTbl = $db->get ('fotos_albun fa', null, 'adb.id_albun, adb.nome_albun, adb.portada_album, adb.ref_album, fa.id_foto, fa.nome_foto, fa.descri_foto, fa.img_foto'); 
    
    $rowQueryTbl = count($queryTbl);
    if($rowQueryTbl>0){
        foreach($queryTbl as $qKey){
            $dataArr[] = $qKey; 
            
        }
        //$dataArr = unique_multidim_array($dataArr, 'id_material');
        return $dataArr;
    }
    
}


//ITEM CATALOGO FULL
function queryDetallesItemRef($itemvar_){
    global $db;
    $dataQuery = array();
                                               
    $db->where('id_prod_filing',$itemvar_);  
    $db->orderBy('id_prod_filing','desc');        
    $queryTbl = $db->get ('productos_filing', 1, 'id_producto, id_prod_filing, id_estado_contrato, agotado_filing, cod_venta_prod_filing, cod_venta_descri_filing, nome_producto_filing, foto_producto_filing, ref_album_prod_filing, cant_exist_prod_filing, min_exist_prod_filing, id_talla_letras, id_talla_numer, id_color');
    
    $rowQueryTbl = count($queryTbl);
    if($rowQueryTbl>0){
        foreach($queryTbl as $qKey){    
            $idProdItemRef = $qKey['id_prod_filing'];
            $refAlbumItemRef = $qKey['ref_album_prod_filing'];
            $idColorRef = $qKey['id_color'];
            $idTallaNumRef = $qKey['id_talla_numer'];
            $idTallaLetraRef = $qKey['id_talla_letras'];
                            
            //TALLAS LETRAS        
            //$dataQuery[] = tallaLetraRef($idTallaLetraRef);
            $dataTL[] = tallaLetraItemRef($idTallaLetraRef);
            
            if(!is_array($dataTL) && count($dataTL)==0){                
                $dataTL = null;
            }

            //TALLAS NUMEROS
            //$dataQuery[] = tallaNumRef($idTallaNumRef);
            $dataTN[] = tallaNumItemRef($idTallaNumRef);
            if(!is_array($dataTN) && count($dataTN)==0){                
                $dataTN = null;
            }

            //COLORES
            //$dataQuery[] = colorRef($idColorRef);
            $dataColor[] = colorItemRef($idColorRef);
            if(!is_array($dataColor) && count($dataColor)==0){                
                $dataColor = null;
            }
            
            //ALBUM FOTOS
            $dataFotos = fotosRef($refAlbumItemRef);
            if(!is_array($dataFotos) && count($dataFotos)==0){                
                $dataFotos = null;
            }

            //SOBRE EL PRODUCTO
            $idItemGB = $qKey['id_producto'];
            $statusItemRef = $qKey['id_estado_contrato'];
            $actiStockItemRef = $qKey['agotado_filing'];
            $codVentaItemRef = $qKey['cod_venta_prod_filing'];
            $codVentaFullItemRef = $qKey['cod_venta_descri_filing'];
            $nameItemRef = $qKey['nome_producto_filing'];
            $fotoItemRef = $qKey['foto_producto_filing'];            
            $cantItemRef = $qKey['cant_exist_prod_filing'];
            $minCantItemRef = $qKey['min_exist_prod_filing'];

            $dataQuery[] = array(
                'id_producto' => $idItemGB,
                'id_prod_filing' => $idProdItemRef, 
                'id_estado_contrato' => $statusItemRef,
                'agotado_filing' =>$actiStockItemRef,
                'cod_venta_prod_filing' => $codVentaItemRef,
                'cod_venta_descri_filing' =>$codVentaFullItemRef,
                'nome_producto_filing' => $nameItemRef,
                'foto_producto_filing' =>$fotoItemRef,
                'ref_album_prod_filing' =>$refAlbumItemRef,
                'cant_exist_prod_filing' => $cantItemRef,
                'min_exist_prod_filing' =>$minCantItemRef,
                'id_color' => $idColorRef,
                'id_talla_numer'=> $idTallaNumRef,
                'id_talla_letras' => $idTallaLetraRef,
                'tallaletraref' =>$dataTL,
                'tallanumeref' =>$dataTN,
                'colorref' =>$dataColor,
                'fotosref' =>$dataFotos
            );    
            
            
            //$dataQuery[] = $qKey;             
        }        
        return $dataQuery;
    }        
}