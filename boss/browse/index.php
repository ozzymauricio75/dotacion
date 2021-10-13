<?php require_once '../../appweb/lib/MysqliDb.php'; ?>
<?php require_once '../../cxconfig/config.inc.php'; ?>
<?php require_once '../../cxconfig/global-settings.php'; ?>
<?php //require_once '../../appweb/inc/sessionvars.php'; ?>

<?php require_once '../../appweb/lib/gump.class.php'; ?>
<?php require_once '../../appweb/inc/site-tools.php'; ?>
<?php require_once '../../appweb/inc/sessionvars-boss.php'; ?>
<?php require_once '../../appweb/inc/query-prods-boss.php'; ?>
<?php require_once '../../appweb/inc/valida-pedido-tmp-boss.php'; ?>


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
/*
$printCatalogo = categoSelectQuery($idCategoProd);
foreach($printCatalogo as $printCatKey){
    $idCategoProd = $printCatKey['id_catego_product'];
    $nomeCategoProd = $printCatKey['nome_catego_product'];
    $subNomeCategoProd = $printCatKey['descri_catego_prod'];
}*/




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
$cantPzCatego = count($subCateArr);


//INFO CATEGO VISITADO

//IMPRIME CATEGORIAS - CATALOGO ->[[[KITS]]]



//DEFINIR ESTADOS DE PROGRESO POR KIT

$totalPZasOrder = 0;
$totalPzKit=0;
$totalPZasOrderGLOB  = 0;
/*$totalItemsOTNOW = queryOrderTmpItem($otNOW, $idCategoProd);//queryOrderTmpOne($otNOW);
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
*/
//PATH FOTO DEFAULT
$pathFileDefault = $pathmm."img/nopicture.png";

