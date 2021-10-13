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
 *QUERY PPRENDAS DISPONIBLES
 *==================================
*/


function prendasUserQuery($kitId_, $typeColection_){
    global $db;
    $datasPrenda = array();
    
    $db->where ("id_depart_prod", $typeColection_); 
    $db->where ("tipo_kit_4user", $kitId_);        
    $db->orderBy("nome_catego_product","asc");									
    //$db->orderBy("descri_catego_prod","asc");									
    $kitsQ = $db->get('categorias_productos');    
    $resukitsQ = count($kitsQ);
    if ($resukitsQ > 0){
        foreach ($kitsQ as $kitsQkey) { 
            $datasPrenda[] = $kitsQkey;
        }    
        return $datasPrenda;
    }
    
}

/*
 *==================================
 *QUERY CATEGORIAS 
 *==================================
*/



function catalogoQuery($typeColection_, $k4u_) {
    global $db;
    
    //$typeColection_ = (empty($typeColection_))? "" : $typeColection_;
    
    $db->where ("id_depart_prod", $typeColection_);  
    $db->where ("tipo_kit_4user", $k4u_);        
    $db->orderBy("nome_catego_product","asc");									
    $db->orderBy("descri_catego_prod","asc");									
    $guiaRaza = $db->get('categorias_productos');    
    $resuGuiaRaza = count($guiaRaza);
    if ($resuGuiaRaza > 0){
        foreach ($guiaRaza as $guiakey) { 
            $dataCatalogoProds[] = $guiakey;
        }    
        return $dataCatalogoProds;
    }
}

function categoSelectQuery($idCategoProd_) {
    global $db;
    
    //$typeColection_ = (empty($typeColection_))? "" : $typeColection_;
    
    $db->where ("id_catego_product", $idCategoProd_);        
    $db->orderBy("nome_catego_product","asc");									
    $db->orderBy("descri_catego_prod","asc");									
    $guiaRaza = $db->get('categorias_productos', 1, 'id_catego_product,nome_catego_product,descri_catego_prod'); 
    return $guiaRaza;
    /*$resuGuiaRaza = count($guiaRaza);
    if ($resuGuiaRaza > 0){
        foreach ($guiaRaza as $guiakey) { 
            $dataCatalogoProds[] = $guiakey;
        }    
        return $dataCatalogoProds;
    }*/
}

function subCateCatalogoQuery($idCategoProd_, $adicionalVar_){
//function subCateCatalogoQuery($idCategoProd_) { //$idCategoProd_
    global $db;

    /*$levelProd2 = $db->subQuery ("cat");
    $levelProd2->where ("id_catego_product", $idCategoProd_);           
    $levelProd2->get("categorias_productos");

    $db->join($levelProd2, "sub.id_catego_product=cat.id_catego_product");        
    //$db->orderBy("cat.nome_catego_product","asc");    
    if(isset($adicionalVar_)&& $adicionalVar_ !=""){
    $db->where ("id_subcatego_producto", $adicionalVar_);
    }
    $db->orderBy("sub.posi_sub_cate_prod","asc");    
    $levelProd3 = $db->get ("sub_categorias_productos sub", null, "cat.id_catego_product, cat.nome_catego_product, sub.nome_subcatego_producto, sub.id_subcatego_producto, sub.img_subcate_prod");*/
    
    
    
    
    if(isset($adicionalVar_)&& $adicionalVar_ !=""){
        
        $db->where ("id_subcatego_producto", $adicionalVar_);    
        $db->orderBy("posi_sub_cate_prod","asc");    
        $levelProd3 = $db->get ("sub_categorias_productos", null, "id_catego_product, nome_subcatego_producto, id_subcatego_producto, img_subcate_prod, talla_tipo_prenda, tags_depatament_produsts");
        
        
    }else{
        
        $levelProd2 = $db->subQuery ("cat");
        $levelProd2->where ("id_catego_product", $idCategoProd_);           
        $levelProd2->get("categorias_productos");

        $db->join($levelProd2, "sub.id_catego_product=cat.id_catego_product");    
        $db->orderBy("sub.posi_sub_cate_prod","asc");    
        $levelProd3 = $db->get ("sub_categorias_productos sub", null, "cat.id_catego_product, cat.nome_catego_product, sub.nome_subcatego_producto, sub.id_subcatego_producto, sub.img_subcate_prod, sub.talla_tipo_prenda, sub.tags_depatament_produsts");
        
        
    }

    $resuLevelProd3 = count($levelProd3);
    if ($resuLevelProd3 > 0){
        foreach ($levelProd3 as $level3key) { 
            $dataSubCateCatalogoProds[] = $level3key;    
        }
        return $dataSubCateCatalogoProds;
    }
}

//CHECA LAS PIEZAS INCLUIDAS POR CADA KIT EN EL PEDIDO 
function pzChTO($idSubCateProd_){
    global $db;
    global $otNOW;
    //$dataPZCH = array();
    
    $db->where ("id_subcatego_producto", $idSubCateProd_);
    $db->where ("id_solici_promo", $otNOW);
    $pzCheck= $db->getOne("especifica_prod_pedido","id_subcatego_producto");
    $dataPZCH = $pzCheck['id_subcatego_producto'];
    /*$resupzCheck = count($pzCheck);
    if ($resupzCheck > 0){
        foreach ($pzCheck as $pcK) { 
            $dataPZCH[] = $pcK;    
        }
        return $dataPZCH;
    }*/
    return $dataPZCH;
}

