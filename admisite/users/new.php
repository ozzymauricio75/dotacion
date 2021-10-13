<?php require_once '../appweb/lib/MysqliDb.php'; ?>
<?php require_once '../cxconfig/config.inc.php'; ?>
<?php require_once '../cxconfig/global-settings.php'; ?>
<?php require_once '../appweb/inc/sessionvars.php'; ?>
<?php require_once '../appweb/lib/gump.class.php'; ?>
<?php require_once '../appweb/inc/site-tools.php'; ?>
<?php require_once '../appweb/inc/query-users.php'; ?>
<?php require_once '../appweb/inc/query-levels.php'; ?>
<?php require_once '../i18n-textsite.php'; ?>
<?php 

//***********
//DEFINE CANCEL - TRASH EVENT
//***********
$statusCancel = "";
if(isset($_GET['trash']) && $_GET['trash'] == "ok"){ 
    
    if(isset($_GET['coditemget'])){
        
        $itemVarGET = (int)$_GET['coditemget'];
        $itemVarGET = $db->escape($itemVarGET);

        /*//ELIMINAR ESPECIFICACIONES COLOR    
        $fieldColorTBL = "id_producto";  
        $tblColorTBL = "especifica_product_tipo_color";      
        $trashColorItem = deleteFieldDB($itemVarGET, $fieldColorTBL, $tblColorTBL);

        //ELIMINAR ESPECIFICACIONES TALLAS    
        $fieldTallaTBL = "id_producto";  
        $tblTallaTBL = "especifica_grupo_talla";      
        $trashTallaItem = deleteFieldDB($itemVarGET, $fieldTallaTBL, $tblTallaTBL);

        //ELIMINAR ESPECIFICACIONES MATERIALES    
        $fieldMaterTBL = "id_producto";  
        $tblMaterTBL = "especifica_prod_material";     
        $trashMaterItem = deleteFieldDB($itemVarGET, $fieldMaterTBL, $tblMaterTBL);*/

        //ELIMINAR ITEM
        $fieldItemTBL = "id_account_user";  
        $tblItemTBL = "account_user";
        $trashItem = deleteFieldDB($itemVarGET, $fieldItemTBL, $tblItemTBL);
    }
    
    $statusCancel = 1;
    
    $_SESSION['newitem'] = NULL; 
    unset($_SESSION['newitem']);
    
    
}else{


    //***********
    //CREA NUEVO PRODUCTO
    //***********
    //"""" DEFINE ID NEW PROD
    if(!isset($_SESSION['newitem'])){ $_SESSION['newitem'] = NULL; }

    
    $codeNewProd ="";
    if(isset($_SESSION['newitem'])){
        $codeNewProd = $_SESSION['newitem'];
    }else{
        $codeNewProd = "";
    }
    //if(!isset($codeNewProd)/* && $codeNewProd == ""*/){
    if($codeNewProd == ""){
        $lastUser = lastIDRegis('account_user', 'id_account_user');
        $lastUser = $lastUser + 1;
        $newuser = "userdefault_000".$lastUser;
        

        $pordDataIns = array(    
            'estado_cuenta' => '5',
            'account_pseudo_user' => $newuser,
            'fecha_alta_account_user' => $dateFormatDB
        );
        $newProdIns = $db->insert ('account_user', $pordDataIns);
        if(!$newProdIns){ 
            $erroQuery = $db->getLastError(); 
            echo $erroQuery;
            
        }else{ 
            $_SESSION['newitem'] = $newProdIns; // echo "ultimo producto ".$newProdIns;
            $codeNewProd = $_SESSION['newitem'];
        }

    }
            
}

//***********
//GENERO USUARIO
//***********
//tipo de persona
$generoPrenda = array();
$generoPrenda = forGenero();


//***********
//EMPRESA USUARIO
//***********
$companyUser = array();
$companyUser = queryStores();


//***********
//KITS USUARIO
//***********

///////////////////////////////////////////////////
//////////////////////////////////////////////////

//***********
//ESQUEMA CATGEGORIAS DOTACION ROPA
//***********


$printLevelList = array();
$printLevelList = queryLevelsFull();//getLevelsList();

