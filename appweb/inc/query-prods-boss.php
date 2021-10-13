<?php
/*
 *==================================
 *QUERY ESQUEMA GLOBAL
 *==================================
*/


function getCalidoKit($dotKIT_, $varL2Prod_){
    global $db;
    $dataAddKit = array();
    
    $smCatDot = $db->subQuery ('cd');        
    
    $smCatDot->where('id_catego_product', $varL2Prod_);
    $smCatDot->where('tipo_kit_4user', $dotKIT_);    
    //$db->orderBy('tipo_kit_4user','asc');
    $smCatDot->get('categorias_productos');

    $db->join($smCatDot, 'scd.id_catego_product=cd.id_catego_product');                        
    //$db->orderBy('scd.nome_subcatego_producto','asc');
    $resuAK = $db->get ('sub_categorias_productos scd', null, 'cd.id_depart_prod, cd.id_catego_product, cd.nome_catego_product, cd.descri_catego_prod, scd.id_subcatego_producto, scd.nome_subcatego_producto, cd.tipo_kit_4user'); 
    
    if(count($resuAK)>0){
    foreach($resuAK as $rakKey){
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
    
    $smCatDot->where('id_catego_product', $varL2Prod_);
    $smCatDot->where('tipo_kit_4user', $dotKIT_);    
    //$db->orderBy('tipo_kit_4user','asc');
    $smCatDot->get('categorias_productos');

    $db->join($smCatDot, 'scd.id_catego_product=cd.id_catego_product');                        
    //$db->orderBy('scd.id_catego_product','asc');
   $resuAK = $db->get ('sub_categorias_productos scd', null, 'cd.id_depart_prod, cd.id_catego_product, cd.nome_catego_product, cd.descri_catego_prod, scd.id_subcatego_producto, scd.nome_subcatego_producto, cd.tipo_kit_4user'); 
    
    if(count($resuAK)>0){
    foreach($resuAK as $rakKey){
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
    
    $smCatDot->where('id_catego_product', $varL2Prod_);
    $smCatDot->where('tipo_kit_4user', $dotKIT_);    
    //$db->orderBy('tipo_kit_4user','asc');
    $smCatDot->get('categorias_productos');

    $db->join($smCatDot, 'scd.id_catego_product=cd.id_catego_product');                        
    //$db->orderBy('scd.nome_subcatego_producto','asc');
    $resuAK = $db->get ('sub_categorias_productos scd', null, 'cd.id_depart_prod, cd.id_catego_product, cd.nome_catego_product, cd.descri_catego_prod, scd.id_subcatego_producto, scd.nome_subcatego_producto, cd.tipo_kit_4user'); 
    
    if(count($resuAK)>0){
    foreach($resuAK as $rakKey){
        $dataAddKit[] = $rakKey;
       // $dataAddKit['tipo_kit_4user'] = "adicional";
    }
    return $dataAddKit;
    }
}


function  defUserPackDot(){
    global $db;
        
    //ARRAY PRINT SITE MAP USER    
    $dataDefUserPackDot = array();
    //CATEGORIAS
    //$smPackDot = $db->subQuery ('pd');        
    //$smPackDot->where('id_account_user', $idSSUser);                                                     
    //$smPackDot->where('kit', 'adicional', '!=');
    //$smPackDot->get('departamento_prods');


    //$db->join($smPackDot, 'pd.id_depart_prod=cp.id_depart_prod');     
    
    //PARA HOMBRE
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
                /*//SUBCATEGORIAS
                $smCatDot = $db->subQuery ('cd');        
                $smCatDot->where('id_catego_product', $varL2Prod);
                $smCatDot->where('tipo_kit_4user', $ifADDKIT);
                //$smCatDot->where('tipo_kit_4user', 'zapatos', '!=');
                $db->orderBy('tipo_kit_4user','asc');
                $smCatDot->get('categorias_productos');

                $db->join($smCatDot, 'scd.id_catego_product=cd.id_catego_product');                        
                $db->orderBy('scd.nome_subcatego_producto','asc');
                $dataDefUserPackDot[] = $db->get ('sub_categorias_productos scd', null, 'cd.id_depart_prod, cd.id_catego_product, cd.nome_catego_product, cd.descri_catego_prod, scd.id_subcatego_producto, scd.nome_subcatego_producto, cd.tipo_kit_4user'); */
                $dataDefUserPackDot[] = getFrioKit($dotKIT, $varL2Prod);
    
           // }
            
            //if($dotKIT == "calido"){
                /*//SUBCATEGORIAS
                $smCatDot = $db->subQuery ('cd');        
                $smCatDot->where('id_catego_product', $varL2Prod);
                $smCatDot->where('tipo_kit_4user', $ifADDKIT);
                //$smCatDot->where('tipo_kit_4user', 'zapatos', '!=');
                $db->orderBy('tipo_kit_4user','asc');
                $smCatDot->get('categorias_productos');

                $db->join($smCatDot, 'scd.id_catego_product=cd.id_catego_product');                        
                $db->orderBy('scd.nome_subcatego_producto','asc');
                $dataDefUserPackDot[] = $db->get ('sub_categorias_productos scd', null, 'cd.id_depart_prod, cd.id_catego_product, cd.nome_catego_product, cd.descri_catego_prod, scd.id_subcatego_producto, scd.nome_subcatego_producto, cd.tipo_kit_4user'); */
                //$dataDefUserPackDot[] = getCalidoKit($dotKIT, $varL2Prod);
    
            //}
            
            //if($dotKIT == "zapatos"){
                /*//SUBCATEGORIAS
                $smCatDot = $db->subQuery ('cd');        
                $smCatDot->where('id_catego_product', $varL2Prod);
                $smCatDot->where('tipo_kit_4user', $ifADDKIT);
                //$smCatDot->where('tipo_kit_4user', 'zapatos', '!=');
                $db->orderBy('tipo_kit_4user','asc');
                $smCatDot->get('categorias_productos');

                $db->join($smCatDot, 'scd.id_catego_product=cd.id_catego_product');                        
                $db->orderBy('scd.nome_subcatego_producto','asc');
                $dataDefUserPackDot[] = $db->get ('sub_categorias_productos scd', null, 'cd.id_depart_prod, cd.id_catego_product, cd.nome_catego_product, cd.descri_catego_prod, scd.id_subcatego_producto, scd.nome_subcatego_producto, cd.tipo_kit_4user'); */
               // $dataDefUserPackDot[] = getZapatoKit($dotKIT, $varL2Prod);
    
           // }

                              
        }
        
        //PARA MUJER
        
    }
    return $dataDefUserPackDot;
}//fin function defUserPackDot



/*
 *==================================
 *QUERY ESQUEMA SUBCATEGO ESPECIFICO
 *==================================
*/
function subCateCatalogoQuery($idCategoProd_, $adicionalVar_){
//function subCateCatalogoQuery($idCategoProd_) { //$idCategoProd_
    global $db;

    ///if(isset($adicionalVar_)&& $adicionalVar_ !=""){
        
        $db->where ("id_subcatego_producto", $adicionalVar_);    
        //$db->orderBy("posi_sub_cate_prod","asc");    
        $levelProd3 = $db->get ("sub_categorias_productos", null, "id_catego_product, nome_subcatego_producto, id_subcatego_producto, img_subcate_prod, descri_subcatego_prod, tipo_prenda, tags_depatament_produsts");
        
        
    /*}else{
        
        $levelProd2 = $db->subQuery ("cat");
        $levelProd2->where ("id_catego_product", $idCategoProd_);           
        $levelProd2->get("categorias_productos");

        $db->join($levelProd2, "sub.id_catego_product=cat.id_catego_product");    
        $db->orderBy("sub.posi_sub_cate_prod","asc");    
        $levelProd3 = $db->get ("sub_categorias_productos sub", null, "cat.id_catego_product, cat.nome_catego_product, sub.nome_subcatego_producto, sub.id_subcatego_producto, sub.img_subcate_prod");
        
        
    }*/

    $resuLevelProd3 = count($levelProd3);
    if ($resuLevelProd3 > 0){
        foreach ($levelProd3 as $level3key) { 
            $dataSubCateCatalogoProds[] = $level3key;    
        }
        return $dataSubCateCatalogoProds;
    }
}


$userPDActiArr = array();
$userPDActiArr = defUserPackDot();
//echo "<pre>";
//print_r($userPDActiArr);
//echo "</pre>";



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
//$idCategoProd = "";
//CATEGORIA - NIVEL 2
$idCategoProd = "";
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
$printLev2Acti_nome = "";
if($l2_filtro_acti!=""){
    $db->where ("id_catego_product", $l2_filtro_acti);            
    $printLev2Acti = $db->getOne('categorias_productos', 'id_catego_product, nome_catego_product, descri_catego_prod, tipo_kit_4user');                                        
    $printLev2Acti_id = $printLev2Acti['id_catego_product'];
    $printLev2Acti_nome = $printLev2Acti['nome_catego_product'];
    $printLev2Acti_subnome = $printLev2Acti['descri_catego_prod'];
        $printLev2Acti_nomekit = $printLev2Acti['tipo_kit_4user'];
    
    $input_l2 = "<input type='hidden' name='l2inp' value='".$l2_filtro_acti."' />";
    $bc_acti .= "<li><a href='#'>".$printLev2Acti_nome."</a></li>";
                                
}
$printLev3Acti_id = "";
$printLev3Acti_nome = "";
if($filtro_catego_acti!=""){
    $db->where ("id_subcatego_producto", $filtro_catego_acti);            
    $printLev3Acti = $db->getOne('sub_categorias_productos', 'id_subcatego_producto, nome_subcatego_producto, tipo_prenda, tags_depatament_produsts');                                        
    $printLev3Acti_id = $printLev3Acti['id_subcatego_producto'];
    $printLev3Acti_nome = $printLev3Acti['nome_subcatego_producto'];
    $printLev3Acti_tipoprenda = $printLev3Acti['tipo_prenda'];
    $printLevel3Acti_genero = $printLev3Acti['tags_depatament_produsts'];
    
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
/*
/*LAYOUT NAVEGACION CATALOGO
/*
*/

/*
//LEVEL 1
//SELECT `id_depart_prod`, `nome_depart_prod`, `descri_depart_prod`, `nome_clean_depa_prod` FROM `departamento_prods` WHERE 1
function levelDpto(){
    global $db;
    $dataLevel = array();
    
    //$db->orderBy("sub.posi_sub_cate_prod","asc");    
    $db->where ("departamento_prods", "id_depart_prod, nome_depart_prod, nome_clean_depa_prod");
    $levelQ = $db->get ("departamento_prods", "id_depart_prod, nome_depart_prod, nome_clean_depa_prod");
    
    $rowLevel = count($levelQ);    
    if ($rowLevel > 0){
        foreach ($levelQ as $lkey) { 
            $varL1 = $lkey['id_depart_prod'];                                    
            $nameL1 = $lkey['nome_depart_prod'];
            $lylevel = "<li class='menu__item'><a class='menu__link' data-submenu='submenu-".$varL1."' href='#'>".$nameL1."</a></li>";
            $dataLevel[] = $lylevel;    
        }
        return $dataLevel;
    }
}
//KITS
//SELECT `id_catego_product`, `id_depart_prod`, `nome_catego_product`, `descri_catego_prod`, `tags_depatament_produsts`, `tipo_kit_4user` FROM `categorias_productos` WHERE 1
function levelKit(){
    global $db;
    $dataLevel = array();
    
    $db->orderBy("tipo_kit_4user","asc");    
    $levelQ = $db->get ("categorias_productos", "id_depart_prod, id_catego_product, nome_catego_product, tipo_kit_4user");
    
    $rowLevel = count($levelQ);
    if ($rowLevel > 0){
        foreach ($levelQ as $lkey) { 
            $varL1 = $lkey['id_depart_prod'];
            $varKit = $lkey['tipo_kit_4user'];
            
            $lylevel = "<ul data-menu='submenu-".$varL1."' class='menu__level'>";
            $lylevel .= "<li class='menu__item'><a class='menu__link' data-submenu='submenu-".$varL1."-".$varKit."' href='#'>".$varKit."</a></li>";
            $lylevel .= "</ul>";
            
            $dataLevel[] = $lylevel;     
        }
        return $dataLevel;
    }
}

//LEVEL2
function levelCat(){
    global $db;
    $dataLevel = array();
    
    
   
    
    $db->where('tipo_kit_4user', 'adicional', '!=');
    $levelQ = $db->get ("categorias_productos", null, "id_depart_prod, id_catego_product, nome_catego_product, tipo_kit_4user");
    
    $varL1 = $levelQ['id_depart_prod'];
    $varKit = $levelQ['tipo_kit_4user'];
    
    $lylevel = "<ul submenu-".$varL1."-".$varKit.">";
    
    $rowLevel = count($levelQ);
    //$lylevel ="";
    
    if ($rowLevel > 0){
        foreach ($levelQ as $lkey) { 
            
            //$varL1 = $lkey['id_depart_prod'];
            //$varKit = $lkey['tipo_kit_4user'];
            $varCat = $lkey['id_catego_product'];
            //$varSubcat = $lkey['id_subcatego_producto'];
            $nameCat = $lkey['nome_catego_product'];
            
            $lylevel .= "<li class='menu__item'><a class='menu__link' data-submenu='submenu-".$varL1."-".$varKit."-".$varCat."' href='#'>".$nameCat."</a>";  
                                                   
            $dataLevel[] = $lylevel; 
        }
        return $dataLevel;
    }    
}



main (L1)
 submenu-L1 (kit)
   submenu-L1-kit  (cat)
      submenu-L1-kit-L2  (cat)

*/



//echo "<pre>";
//print_r($asdasd);
//echo "</pre>";