$generoTalla = "";
$input_genero_talla ="";
if(isset($_GET['gender']) && $_GET['gender'] != ""){
    $generoTalla = $_GET['gender'];
    $generoTalla = (string)$generoTalla;  
    $generoTalla = $db->escape($generoTalla);    
    $input_genero_talla = "<input type='hidden' name='gender' value='".$generoTalla."' />";
}else{
    $generoTalla = $typeColectionTag;
    $input_genero_talla = "<input type='hidden' name='gender' value='".$generoTalla."' />";
}

//CARGA GRUPO TALLAS
function especiGrupoTalla($varSubK_){
    global $db;
    global $typeColectionTag;
    global $generoTalla;
    $dataGrupoTalla = array();
    
    $subQ = $db->subQuery ("sb");
    $subQ->where ("id_subcatego_producto", $varSubK_);           
    $subQ->get("sub_categorias_productos");

    //SELECT `id_subcatego_producto`, `id_catego_product`, `nome_subcatego_producto`, `descri_subcatego_prod`, `img_subcate_prod`, `nome_clean_subcatego_prod`, `tags_depatament_produsts`, `posi_sub_cate_prod`, `tipo_prenda`, `talla_tipo_prenda` FROM `sub_categorias_productos` WHERE 1
    
    $db->join($subQ, "sb.talla_tipo_prenda = etp.name_talla_tipo_prenda");    
    //$db->where("sb.tags_depatament_produsts", "etp.genero_talla");
    $db->where("etp.genero_talla", $generoTalla);
    $db->orderBy("etp.posi_talla","asc");    
    $gtQ = $db->get ("especifica_tallas_tipo_prenda etp", null, "etp.id_talla_tablas, etp.talla_tipo_prenda, etp.tipo_talla");
    
    
    
    /*//global $otNOW;
    //$dataPZCH = array();
    //SELECT `id_talla_tipo_prenda`, `name_talla_tipo_prenda`, `id_talla_tablas`, `talla_tipo_prenda`, `tipo_talla`, `genero_talla` FROM `especifica_tallas_tipo_prenda` WHERE 1
    $db->where ("name_talla_tipo_prenda", $tipe_prenda_SubCateProd_);
    $db->where ("genero_talla", $tipe_genero_SubCateProd_);
    $gtQ= $db->get("especifica_tallas_tipo_prenda",null,"id_talla_tablas, talla_tipo_prenda, tipo_talla");
    //$dataPZCH = $pzCheck['id_subcatego_producto'];*/
    $rowGt = count($gtQ);
    if ($rowGt > 0){
        foreach ($gtQ as $gtKey) { 
            $dataGrupoTalla[] = $gtKey;    
        }
        return $dataGrupoTalla;
    }
    
    
}
/*
 *==================================
 *DEFINE FILTROS
 *==================================
*/
/*$idSponsor = $db->rawQuery("INSERT INTO sponsors_leiloes (id_leilao, file_sponsor, url_sponsor) VALUES('".$lastLeilaoID."', '".$nameFileSponsorF.".jpg','".$urldb."')");
if(!$idSponsor){ 
$errsponsordb = "Failed to insert new SPONSOR:\n Erro:". $db->getLastErrno();
$errDBSponsorArr[] = array($errsponsordb);
}*/
/*
 *FILTROS CATALOGOS
 *---1. CATALOGO FULL
 *---2.SEARCH BOX
 *---3.CATEGORIA - SUBCATEGORIA
 *---4.MARCAS
 *---5.TALLAS
 *---6.COLORES
*/
$getCateFilter="";
$getBrandFilter="";
$getTallaFilter="";
$getColorFilter="";

$searchBox_filtro = "";
$l2_filtro = "";
$catego_filtro = "";
$marcas_filtro = "";
$tallas_filtro = "";
$colores_filtro = "";

$searchBox_filtro_query = "";
$l2_filtro_query = "";
$catego_filtro_query = "";
$marcas_filtro_query = "";
$tallas_filtro_query = "";
$colores_filtro_query = "";

$queryCategoSQL = "";
$queryMarcaSQL = "";
$queryTallasSQL = "";
$queryColoresSQL = "";

$filtro_sb_acti = "";
$l2_filtro_acti = "";
$filtro_catego_acti = "";
$filtro_brand_acti = "";
$filtro_talla_acti = "";
$filtro_color_acti = "";

$browseProds = array();
$filterActiItem = array();

/*-----------
2. SEARCH BOX
*/
//$_GET['search'] = "escucha musica";
if(isset($buskString) && isset($buskString) != ""){
    $searchBox_filtro = "{$buskString}";//"%%%%{$_GET['search']}%%%%";
    $searchBox_filtro = (string)$searchBox_filtro;  
    $searchBox_filtro = $db->escape($searchBox_filtro);    
    //$searchBox_filtro_query = "nome_producto LIKE '$searchBox_filtro' OR caracteristicas_producto LIKE '$searchBox_filtro'";
    $searchBox_filtro_query = $searchBox_filtro;
    $browseProds['qsb'] = $searchBox_filtro_query;
}