$lyBrowseCat = "";
$lyBrowseCat .="<div class='box box75 padd-hori-md '>  
                    <div class='box-header'></div>
                    <div class='box-body'>
                    <ul class='categoesquema'>";


    $prevVarGender = "";
    $prevVarItemKit = "";
    $prevVarItemCat = "";
    $prevVarItemSub = "";
     
    if(is_array($printLevelList)){
        foreach($printLevelList as $pllKey){
            $idLevel1 = $pllKey['idlevel1'];
            $nameLevel1 = $pllKey['namelevel1'];            
            $descriLevel1 = $pllKey['descrilevel1'];            
            $tagLevel1 = $pllKey['taglevel1']; //H - M
            
            $datasLevel2 = $pllKey['datal2']; //LEVEL2
            
            
            
            if(is_array($datasLevel2)){
                foreach($datasLevel2 as $l2Key){

                    $idLevel2 = $l2Key['idlevel2'];
                    $nameLevel2 = $l2Key['namelevel2'];            
                    $descriLevel2 = $l2Key['descrilevel2'];
                    $kitLevel2 = $l2Key['kitlevel2']; 
                    $pzsLevel2  = $l2Key['cantlevel2']; 

                    $datasLevel3 = $l2Key['datal3']; //LEVEL2
                    
                    $datasCategoria = $l2Key['datacategoria']; //CATEGORIA CATALOGO


                    //======IMPRIME LAYOUT ITEM KIT
                    if($prevVarItemCat != $idLevel2){
                        if($prevVarItemCat != ""){                            
                            $lyBrowseCat .= "</ul></li>";////CIERRA wrap KIT DOTACION   

                        }                                                                                                                   

                        //======IMPRIME LAYOUT ITEM PACK DOTACION
                        if($prevVarItemKit != $kitLevel2){

                            if($prevVarItemKit != ""){                        
                                $lyBrowseCat .= "</ul></li>";//CIERRA wrap PACK DOTACION
                            }//CIERRA ITEM PACK DOTACION


                                //======IMPRIME LAYOUT MASCULINO FEMENINO
                                if($prevVarGender != $idLevel1){

                                    if($prevVarGender != ""){                            
                                       $lyBrowseCat .= "</ul></li>";//CIERRA wrap DEPTO
                                    }//CIERRA ITEM L1 DOTACION  

                                    $lyBrowseCat .= "<li style='margin-bottom:15px;' id='wrapplevel1".$idLevel1."'>";////wrap PACK DPTO      
                                    $lyBrowseCat .= "<div class='row'><div class='col-xs-9'>";
                                    $lyBrowseCat .= "<h3 class='no-padmarg' id='wpeditl1_".$idLevel1."'>";
                                    $lyBrowseCat .= "<span id='wrappupdatenamel1".$idLevel1."'>".$nameLevel1."</span>";
                                    $lyBrowseCat .= "<small id='wrappupdatedescril1".$idLevel1."' style='display:block;'>".$descriLevel1."</small>";
                                    $lyBrowseCat .= "</h3>";
                                    $lyBrowseCat .= "</div>";
                                    $lyBrowseCat .= "<div class='col-xs-3 text-right'>";
                                    $lyBrowseCat .= "<input type='checkbox' value='root' class='simple boxnivel' id='box_dep_".$idLevel1 ."' /><label for='box_dep_".$idLevel1 ."'></label>";
                                    $lyBrowseCat .= "</div></div>";                                    
                                    $lyBrowseCat .= "<ul style='margin-top:0px;'>";//INICIA CONTENEDOR LEVEL2

                                    $prevVarGender = $idLevel1;                                    
                                }
                                //======FIN IMPRIME LAYOUT MASCULINO FEMENINO


                            //======IMPRIME ITEM KIT                    
                            $lyBrowseCat .= "<li style='margin-top:15px;' ><span class='txtUppercase'>".$kitLevel2."</span><ul class='bg-gray-light' style='margin-top:5px; padding-left:10px; padding-right:10px; padding-top:0px; padding-bottom:0px;'>";////wrap KIT DOTACION
                            $prevVarItemKit = $kitLevel2;                            
                        }                       
                        
                        //======IMPRIME ITEM KIT                        
                        $lyBrowseCat .= "<li id='wrapplevel2".$idLevel2."'>";
                        $lyBrowseCat .= "<div id='wpeditl2_".$idLevel2."' class='row no-padmarg padd-verti-xs' style='border:1px dashed #ccc; '>";
                        $lyBrowseCat .= "<div class='col-xs-7'>";
                        $lyBrowseCat .= "<p class='no-padmarg'>";
                        $lyBrowseCat .= "<strong id='wrappupdatenamel2".$idLevel2."'>".$nameLevel2."</strong>";
                        $lyBrowseCat .= "<span style='display:block;' id='wrappupdatesubnamel2".$idLevel2."'>".$descriLevel2."</span>";
                        $lyBrowseCat .= "</p>";
                        $lyBrowseCat .= "</div>";//col-xs-7
                        
                        $lyBrowseCat .= "<div class='col-xs-2'>";
                        $lyBrowseCat .= "<span id='wrappupdatepzsl2".$idLevel2."'>".$pzsLevel2."</span>&nbsp;Pzs";
                        $lyBrowseCat .= "</div>";//col-xs-2
                        
                        $lyBrowseCat .= "<div class='col-xs-3 text-right'>";
                        $lyBrowseCat .= "<input type='checkbox' value='' class='simple boxnivel' id='box_kit_".$idLevel2."' /><label for='box_kit_".$idLevel2."'></label>";
                        $lyBrowseCat .= "</div>";//col-xs-3
                                                                        
                        $lyBrowseCat .= "</div>";//wpeditl2_
                        $lyBrowseCat .= "<ul>";//INICIA CONTENEDOR LEVEL 3
                        
                        $prevVarItemCat = $idLevel2;                        
                    }//CIERRA ITEM ITEM KIT
                    
                    //CATEGORIA CATALOGO
                    if(is_array($datasCategoria)){
                        foreach($datasCategoria as $dccKey){
                            $idCC = $dccKey['id_categoria_catalogo'];
                            $tagCC = $dccKey['tag_nombre_categoria_catalogo']; 
                            //echo $tagCC;
                        }
                    }//CIERRA CATEGORIA CATALOGO
                                                            
                    if(is_array($datasLevel3)){
                        foreach($datasLevel3 as $l3Key){

                            $idLevel3 = $l3Key['id_subcatego_producto'];
                            $nameLevel3 = $l3Key['nome_subcatego_producto'];            
                            $descriLevel3 = $l3Key['descri_subcatego_prod'];
                            $tagLevel3 = $l3Key['nome_clean_subcatego_prod']; 
                            $posiLevel3  = $l3Key['posi_sub_cate_prod']; 
                            $tipoPrendaLevel3  = $l3Key['tipo_prenda']; //superior | inferior | traje | 
                            $tipoTallaLevel3 = $l3Key['talla_tipo_prenda'];  // tl | tn | unica
                            $labelLevel3  = empty($l3Key['img_subcate_prod'])? "" : $l3Key['img_subcate_prod']; 
                            
                            //PATH FOTO DEFAULT
                            $pathFileDefault = $pathmm."img/nopicture.png";
                            //PORTADA
                            $pathPortada = "../../files-display/tienda/img-catego/".$labelLevel3;

                            if (file_exists($pathPortada)) {
                                $portadaFile = $pathPortada;
                            } else {
                                $portadaFile = $pathFileDefault;
                            }

                            //======IMPRIME LAYOUT ITEM PRENDA
                            $lyBrowseCat .= "<li style='margin-top:10px; margin-bottom:10px;' id='wrapplevel3".$idLevel3."'>";
                            
                            $lyBrowseCat .= "<div id='wpeditl3_".$idLevel3."' class='row no-padmarg padd-verti-xs' style='border:1px dashed #ccc; '>";
                            $lyBrowseCat .= "<div class='col-xs-9'>";
                            
                            $lyBrowseCat .= "<div class='media no-padmarg'>";                                                                                    
                            $lyBrowseCat .= "<div class='media-left'>";                            
                            $lyBrowseCat .= "<img class='media-object' src='".$portadaFile."' style='height:60px;'>";                            
                            $lyBrowseCat .= "</div>";
                            $lyBrowseCat .= "<div class='media-body'>";
                            $lyBrowseCat .= "<h4 class='media-heading' id='wrappupdatenamel3".$idLevel3."'>".$nameLevel3."</h4>";
                            $lyBrowseCat .= "<span id='wrappupdatedescril3".$idLevel3."'>".$descriLevel3."</span>";
                            $lyBrowseCat .= "</div>";
                            $lyBrowseCat .= "</div>";//wrap media
                            
                            $lyBrowseCat .= "</div>";//col-xs-9
                            
                            $lyBrowseCat .= "<div class='col-xs-3 text-right'>";
                            $lyBrowseCat .= "<input type='checkbox' name='' value='".$idLevel3."' class='simple boxnivel ropuserkit' id='box_prenda_".$idLevel3."' data-l2='".$idLevel2."' data-tagl1='".$tagLevel1."' data-idkit='".$idCC."' data-tkit='".$tagCC."' data-numepzs='".$pzsLevel2."' /><label for='box_prenda_".$idLevel3."'></label>";
                            $lyBrowseCat .= "</div>";//col-xs-3
                                                                                    
                            $lyBrowseCat .= "</div>";//wpeditl3_                      
                                                                                    
                            $lyBrowseCat .= "</li>";////////ITEM PRENDA
                            
                        }//fin foreach $datasLevel3
                    }//fin is_array $datasLevel3
                    
                }//fin foreach $datasLevel2
            }//fin is_array $datasLevel2                                    
        }    
    }   

