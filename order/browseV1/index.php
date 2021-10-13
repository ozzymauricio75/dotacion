<?php require_once '../../appweb/lib/MysqliDb.php'; ?>
<?php require_once '../../cxconfig/config.inc.php'; ?>
<?php require_once '../../cxconfig/global-settings.php'; ?>
<?php require_once '../../appweb/inc/sessionvars.php'; ?>
<?php require_once '../../appweb/lib/gump.class.php'; ?>
<?php require_once '../../appweb/inc/site-tools.php'; ?>
<?php require_once '../../appweb/inc/query-prods.php'; ?>
<?php require_once '../../appweb/inc/valida-pedido-tmp.php'; ?>
<?php require_once '../../appweb/inc/process-shop.php'; ?>

<?php 
/*
///////////////////////////////////////////////////
//////////////////////////////////////////////////
++++++++++++++++++++++++++++++++++++++++++++++++++++
CRUD CATALOGO - PEDIDO
++++++++++++++++++++++++++++++++++++++++++++++++++++
///////////////////////////////////////////////////
//////////////////////////////////////////////////
*/

//DEFINE VARS
$printCatalogo = array();
$subCateArr = array();
$printSubCate = array();
$printPzasOrder = array();


//$idCategoProd = $_GET['l2'];

//IMPRIME CATEGORIAS - CATALOGO ->[[[KITS]]]

$printCatalogo = categoSelectQuery($idCategoProd);
foreach($printCatalogo as $printCatKey){
    $idCategoProd = $printCatKey['id_catego_product'];
    $nomeCategoProd = $printCatKey['nome_catego_product'];
    $subNomeCategoProd = $printCatKey['descri_catego_prod'];
}




//IMPRIME SUBCATEGOS

/*$printSubCate = subCateCatalogoQuery();
echo "<pre>";
print_r($printSubCate);
echo "</pre>";*/


$adicionalVar = "";
$input_l3 ="";
if(isset($_GET['addl3']) && $_GET['addl3'] != ""){
    $adicionalVar = (int)$_GET['addl3'];
    $input_l3 = "<input type='hidden' name='addl3inp' value='".$adicionalVar."' />";
}elseif(isset($_GET['addl3inp']) && $_GET['addl3inp'] != ""){
    $adicionalVar = (int)$_GET['addl3inp'];
    $input_l3 = "<input type='hidden' name='addl3inp' value='".$adicionalVar."' />";
}
//QUERY SUBCATAGORIA DATABASE -> [[[[PRENDAS]]]]
$subCateArr = subCateCatalogoQuery($idCategoProd, $adicionalVar);
//$subCateArr = subCateCatalogoQuery($catego_filtro, $adicionalVar);

$cantPzCatego = count($subCateArr);

if(is_array($subCateArr) && $cantPzCatego>0){                                                        
    foreach($subCateArr as $refkey){
        $level2Prod = $refkey['id_catego_product'];
                    
        $printSubCate[] = $refkey;
        $printPzasOrder[] = $refkey;                                
    }
}

/*if(isset($_GET['catego']) && $_GET['catego'] != ""){
    $subcatNow = (int)$_GET['catego'];
    
    //$tipe_prenda_SubCateProd = $refkey['talla_tipo_prenda'];
    //$tipe_genero_SubCateProd = $refkey['tags_depatament_produsts'];

    //DEFINE GRUPO TALLAS PARA PRENDA                                                                        
    //f(isset($tipe_prenda_SubCateProd) && $tipe_prenda_SubCateProd !=""){
    $grupoTalla = array();
    $grupoTalla[] = especiGrupoTalla($subcatNow);
    
}*/




//DEFINIR ESTADOS DE PROGRESO POR KIT

//$totalPZasOrder = 0;
$totalItemsOTNOW = queryOrderTmpItem($otNOW, $idCategoProd);//queryOrderTmpOne($otNOW);
$totalPZasOrder = count($totalItemsOTNOW);

$maxPZAS = $cantPzCatego;
$valueProgresGlobal = ($totalPZasOrder/$maxPZAS)*100;
$valueProgresGlobalFormat = round($valueProgresGlobal, 2, PHP_ROUND_HALF_DOWN);


//DEFINE PROGRESO COMPRA GLOBAL
$totalItemsOTGLOB = queryOrderTmpOne($otNOW);
$totalPZasOrderGLOB = count($totalItemsOTGLOB);


$valueGlobalProgess = ($totalPZasOrderGLOB/$totalPzKit)*100;//$totalPZasOrder
$valueGlobalProgessFormat = round($valueGlobalProgess, 2, PHP_ROUND_HALF_DOWN);


//IMPRIME PRODS
$printProds = array();
$printProds = queryProds();

//$totalItemsProd = count($printProds);

//LAYOUT BTN CONTINUAR COMPRANDO
$btnContinuebuying = "";
if($totalPZasOrder==$maxPZAS){
    $btnContinuebuying = "<div class='row'>";
    $btnContinuebuying .= "<div class='col-xs-12 text-center'>";
    $btnContinuebuying .= "<div class='box25'>";
    $btnContinuebuying .= "<a href='".$pathmm."order/inicio/?steps=dos' type='button' class='btn btn-success btn-lg padd-hori-md'>";
    $btnContinuebuying .= "<i class='fa fa-shopping-cart fa-lg margin-right-md'></i>";
    $btnContinuebuying .= "Continuar comprando";
    $btnContinuebuying .= "</a>";
    $btnContinuebuying .= "</div>";
    $btnContinuebuying .= "</div>";
    $btnContinuebuying .= "</div>";
}

//PATH FOTO DEFAULT
$pathFileDefault = $pathmm."img/nopicture.png";

//IMPRIME FOTOS
$queryFotosProds = array();

/*
*SITE MAP - ESQUEMA LINKS
*/

$actiSecc = "catalogo";

?>
<!DOCTYPE html>
<html lang="<?php echo LANG ?>">
<head>
    <meta charset="utf-8">
    <title>QUEST - Toma Pedidos</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">    
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <meta name="author" content="massin">
    <?php echo _CSSFILESLAYOUT_ ?>             
    <?php echo _FAVICON_TOUCH_ ?>
    
    <link rel="stylesheet" type="text/css" href="../../appweb/plugins/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="../../appweb/plugins/slick/slick-theme.css"/>
    <link rel="stylesheet" type="text/css" href="../../appweb/plugins/guiatalla/guiatalla.css"/>