/*-----------
3. CATEGORIA
*/
//$_GET['catego'] = "7";
//$idCategoProd = $_GET['l2'];
$idCategoProd = "";
//CATEGORIA - NIVEL 2
if(isset($_GET['l2']) && $_GET['l2'] != ""){
    $idCategoProd = $_GET['l2'];
}elseif(isset($_GET['l2inp']) && $_GET['l2inp'] != ""){
    $idCategoProd = $_GET['l2inp'];
}

if(isset($idCategoProd) && $idCategoProd != ""){
    $l2_filtro = $idCategoProd;//$_GET['catego'];
    $l2_filtro = (int)$l2_filtro; 
    $l2_filtro = $db->escape($l2_filtro);    
    //$catego_filtro_query = " id_subcatego_producto = '$catego_filtro' ";
    $l2_filtro_query = $l2_filtro;
    //$queryCategoSQL = "AND id_subcatego_producto = '".$catego_filtro_query."'";            
    
    //$browseProds['ql2'] = $l2_filtro_query;
}


//SUBCATEGORIA
if(isset($_GET['catego']) && $_GET['catego'] != ""){
    $getCateFilter = $_GET['catego'];
}elseif(isset($_GET['catinp']) && $_GET['catinp'] != ""){
    $getCateFilter = $_GET['catinp'];
}

//if(isset($_GET['catego']) && isset($_GET['catego']) != ""){
if(isset($getCateFilter) && $getCateFilter != ""){
    $catego_filtro = $getCateFilter;//$_GET['catego'];
    $catego_filtro = (int)$catego_filtro; 
    $catego_filtro = $db->escape($catego_filtro);    
    //$catego_filtro_query = " id_subcatego_producto = '$catego_filtro' ";
    $catego_filtro_query = $catego_filtro;
    $queryCategoSQL = "AND id_subcatego_producto = '".$catego_filtro_query."'";            
    
    $browseProds['qcate'] = $catego_filtro_query;
}

/*-----------
4. MARCAS
*/

if(isset($_GET['brand']) && $_GET['brand'] != ""){
    $getBrandFilter = $_GET['brand'];
}elseif(isset($_GET['brainp']) && $_GET['brainp'] != ""){
    $getBrandFilter = $_GET['brainp'];    
}

if(isset($getBrandFilter) && $getBrandFilter != ""){
    $marcas_filtro = $getBrandFilter;//$_GET['brand'];
    $marcas_filtro = (int)$marcas_filtro;
    $marcas_filtro = $db->escape($marcas_filtro);    
    //$marcas_filtro_query = "id_marca_producto = '$marcas_filtro'";
    $marcas_filtro_query = $marcas_filtro;
    $queryMarcaSQL = "AND productos.id_marca_prod = '".$marcas_filtro_query."'";            
    
    $browseProds['qbrand'] = $marcas_filtro_query;
    $filterActiItem['brandfilter'] = $marcas_filtro_query;
}


/*-----------
5. TALLAS
*/

if(isset($_GET['tallaq']) && $_GET['tallaq'] != ""){
    $getTallaFilter = $_GET['tallaq'];
}elseif(isset($_GET['tallaqinp']) && $_GET['tallaqinp'] != ""){
    $getTallaFilter = $_GET['tallaqinp'];
}

if(isset($getTallaFilter) && $getTallaFilter != ""){
    $tallas_filtro = $getTallaFilter;//$_GET['brand'];
    $tallas_filtro = (int)$tallas_filtro;
    $tallas_filtro = $db->escape($tallas_filtro);    
    //$marcas_filtro_query = "id_marca_producto = '$marcas_filtro'";
    $tallas_filtro_query = $tallas_filtro;
    $queryTallasSQL = "AND especifica_producto_talla_text.id_talla_letras = '".$tallas_filtro_query."' AND especifica_producto_talla_text.id_producto = productos.id_producto";            
    
    $browseProds['qtalla'] = $tallas_filtro_query;
    $filterActiItem['tallafilter'] = $tallas_filtro_query;
}

/*-----------
6. COLORES
*/

if(isset($_GET['colorq']) && $_GET['colorq'] != ""){
    $getColorFilter = $_GET['colorq'];
}elseif(isset($_GET['colorqinp']) && $_GET['colorqinp'] != ""){
    $getColorFilter = $_GET['colorqinp'];
}

if(isset($getColorFilter) && $getColorFilter != ""){
    $colores_filtro = $getColorFilter;//$_GET['brand'];
    $colores_filtro = (int)$colores_filtro;
    $colores_filtro = $db->escape($colores_filtro);    
    //$marcas_filtro_query = "id_marca_producto = '$marcas_filtro'";
    $colores_filtro_query = $colores_filtro;
    $queryColoresSQL = "AND especifica_product_tipo_color.id_color = '".$colores_filtro_query."' AND especifica_product_tipo_color.id_producto = productos.id_producto";            
    
    $browseProds['qcolor'] = $colores_filtro_query;
    $filterActiItem['colorfilter'] = $colores_filtro_query;
}