$lyBrowseCat .="</ul>";
$lyBrowseCat .="</div><!--//body-->";
$lyBrowseCat .="</div><!--//CATALOGO-->";
                
///////////////////////////////////////////////////




//***********
//ESQUEMA CATGEGORIAS DOTACION ADICIONAL
//***********


$printLevelList_add = array();
$printLevelList_add = queryLevelsFull();//getLevelsList();

$layoutAdicional = "";
$layoutAdicional .="<div class='box box75 padd-hori-md'>  
                    <div class='box-header'></div>
                    <div class='box-body'>
                    <ul id='addcategoesquema'>";


    $prevVarGender = "";
    $prevVarItemKit = "";
    $prevVarItemCat = "";
    $prevVarItemSub = "";
     
    if(is_array($printLevelList_add)){
        foreach($printLevelList_add as $pllKey){
            $idLevel1 = $pllKey['idlevel1'];
            $nameLevel1 = $pllKey['namelevel1'];            
            $descriLevel1 = $pllKey['descrilevel1'];            
            $tagLevel1 = $pllKey['taglevel1']; //H - M
            
            $datasLevel2 = $pllKey['datal2']; //LEVEL2
            
            
            
            if(is_array($datasLevel2)){
                foreach($datasLevel2 as $l2Key){

                    $idLevel2 = $l2Key['idlevel2'];
                    $nameLevel2 = $l2Key['namelevel2'];            
                    $descriLevel2 = $l2Key['descrilevel2'];
                    $kitLevel2 = $l2Key['kitlevel2']; 
                    $pzsLevel2  = $l2Key['cantlevel2']; 

                    $datasLevel3 = $l2Key['datal3']; //LEVEL2
                    
                    $datasCategoria = $l2Key['datacategoria']; //CATEGORIA CATALOGO


                    //======IMPRIME LAYOUT ITEM KIT
                    if($prevVarItemCat != $idLevel2){
                        if($prevVarItemCat != ""){                            
                            $layoutAdicional .= "</ul></li>";////CIERRA wrap KIT DOTACION   

                        }                                                                                                                   

                        //======IMPRIME LAYOUT ITEM PACK DOTACION
                        if($prevVarItemKit != $kitLevel2){

                            if($prevVarItemKit != ""){                        
                                $layoutAdicional .= "</ul></li>";//CIERRA wrap PACK DOTACION
                            }//CIERRA ITEM PACK DOTACION


                                //======IMPRIME LAYOUT MASCULINO FEMENINO
                                if($prevVarGender != $idLevel1){

                                    if($prevVarGender != ""){                            
                                       $layoutAdicional .= "</ul></li>";//CIERRA wrap DEPTO
                                    }//CIERRA ITEM L1 DOTACION  

                                    $layoutAdicional .= "<li style='margin-bottom:15px;' id='wrappadd1".$idLevel1."'>";////wrap PACK DPTO
                                    $layoutAdicional .= "<div class='row'><div class='col-xs-9'>";                 
                                    $layoutAdicional .= "<h3 class='no-padmarg ' id='wpeditl1_".$idLevel1."'>";
                                    $layoutAdicional .= "<span >".$nameLevel1."</span>";
                                    $layoutAdicional .= "<small style='display:block;'>".$descriLevel1."</small>";
                                    $layoutAdicional .= "</h3>"; 
                                    $layoutAdicional .= "</div>";//col-9
                                    $layoutAdicional .= "<div class='col-xs-3 text-right'>";
                                    //$layoutAdicional .= "<input type='checkbox' value='root' class='simple boxnivel' id='box_add_dep_".$idLevel1 ."' /><label for='box_add_dep_".$idLevel1 ."'></label>";
                                    $layoutAdicional .= "</div></div>";//col-3
                                    $layoutAdicional .= "<ul style='margin-top:0px;'>";//INICIA CONTENEDOR LEVEL2

                                    $prevVarGender = $idLevel1;                                    
                                }
                                //======FIN IMPRIME LAYOUT MASCULINO FEMENINO


                            //======IMPRIME ITEM KIT                    
                            $layoutAdicional .= "<li style='margin-top:15px;' ><span class='txtUppercase'>".$kitLevel2."</span><ul class='bg-gray-light' style='margin-top:5px; padding-left:10px; padding-right:10px; padding-top:0px; padding-bottom:0px;'>";////wrap KIT DOTACION
                            
                            $prevVarItemKit = $kitLevel2;                            
                        }                       
                        
                        //======IMPRIME ITEM KIT                        
                        $layoutAdicional .= "<li id='wrappadd2".$idLevel2."'>";
                        $layoutAdicional .= "<div id='wpeditl2_".$idLevel2."' class='row no-padmarg padd-verti-xs' style='border:1px dashed #ccc; '>";
                        $layoutAdicional .= "<div class='col-xs-7'>";
                        $layoutAdicional .= "<p class='no-padmarg'>";
                        $layoutAdicional .= "<strong >".$nameLevel2."</strong>";
                        $layoutAdicional .= "<span style='display:block;' >".$descriLevel2."</span>";
                        $layoutAdicional .= "</p>";
                        $layoutAdicional .= "</div>";
                        $layoutAdicional .= "<div class='col-xs-2'>";
                        $layoutAdicional .= "<span >1</span>&nbsp;Pzs";
                        $layoutAdicional .= "</div>";//col-xs-2
                        $layoutAdicional .= "<div class='col-xs-3 text-right'>";
                        //$layoutAdicional .= "<input type='checkbox' value='' class='simple boxnivel' id='box_add_kit_".$idLevel2."' /><label for='box_add_kit_".$idLevel2."'></label>";                        
                        $layoutAdicional .= "</div>";//col-xs-3
                                                                        
                        $layoutAdicional .= "</div>";//wpeditl2_
                                            
                        $layoutAdicional .= "<ul>";//INICIA CONTENEDOR LEVEL 3
                        
                        $prevVarItemCat = $idLevel2;                        
                    }//CIERRA ITEM ITEM KIT
                    
                    //CATEGORIA CATALOGO
                    if(is_array($datasCategoria)){
                        foreach($datasCategoria as $dccKey){
                            $idCC = $dccKey['id_categoria_catalogo'];
                            $tagCC = $dccKey['tag_nombre_categoria_catalogo']; 
                            //echo $tagCC;
                        }
                    }//CIERRA CATEGORIA CATALOGO
                                                            
                    if(is_array($datasLevel3)){
                        foreach($datasLevel3 as $l3Key){

                            $idLevel3 = $l3Key['id_subcatego_producto'];
                            $nameLevel3 = $l3Key['nome_subcatego_producto'];            
                            $descriLevel3 = $l3Key['descri_subcatego_prod'];
                            $tagLevel3 = $l3Key['nome_clean_subcatego_prod']; 
                            $posiLevel3  = $l3Key['posi_sub_cate_prod']; 
                            $tipoPrendaLevel3  = $l3Key['tipo_prenda']; //superior | inferior | traje | 
                            $tipoTallaLevel3 = $l3Key['talla_tipo_prenda'];  // tl | tn | unica
                            $tipoColeccioinL1_add = $l3Key['tags_depatament_produsts'];
                            $labelLevel3  = empty($l3Key['img_subcate_prod'])? "" : $l3Key['img_subcate_prod']; 
                            
                            
                            //DEFINE TIPO DE KIT ADICIONAL
                            $idAdicionalHM = "";
                            if($tipoColeccioinL1_add == "masculino"){
                            	$idAdicionalHM = "4";
                            }else if($tipoColeccioinL1_add == "femenino"){
                            	$idAdicionalHM = "10";
                            }
                            
                            
                            
                            
                            //PATH FOTO DEFAULT
                            $pathFileDefault = $pathmm."img/nopicture.png";
                            //PORTADA
                            $pathPortada = "../../files-display/tienda/img-catego/".$labelLevel3;

                            if (file_exists($pathPortada)) {
                                $portadaFile = $pathPortada;
                            } else {
                                $portadaFile = $pathFileDefault;
                            }

                            //======IMPRIME LAYOUT ITEM PRENDA
                            $layoutAdicional .= "<li style='margin-top:10px; margin-bottom:10px;' id='wrappadd3".$idLevel3."'>";
                            
                            $layoutAdicional .= "<div class='row no-padmarg padd-verti-xs' style='border:1px dashed #ccc; '>";
                            $layoutAdicional .= "<div class='col-xs-9'>";
                            
                            $layoutAdicional .= "<div class='media no-padmarg'>";                                                                                    
                            $layoutAdicional .= "<div class='media-left'>";                            
                            $layoutAdicional .= "<img class='media-object' src='".$portadaFile."' style='height:60px;'>";                            
                            $layoutAdicional .= "</div>";
                            $layoutAdicional .= "<div class='media-body'>";
                            $layoutAdicional .= "<h4 class='media-heading' >".$nameLevel3."</h4>";
                            $layoutAdicional .= "<span >".$descriLevel3."</span>";
                            $layoutAdicional .= "</div>";
                            $layoutAdicional .= "</div>";//wrap media
                            
                            $layoutAdicional .= "</div>";//col-xs-9
                            
                            $layoutAdicional .= "<div class='col-xs-3 text-right'><input type='checkbox' name='' value='".$idLevel3."' class='simple boxnivel adduserkit' id='box_add_prenda_".$idLevel3."' data-l2='".$idLevel2."' data-tagl1='".$tagLevel1."' data-idkit='".$idAdicionalHM."' data-tkit='adicional' data-numepzs='1' /><label for='box_add_prenda_".$idLevel3."' ></label>";
                            $layoutAdicional .= "</div>";//col-xs-3
                                                                                    
                            $layoutAdicional .= "</div>";//wpeditl3_                      
                                                                                    
                            $layoutAdicional .= "</li>";////////ITEM PRENDA
                            
                        }//fin foreach $datasLevel3
                    }//fin is_array $datasLevel3
                    
                }//fin foreach $datasLevel2
            }//fin is_array $datasLevel2                                    
        }    
    }   