</head>
<body class="hold-transition skin-black layout-top-nav " >
    <?php echo "<span id='currencysite' class='hidden'>".CURRENCYSITE."</span>"; ?>
    <?php echo "<span id='pathfile' class='hidden'>".$pathmm."</span>"; ?>
    <?php echo "<span id='clientnow' class='hidden'>".$nomeClienteOrder."</span>"; ?>       
    <!-- Site wrapper -->
    <div class="wrapper" id="wrapperbrowse">
        <?php
        /*
            *
            *---------------------------
            *HEADER
            *---------------------------
            *    
        */  
        ?>
        <?php include '../../appweb/tmplt/header-tomapedido.php'; ?>
        <?php
        /*
            *
            *---------------------------
            *CONTAINS PAGE - WRAPER
            *---------------------------
            *    
        */  
        ?>        
        <div class="content-wrapper">
            <?php
            /*
                *
                *---------------------------
                *PAGE HEADER - BREAD CRUMB
                *---------------------------
                *    
            */  
                              
            ?>                            
            <?php echo $headClienteActi_tmpl; ?>
            
            <section class="content-header maxwidth-layout">
                <h1>Dotaciones QUEST</h1>
                <ol class="breadcrumb">                  
                    <li><a href="../inicio/?steps=dos"><i class="fa fa-th-large"></i>Tus Kits</a></li>

                    <?php
                    //LEVEL L2
                    //$idCategoProd;
                    //$printLev2Acti_nome;

                    //LEVEL L3
                    //$getCateFilter;
                    //$printLev3Acti_nome;
                    $mdpLayout = "";
                    if(isset($getCateFilter)){
                        $mdpLayout .= "<li><a href='?l2=".$idCategoProd."'>".$nomeCategoProd."</a></li>";
                        $mdpLayout .= "<li class='active'>".$printLev3Acti_nome."</li>";
                    }else{
                        $mdpLayout .= "<li class='active'>".$nomeCategoProd."</li>";
                    }

                    echo $mdpLayout;

                    ?>  
                    
                </ol>                
            </section>
            
            <?php
            /*
                *
                *------------------------------
                *PROCESO COMPRA
                *------------------------------
                *
            */
            ?>
            
            <div class="stepShopWrap maxwidth-layout">
                <div class="row">                    
                    <div class="col-xs-12 col-sm-10">                           
                        <?php echo $layoutPackDotHome; ?>
                    </div>
                    <div class="col-xs-12 col-sm-2 wrapknob" >
                        <?php 
                            if($valueGlobalProgessFormat < 100){ //
                                echo "<input type='text' class='knob' value='".$valueGlobalProgessFormat."' data-skin='tron'  data-thickness='0.2' data-width='90' data-height='90' data-fgColor='#00a65a' data-readonly='true'>";
                            }else{
                                echo "<input type='text' class='knob' value='100' data-skin='tron'  data-thickness='0.2' data-width='90' data-height='90' data-fgColor='#00a65a' data-readonly='true'>";    
                            }                        
                        ?>                        
                        <div class="no-padmarg knob-label"><label>% Progreso Pedido</label></div>
                    </div>
                </div>
                                
            </div>
                                    
            <?php 
            /*
                *
                *------------------------------
                *MENSAJES EVENTOS
                *------------------------------
                *
            */
                if(isset($errValidaTrashOrder) && $errValidaTrashOrder !=""){ echo $errValidaTrashOrder; }                
                if(isset($trashOrderOK) && $trashOrderOK !=""){ echo $trashOrderOK; }
                if(isset($errValidaSendOrder) && $errValidaSendOrder !=""){ echo $errValidaSendOrder; }
                if(isset($sendOrderOK) && $sendOrderOK !=""){ echo $sendOrderOK; }            
            ?>                           
          <?php
                /*if(is_array($browseProds) && count($browseProds) > 0){
                    
                    $browsLocationTmpl = "<div class='row maxwidth-layout'>";
                    $browsLocationTmpl .= "<div class=' col-xs-12 browse-location margin-bottom-md'>";
                    $browsLocationTmpl .= "<ol class='breadcrumb unlateralpadding'>";
                    $browsLocationTmpl .= "<li><a href='".$pathmm."order/inicio/'><i class='fa fa-arrow-left'></i> Catalogo</a></li>";
                    $browsLocationTmpl .= "<li><a href='".$pathmm."order/browse/?l2=".$idCategoProd."'>KIT</a></li>";
                    $browsLocationTmpl .= $bc_acti;
                    $browsLocationTmpl .= "</ol>";
                    $browsLocationTmpl .= "</div>";
                    $browsLocationTmpl .= "</div>";
                    echo $browsLocationTmpl;                                
                }*/
            ?>                                                                                   
                                                
            <div class="migajassite row maxwidth-layout">
                <div class="col-xs-12">
                    <!-- Widget: user widget style 1 -->
                    <div class="box box-widget widget-user-2 collapsed-box"> <!--collapsed-box-->
                        <!-- Add the bg color to the header using any of the bg-* classes 
                        <div class="widget-user-header bg-yellow">
                            <div class="widget-user-image">
                                <img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="User Avatar">
                            </div>
                            
                            <h3 class="widget-user-username">Nadia Carmichael</h3>
                            <h5 class="widget-user-desc">Lead Developer</h5>
                        </div>-->      
                        
                        <div class="info-box bg-red untopdowlmargin ">
                            <span class="info-box-icon" data-toggle='control-sidebar' style="cursor: pointer;"><i class="fa fa-shopping-cart"></i></span>

                            <div class="info-box-content">
                                <div class="box100">
                                    <!--<div class="pull-right">
                                        <span class="badge bg-red-active padd-hori-md" style="font-size:1.5476em;">Camisa</span>
                                    </div>-->
                                    <span class="info-box-text">Kit Dotación</span>
                                    <span class="info-box-number"><?php echo $nomeCategoProd."&nbsp;".$subNomeCategoProd; ?></span>
                                                                                                                                                
                                </div>
                                <div class="progress ">
                                    <!--<div class="progress-bar " style="width: 70%"></div>-->
                                <?php 
                                if($valueProgresGlobalFormat<100){
                                    echo "<div class='progress-bar ' style='width: ".$valueProgresGlobalFormat."%'></div>";	
                                }else{
                                    echo "<div class='progress-bar ' style='width: 100%'></div>";	                                                
                                }
                                ?>                                                                                                                    
                                </div>
                                <div <span class="progress-description text-right"">
                                <span class="badge bg-red-active padd-hori-md">                                        
                                    <?php echo $totalPZasOrder ."Pz&nbsp;&nbsp;/&nbsp;&nbsp;" .$cantPzCatego."Pz";  ?>
                                </span>
                                </div>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <div class="row padd-verti-xs padd-hori-xs">
                            <div class="col-xs-3">
                                <?php //if($totalPZasOrder == 0 ){ ?>
                                <a href="<?php echo $pathmm; ?>order/inicio/?steps=dos" class="btn btn-box-tool" type="button">                                  
                                    <i class="fa fa-th-large fa-lg margin-right-xs"></i>
                                    Kits disponibles
                                </a>
                                <?php //} ?>
                            </div>
                            <div class="col-xs-6">
                                <?php
                                    if(isset($printLev3Acti_nome) && $printLev3Acti_nome != ""){
                                        echo "<h2 class='no-padmarg text-center hidden-xs'><small class='margin-right-xs'>Puedes escoger tu </small>".$printLev3Acti_nome."</h2>";                                        
                                    }else{
                                        echo "<h4 class='text-center hidden-xs'>Hola, para este KIT puedes seleccionar las siguientes piezas </h4>";
                                    }
                                ?>
                                <!--<h4 class="text-center">Hola, para este KIT podes seleccionar las siguientes piezas </h4>-->
                                <!--<div class="box100 clearfix padd-verti-xs padd-hori-xs">-->                                    
                                <!--</div>-->
                            </div>
                            <div class="col-xs-3">
                                <div class="box-tools pull-right" >
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                        <i class="fa fa-plus margin-right-xs "></i> Piezas
                                    </button>
                                </div>
                            </div>
                        </div>
                    

                        <!-- /.info-box -->
                        <div class="box-footer no-padding">
                            
                            <ul class="nav nav-stacked">                                  
                                <?php 
                                /*$tmplLayoutBackKit = "<li>";// item subcate
                                $tmplLayoutBackKit .= "<a href='".$pathmm."order/inicio/'>";                                    
                                $tmplLayoutBackKit .= "<i class='fa fa-th-large fa-lg margin-right-xs'></i>";
                                $tmplLayoutBackKit .= "Ver otros Kits";                                    
                                $tmplLayoutBackKit .= "</a>";
                                $tmplLayoutBackKit .= "</li>";// fin item subcate

                                echo  $tmplLayoutBackKit;*/
                                
                                //PRINT SUBCATEGO ITEM LAYOUT
                                foreach($printPzasOrder as $pzOrderItem){
                                    
                                    $idSubCateProd = $pzOrderItem['id_subcatego_producto'];
                                    $nomeSubCateProd = $pzOrderItem['nome_subcatego_producto'];
                                    $fileSubCateProd = $pzOrderItem['img_subcate_prod'];
                                    /*$tipe_prenda_SubCateProd = $pzOrderItem['talla_tipo_prenda'];
                                    $tipe_genero_SubCateProd = $pzOrderItem['tags_depatament_produsts'];
                                    
                                    
                                    //DEFINE GRUPO TALLAS PARA PRENDA                                                                        
                                    //f(isset($tipe_prenda_SubCateProd) && $tipe_prenda_SubCateProd !=""){
                                    $grupoTalla = array();
                                    $grupoTalla = especiGrupoTalla($tipe_prenda_SubCateProd, $tipe_genero_SubCateProd);*/
                                    //}
                                    
                                    
                                    $pzcheckTO = array();
                                    $pzcheckTO = pzChTO($idSubCateProd);
                                                                                                                                                                                    
                                    if($pzcheckTO == $idSubCateProd){
                                        
                                        $checkPZClass = "bg-green";
                                        $linkPZ = "<a href='#' class='pzskit' name='".$nomeSubCateProd."' title='Pieza seleccionada' data-msj='Ya seleccionaste esta pieza, para cambiarla debes primero eliminarla desde la orden del pedido'>";
                                                                                                                        
                                    }else{
                                        $checkPZClass = "bg-gray";  
                                        $linkPZ = "<a href='".$pathFile."/?catego=".$idSubCateProd."&l2=".$idCategoProd."&addl3=".$adicionalVar."'>";
                                    }   

                                    $tmplLayoutItem = "<li>";// item subcate

                                    //$tmplLayoutItem .= "<a href='".$pathFile."/?catego=".$idSubCateProd."&l2=".$idCategoProd."'>";

                                    $tmplLayoutItem .= $linkPZ;

                                    $tmplLayoutItem .= $nomeSubCateProd;
                                    $tmplLayoutItem .= "<span class='pull-right badge ".$checkPZClass."'>";                            
                                    $tmplLayoutItem .= "<i class='fa fa-check'></i>";
                                    $tmplLayoutItem .= "</span>";
                                    $tmplLayoutItem .= "</a>";
                                    $tmplLayoutItem .= "</li>";// fin item subcate

                                    echo $tmplLayoutItem;
                                    

                                }
                                ?>
                                <!--<li><a href="#">Projects <span class="pull-right badge bg-blue">31</span></a></li>
                                <li><a href="#">Tasks <span class="pull-right badge bg-aqua">5</span></a></li>
                                <li><a href="#">Completed Projects <span class="pull-right badge bg-green">12</span></a></li>
                                <li><a href="#">Followers <span class="pull-right badge bg-red">842</span></a></li>-->
                            </ul>
                        </div>
                    </div>
                    <!-- /.widget-user -->
                </div>                        
            </div>
            
            
            
            
            
            <?php
            /*
                *
                *---------------------------
                *MAIN CONTENT
                *---------------------------
                *    
            */
            ?>    
            <section class="content"> 
                
                <?php
                /*
                 *---------------------------
                 *EXPLORAR PRODUCTOS
                 *---------------------------
                */                
                ?>
                
                <?php if(is_array($browseProds) && count($browseProds) > 0){ //========== PRINT PRODUCTOS ===========// ?>
                    
                
                    <?php
                    /*
                     *---------------------------
                     *FILTROS LAYOUT
                     *---------------------------
                    */
                    ?>

                    <!--filtros-->
                    <div class="row maxwidth-layout">
                        <div class="col-xs-12">
                            <div class="box box-default">                                
                                <div class="box-body">
                                   <!-- <div class="form-inline"> SELECT `id_color`, `nome_color`, `color_hexa` FROM `tipo_color` WHERE 1-->
                                    <form action="<?php echo $pathFile; ?>/" method="get">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-5">
                                                <label>Selecciona tu color</label>
                                                <ul class="colorselect">
                                                    <!--<li><input name="" value="" type="hidden" /></li>-->                                            
                                                <?php 
                                                $actiClassColor="";
                                                $selectedColor = "";
                                                /*$db->orderBy("nome_color","Asc");									
                                                $colorSelect = $db->get('tipo_color');                                        
                                                if ($db->count > 0){
                                                    foreach ($colorSelect as $csKey) { 
                                                        $idColorSelect = $csKey['id_color'];
                                                        $nomeColorSelect = $csKey['nome_color'];
                                                        $hexaColorSelect = $csKey['color_hexa'];                                                    
                                                        $actiClassColor = ($filtro_color_acti == $idColorSelect)? "active" : "" ; 
                                                        $selectedColor = ($filtro_color_acti == $idColorSelect)? $filtro_color_acti : "" ;

                                                        echo "<li data-color='".$idColorSelect."' style='background-color:".$hexaColorSelect."' class='".$actiClassColor."'></li>";	
                                                    }
                                                }     */
                                                
                                                if(is_array($grupoColores)){
   
	                                                foreach($grupoColores as $ccKey){
	                                                    if(is_array($ccKey)){
	
	                                                            $idColorSelect = $ccKey['id_color'];
	                                                            
	                                                            $nomeColorSelect = $ccKey['nome_color'];
	                                                            $hexaColorSelect = $ccKey['color_hexa'];                                                    
	                                                            $actiClassColor = ($filtro_color_acti == $idColorSelect)? "active" : "" ; 
	                                                            $selectedColor = ($filtro_color_acti == $idColorSelect)? $filtro_color_acti : "" ;
	
	                                                            echo "<li data-color='".$idColorSelect."' style='background-color:".$hexaColorSelect."' class='".$actiClassColor."'></li>";   
	                                                     }
	                                                   
	                                                }

                                                }
                                                
                                                ?> 
                                                </ul>
                                            </div>
                                            <div class="col-xs-12 col-sm-5">
                                                <label>Selecciona tu talla</label>
                                                <ul class="tallaletraselect">                                                                                           
                                                <?php    
                                                if(is_array($grupoTalla)){ // && count($grupoTalla)>0
                                                    foreach ($grupoTalla as $tlKey) { 
                                                        //SELECT `id_talla_tipo_prenda`, `name_talla_tipo_prenda`, `id_talla_tablas`, `talla_tipo_prenda`, `tipo_talla`, `genero_talla` FROM `especifica_tallas_tipo_prenda` WHERE 1
                                                        $idTLSelect = $tlKey['id_talla_tablas'];
                                                        $nomeTLSelect = $tlKey['talla_tipo_prenda']; 
                                                        $actiClassTL = ($filtro_talla_acti == $idTLSelect)? "active" : "" ; 
                                                        $selectedTL = ($filtro_talla_acti == $idTLSelect)? $filtro_talla_acti : "" ; 

                                                        echo "<li data-tl='".$idTLSelect."' class='".$actiClassTL."'><span>".$nomeTLSelect."</span></li>";	
                                                    }   
                                                }
    
    
                                                /*$actiClassTL = "";
                                                $selectedTL = "";
                                                if(isset($printLev3Acti_tipoprenda) && $printLev3Acti_tipoprenda != ""){
                                                    if($printLev3Acti_tipoprenda == "tl"){
                                                        //SELECT `id_talla_letras`, `nome_talla_letras` FROM `talla_letras` WHERE 1
                                                        $db->orderBy("posi_talla","Asc");									
                                                        $tletraSelect = $db->get('talla_letras');                                        
                                                        if ($db->count > 0){
                                                            foreach ($tletraSelect as $tlKey) { 
                                                                $idTLSelect = $tlKey['id_talla_letras'];
                                                                $nomeTLSelect = $tlKey['nome_talla_letras']; 
                                                                $actiClassTL = ($filtro_talla_acti == $idTLSelect)? "active" : "" ; 
                                                                $selectedTL = ($filtro_talla_acti == $idTLSelect)? $filtro_talla_acti : "" ; 

                                                                echo "<li data-tl='".$idTLSelect."' class='".$actiClassTL."'><span>".$nomeTLSelect."</span></li>";	
                                                            }
                                                        }

                                                    }else if($printLev3Acti_tipoprenda == "tn" ){
                                                        //SELECT `id_talla_numer`, `talla_numer` FROM `talla_numerico` WHERE 1
                                                        $db->orderBy("posi_talla","Asc");									
                                                        $tletraSelect = $db->get('talla_numerico');                                        
                                                        if ($db->count > 0){
                                                            foreach ($tletraSelect as $tlKey) { 
                                                                $idTLSelect = $tlKey['id_talla_numer'];
                                                                $nomeTLSelect = $tlKey['talla_numer']; 
                                                                $actiClassTL = ($filtro_talla_acti == $idTLSelect)? "active" : "" ; 
                                                                $selectedTL = ($filtro_talla_acti == $idTLSelect)? $filtro_talla_acti : "" ; 

                                                                echo "<li data-tl='".$idTLSelect."' class='".$actiClassTL."'><span>".$nomeTLSelect."</span></li>";	
                                                            }
                                                        }

                                                    }

                                                }*/

                                                ?> 
                                                </ul>   
                                            </div>
                                            <div class="col-xs-12 col-sm-2 ">
                                                <div class="guia-tallas hidden-xs"><p><span>+</span> GUÍA DE TALLAS</p></div>
                                                <label>&nbsp;</label>
                                                <input type="submit" value="Buscar" class="btn btn-filter btn-block" name="" />   
                                            </div>                                         
                                            <input name="colorq" value="" type="hidden" />
                                            <input name="tallaq" value="" type="hidden" />
                                        </div>

                                        <?php
                                            echo $input_l2.$input_l3.$input_cate.$input_talla.$input_color;//$input_talla.$input_color;//$input_sb.$input_brand
                                        ?>
                                        <!--</div>-->
                                    </form>
                                    <!--</div>-->

                                </div>                                                
                            </div>
                        </div>
                    </div>

                    <!--/ filtros-->

                    <?php
                    /*
                     *---------------------------
                     *PRODUCTOS LAYOUT
                     *---------------------------
                    */
                    ?>
                
                    <?php if(is_array($filterActiItem) && count($filterActiItem) > 0){ //=========== SI EXISTEN FILTROS ACTIVADOS//////////// ?>
                    

                    <!-- list prods -->
                    <div class="row maxwidth-layout padd-verti-md">
                        <?php 

                        $tmplBreak = 1;  

                        if(is_array($printProds)){//SI EXISTEN VALORES EN LA GUIA
                        foreach($printProds as $prodKey ){ //as $valprods
                            //foreach($valprods as $prodKey){
                            $datasHCNAL = array();
                            $datasHCIMP = array();
                            $dataProdECP = array();
                            /*========================
                             *RECIBE INFORMACION PRODUCTO
                            */
                            //INFO BASICA PRODUCTO                                
                            $varProdFiling = $prodKey['id_prod_filing'];                                
                            $varProd = $prodKey['id_producto'];                                
                            //$sLProd = $prodKey['id_catego_product'];
                            $tLProd = $prodKey['id_subcatego_producto'];
                            $tituProd = $prodKey['cod_venta_descri_filing'];
                            $SKUProd = $prodKey['cod_venta_prod'];
                            $urlProd = $prodKey['url_amigable_prod'];
                            $refAlbumProd = $prodKey['ref_album_prod_filing'];

                            //ESTADO ACTIVASDO - DESACTIVADO PRODUCTO
                            $estadoProd = $prodKey['id_estado_contrato']; //activa desactiva catalogo - activa nacional
                            //$estadoProdImp = $prodKey['acti_imp']; //activa imporatado
                            $agotadoProdDB = $prodKey['agotado']; //agotado nacional
                            //$agotadoProdImpDB = $prodKey['agotado_imp']; //agotado importado
                            //$dateTimePubliProd = $prodKey['datetime_publi']; //datetime publicado
                            //$dateTimeServerProd = $prodKey['datetime_server']; //datetime actualizado en servidor

                            //PORTADA - GALERIA FOTOSPRODUCTO
                            $prodFile = empty($prodKey['foto_producto_filing'])? $prodKey['foto_producto'] : $prodKey['foto_producto_filing'];
                            
                            //$descriFileProd = $prodKey['txt_alt_img_prod'];

                            //PRECIO COSTO - PRECIO VENTA NACIONAL
                            //$priceProd = $prodKey['precio_producto'];
                            //$utilidadProd = $prodKey['utilidad_costo_prod'];
                            //$margenDctoProd = $prodKey['porcent_dcto_mayor_prod'];
                            //$maxDctoMayorProd = $prodKey['max_dcto_mayor'];
                            //$maxDctoProd = $prodKey['max_dcto_utilidad'];
                            //$priceVentaUnitProd = $prodKey['precio_unit_prod'];
                            
                            
                            
                            
                            //FILTROS
                               
                            if($printLev3Acti_tipoprenda=="tl"){
                                //$tallaItemID = empty($prodKey['id_talla_letras'])? $prodKey['id_talla_letras'] : $prodKey['id_talla_numer'] ;        
                                $tallaItemID = $prodKey['id_talla_letras'];
                            }else if($printLev3Acti_tipoprenda ="tn"){
                                $tallaItemID = $prodKey['id_talla_numer'];    
                            }
                            
                            //TALLA PRODUCTO
                            $tallaProd = especificaTallaItem($tallaItemID, $printLev3Acti_tipoprenda);
                            
                            if(is_array($tallaProd)){
                                foreach($tallaProd as $tpKey ){
                                    //$idProdECP = $cpKey['id_producto'];
                                    //$dataProdECP[] = $cpKey;                                    
                                    $idTallaItem = (!empty($tpKey['id_talla_letras']))?$tpKey['id_talla_letras'] : $tpKey['id_talla_numer'];
                                    $nomeTallaItem = (!empty($tpKey['nome_talla_letras']))?$tpKey['nome_talla_letras'] : $tpKey['talla_numer'];
                                }    
                            }
                                                                                    
                            //COLORES PRODUCTO
                            $colorItemID = $prodKey['id_color'];                             
                            $colorProd = especificaColorItem($colorItemID);
                                
                            //$colorProd = especificaColor($varProd);

                            if(is_array($colorProd)){
                                foreach($colorProd as $cpKey ){
                                    //$idProdECP = $cpKey['id_producto'];
                                    //$dataProdECP[] = $cpKey;                                    
                                    $nomeColorItem = $cpKey['nome_color'];
                                    $hexaColorItem = $cpKey['color_hexa'];
                                }    
                            }
                            
                            //MATERIAL PRODUCTO
                            $materialProd = array();
                            $materialProd = especificaMaterialItem($varProd);
                            
                            
                            //print_r($materialProd);
                            //EXISTENCIAS PRODCUTO
                            $stockExistVent = $prodKey['cant_exist_prod_filing'];                                    
                            //$pressProdVentNal = $prodKey['descri_corta_presprod_vent'];                                                                                                                                                                                                                                                       
                            //PORTADA - GALERIA FOTOS
                            $pathPortada = "../../files-display/album/labels/$prodFile";  
                            $pathImgDefault = $pathmm."img/nopicture.png";

                            if (file_exists($pathPortada)) {
                                $portadaFile = $pathPortada;
                            } else {
                                $portadaFile = $pathImgDefault;
                            }
                            
                            
                            //FOTOS - ALBUM PRODUCTO
                            $queryFotosProds = queryFotosProd($refAlbumProd);                                                                
                            $resuQueryFoto = count($queryFotosProds);

                            $printRefAlbum="";
                            $printFotos = array();
                            if($resuQueryFoto>0){

                                $pathFile = $pathmm."files-display/album/400/"; 
                                foreach($queryFotosProds as $refkey){
                                    $printRefAlbum = $refkey['ref_album'];
                                    $printLabelAlbum = $refkey['portada_album'];
                                    $pathLabelAlbum = "../../files-display/album/labels/$printLabelAlbum";
                                    $printFotos[] = $refkey['img_foto'];

                                }
                            }

                            //ESTADOS PRODUCTO  ACTI NAL - ACTI IMP
                            $agotadoNal = "";
                            $agotadoImp = "";
                            $actiStockNal = "";
                            $actiStockImp = "";
                            $encondingPrice = "";
                            $encondingPriceIMP = "";

                            switch($agotadoProdDB){
                                case "1":
                                    $agotadoNal = "Agotado";
                                    break;
                                case "0":
                                    $agotadoNal = "En stock";
                                    break;	
                            }
                                    
                        ?>
                        <!-- prod item -->
                        <div class="col-xs-12 col-sm-4 col-md-4 wrap-prod">
                            <!-- Wrap prod -->
                            <div class="box box-widget widget-user-3">                                                             
                                <?php 
                                    
                            $totalFiles = count($printFotos); 
                                if($totalFiles>0){                                                          
                                
                                                       
                                     if($printRefAlbum == $refAlbumProd){                     
                                        $galeryTmpl = "<div class='wrapgallery'>";  
                                            //$galeryTmpl .= "<div>";
                                            //$galeryTmpl .= "<img src='".$pathLabelAlbum."' class='img-responsive' />";
                                            //$galeryTmpl .= "</div>"; 
                                        foreach($printFotos as $itemF){
                                            $printItemFotos = $pathmm."files-display/album/400/".$itemF;

                                            $galeryTmpl .= "<div>";
                                            $galeryTmpl .= "<img src='".$printItemFotos."' class=''style='width:100%; display:block;' />";
                                            $galeryTmpl .= "</div>";
                                        }
                                            //$galeryTmpl .= "<div>";
                                            //$galeryTmpl .= "<img src='".$portadaFile."' class='img-responsive'  />";
                                            //$galeryTmpl .= "</div>";    
                                        $galeryTmpl .= "</div>";   
                                        echo $galeryTmpl;
                                    }                    
                                }else{
                                    echo "<div class='widget-user-header' style='background-image:url(".$portadaFile.");'></div>"; 
                                    /*if (file_exists($portadaFile)) {
                                        echo "<div class='widget-user-header' style='background-image:url(".$portadaFile.");'></div>"; 
                                    } else {
                                        echo "<div class='widget-user-header' style='background-image:url(".$pathFileDefault.");'></div>";
                                    }*/
                                    //echo "<img src='".$pathPortadaGuia."' class='img-responsive' />";     
                                }                                
                             
                                
                                ?>
                                <h4 class="padd-verti-xs padd-hori-xs untopdowlmargin"><?php echo $tituProd; ?></h4>
                                <p class="padd-hori-xs untopdowlmargin">Ref: <strong class="text-maroon margin-left-xs"><?php echo $SKUProd; ?></strong></p>
                                <div class="box100 padd-hori-xs clearfix">
                                    <h4>Especificaciones</h4>
                                    <dl class="dl-icos padd-bottom-xs">                                        
                                        <dt>Color:</dt>
                                        <dd>
                                        <?php
                                            $tmplColorItem = "<span class='pull-left margin-right-xs' style='display:block; box-shadow:0px 0px 2px rgba(0,0,0,.18); width:30px; height:30px; background-color:".$hexaColorItem."'></span>";
                                            $tmplColorItem .= "<label clas='pull-left'>".$nomeColorItem."</label>";
                                            echo $tmplColorItem;
                                        ?>
                                        </dd>                                        
                                        <dt>Talla:</dt>
                                        <dd>
                                        <?php
                                            if(isset($nomeTallaItem)){
                                            echo "<span style='display:block; border:#c8c8c8 solid 2px; width:30px; height:30px; text-align:center;'><label style='padding-top:4px;'>".$nomeTallaItem."</label></span>";                                           
                                            }else{
                                                echo "<span style='display:block; border:#c8c8c8 solid 2px; width:30px; height:30px; text-align:center;'><label style='padding-top:4px;'>Talla unica</label></span>"; 
                                            }
                                        ?>
                                        </dd>
                                    </dl>
                                        <?php
                            
                                        $layoutMaterialProd = "<div class='padd-hori-xs'>";
                                        $layoutMaterialProd .= "<label>Material(es):</label>";
                                        //$layoutMaterialProd .= "<dd>";
                                        $layoutMaterialProd .= "<p>";
                            
                                        if(is_array($materialProd)){
                                            foreach($materialProd as $mpKey){
                                                $nameMaterialItem = $mpKey['nome_material'];
                                                $valMaterialItem = $mpKey['valor_material'];
                                                
                                                $layoutMaterialProd .= "<label style='display:block; margin-bottom:2px; margin-left:7px;'>".$nameMaterialItem;
                                                $layoutMaterialProd .= "<span class='badge bg-black margin-left-xs'>".$valMaterialItem."</span>";
                                                $layoutMaterialProd .= "</label>"; 
                                            }
                                        }
                            
                                        $layoutMaterialProd .= "</p>";
                                        $layoutMaterialProd .= "</div>";
                                        echo $layoutMaterialProd;
                            
                                        //</dd>                                        
                                        //<dt><i class="fa fa-file-pdf-o fa-2x"></i></dt>
                                        //<dd>
                                        
                                            //echo "<a href='../../files-display/fichatecnica/catalogo-prueba.pdf' class=''><strong>Ficha Técnica</strong></a>";
                                            //echo "<a href='datasheet/?dsfile=catalogo-prueba.pdf' target='_black'><strong>Ficha Técnica</strong></a>";
                            
                                        
                                        //</dd>   
                                        ?>
                                                                                                                                        
                                </div>
                                <div class="box100 padd-verti-xs clearfix" id="wrapaddpot<?php echo $varProd; ?>">
                                    <div id="addpot<?php echo $varProd; ?>" class="text-center">
                                        <button data-this="<?php echo $varProd; ?>" type="button" class="btn btn-success addprodsr" >
                                            <i class="fa fa-shopping-cart margin-right-xs"></i>Agregar
                                        </button>                                     
                                    </div>
                                    <div id="erraddpot<?php echo $varProd; ?>"></div>
                                    <input type="hidden" name="prodbuyed" id="prodbuyed<?php echo $varProd; ?>" value="<?php echo $varProd; ?>">
                                    <input type="hidden" name="prodfiling" id="prodfiling<?php echo $varProd; ?>" value="<?php echo $varProdFiling; ?>">
                                    <input type="hidden" name="kitcod" id="kitcod<?php echo $varProd; ?>" value="<?php echo $idCategoProd; ?>">
                                    <input type="hidden" name="itemkit" id="itemkit<?php echo $varProd; ?>" value="<?php echo $filtro_catego_acti; ?>">
                                    <input type="hidden" name="ordernow" id="ordernow" value="<?php echo $idOrderNow; ?>">
                                    <!--<input type="hidden" name="ordernow" id="ordernow" value="'+ordernow+'">-->
                                    <input type="hidden" name="addform" id="addform" value="ok">
                                </div>
                            </div>
                            <!-- /.widget-user --> <!-- Wrap prod -->
                        </div>
                        <!-- /prod item --> 
                        <?php 
                                if(fmod($tmplBreak,3)==0){
                                    echo "<div class='clearfix hidden-xs visible-sm visible-md visible-lg'></div>";
                                }
                                /*if(fmod($tmplBreak,2)==0){
                                    echo "<div class='clearfix hidden-xs visible-sm hidden-md hidden-lg'></div>";
                                }*/
                                if(fmod($tmplBreak,1)==0){
                                    echo "<div class='clearfix visible-xs hidden-sm hidden-md hidden-lg'></div>";
                                }
                                $tmplBreak++;
                            //}
                            }//fin forech 
                            }else{//SI HAY PUBLICACIONES
                        ?> 
                        <div class="box50">
                            <div class="alert alert-danger text-center padd-verti-xs padd-hori-xs">
                                <i class="ion ion-information-circled cria-icon-3x"></i>
                                <h3>O "CERO" productos encontrados</h3>
                            </div>
                            <!--<div class="btn-group">
                                <a href="" class="btn btn-md btn-success">Publicar guia</a>   
                            </div>-->
                        </div>

                        <?php } //SI HAY PUBLICACIONES ?>
                    </div>
                    <!-- /list prods -->  
                
                    <?php } //================================FIN SI EXISTEN FILTROS ACTIVADOS//////////////////////////     ?> 
                                                
                <?php }else{ //========== PRINT CATALOGO ===========//  ?>
                
                    <?php
                    /*
                     *---------------------------
                     *ACTIVA BOTON CONTINUAR COMPRANDO
                     *---------------------------
                    */                
                    ?>
                
                    <?php echo $btnContinuebuying; ?>
                            
                    <?php
                    /*
                     *---------------------------
                     *CATEGORIAS LAYOUT
                     *---------------------------
                    */                
                    ?>
                                                         
                    <!-- list categorias -->
                    <div class="row maxwidth-layout padd-verti-md">
                        <?php

                        $catalogoBreak = 1;
                        /*foreach($printCatalogo as $printCatKey){
                            $idCategoProd = $printCatKey['id_catego_product'];
                            $nomeCategoProd = $printCatKey['nome_catego_product'];*/

                            


                            /*//PRINT CATALGOO LAYOUT
                            if($level2Prod == $idCategoProd){
                                //$totalFiles = count($printSubCate);                    
                                if(is_array($printSubCate) && count($printSubCate)>0){
                                    //IMPRIME NOME CATEGORIA
                                    $tmplTituCate = "<div class='col-xs-12'>";
                                    $tmplTituCate .= "<h3 class='catalog-titusecc'>";
                                    $tmplTituCate .= $nomeCategoProd;
                                    $tmplTituCate .= "</h3>";
                                    $tmplTituCate .= "</div>";

                                    $tmplTituCate .= "<div class='col-xs-12'>";//wrap layout item
                                    $tmplTituCate .= "<div class='row'>";

                                    echo $tmplTituCate;*/

                                    //PRINT SUBCATEGO ITEM LAYOUT
                                    foreach($printSubCate as $subCateItem){

                                        $idSubCateProd = $subCateItem['id_subcatego_producto'];
                                        $nomeSubCateProd = $subCateItem['nome_subcatego_producto'];
                                        $fileSubCateProd = $subCateItem['img_subcate_prod'];

                                        $pathFileSubCate = "../../files-display/tienda/img-catego/".$fileSubCateProd;                

                                        //VERIFICAR PORTADA
                                        if (file_exists($pathFileSubCate)) {
                                            $portadaSubCateFile = $pathFileSubCate;                                        
                                        } else {
                                            $portadaSubCateFile = $pathFileDefault;
                                        }
                                        
                                        //CHECAR ITEMS SELECCIONADOS      
                                        $pzcheckTO_IN = array();
                                        $pzcheckTO_IN = pzChTO($idSubCateProd);

                                        if($pzcheckTO_IN == $idSubCateProd){
                                        
                                        
                                        //if($idPzCH == $idSubCateProd){
                                        //if($totalPZasOrder == $cantPzCatego){
                                            $wrapPZClass = "desabled";
                                            $linkWrapPZ = "<a href='#' class='pzskit' name='".$nomeSubCateProd."' title='Pieza seleccionada' data-msj='Ya seleccionaste esta pieza, para cambiarla primero debes eliminarla desde la orden del pedido'>";
                                            $divDisabledPZ = "show";
                                        }else{
                                            //$wrapPZClass = "";
                                            if(isset($_GET['addl3']) && $_GET['addl3'] != ""){
                                                $adicionalVar = (int)$_GET['addl3'];
                                                $linkWrapPZ = "<a href='".$pathFile."/?catego=".$idSubCateProd."&l2=".$idCategoProd."&addl3=".$adicionalVar."'>";
                                            }else{
                                                $linkWrapPZ = "<a href='".$pathFile."/?catego=".$idSubCateProd."&l2=".$idCategoProd."'>";    
                                            }            
                                            $divDisabledPZ = "hidden";
                                        }
                                                                                
                                        $tmplLayoutItem = "<div class='col-xs-12 col-sm-6 wrap-prod'>";// item subcate ".$wrapPZClass."
                                        $tmplLayoutItem .= $linkWrapPZ;//"<a href='".$pathFile."/?catego=".$idSubCateProd."&l2=".$idCategoProd."'>";
                                        $tmplLayoutItem .= "<div class='box box-widget widget-user-3 '>";// wrap subcate
                                        $tmplLayoutItem .= "<div class='desabled ".$divDisabledPZ."'><i class='fa fa-check'></i><span>Seleccionado</span></div>";
                                        $tmplLayoutItem .= "<div class='widget-user-header' style='background-image:url(".$portadaSubCateFile.");'></div>";
                                        $tmplLayoutItem .= "<h3 class='padd-verti-xs padd-hori-xs untopdowlmargin text-center'>";
                                        $tmplLayoutItem .= $nomeSubCateProd;
                                        $tmplLayoutItem .= "</h3>";                            
                                        $tmplLayoutItem .= "</div>";//fin wrap subcate
                                        $tmplLayoutItem .= "</a>";
                                        $tmplLayoutItem .= "</div>";// fin item subcate

                                        echo $tmplLayoutItem;

                                        //DEFINE PUNTOS DE QUIEBRE
                                        /*if(fmod($catalogoBreak,6)==0){
                                            echo "<div class='clearfix hidden-xs hidden-sm visible-md visible-lg'></div>";
                                        }
                                        if(fmod($catalogoBreak,3)==0){
                                            echo "<div class='clearfix hidden-xs visible-sm hidden-md hidden-lg'></div>";
                                        }*/
                                        if(fmod($catalogoBreak,2)==0){
                                            echo "<div class='clearfix hidden-xs visible-sm visible-md visible-lg'></div>";
                                        }
                                        if(fmod($catalogoBreak,1)==0){
                                            echo "<div class='clearfix visible-xs hidden-sm hidden-md hidden-lg'></div>";
                                        }
                                        $catalogoBreak++;                                                                                                            
                                    }//PRINT SUBCATEGO ITEM LAYOUT

                                    /*$finTmplLayoutItem = "</div>";
                                    $finTmplLayoutItem .= "</div>";//fin wrap layout item
                                    echo $finTmplLayoutItem;*/

                                //}//IMPRIME NOME CATEGORIA                           

                            //}//FIN PRINT CATALGOO LAYOUT



                        //}//FIN FOREACH CATALOGO

                        ?>

                    </div>
                    <!-- /list categorias -->
                
                <?php }  //==========FIN PRINT CATALOGO ===========// ?>
                
            </section>              
        </div><!--/content-wrapper-->
        
        
    
        <?php
        /*
            *
            *---------------------------
            *FOOTER
            *---------------------------
            *    
        */
        ?>
        <?php include "../../appweb/tmplt/footer-tomapedido2.php"; ?>
    
        <div id="respuesta"></div>
        <input type="hidden" name="actionform" id="actionform" value="<?php echo $pathmm.$takeOrderDir."/browse/"; ?>">
        <input type="hidden" name="ordernow" id="ordernow" value="<?php echo $idOrderNow; ?>">
        <input type="hidden" name="tipokit" id="tipokit" value="<?php echo $idCategoProd; ?>">        
                
                                                                     
    </div><!-- /Site wrapper --> 
    <div class="modal fade" id="polidev" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">            
                <div class="modal-body">
                    <div id="showpolidev"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>                                
                </div>
            </div>
        </div>
    </div>
       
    <?php
    /*
        *
        *---------------------------
        *CONTROL SIDE - LIST ORDER
        *---------------------------
        *    
    */
    ?>
    <?php include '../../appweb/tmplt/order-list-tomapedido.php'; ?>
    
    
    <div class="tallas" style="display: none;">
        <div class="selector-tallas">
            <span class="close">x</span>
            <div class="title"><h1>ENCUENTRA TU TALLA</h1></div>
            <div class="wrapper">
                <div class="right">
                    <div class="menu-tallaje">
                    <div class="item hombre">
                        <div class="image" id="img-Hombre"></div>
                        Hombre
                    </div>
                    <div class="item mujer">
                        <div class="image" id="img-Mujer"></div>
                        Dama
                    </div>
                    <div class="item nino">
                        <div class="image" id="img-Junior"></div>
                        Junior
                    </div>
                    </div><!--end menu tallaje-->
                    <div class="text-inicio">
                        En QUEST tenemos diferentes siluetas según tu gusto, tanto en prendas superiores como inferiores, es por esto que algunas quedan más holgadas o ajustadas que otras a pesar de ser la misma talla.				
                    </div>
                    <div class="top">
                        <div class="tallaje">
                            <select id="listParts"><option value="Inferiores">Inferiores</option><option value="Superiores">Superiores</option></select>
                        </div><!--end tallaje-->
                    </div>
                    <div class="text-inicio">
                        Toma las medidas sobre tu cuerpo
                    </div>
                    <div class="container_table"></div>
                    <div class="container_message"></div>
                </div><!--end rightarquivos-->
                <div class="left">
                    <div id="figura" class="hombre">
                        <img id="imagen-figura" src="//quest.vteximg.com.br/arquivos/figura-hombre.png" />
                    </div><!--end figura-->
                </div><!--end left-->
            </div><!--end hombre-->
        </div><!--end selector tallas-->
    </div>
    
         
    <?php echo _JSFILESLAYOUT_ ?>
    <script type="text/javascript" src="../../appweb/plugins/slick/slick.js" ></script>
    <!--<script src="appdetail.js"></script>-->
    <script type="text/javascript" src="crud-order.js"></script>
    <script type="application/javascript" src="../../appweb/plugins/guiatalla/guiatalla.js"></script>
    <!-- jQuery Knob -->
    <script src="../../appweb/plugins/knob/jquery.knob.js"></script>
    <!-- pdf view -->
    <script type='text/javascript' src='../../appweb/lib/pdfobject.min.js' ></script>            
    <script type='text/javascript'>
        var pathSite = $("#pathfile").html();
        var optionsPDFview = {
            height: "480px",
            pdfOpenParams: { view: 'FitV', page: '1' }
        };
        PDFObject.embed(pathSite+'legal/politicas-devolucion-quest.pdf', '#showpolidev', optionsPDFview);
    </script>
    <script>
        
        $(function () {
    /* jQueryKnob */

    $(".knob").knob({
      /*change : function (value) {
       //console.log("change : " + value);
       },
       release : function (value) {
       console.log("release : " + value);
       },
       cancel : function () {
       console.log("cancel : " + this.value);
       },*/
      draw: function () {

        // "tron" case
        if (this.$.data('skin') == 'tron') {

          var a = this.angle(this.cv)  // Angle
              , sa = this.startAngle          // Previous start angle
              , sat = this.startAngle         // Start angle
              , ea                            // Previous end angle
              , eat = sat + a                 // End angle
              , r = true;

          this.g.lineWidth = this.lineWidth;

          this.o.cursor
          && (sat = eat - 0.3)
          && (eat = eat + 0.3);

          if (this.o.displayPrevious) {
            ea = this.startAngle + this.angle(this.value);
            this.o.cursor
            && (sa = ea - 0.3)
            && (ea = ea + 0.3);
            this.g.beginPath();
            this.g.strokeStyle = this.previousColor;
            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
            this.g.stroke();
          }

          this.g.beginPath();
          this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
          this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
          this.g.stroke();

          this.g.lineWidth = 2;
          this.g.beginPath();
          this.g.strokeStyle = this.o.fgColor;
          this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
          this.g.stroke();

          return false;
        }
      }
    });
             });
    </script>
    <script type="text/javascript">   
                    
        
        
        
        //anuncio
        $(document).ready(function(){
            $('.wrapgallery').slick({
                arrows: false,
                dots: true,
                infinite: false,
                speed: 500,
                fade: false,
                slidesToShow: 1,
                 slidesToScroll: 1
            });
        });
    </script>
    
    <script type="text/javascript">
                        
        $(function() {
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
            
            //var granTotal = format2(sumaSubTotal, "$");
            var granTotal = sumaSubTotal.format(2, 3, '.', ',');
            //alert(granTotal);
            
            $("#totalTO").html(granTotal);

        });
        
        $(".colorselect li").click(function(){
            var b=$(this);
            if(!b.hasClass("active")){
                b.siblings().removeClass("active");
                var colorq = b.attr("data-color");
                $("input[name=colorq]").val(colorq);
                $("input[name=colorqinp]").val('');
                
                 
                /*var a=b.closest(".skin"),
                    d=b.attr("class")?"-"+b.attr("class"):"",
                    c=a.data("icheckbox"),
                    g=a.data("iradio"),
                    e="icheckbox_minimal",
                    f="iradio_minimal";
                a.hasClass("skin-square")&&(e="icheckbox_square",f="iradio_square",void 0==c&&(c="icheckbox_square-green",g="iradio_square-green"));
                a.hasClass("skin-flat")&&(e="icheckbox_flat",f="iradio_flat",void 0==c&&(c="icheckbox_flat-red",g="iradio_flat-red"));
                a.hasClass("skin-line")&&(e="icheckbox_line",f="iradio_line",void 0==c&&(c="icheckbox_line-blue",g="iradio_line-blue"));
                void 0==c&&(c=e,g=f);
                a.find("input, .skin-states .state").each(function(){
                    var a=$(this).hasClass("state")$(this):$(this).parent(),
                    b=a.attr("class").replace(c,e+d).replace(g,f+d);
                    a.attr("class",b)
                });
                a.data("icheckbox",e+d);
                a.data("iradio",f+d);*/
                b.addClass("active")
            }
        });
        
        $(".tallaletraselect li").click(function(){
            var t=$(this);
            if(!t.hasClass("active")){
                t.siblings().removeClass("active");
                var tallaq = t.attr("data-tl");
                $("input[name=tallaq]").val(tallaq);
                $("input[name=tallaqinp]").val('');
                t.addClass("active")
            }
        });
           
    </script>

    <script>
    $('a.sendbtn').click(function(e) {
        e.preventDefault(); 
        //var linkURL = $(this).attr('href');
        //var nameProd = $(this).attr('name');
        var titleEv = $(this).attr('title');
        var msjProd = $(this).attr('data-msj');
        //var reMsjProd = $(this).attr('data-remsj');
        confiSendOrder(titleEv, msjProd);
      });

    function confiSendOrder(titleEv, msjProd) {
        swal({
          title: titleEv, 
          text: '<span style=color:#DB4040; font-weight:bold;>Oops</span><br>' + msjProd, 
          type: 'warning',
          showCancelButton: false,
          closeOnConfirm: false,
          closeOnCancel: false,
          animation: false,
          html: true
        });
      }
        
        
    $('a.pzskit').click(function(e) {
        e.preventDefault(); 
        //var linkURL = $(this).attr('href');
        var nameProd = $(this).attr('name');
        var titleEv = $(this).attr('title');
        var msjProd = $(this).attr('data-msj');
        //var reMsjProd = $(this).attr('data-remsj');
        checkPzas(titleEv, nameProd, msjProd);
      });

    function checkPzas(titleEv, nameProd, msjProd) {
        swal({
          title: titleEv, 
          text: '<span style=color:#DB4040; font-weight:bold; font-size:15px;>' + nameProd + '</span><br>' + msjProd, 
          type: 'warning',
          showCancelButton: false,
          closeOnConfirm: false,
          closeOnCancel: false,
          animation: false,
          html: true
        });
      }
        
     $('#polidev').modal('hidden');  

    </script>
       
</body>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/580923a9304e8e7585607da6/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
</html>