/*$bplinkVar = "";
$bplink="";
$bplinkVarCount = "";
foreach($browseProds as $bpKey => $bpVal){
    
    if($bpKey == "qsb"){
        $bplinkVar .= "&search=".$bpVal; 
        $bplinkVarCount++;
    }
    if($bpKey == "qcate"){
        $bplinkVar .= ($bplinkVarCount>0)? "&catego=".$bpVal : "catego=".$bpVal;
        $bplinkVarCount ++;
    }
    if($bpKey == "qbrand"){
        $bplinkVar .= ($bplinkVarCount>0)? "&brand=".$bpVal : "brand=".$bpVal;
        $bplinkVarCount++;
    }
    
    $bplink = "<a href='".$pathmm."takeorder/browse/tmporder.php?".$bplinkVar."' class='btn btn-app'><i class='fa fa-shopping-basket'></i>ShowRoom</a>";        
}*/

/*--------------------------------
//DEFINE SHOW ROOM BTN
*/


if(isset($quqerySR) && $quqerySR != ""){
    $bplink = "<a href='".$pathmm.$takeOrderDir."/browse/tmporder.php?".$quqerySR."' class='btn btn-app'><i class='fa fa-shopping-basket'></i>ShowRoom</a>";    
    $bplinkBack = "<a href='".$pathmm.$takeOrderDir."/browse/?".$quqerySR."' class=''><i class='fa fa-arrow-left'></i>Volver</a>";    
}




/*--------------------------------
//DEFINE GRUPO DE TALLAS
*/

        
$grupoTalla = array();
$grupoTalla = especiGrupoTalla($catego_filtro_query);//$catego_filtro_query
//echo "<pre>";
//print_r($grupoTalla);
//echo "</pre>";


/*--------------------------------
//DEFINE GRUPO DE COLORES
*/

function colorsByCatego($idProdColor_){
    global $db;
    $dataQuery = array();
    
    $subQ = $db->subQuery ("sb");
    $subQ->where ("id_producto", $idProdColor_);           
    $subQ->get("especifica_product_tipo_color");
 
    $db->join($subQ, "sb.id_color = qp.id_color");
    $db->orderBy('qp.nome_color','asc');        
    $gtQ = $db->get ("tipo_color qp", null, "qp.id_color, qp.nome_color, qp.color_hexa");
    
    $rowGt = count($gtQ);
    if ($rowGt > 0){
        foreach ($gtQ as $gtKey) { 
            $dataQuery[] = $gtKey;    
            
        }
        return $dataQuery;
    }
}

function especiGrupoColor($catego_filtro_query_){//$catego_filtro_query_
    global $db;
    $dataGrupoColor = array();
    
    $db->where ("id_subcatego_producto", $catego_filtro_query_);           
    $gtQ = $db->get("productos", null, "id_producto");

    $rowGt = count($gtQ);
    if ($rowGt > 0){
        foreach ($gtQ as $gtKey) { 
            
            $idProdColor = $gtKey['id_producto'];
            
            //BUSCO LOS IDS COLORES PARA ESTOS PRODUCTOS

            $coloresListProdsThisCatego = colorsByCatego($idProdColor);

            $dataGrupoColor[] = $coloresListProdsThisCatego;
               
        }
        return $dataGrupoColor;
    }
}

$grupoColores  = array();
$grupoColoresGet = array();
$grupoColoresGet = especiGrupoColor($catego_filtro_query);
if(is_array($grupoColoresGet)){
    foreach($grupoColoresGet as $gcKey ){
        if(is_array($gcKey)){
            foreach($gcKey as $gcVal){
                $colorListProds[] = $gcVal;    
            }
        }
    }
    
    $grupoColores = unique_multidim_array($colorListProds, 'id_color');
}



//echo $bplinkVarCount."<br>";
//echo $bplink;

/*$browseProds = array('qsb'=>$searchBox_filtro_query,
                    'qcate'=>$catego_filtro_query,
                    'qbrand'=>$marcas_filtro_query);*/
/*$browseProds[] = $searchBox_filtro_query;
$browseProds[] = $catego_filtro_query;
$browseProds[] = $marcas_filtro_query;*/

//test filtros recibidos
/*echo"<pre>";
print_r($browseProds);
echo"</pre>";*/
/*
 *==================================
 *DEFINE FILTROS ACTIVADOS
 *==================================
*/
$filtro_sb_acti = $searchBox_filtro_query;
$l2_filtro_acti = $l2_filtro_query;
$filtro_catego_acti = $catego_filtro_query;
$filtro_brand_acti = $marcas_filtro_query;    
$filtro_talla_acti = $tallas_filtro_query;
$filtro_color_acti = $colores_filtro_query;
/*===============
print filtros acti
*/
$input_sb="";
$input_l2="";
$input_cate="";
$input_brand ="";
$input_talla ="";
$input_color ="";

//filtro activado en BROWSE LOCATION -> BREADCRUMB
$bc_acti = "";