$layoutAdicional .="</ul>";
$layoutAdicional .="</div><!--//body-->";
$layoutAdicional .="</div><!--//CATALOGO-->";


//$layoutAdicional = $lyBrowseCat;






//***********
//SITE MAP
//***********

$rootLevel = "usuario";
$sectionLevel = "new";
$subSectionLevel = "";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo METATITLE ?></title>    
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <meta name="author" content="massin">
    <?php echo _CSSFILESLAYOUT_ ?>        
    <?php echo _FAVICON_TOUCH_ ?>    
    
    <style>
        .kv-avatar .file-preview-frame,.kv-avatar .file-preview-frame:hover {
            margin: 0 ;            
            padding: 0;
            border: none;
            box-shadow: none;
            text-align: center;            
        }
        .kv-avatar .file-input {
            display: table-cell;
            max-width: 160px;
        }
    </style>
    
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="../appweb/plugins/iCheck/all.css">
    <!---switchmaster--->    
    <link rel="stylesheet" href="../appweb/plugins/switchmaster/css/bootstrap3/bootstrap-switch.min.css">
    <!--jquery bonsai--->
    <link rel="stylesheet" href="../appweb/plugins/jquery-bonsai/jquery.bonsai.css">
    
    <style type="text/css">
        /*** custom checkboxes http://codepen.io/jamesbarnett/pen/yILjk ***/

        input[type=checkbox].boxnivel { display:none; } /* to hide the checkbox itself */
        input[type=checkbox].boxnivel + label:before {
          font-family: FontAwesome;
          font-size:15px;
          color:#444;
          display: inline-block;
        }

        input[type=checkbox].boxnivel + label:before { content: "\f096"; } /* unchecked icon */
        input[type=checkbox].boxnivel + label:before { letter-spacing: 10px; } /* space between checkbox and label */

        input[type=checkbox].boxnivel:checked + label:before { content: "\f046"; } /* checked icon */
        input[type=checkbox].boxnivel:checked + label:before { letter-spacing: 5px; } /* allow space for check mark */

    </style>
    