//IMPRIME FOTOS
//$queryFotosProds = array();

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
</head>
<body class="hold-transition skin-black sidebar-mini" > <!--layout-top-nav-->
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
        <?php include '../../appweb/tmplt/header-boss.php'; ?>
                               
            <!-- Left side column. contains the sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">      
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <!-- Sidebar user panel -->
          <div class="user-panel">

            <div class="headtxtbc text-center ">
              <h2 class="no-padmarg">Explora </h2>
              <h2 class="no-padmarg">Nuestro  </h2>
              <h2 class="no-padmarg">Catalogo </h2>
                <div class="padd-top-xs">
                <i class="fa fa-arrow-down fa-3x "></i>
                </div>
            </div>
          </div>

         <?php       

        $navdot ="<ul class='sidebar-menu'>";

            $prevVarGender = "";
            $prevVarItemKit = "";
            $prevVarItemCat = "";
            $prevVarItemSub = "";

            $lyBrowseCat = "";     

            if(is_array($userPDActiArr)){

                foreach($userPDActiArr as $smcKey){

                    if(is_array($smcKey)){

                        foreach($smcKey as $smcVal){

                            $varItemDepto = empty($smcVal['id_depart_prod'])? "" : $smcVal['id_depart_prod'];


                            if($varItemDepto == 1){
                                $nameItemDpto = "Masculino";      
                            }else if($varItemDepto == 2){
                                $nameItemDpto = "Femenino";      
                            }


                            if(!empty($smcVal['tipo_kit_4user'])){
                                $nameItemKit = $smcVal['tipo_kit_4user'];    
                            }else{
                                $nameItemKit = "unitario";    
                            } 



                            $varItemCate = $smcVal['id_catego_product'];
                            $nameItemCate = $smcVal['nome_catego_product'];

                            $varItemSubCate = $smcVal['id_subcatego_producto'];
                            $nameItemSubCate = $smcVal['nome_subcatego_producto'];

                            //if($nameItemKit == ""){ $nameItemKit = "unitario"; }
                            //======IMPRIME LAYOUT ITEM KIT
                            if($prevVarItemCat != $varItemCate){
                                if($prevVarItemCat != ""){
                                    $lyBrowseCat .= "</li>";//////CIERRA ITEM KIT DOTACION
                                    $lyBrowseCat .= "</ul>";////CIERRA wrap KIT DOTACION   

                                }                                                                                                                   

                                //======IMPRIME LAYOUT ITEM PACK DOTACION
                                if($prevVarItemKit != $nameItemKit){

                                    if($prevVarItemKit != ""){
                                        $lyBrowseCat .= "</li>";//CIERRA ITEM PACK DOTACION
                                        $lyBrowseCat .= "</ul>";//CIERRA wrap PACK DOTACION
                                    }//CIERRA ITEM PACK DOTACION


                                    //======IMPRIME LAYOUT MASCULINO FEMENINO
                                    if($prevVarGender != $varItemDepto){
                                        if($prevVarItemKit != ""){
                                            $lyBrowseCat .= "</li>";//CIERRA ITEM DEPTO
                                            $lyBrowseCat .= "</ul>";//CIERRA wrap DEPTO
                                        }//CIERRA ITEM PACK DOTACION    

                                         //======IMPRIME ITEM PACK
                                        $lyBrowseCat .= "<li class='treeview'>";//ITEM PACK DEPTO
                                        $lyBrowseCat .= "<a href='#'><strong class='titupackdot'>".$nameItemDpto."</strong></a>";
                                        $lyBrowseCat .= "<ul class='treeview-menu'>";////wrap PACK DPTO                                       
                                        $prevVarGender = $varItemDepto;

                                    }

                                    //======FIN IMPRIME LAYOUT MASCULINO FEMENINO


                                    //======IMPRIME ITEM PACK
                                    $lyBrowseCat .= "<li>";//ITEM PACK DOTACION             
                                    $lyBrowseCat .= "<a href='#'><strong class='titupackdot'>Kit ".$nameItemKit."</strong></a>";
                                    $lyBrowseCat .= "<ul class='treeview-menu'>";////wrap KIT DOTACION                                        
                                    $prevVarItemKit = $nameItemKit;
                                }

                                //======IMPRIME ITEM KIT
                                $lyBrowseCat .= "<li><a href='#'><i class='fa fa-circle-o'></i><strong>".$nameItemCate."</strong><span class='pull-right-container'><i class='fa fa-angle-left pull-right'></i></span></a>";
                                $lyBrowseCat .= "<ul class='treeview-menu'>";//////ITEM KIT DOTACION ////////WRAP ITEM PRENDA
                                $prevVarItemCat = $varItemCate;
                            }//CIERRA ITEM ITEM KIT

                            //======IMPRIME LAYOUT ITEM PRENDA
                            $lyBrowseCat .= "<li><a href='".$pathFile."?catego=".$varItemSubCate."&l2=".$varItemCate."&addl3=".$varItemSubCate."'><i class='fa fa-circle-o'></i><strong>".$nameItemSubCate."</strong></a></li>";////////ITEM PRENDA



                        }//FIN FOREACH SITE MAP CATAGO ARR VAL
                    }
                }//FIN FOREACH SITE MAP CATAGO ARR

            }//FIN IS ARRAY SITE MAP CATAGO ARR

            //$lyBrowseCat .= "</li>";//////ITEM KIT DOTACION
            $lyBrowseCat .= "</ul>";////////WRAP ITEM PRENDA
            $lyBrowseCat .= "</li>";//////CIERRA ITEM KIT DOTACION                
            $lyBrowseCat .= "</ul>";////wrap KIT DOTACION 
            $lyBrowseCat .= "</li>";//////CIERRA ITEM DEPTO                
            $lyBrowseCat .= "</ul>";////wrap KIT DEPTO
            $lyBrowseCat .= "</li>";//ITEM PACK DOTACION  

            $navdot .= $lyBrowseCat;                            

        $navdot .="</ul>";//sidebar-menu

        echo $navdot;

        ?>        
        </section>
        <!-- /.sidebar -->
      </aside>

  <!-- =============================================== -->



    <?php
    /*
        *
        *---------------------------
        *CONTAINS PAGE - WRAPER
        *---------------------------
        *    
    */  
    ?>        
    <div class="content-wrapper ">
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
    
    	<section class="maxwidth-layout">
	<h1>Dotaciones QUEST</h1>
	<ol class="breadcrumb ">                  
	    <li><a href="<?php echo $pathFile."/"; ?>"><i class="fa fa-home"></i> Inicio</a></li>

	    <?php
	   /* $pathmm = $protocol.$httphost.$uriDIR;

//path this file
$pathFile = $protocol.$httphost.$uriFILE;

//directorys name section web
$takeOrderDir = "order";
$bossDir = "boss";*/
	    
	    //LEVEL L2
	    //$idCategoProd;
	    //$printLev2Acti_nome;
	
	    //LEVEL L3
	    //$getCateFilter;
	    //$printLev3Acti_nome;
	    
	    
	    $mdpLayout = "";
	    if(isset($getCateFilter) && $getCateFilter != ""){
	        //$mdpLayout .= "<li><a href='?l2=".$printLev2Acti_id."'>".$printLev2Acti_nome."</a></li>";
	        $mdpLayout .= "<li style='text-transform: capitalize;'>".$printLev2Acti_nomekit."</li>"; 
	        
	        $mdpLayout .= "<li style='text-transform: capitalize;'>".$printLevel3Acti_genero."</li>";
	        $mdpLayout .= "<li>".$printLev2Acti_nome."</li>";
	        $mdpLayout .= "<li class='active'>".$printLev3Acti_nome."</li>"; 
	    }/*else{
	        $mdpLayout .= "<li class='active'>".$printLev2Acti_nome."</li>";
	    }*/
	
	    echo $mdpLayout;
	
	    ?>  
	    
	</ol>

	</section>
                             

    <?php
    /*
        *
        *---------------------------
        *MAIN CONTENT
        *---------------------------
        *    
    */
    ?>



    <!--<button class="action action--open" aria-label="Open Menu"><span class="fa fa-bars"></span></button>-->



    <section class="content padd-verti-lg"> 

        <?php
        /*
         *---------------------------
         *EXPLORAR PRODUCTOS
         *---------------------------
        */                
        ?>

        <?php if(is_array($subCateArr) && count($subCateArr) > 0){ //========== PRINT PRODUCTOS ===========// ?>

        <?php
        /*
         *---------------------------
         *SISTEMA DE COMPRA
         *---------------------------
        */
        ?>
        
        <?php
        //PRINT SUBCATEGO ITEM LAYOUT
        foreach($subCateArr as $subCateItem){
            
            $idCatKitProd = $subCateItem['id_catego_product'];
            $idSubCateProd = $subCateItem['id_subcatego_producto'];
            $nomeSubCateProd = $subCateItem['nome_subcatego_producto'];
            $descriSubCateProd = $subCateItem['descri_subcatego_prod'];
            $fileSubCateProd = $subCateItem['img_subcate_prod'];
            $typePrendaProd = $subCateItem['tipo_prenda'];
            $generoPrendaProd = $subCateItem['tags_depatament_produsts'];
            

            $pathFileSubCate = "../../files-display/tienda/img-catego/".$fileSubCateProd;                

            //VERIFICAR PORTADA
            if (file_exists($pathFileSubCate)) {
                $portadaSubCateFile = $pathFileSubCate;                                        
            } else {
                $portadaSubCateFile = $pathFileDefault;
            }


        }//PRINT SUBCATEGO ITEM LAYOUT
        ?>



        <div class="box box-widget widget-user box75">
        <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-black" style="background: url('<?php echo $portadaSubCateFile; ?>') center center; height:320px;"></div>
            <div class="widget-user-image" style="top:280px;">
            <img class="img-thumbnail" src="<?php echo $portadaSubCateFile; ?>" >
            </div>

            <div class="box-body padd-top-lg">
                <div  class="padd-hori-xs padd-bottom-xs">
                <h3><?php echo $nomeSubCateProd; ?></h3>
                <h5 ><?php echo $descriSubCateProd?></h5>
                </div>
                <div class=" padd-hori-xs">
                <form name="neworder" method="post"> 
                    <div class="row" id="wrapaddpot">
                        <div class="col-xs-12 col-sm-4">
                            <label>Selecciona el color</label>
                            <ul class="colorselect">
                                <!--<li><input name="" value="" type="hidden" /></li>-->                                            
                            <?php 
                            /*$actiClassColor="";
                            $selectedColor = "";
                            $db->orderBy("nome_color","Asc");									
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
                            } */
                            
                            
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
				
							
				function especiGrupoColor($printLev3Acti_tipoprenda){//$catego_filtro_query_
				    global $db;
				    $dataGrupoColor = array();
				    
				    //$subQ = $db->subQuery ("sb");
				    $db->where ("id_subcatego_producto", $printLev3Acti_tipoprenda);           
				    $gtQ = $db->get("productos", null, "id_producto");
				
				    
				    $rowGt = count($gtQ);
				    if ($rowGt > 0){
				        foreach ($gtQ as $gtKey) { 
				            
				            $idProdColor = $gtKey['id_producto'];
				            
				            //BUSCO LOS IDS COLORES PARA ESTOS PRODUCTOS
				            
				            //$coloresListProdsThisCatego = array();
				            $coloresListProdsThisCatego = colorsByCatego($idProdColor);
				            
				            //$noRepetColor = unique_multidim_array($coloresListProdsThisCatego, 'id_color');
				            
				            $dataGrupoColor[] = $coloresListProdsThisCatego;
				            //$dataGrupoColor[] = array(
				                //'idprodcolor' => $idProdColor,
				                //'listcolorcatego' => $coloresListProdsThisCatego
				           // );
				        
				            
				            //$dataGrupoColor[] = $gtKey;    
				        }
				        return $dataGrupoColor;
				    }
				}
				//$noRepetColor = unique_multidim_array($ccVal, 'id_color');
				$colorListProds = array();
				$grupoColores  = array();
				$grupoColoresGet = array();
				$grupoColoresGet = especiGrupoColor($catego_filtro_query);//colorsByCatego2('20');//especiGrupoColor('20'); //$catego_filtro_query
				//$grupoColores = unique_multidim_array($grupoColores, 'id_color');
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
				
				
				$selectedColor = "";
				                                    
				if (is_array($grupoColores)){
				foreach ($grupoColores as $csKey) { 
				    $idColorSelect = $csKey['id_color'];
				    $nomeColorSelect = $csKey['nome_color'];
				    $hexaColorSelect = $csKey['color_hexa'];                                                    
				    $actiClassColor = ($filtro_color_acti == $idColorSelect)? "active" : "" ; 
				    $selectedColor = ($filtro_color_acti == $idColorSelect)? $filtro_color_acti : "" ;
				
				    echo "<li data-color='".$idColorSelect."' style='background-color:".$hexaColorSelect."' class='".$actiClassColor."'></li>";	
				}
				}
                            
                                
                            ?> 
                            </ul>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <label>Selecciona la talla</label>
                            <ul class="tallaletraselect">                                                                                           
                            <?php      
                            /*$actiClassTL = "";
                            $selectedTL = "";
                            if(isset($printLev3Acti_tipoprenda) && $printLev3Acti_tipoprenda != ""){
                                if($printLev3Acti_tipoprenda == "tl"){
                                    ///SELECT `id_talla_letras`, `nome_talla_letras` FROM `talla_letras` WHERE 1
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
                            
                            $generoTalla = $generoPrendaProd;
			/*$input_genero_talla ="";
			if(isset($_GET['gender']) && $_GET['gender'] != ""){
			    $generoTalla = $_GET['gender'];
			    $generoTalla = (string)$generoTalla;  
			    $generoTalla = $db->escape($generoTalla);    
			    $input_genero_talla = "<input type='hidden' name='gender' value='".$generoTalla."' />";
			}else{
			    $generoTalla = $typeColectionTag;
			    $input_genero_talla = "<input type='hidden' name='gender' value='".$generoTalla."' />";
			}*/
                            

				//CARGA GRUPO TALLAS
				function especiGrupoTalla($varSubK_){
				    global $db;
				    global $typeColectionTag;
				    global $generoTalla;
				    $dataGrupoTalla = array();
				    
				    $subQ = $db->subQuery ("sb");
				    $subQ->where ("id_subcatego_producto", $varSubK_);           
				    $subQ->get("sub_categorias_productos");
				
				    $db->join($subQ, "sb.talla_tipo_prenda = etp.name_talla_tipo_prenda");    
				    $db->where("etp.genero_talla", $generoTalla);
				    //$db->orderBy("etp.posi_talla","asc");    
				    $gtQ = $db->get ("especifica_tallas_tipo_prenda etp", null, "etp.id_talla_tablas, etp.talla_tipo_prenda, etp.tipo_talla");
				    
				    $rowGt = count($gtQ);
				    if ($rowGt > 0){
				        foreach ($gtQ as $gtKey) { 
				            $dataGrupoTalla[] = $gtKey;    
				        }
				        return $dataGrupoTalla;
				    } 
				}
                            
				/*--------------------------------
				//DEFINE GRUPO DE TALLAS
				*/     
				$grupoTalla = array();
				$grupoTalla = especiGrupoTalla($getCateFilter);//$catego_filtro_query
				
				$actiClassTL = "";
                            	$selectedTL = "";
                            	
				if (is_array($grupoTalla)){
					foreach ($grupoTalla as $tlKey) { 
					    $idTLSelect = $tlKey['id_talla_tablas'];
					    $nomeTLSelect = $tlKey['talla_tipo_prenda']; 
					    $actiClassTL = ($filtro_talla_acti == $idTLSelect)? "active" : "" ; 
					    $selectedTL = ($filtro_talla_acti == $idTLSelect)? $filtro_talla_acti : "" ; 
					
					    echo "<li data-tl='".$idTLSelect."' class='".$actiClassTL."'><span>".$nomeTLSelect."</span></li>";	
					}
				}

                            ?> 
                            </ul>   
                        </div>
                        <div class="col-xs-12 col-sm-2">
                            <div class="form-group">
                                <label>Escribe la cantidad</label>
                                <div class="input-group">
                                    <input class="form-control" type="text" name="cantcart" value="" id="cantcart" class='cantcart' data-validation="number required" data-validation-error-msg="Debes escribir la cantidad que deseas ordenar"/>
                                    <span class="input-group-addon">Unid.</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-2 ">   
                            <div id="addpot">
                                <button type="button" class="btn btn-filter btn-block" id="addprodorder">
                                    <i class="fa fa-shopping-cart fa-2x margin-right-xs"></i> 
                                    Agregar
                                </button>
                            </div>
                        </div>                                         
                        <input id="colorq" name="colorq" value="" type="hidden" />
                        <input id="tallaq" name="tallaq" value="" type="hidden" />
                        <input id="kitq" name="kitq" value="<?php echo $idCatKitProd; ?>" type="hidden">
                        <input id="prendaq" name="prendaq" value="<?php echo $idSubCateProd; ?>" type="hidden">
                        <input id="tipoprendaq" name="tipoprendaq" value="<?php echo $typePrendaProd; ?>" type="hidden">
                        
                    </div>
                    
                    <div id="erraddpot"></div>

                    <?php
                        //echo $input_l2.$input_l3.$input_cate.$input_talla.$input_color;$input_talla.$input_color;//$input_sb.$input_brand
                    ?>
                    <!--</div>-->
                </form> 
                </div>

            </div>

            
        </div>
        
        

        <?php }else{ //========== PRINT CATALOGO ===========//  ?>


            <?php
            /*
             *---------------------------
             *DEFAULT LAYOUT
             *---------------------------
            */                
            ?>

            <div class="box50 padd-top-lg">
                <div class="alert bg-gray">
                    <div class="media">
                        <div class=" media-left">
                            <i class="fa fa-bell-o fa-4x text-blue"></i>
                        </div>
                        <div class="media-body">
                            <h3 class="no-padmarg">Hola!</h3>
                            <p style="font-size:1.232em; line-height:1;">Por favor escoje una categoría del menu izquierdo</p>                                
                        </div>

                    </div>
                </div>
            </div>

            <!-- list categorias  
            <div class="row maxwidth-layout padd-verti-md">
            </div>
              /list categorias -->

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
        <?php include "../../appweb/tmplt/footer-boss.php"; ?>

        <div id="respuesta"></div>
        <input type="hidden" name="actionform" id="actionform" value="<?php echo $pathmm.$takeOrderDir."/browse/"; ?>">
        <input type="hidden" name="ordernow" id="ordernow" value="<?php echo $idOrderNow; ?>">
        <input type="hidden" name="tipokit" id="tipokit" value="<?php echo $idCategoProd; ?>">        


    </div><!-- /Site wrapper --> 
    
       
    <?php
    /*
        *
        *---------------------------
        *CONTROL SIDE - LIST ORDER
        *---------------------------
        *    
    */
    ?>
    <?php include '../../appweb/tmplt/order-list-tomapedido-boss.php'; ?>
    
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
    
                     
    <?php echo _JSFILESLAYOUT_ ?>
    <script type="text/javascript" src="../../appweb/plugins/form-validator/jquery.form-validator.min.js"></script>      
    <script type="text/javascript" src="crud-order.js"></script>
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
    <script type="text/javascript">   
                                                    
    //validaciones	
    $.validate({
        modules : 'logic, jsconf',            
        onModulesLoaded : function() {                
            var configIdenti = {           
                validate : {
                    '.cantcart' : {
                        validation : 'number required',
                        'error-msg' : 'Escribe la cant. que deseas ordenar'
                    }
                }
              };                
            $.setupValidation(configIdenti);
        }
    });
        
    
    </script>
    
    <script type="text/javascript">
                                    
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
        var linkURL = $(this).attr('href');
        var nameProd = $(this).attr('name');
        var titleEv = $(this).attr('title');
        var msjProd = $(this).attr('data-msj');
        //var reMsjProd = $(this).attr('data-remsj');
        checkPzas(linkURL, titleEv, nameProd, msjProd);
      });

    function checkPzas(linkURL, titleEv, nameProd, msjProd) {
        swal({
          title: titleEv, 
          text: '<span style=color:#DB4040; font-weight:bold; font-size:15px;>' + nameProd + '</span><br>' + msjProd, 
          type: 'warning',
          showCancelButton: true,
          closeOnConfirm: false,
          closeOnCancel: true,
          animation: false,
          html: true
        }, function(isConfirm){
                  if (isConfirm) {
                    window.location.href = linkURL;
                  } else {
                    return false;	
                  }
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