//2. STRING SEARCH BOX
if($filtro_sb_acti!=""){
    $input_sb = "<input type='hidden' name='search' value='".$filtro_sb_acti."' />";//<input type='hidden' name='sb' value='ok' />
    $bc_acti .= "<li><a href='#'>".$filtro_sb_acti."</a></li>";
}

//3. CATEGORIA  
$piezas_kit_Level2Acti="";
if($l2_filtro_acti!=""){
    $db->where ("id_catego_product", $l2_filtro_acti);            
    $printLev2Acti = $db->getOne('categorias_productos', 'id_catego_product, nome_catego_product, descri_catego_prod, cant_pz_kit');                                        
    $printLev2Acti_id = $printLev2Acti['id_catego_product'];
    $printLev2Acti_nome = $printLev2Acti['nome_catego_product'];
    $printLev2Acti_subnome = $printLev2Acti['descri_catego_prod'];
    $piezas_kit_Level2Acti = $printLev2Acti['cant_pz_kit']; 
    
    $input_l2 = "<input type='hidden' name='l2inp' value='".$l2_filtro_acti."' />";
    $bc_acti .= "<li><a href='#'>".$printLev2Acti_nome."</a></li>";
                                
}

$printLev3Acti_nome = "";
if($filtro_catego_acti!=""){
    $db->where ("id_subcatego_producto", $filtro_catego_acti);            
    $printLev3Acti = $db->getOne('sub_categorias_productos', 'id_subcatego_producto, nome_subcatego_producto, tipo_prenda');                                        
    $printLev3Acti_id = $printLev3Acti['id_subcatego_producto'];
    $printLev3Acti_nome = $printLev3Acti['nome_subcatego_producto'];
    $printLev3Acti_tipoprenda = $printLev3Acti['tipo_prenda'];
    $input_cate = "<input type='hidden' name='catinp' value='".$filtro_catego_acti."' />";
    $bc_acti .= "<li><a href='#'>".$printLev3Acti_nome."</a></li>";
                                
}

//4. MARCA
if($filtro_brand_acti!=""){
    $db->where ("id_marca_prod", $filtro_brand_acti);            
    $printBrandActi = $db->getOne('marcas_prods', 'id_marca_prod, nome_marca_prod');                                        
    $printBrandActi_id = $printBrandActi['id_marca_prod'];
    $printBrandActi_nome = $printBrandActi['nome_marca_prod'];
    $input_brand = "<input type='hidden' name='brainp' value='".$filtro_brand_acti."' />";
    $bc_acti .= "<li><a href='#'>".$printBrandActi_nome."</a></li>";
}

//5. TALLAS
if($filtro_talla_acti != ""){
    $db->where ("id_talla_letras", $filtro_talla_acti);            
    $printTLActi = $db->getOne('talla_letras', 'id_talla_letras, nome_talla_letras');                                        
    $printTLActi_id = $printTLActi['id_talla_letras'];
    $printTLActi_nome = $printTLActi['nome_talla_letras'];
    $input_talla = "<input type='hidden' name='tallaqinp' value='".$filtro_talla_acti."' />";
    $bc_acti .= "<li><a href='#'>".$printTLActi_nome."</a></li>";
}

//6. COLORES
if($filtro_color_acti != ""){
    $db->where ("id_color", $filtro_color_acti);            
    $printCOLORActi = $db->getOne('tipo_color', 'id_color, nome_color, color_hexa');                                        
    $printCOLORActi_id = $printCOLORActi['id_color'];
    $printCOLORActi_nome = $printCOLORActi['nome_color'];
    $printHEXACOLORActi_nome = $printCOLORActi['color_hexa'];
    $input_color = "<input type='hidden' name='colorqinp' value='".$filtro_color_acti."' />";
    $bc_acti .= "<li><a href='#'>".$printCOLORActi_nome."</a></li>";
}




/*
 *==================================
 *QUERY PRODUCTOS
 *==================================
*/