</head>
    
<?php echo LAYOUTOPTION ?><!---//print body tag--->    

    
<div class="wrapper">            
    <?php
    /*
    /
    ////HEADER
    /
    */
    ?>
    <?php include '../appweb/tmplt/header.php';  ?>           
    <?php
    /*
    /
    ////SIDEBAR
    /
    */
    ?>
    <?php include '../appweb/tmplt/side-mm.php';  ?>
    <?php
    /*
    /
    ////WRAP CONTENT
    /
    */
    ?>        
    <div class="content-wrapper">
        <?php
        /*
        /*****************************//*****************************
        /HEADER CONTENT
        /*****************************//*****************************
        */
        ?>
        <section class="content-header bg-content-header">
                                    
            <h1>
            <small>Usuarios</small> / Publicar nuevo
            </h1>
            <a href="<?php echo $pathmm.$admiDir."/users/"; ?>" class="ch-backbtn">
                <i class="fa fa-arrow-left"></i>
                Lista de usuarios
            </a>                                    
        </section>

        <?php
        /*
        /*****************************//*****************************
        /MAIN WRAPPER CONTEN
        /*****************************//*****************************
        */
        ?>
        
        <?php if(!$statusCancel){ ?>
        <section class="content ">

            <div class="box75 padd-bottom-lg">
                <form method="post" enctype="text/plain" id="newitem" autocomplete="off">                                               
                <div class="row wrapdivsection">
                    <div class="col-xs-12 col-sm-4">
                        <!--<div class="form-group ">
                            <div class="kv-avatar " style="width:100px">
                                <input id="valida-upload" name="fotoprod" type="file" class="fileimg" >class=file-loading 
                            </div>
                            <div id="kv-avatar-errors-2" class="center-block" style="width:90%; margin:5px auto; display:none"></div>
                            <div id="successupload" class="center-block" style="width:90%; margin:5px auto;"></div>                        
                        </div>-->
                        <h4>Generalidades</h4>
                        <p class="help-block">Valida la empresa a la que pertenece este usuario, y define el tipo de catálogo al que accederá el usuario (CATALOGO MASCULINO - CATALOGO FEMENINO)</p>
                    </div>
                    <div class="col-xs-12 col-sm-8 ">
                        <div class="form-group">                        
                        <?php

                        $lyoutCompany = "<select name='company' class='form-control'>"; 
                        $lyoutCompany .= "<option value='0' select>Selecciona una empresa</option>";
                        if(is_array($companyUser)){
                            foreach($companyUser as $cuKey){
                                $idCompany = $cuKey['id_account_empre'];
                                $nameCompany = $cuKey['nombre_account_empre'];                                

                                $lyoutCompany .= "<option value='".$idCompany."'>";
                                $lyoutCompany .= $nameCompany;
                                $lyoutCompany .= "</option>";


                            }
                        }
                        $lyoutCompany .= "</select>"; 
                        echo $lyoutCompany;
                        ?>
                        </div>
                        
                        
                        <div class="form-group">
                        <?php

                        $lyoutGenero = "<select name='colectioncheck' class='form-control generopz'>"; 
                        $lyoutGenero .= "<option value='0' select>Selecciona un tipo de colección</option>";
                        if(is_array($generoPrenda)){
                            foreach($generoPrenda as $gpKey){
                                $idL1Item = $gpKey['id_depart_prod'];
                                $nameL1Item = $gpKey['nome_depart_prod'];
                                $tagL1Item = $gpKey['nome_clean_depa_prod'];

                                $lyoutGenero .= "<option value='".$idL1Item."'>";
                                $lyoutGenero .= $nameL1Item;
                                $lyoutGenero .= "</option>";
                            }
                        }
                        $lyoutGenero .= "</select>"; 
                        echo $lyoutGenero;
                        ?>
                        </div>
                                                                                                                        
                    </div>  
                    <hr class="linesection"/>
                </div>

                <div class="row wrapdivsection">
                    <div class="col-xs-12 col-sm-4">
                        <h4>Información personal</h4>
                        <p class="help-block"></p>
                    </div>                                           
                    <div class="col-xs-12 col-sm-8">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nomeuser" class="form-control" value ="" placeholder="Nombre completo">
                        </div>
                        <div class="form-group">
                            <label>Cedula/Identificación</label>
                            <input type="text" name="cedulauser" class="form-control" value ="" placeholder="Cedula">
                        </div>
                        <div class="form-group">
                            <label>Teléfono</label>
                            <input type="text" name="tel1user" class="form-control" value ="" placeholder="Teléfono">
                        </div>
                        <div class="form-group">
                            <label>Celular / Teléfono</label>
                            <input type="text" name="tel2user" class="form-control" value ="" placeholder="Otro Teléfono | Celular">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="emailuser" class="form-control" value ="" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label>Dirección</label>
                            <input type="text" name="adressuser" class="form-control" value ="" placeholder="Dirección">
                        </div>
                        <div class="form-group">
                            <label>Ciudad</label>
                            <input type="text" name="cityuser" class="form-control" value ="" placeholder="Ciudad">
                        </div>
                    </div>      
                    <hr class="linesection"/>
                </div>
                <div class="row wrapdivsection">
                    <div class="col-xs-12 col-sm-4">
                        <h4>LogIn</h4>
                        <p class="help-block">Define la información para validar el acceso a la plataforma de pedidos</p>
                    </div>
                    <div class="col-xs-12 col-sm-8">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon" ><i class="fa fa-user"></i></span>
                                <input type="text" name="userstore" class="form-control" placeholder="Nombre de usuario" maxlength="12" >                        
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon" ><i class="fa fa-lock"></i></span>
                                <input type="text" name="pass" class="form-control" placeholder="Contraseña" maxlength="12">                        
                            </div>
                        </div>
                    </div>
                    <hr class="linesection"/>
                </div>

                <div class="row wrapdivsection">
                    <div class="col-xs-2 col-sm-3">
                        <input id="switchropa" type="checkbox" name="" data-switch-value="mini" class="opcikit">
                    </div>
                    <div class="col-xs-10 col-sm-9">
                        <h3 class="no-padmarg">
                            Kit dotación                            
                        </h3>
                        <span class="help-block  margin-bottom-md">Asignarle este kit al usuario</span>
                        
                        <div id="wrapkitropa" class="row margin-bottom-md"><?php echo $lyBrowseCat; ?></div><!---/FIN WRAPP KIT ROPA--->
                    </div>
                    <hr class="linesection"/>
                </div>
                
                
                <div class="row wrapdivsection">
                    <div class="col-xs-2 col-sm-3">
                        <input id="switchadd" type="checkbox" name="" data-switch-value="mini" class="opcikit">
                    </div>
                    <div class="col-xs-10 col-sm-9">
                        <h3 class="no-padmarg">
                            Kit Unitario                            
                        </h3>
                        <span class="help-block  margin-bottom-md">Asignarle este kit al usuario</span>
                        
                        <div id="wrapkitadd" class="row margin-bottom-md"><?php echo $layoutAdicional; ?></div><!---/FIN WRAPP KIT ADICIONAL--->
                    </div>
                    <hr class="linesection"/>
                </div>
                

                <div class="row wrapdivsection">                        
                    <input name="newprod" type="hidden" value="ok">
                    
                    <input type="hidden" name="codeitemform" id="codeitemform" value="<?php echo $codeNewProd; ?>"> 
                </div>
            </form>                
            </div>

        </section>    
                        
        <?php
        /*
        /*****************************//*****************************
        /FOOTER CONTENT - BOTTOM NAV
        /*****************************//*****************************
        */
        ?>
        <section class="main-footer navbar-fixed-bottom bottonnav">
            <div id="wrapadditem"></div>
            <div id="erradditem"></div>       
            <nav class="">
                <div id="left-barbtn" class="nav navbar-nav margin-left-md padd-verti-xs" style="display:none;">
                    <a href="<?php echo $pathmm.$admiDir."/users/new.php"; ?>" class="btn btn-info margin-hori-xs">
                        <i class="fa fa-plus fa-lg margin-right-xs"></i>
                        <span>Nuevo usuario</span>
                    </a>
                    <a href="<?php echo $pathmm.$admiDir."/users/"; ?>" class="btn btn-success margin-hori-xs">
                        <i class="fa fa-th-list fa-lg margin-right-xs"></i>
                        <span>Lista de usuarios</span>
                    </a>
                    <a href="<?php echo $pathmm.$admiDir."/users/new.php?trash=ok&coditemget=".$codeNewProd; ?>" class="btn btn-default trashtobtn" name="" title="Eliminar item" data-msj="Perderás toda la información para este usuario. Deseas continuar?" data-remsj="">
                        <i class="fa fa-trash fa-lg margin-right-xs"></i>
                        <span>Eliminar</span>
                    </a>
                
                </div>
                <div id="right-bartbtn" class="nav navbar-nav navbar-right margin-right-md padd-verti-xs">
                    <a href="<?php echo $pathmm.$admiDir."/users/new.php?trash=ok&coditemget=".$codeNewProd; ?>" class="btn btn-default trashtobtn" name="" title="Eliminar item" data-msj="Perderás toda la información para este usuario. Deseas continuar?" data-remsj="">
                        <i class='fa fa-times fa-lg'></i>
                        <span>Cancelar</span>                        
                    </a> 
                    <button type="button" class="btn btn-info margin-hori-xs " id="additembtn">
                        <i class='fa fa-save fa-lg'></i>
                        <span>Guardar</span>                     
                    </button>                                                               
                </div>
            </nav>
        </section>
        
        
        <?php }else{ ?>
        <section class="content ">                    
            <div class="box50  padd-verti-lg">
                <div class="alert alert-dismissible bg-gray">
                    <div class="media">
                        <div class=" media-left">
                            <i class="fa fa-bell-o fa-4x text-blue"></i>
                        </div>
                        <div class="media-body">
                            <h3 class="no-padmarg">Hola!</h3>
                            <p style="font-size:1.232em; line-height:1;">
                                Este item fue eliminado correctamente, que deseas hacer ahora?
                            </p>                            
                        </div>

                    </div>                    
                </div>
                <div class="margin-verti-xs">
                    <div class="btn-toolbar" role="toolbar">
                        <div class="btn-group text-center">
                            <a href="<?php echo $pathmm.$admiDir."/users/"; ?>" type="button" class="btn btn-default">
                                <i class='fa fa-th-list fa-lg'></i>
                                <span>lista de usuarios</span>                        
                            </a> 
                        </div>
                    
                        <div class="btn-group text-center">                            
                            <a href="<?php echo $pathmm.$admiDir."/users/new.php"; ?>" type="button" class="btn btn-info ">
                                <i class='fa fa-plus fa-lg'></i>
                                <span>Nuevo Usuario</span>                     
                            </a>                                                               
                        </div>
                    </div>

                </div>
            </div>
        </section>
        
        
        <?php } ?>
        
    </div>
    <?php
    /*
    /
    ////FOOTER
    /
    */
    ?>
    <?php //include 'appweb/tmplt/footer.php';  ?>
    
            
    <?php
    /*
    /
    ////RIGHT BAR
    /
    */
    ?>
    <?php include '../appweb/tmplt/right-side.php';  ?>
    <?php echo "<input id='pathfile' type='hidden' value='".$pathmm."'/>"; ?>
    <?php echo "<input id='pathdir' type='hidden' value='".$admiDir."'/>"; ?>
    