function queryProds(){
    global $db;    
    global $searchBox_filtro_query;
    global $catego_filtro_query;
    global $marcas_filtro_query;
    global $tallas_filtro_query;
    global $colores_filtro_query;
    
    global $l2_filtro_acti;
    global $filtro_catego_acti;
    global $filtro_brand_acti;
    global $filtro_talla_acti;
    global $filtro_color_acti;
    global $printLev3Acti_tipoprenda;
    
    global $queryCategoSQL;
    global $queryMarcaSQL;
    global $browseProds;
    global $queryTallasSQL;
    global $queryColoresSQL;
    
    $prodTBLget = array();
    $prodTBL = array();        
    $filtrosQueryProds = "";    
    
    if(is_array($browseProds) && count($browseProds) > 0){
        //SELECT `id_prod_filing`, `id_producto`, `id_estado_contrato`, `agotado`, `cod_venta_prod`, `cod_venta_descri`, `nome_producto`, `foto_producto`, `txt_alt_img_prod`, `cant_exist_prod_filing`, `max_exist_prod_filing`, `min_exist_prod_filing`, `id_talla_letras`, `id_talla_numer`, `id_color` FROM `productos_filing` WHERE 1
        //$db->where('id_catego_product', $l2_filtro_acti);        
        
        
        /*$db->where('id_subcatego_producto', $filtro_catego_acti);
        $db->where('id_color', $filtro_color_acti);
        if($printLev3Acti_tipoprenda == "tl"){
            $db->orWhere('id_talla_letras', $filtro_talla_acti);    
        }elseif($printLev3Acti_tipoprenda == "tn"){
            $db->Where('id_talla_numer', $filtro_talla_acti);    
        }                
        $prodTBLget = $db->get('productos_filing', null, 'id_producto, id_prod_filing'); */
        
        
        
        $filingProd = $db->subQuery ("fp");        
        $filingProd->where('id_subcatego_producto', $filtro_catego_acti);
        $filingProd->where('id_color', $filtro_color_acti);
        if($printLev3Acti_tipoprenda == "tl"){
            $filingProd->Where('id_talla_letras', $filtro_talla_acti);    
        }elseif($printLev3Acti_tipoprenda == "tn"){
            $filingProd->Where('id_talla_numer', $filtro_talla_acti);    
        }                
        $filingProd->get("productos_filing");

        $db->join($filingProd, "fp.id_producto=prod.id_producto");        
        //$db->orderBy("tc.nome_color","asc");
        $prodTBLget = $db->get ("productos prod", null, "prod.id_producto, prod.id_estado_contrato, prod.agotado, prod.id_catego_product, prod.id_subcatego_producto, prod.id_marca_prod, prod.cod_venta_prod, prod.nome_producto, prod.foto_producto, prod.txt_alt_img_prod, prod.caracteristicas_producto, prod.url_amigable_prod, fp.id_prod_filing, fp.id_producto, fp.cod_venta_prod_filing, fp.cod_venta_descri_filing, fp.cant_exist_prod_filing, fp.id_talla_letras, fp.id_talla_numer, fp.id_color, fp.ref_album_prod_filing, fp.foto_producto_filing");
        
        
        
        
        
        
        //$prodTBLget = $db->get( //, id_estado_contrato, agotado, id_subcatego_producto, cod_venta_prod, cod_venta_descri, nome_producto, foto_producto, cant_exist_prod_filing, id_talla_letras, id_talla_numer, id_color
        
        
        /*if($catego_filtro_query != ""){                        
            $filtrosQueryProds = "SELECT id_producto, id_estado_contrato, oferta, agotado, id_catego_product, id_subcatego_producto, id_marca_prod, cod_venta_prod, nome_producto, foto_producto, txt_alt_img_prod, precio_producto, precio_antes, impuesto_producto, utilidad_costo_prod, porcent_dcto_mayor_prod, max_dcto_mayor, max_dcto_utilidad, precio_unit_prod, dscto_prod, condi_oferta, caracteristicas_producto, url_amigable_prod, acti_imp, agotado_imp, datetime_publi, datetime_server FROM productos WHERE id_subcatego_producto = '".$catego_filtro_query."' ".$queryMarcaSQL."";
        }

        $prodTBL = $db->rawQuery($filtrosQueryProds);*/
        
        
                                        
        /*if ($searchBox_filtro_query != ""){
                                    
            //define string query cantidad palabras
            $trozos=explode(" ",$searchBox_filtro_query );
            $numero=count($trozos);
                                                                        
            //define query string search box
            if ($numero>1) {		
                
                $filtrosQueryProds = "SELECT id_producto, id_estado_contrato, oferta, agotado, id_catego_product, id_subcatego_producto, id_marca_prod, cod_venta_prod, nome_producto, foto_producto,  txt_alt_img_prod, precio_producto, precio_antes, impuesto_producto, utilidad_costo_prod, porcent_dcto_mayor_prod, max_dcto_mayor, max_dcto_utilidad, precio_unit_prod, dscto_prod, condi_oferta, caracteristicas_producto, url_amigable_prod, acti_imp, agotado_imp, datetime_publi, datetime_server, MATCH (cod_venta_prod, nome_producto, caracteristicas_producto) AGAINST ( '$searchBox_filtro_query' ) AS Score FROM productos WHERE (MATCH (cod_venta_prod, nome_producto, caracteristicas_producto) AGAINST ( '$searchBox_filtro_query' IN NATURAL LANGUAGE MODE WITH QUERY EXPANSION )) ORDER BY Score DESC";//".$queryCategoSQL." ".$queryMarcaSQL."
            }else{	
                 
                $filtrosQueryProds = "SELECT id_producto, id_estado_contrato, oferta, agotado, id_catego_product, id_subcatego_producto, id_marca_prod, cod_venta_prod, nome_producto, foto_producto, txt_alt_img_prod, precio_producto, precio_antes, impuesto_producto, utilidad_costo_prod, porcent_dcto_mayor_prod, max_dcto_mayor, max_dcto_utilidad, precio_unit_prod, dscto_prod, condi_oferta, caracteristicas_producto, url_amigable_prod, acti_imp, agotado_imp, datetime_publi, datetime_server FROM productos WHERE (nome_producto LIKE '%%%$searchBox_filtro_query%%%' OR caracteristicas_producto LIKE '%%%$searchBox_filtro_query%%%' OR cod_venta_prod LIKE '%%%$searchBox_filtro_query%%%')";//".$queryCategoSQL." ".$queryMarcaSQL."
            }
                        
        }//if $buskString
        
            
        //FILTROS CATEGORIA -> NIVEL2 - NIVEL3   $l2_filtro_query
        if(isset($filtro_catego_acti) && $filtro_catego_acti !=""){
            $db->where('id_catego_product', $l2_filtro_acti);
            $db->where('id_subcatego_producto', $filtro_catego_acti);
            $prodTBLget = $db->get('productos', null, 'id_producto');   
        }
        
        
        //FILTROS ADICIONALES   TALLAS -COLORES - MATERIALES - MARCAS
        if(isset($filtro_brand_acti) && $filtro_brand_acti !=""){
            $db->where('id_marca_prod', $filtro_brand_acti);
            $prodTBLget = $db->get('productos', null, 'id_producto');   
        }
        
        
        if(isset($filtro_talla_acti) && $filtro_talla_acti !=""){
            $db->where('id_talla_letras', $filtro_talla_acti);
            $prodTBLget = $db->get('especifica_producto_talla_text', null, 'id_producto');   
        }
        
        if(isset($filtro_color_acti) && $filtro_color_acti !=""){
            $db->where('id_color', $filtro_color_acti);
            $prodTBLget = $db->get('especifica_product_tipo_color', null, 'id_producto');   
        }*/



        
        
        
        $keyPRODTBL = "id_producto";
        $prodTBL = unique_multidim_array($prodTBLget, $keyPRODTBL);//$prodTBLget =
                        
        /*if(is_array($prodTBLget) && count($prodTBLget) > 0){
             $codeProdFiling = array();
            foreach($prodTBLget as $ptblKey=>$ptblVal){
               
                
                //foreach($ptblKey as $ptblVal){
                    //$prodTBL[][]['profiling'] = $ptblVal['id_prod_filing'];
                    //$codeProdFiling = array( 'profiling' => $ptblVal['id_prod_filing']);
                $codeProdFiling[] =  $ptblVal['id_prod_filing'];
                    $codeProdQ = $ptblVal['id_producto'];
                    $filtrosQueryProds = "SELECT productos.id_producto, productos.id_estado_contrato, productos.agotado, productos.id_catego_product, productos.id_subcatego_producto, productos.id_marca_prod, productos.cod_venta_prod, productos.nome_producto, productos.foto_producto, productos.txt_alt_img_prod, productos.caracteristicas_producto, productos.url_amigable_prod FROM productos WHERE productos.id_producto = ".$codeProdQ;    
                    $prodTBL[] = $db->rawQuery($filtrosQueryProds);  //, productos_filing.id_producto, productos_filing.cant_exist_prod_filing, productos_filing.id_talla_letras, productos_filing.id_talla_numer, productos_filing.id_color FROM productos, productos_filing WHERE productos_filing.id_producto = productos.id_producto AND  productos.id_producto = ".$ptblVal;
                    //$prodTBL[][]['profiling'] = $ptblVal['id_prod_filing'];
//                    $prodTBL[] = array(
//                        $db->rawQuery($filtrosQueryProds),
//                        'profiling' => $ptblVal['id_prod_filing'],
//                        
//                    );
                //}                                
                $prodTBL[] = array_push($codeProdFiling, $prodTBL);
            }                         
        }*/
                                 
    }/*else{
        $prodTBL = $db->get('productos', null, 'id_producto, id_estado_contrato, oferta, agotado, id_catego_product, id_subcatego_producto, id_marca_prod, cod_venta_prod, nome_producto, foto_producto, txt_alt_img_prod, precio_producto, precio_antes, impuesto_producto, utilidad_costo_prod, porcent_dcto_mayor_prod, max_dcto_mayor, max_dcto_utilidad, precio_unit_prod, dscto_prod, condi_oferta, caracteristicas_producto, url_amigable_prod, acti_imp, agotado_imp, datetime_publi, datetime_server');
    }*/
    //echo "<pre>";    
    //print_r($prodTBL);
    //echo "</pre>";
    //ENVIAR ARRAY CON PRODUCTOS ENCONTRADOS
    if(is_array($prodTBL) && count($prodTBL)>0){
        return $prodTBL;        
    }
               
}//query prods

//ALBUM FOTOS PROD
function queryFotosProd($albumRef_) {
        global $db;
        //global $varraca;
         //$guia_ = array('lorem-ipsum-dolor-sit-amet-cinco' , 'nome-criatorio');//"lorem-ipsum-dolor-sit-amet-cinco";
        
        //$bbannerRaca = $db->subQuery ("a");
        //$bbannerRaca->where ("id_raza", $idraca);
        //$bbannerRaca->get("albun_db");

        $guiaRaca = $db->subQuery ("a");
        $guiaRaca->where ("ref_album", $albumRef_);
        $guiaRaca->get("albun_db");

        //$db->join($bbannerRaca, "r.id_raza=b.id_raza", "LEFT");
        //$db->join($guiaRaca, "f.id_albun=a.id_albun", "LEFT");
        $db->join($guiaRaca, "f.id_albun=a.id_albun");
        //$db->where ("f.id_albun", $guiaRaca['id_albun']);
        $db->orderBy("f.id_foto","desc");
        $fotosGuia = $db->get ("fotos_albun f", 3, "a.nome_albun, a.portada_album, a.ref_album, f.img_foto");
                                        
        /*$db->where ("id_raza", $varraca);
        $db->orderBy("id_bigbanner","Desc");									
        $bbannerAsoc = $db->get('bbanner_raca_profile'); */   
        $resuFotos = count($fotosGuia);
        if ($resuFotos > 0){
            foreach ($fotosGuia as $imgkey) { 
                $dataFotosGuia[] = $imgkey;    
            }
            return $dataFotosGuia;
        }
    }