</div>

<?php echo _JSFILESLAYOUT_ ?>
<script type="text/javascript" src="crud-newitem.js"></script>    
    
<!--jquery bonsai--->
<script src="../appweb/plugins/jquery-bonsai/jquery.bonsai.js" type="text/javascript"></script>
<script src="../appweb/plugins/jquery-bonsai/jquery.qubit.js" type="text/javascript"></script>
    
<!---switchmaster---> 
<script src="../appweb/plugins/switchmaster/js/bootstrap-switch.min.js" type="text/javascript"></script> 
<!-- iCheck 1.0.1 -->
<script src="../appweb/plugins/iCheck/icheck.min.js"></script>
    


<!---fileimput--->     
<script src="../appweb/plugins/fileimput/fileinput.js" type="text/javascript"></script>        
<script src="../appweb/plugins/fileimput/themes/fa/theme.js"></script>    
<script src="../appweb/plugins/fileimput/locales/es.js"></script> 
<script type="text/javascript">


    
$(document).ready(function() {  
    
    //WRAPS & BOTTOMS EDIT 
    $(".wefield").hide();
    
    $('button.editfieldbtn').each(function(){
        var field = $(this).attr("data-this");  
        //var parent = field.parent().attr("id");
        
        
        var wrapprint = $("#wp"+field).show(); 
        var wrapedit = $("#we"+field).hide();
        
        $(this).click(function(){
            wrapprint.hide();
            wrapedit.show();
        });
        
        
    });
    
    $('button.canceleditfieldbtn').each(function(){
        var field = $(this).attr("data-this");  
        //var parent = field.parent().attr("id");
        
        
        var wrapprint = $("#wp"+field).show(); 
        var wrapedit = $("#we"+field).hide();
        
        $(this).click(function(){
            wrapprint.show();
            wrapedit.hide();
        });
        
        
    });
    

    $(".fileimg").fileinput({        
        theme: "fa",
        language: 'es',
        fileTypeSettings: 'image',        
        maxFileSize: 1700,
        maxImageWidth: 1600,
        maxImageHeight: 1600,            
        maxFilesNum: 1,        
        //overwriteInitial: true,           
        showClose: false,
        showCaption: false,
        showBrowse: false,
        browseOnZoneClick: true,
        removeLabel: '',
        //removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
        // uploadIcon: '<i class="fa fa-upload text-info"></i>',
        removeTitle: 'Cancel or reset changes',
        elErrorContainer: '#kv-avatar-errors-2',
        msgErrorClass: 'alert alert-block alert-danger',
        defaultPreviewContent: '<img src="../../img/camera-icon.png" style="width:160px; margin-bottom:4px;">',//<h6 class="text-muted">Click to select</h6>
        //layoutTemplates: {main2: '{preview}  {remove} {browse}'},
        /*layoutTemplates: {
            main1: '{preview}\n' +
                '<div class="kv-upload-progress hide"></div>\n' +
                '<div class="input-group {class}" style="display:block; position:relative; margin-top:2px;">\n' +
                '   {caption}\n' +
                '   <div class="input-group-btn">\n' +
                '       {remove}\n' +
                '       {cancel}\n' +
                '       {upload}\n' +
                '       {browse}\n' +
                '   </div>\n' +
                '</div>'
        },*/
        allowedFileExtensions: ["jpg", "png", "png"],                                 
        uploadAsync: false,
        uploadUrl: "../appweb/inc/upload-imgfile.php", 
        uploadExtraData: function() {
            return {
                codeitem: $("#codeitemform").val()                
            };
        }
    });

    /*$(".fileimg").on('filebatchuploadsuccess', function(event, data, previewId, index) {
        var form = data.form, files = data.files, extra = data.extra,
            response = data.response, reader = data.reader;
        //console.log(response);
        $("#successupload").html(response);
    });*/


    
    //OPTION KITS
    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });
    
    
    //CARGA TIPO COLECCION USUARIO
    $(".usercolection").find("input[type='radio'], input[type='checkbox']").attr('disabled',true); //usercolection' data-colection
    $(".generopz").change(function(){        
        var id=$(this).val();
        //console.log(id);
        $('.usercolection').each(function(k,v1) { 
            var dcolection = $(v1).attr("data-colection");

            if(id == dcolection){                
                $(".usercolection[data-colection='"+id+"']").find("input[type='radio'], input[type='checkbox']").attr('disabled',false);
            }
         });

    });
    
    //esquema explorador - bonsai 
    /*$('ul#categoesquema').bonsai({
        expandAll: true,
        //checkboxes: true,
    });*/
                       
});   
    
//checktree
jQuery(function() {
    $('ul.categoesquema').bonsai({
        expandAll: false,
        checkboxes: true,
    });
});
    
//checktree
jQuery(function() {
    $('ul#addcategoesquema').bonsai({
        expandAll: false,
        checkboxes: true,
    });
});
    
    
    
//GESTIONA KITS USUARIO
//========switchmaster
//$("[name='opcikit']").bootstrapSwitch();
$(".opcikit").bootstrapSwitch();

//========KIT DE ROPA 
$("#wrapkitropa").hide();
//$("#wrapkitropa").find("input[type='radio']").attr('disabled',true);
$("#switchropa").on('switchChange.bootstrapSwitch', function(event, state) {
    if($(this).is(':checked')) {
        $("#wrapkitropa").show();            
    }else{
        $("#wrapkitropa").hide();            
    }
});

//========KIT DE ZAPATOS
$("#wrapkitzapato").hide();     
$("#switchzapato").on('switchChange.bootstrapSwitch', function(event, state) {
    if($(this).is(':checked')) {
        $("#wrapkitzapato").show();            
    }else{
        $("#wrapkitzapato").hide();            
    }
});

//========KIT ADICIONAL
$("#wrapkitadd").hide();     
$("#switchadd").on('switchChange.bootstrapSwitch', function(event, state) {
    if($(this).is(':checked')) {
        $("#wrapkitadd").show();            
    }else{
        $("#wrapkitadd").hide();            
    }
});
    
</script>     
</body>
</html>