function especificaColor($idProd_) {
    global $db;

    $etcProd = $db->subQuery ("etc");
    $etcProd->where ("id_producto", $idProd_);
    $etcProd->get("especifica_product_tipo_color");

    $db->join($etcProd, "etc.id_color=tc.id_color");        
    $db->orderBy("tc.nome_color","asc");
    $coloProdQuery = $db->get ("tipo_color tc", 3, "etc.id_producto, tc.id_color, tc.color_hexa, tc.nome_color");


    $resuColoProdQuery = count($coloProdQuery);
    if ($resuColoProdQuery > 0){
        foreach ($coloProdQuery as $etckey) { 
            $dataEtcProd[] = $etckey;    
        }
        return $dataEtcProd;
    }
}


//DETALLES FILTROS

function especificaColorItem($colorItemID_) {
    global $db;
       
    $db->where("id_color",$colorItemID_);
    $coloProdQuery = $db->get ("tipo_color", 1, "id_color, color_hexa, nome_color");
    //print_r($coloProdQuery);
    return $coloProdQuery;


    /*$resuColoProdQuery = count($coloProdQuery);
    if ($resuColoProdQuery > 0){
        foreach ($coloProdQuery as $etckey) { 
            $dataEtcProd[] = $etckey;    
        }
        return $dataEtcProd;
    }*/
}

function especificaTallaItem($tallaItemID_, $tipoPrenda_) {
    global $db;
    
    if($tipoPrenda_ == "tl"){
        $primaryTallaTBL = "id_talla_letras";
        $tallaTBL = "talla_letras";
        $selectTallTBL = "id_talla_letras, nome_talla_letras";        
    }elseif($tipoPrenda_ == "tn"){
        $primaryTallaTBL = "id_talla_numer";
        $tallaTBL = "talla_numerico";   
        $selectTallTBL = "id_talla_numer, talla_numer";
    }
       
    $db->where($primaryTallaTBL,$tallaItemID_);
    $tallaProdQuery = $db->get ($tallaTBL, 1, $selectTallTBL);
    
    return $tallaProdQuery;


    /*$resuColoProdQuery = count($coloProdQuery);
    if ($resuColoProdQuery > 0){
        foreach ($coloProdQuery as $etckey) { 
            $dataEtcProd[] = $etckey;    
        }
        return $dataEtcProd;
    }*/
}


function especificaMaterialItem($idProd_) {
    global $db;
    $dataEtmProd = array();
    $etmProd = $db->subQuery ("emp");
    $etmProd->where ("id_producto", $idProd_);
    $etmProd->get("especifica_prod_material");

    $db->join($etmProd, "emp.id_material=tm.id_material");          	
    //$db->orderBy("tc.nome_color","asc");
    $materialProdQuery = $db->get ("tipo_material tm", null, "tm.nome_material, tm.valor_material");


    $resuMaterialProdQuery = count($materialProdQuery);
    if ($resuMaterialProdQuery > 0){
        foreach ($materialProdQuery as $etmkey) { 
            $dataEtmProd[] = $etmkey;    
        }
        return $dataEtmProd;
    }
}

//$wasdfadasd = especificaMaterialItem('43');
//print_r($wasdfadasd);

//guias publicadas usuario
/*function guiaraza() {
    global $db;
    global $idDBUser;

    $db->where ("id_accountusu", $idDBUser);
    $db->orderBy("id_guia","Desc");									
    $guiaRaza = $db->get('guia');    
    $resuGuiaRaza = count($guiaRaza);
    if ($resuGuiaRaza > 0){
        foreach ($guiaRaza as $guiakey) { 
            $dataGuia[] = $guiakey;
        }    
        return $dataGuia;
    }
}

//album fotos          
function fotosGuiaRazas($guia_) {
    global $db;

    $guiaRaca = $db->subQuery ("a");
    $guiaRaca->where ("ref_album", $guia_);
    $guiaRaca->get("albun_db");

    $db->join($guiaRaca, "f.id_albun=a.id_albun");        
    $db->orderBy("f.id_foto","desc");
    $fotosGuia = $db->get ("fotos_albun f", 3, "a.nome_albun, a.portada_album, a.ref_album, f.img_foto");


    $resuFotos = count($fotosGuia);
    if ($resuFotos > 0){
        foreach ($fotosGuia as $imgkey) { 
            $dataFotosGuia[] = $imgkey;    
        }
        return $dataFotosGuia;
    }
}*/





/*
 *==================================
 *QUERY INFO - DETALLES PROD
 *==================================
*/

/*function queryInfoProd($idProd){
    global $db;    
}*/