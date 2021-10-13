<?php require_once '../appweb/lib/MysqliDb.php'; ?>
<?php require_once '../cxconfig/config.inc.php'; ?>
<?php require_once '../cxconfig/global-settings.php'; ?>
<?php require_once '../appweb/inc/sessionvars.php'; ?>
<?php require_once '../appweb/lib/gump.class.php'; ?>
<?php require_once '../appweb/inc/site-tools.php'; ?>
<?php require_once '../appweb/inc/query-prods.php'; ?>
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

        //ELIMINAR ESPECIFICACIONES COLOR    
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
        $trashMaterItem = deleteFieldDB($itemVarGET, $fieldMaterTBL, $tblMaterTBL);

        //ELIMINAR ITEM
        $fieldItemTBL = "id_producto";  
        $tblItemTBL = "productos";
        $trashItem = deleteFieldDB($itemVarGET, $fieldItemTBL, $tblItemTBL);
    }
    
    $statusCancel = 1;
                
}


//***********
//ESPECIFICACIONES ITEM REFERENCIA
//***********
$itemVarGET = "";
if(isset($_GET['coditemget'])){

    $itemVarGET = (int)$_GET['coditemget'];
    $itemVarGET = $db->escape($itemVarGET);
            
}

//***********
//INFO ITEM
//***********
$detallesItem = array();
$detallesItem = queryDetallesItem($itemVarGET);

$dataCatego = array();
$dataTL = array();
$dataColor = array();
$dataMaterial = array();
$dataTLCheck = array();
$dataColorCheck = array();
$dataMaterialCheck = array();

if(is_array($detallesItem)){
    foreach($detallesItem as $diKey){
        $categoItem = $diKey['id_catego_product'];
        $subCateItem = $diKey['id_subcatego_producto'];
        $dataCatego = $diKey['categoitem'];           
        $idProdItem = $diKey['id_producto'];
        $statusItem = $diKey['id_estado_contrato'];
        $actiStockItem = $diKey['agotado'];
        $codVentaItem = $diKey['cod_venta_prod'];
        $nameItem = $diKey['nome_producto'];
        $fotoItem = $diKey['foto_producto'];
        $refAlbumItem = $diKey['ref_album'];
        $priceItem = $diKey['precio_producto'];
        $descriItem = $diKey['caracteristicas_producto'];
        $dataTL = $diKey['tallasitem'];
        $dataColor = $diKey['coloritem'];
        $dataMaterial = $diKey['materialitem'];
            
        $dataTLCheck = $diKey['tallasitem'];
        $dataColorCheck = $diKey['coloritem'];
        $dataMaterialCheck = $diKey['materialitem'];
        
        //SOBRE CATEGORIA
        $categoLayout = "";
        if(is_array($dataCatego)){
            foreach($dataCatego as $catKey){
                $namel1Item = $catKey['nome_depart_prod'];
                $climaKitItem = $catKey['tipo_kit_4user'];
                $namel2Item = $catKey['nome_catego_product'];
                $namel3Item = $catKey['nome_subcatego_producto'];     
                
                $categoLayout .= "<p>";
                $categoLayout .= "<span class='img-thumbnail margin-right-xs padd-hori-xs'>".$namel1Item."</span>";
                $categoLayout .= "<span class='img-thumbnail margin-right-xs padd-hori-xs txtCapitalice'>".$climaKitItem."</span>";
                $categoLayout .= "<span class='img-thumbnail margin-right-xs padd-hori-xs'>".$namel2Item."</span>";
                $categoLayout .= "<span class='img-thumbnail padd-hori-xs'>".$namel3Item."</span>";
                $categoLayout .= "</p>";
            }
            
        }
        
        //SOBRE TALLAS
        $tallaLayout = "";//"<div class='row'>";
        $nameGrupoTallaPrendaItem = "";
        $dataGrupoTallaEdit = array();
        if(is_array($dataTL)){
            foreach($dataTL as $tallaKey){
                
                $idgrupoTallaItem = $tallaKey['id_grupo_talla'];
                $idTallaTblItem = $tallaKey['id_talla_tablas'];
                $nameTallaItem = $tallaKey['talla_tipo_prenda']; 
                $nameGrupoTallaPrendaItem = $tallaKey['name_talla_tipo_prenda'];
                $tagGrupoTalla = $tallaKey['genero_talla']; 
                
                $tallaLayout .= "<div class='col-xs-4'>";
                $tallaLayout .= "<span class='img-thumbnail margin-right-xs padd-hori-xs'>".$nameTallaItem."</span>";                
                $tallaLayout .= "</div>";
                
                
                $dataGrupoTallaEdit = grupoTallaItemEdit($nameGrupoTallaPrendaItem, $tagGrupoTalla);
                
            }
            
        }
        //$tallaLayout .= "</div>";
        
        //SOBRE COLORES
        $colorsLayout = "";        
        if(is_array($dataColor)){
            foreach($dataColor as $colorKey){                                 
                $idColorItem = $colorKey['id_color'];
                $nameColorItem = $colorKey['nome_color'];
                $hexaColorItem = $colorKey['color_hexa'];
                                                
                $colorsLayout .="<div class='col-xs-4' >"; 
                $colorsLayout .="<label>";
                $colorsLayout .= "<span  style='position:absolute; right:20px; top:0px; float:right; display:block; width:20px; height:20px; margin: 0; -webkit-box-shadow: 0px 0px 1px 0px rgba(0, 0, 0, 0.35); -moz-box-shadow: 0px 0px 1px 0px rgba(0, 0, 0, 0.35); box-shadow: 0px 0px 1px 0px rgba(0, 0, 0, 0.35); background-color:" .$hexaColorItem .";'>";
                $colorsLayout .= "</span>";                
                $colorsLayout .= $nameColorItem;                                                
                $colorsLayout .="</label>";
                $colorsLayout .="</div>";                                                
                
            }
            
        }
        
        //SOBRE MATERIALES
        $materLayout = "";
        if(is_array($dataMaterial)){
            foreach($dataMaterial as $materKey){                                 
                $idMaterItem = $materKey['id_material'];
                $nameMaterItem = $materKey['nome_material'];
                $valorMaterItem = $materKey['valor_material'];
                
                $materLayout .="<div class='col-xs-4' >"; 
                $materLayout .="<label class='img-thumbnail margin-right-xs padd-hori-xs'>";
                $materLayout .= "<span  style=' margin-left:20px; top:0px; float:right; display:inline-block;'>";
                $materLayout .= $valorMaterItem;
                $materLayout .= "</span>";                
                $materLayout .= $nameMaterItem;                                                
                $materLayout .="</label>";
                $materLayout .="</div>";
                
            }
            
        }
    }
    //PATH FOTO DEFAULT
    $pathFileDefault = $pathmm."img/nopicture.png";
    //PORTADA
    $pathPortada = "../../files-display/tienda/img200/".$fotoItem;

    if (file_exists($pathPortada)) {
    $portadaFile = $pathPortada;
        } else {
    $portadaFile = $pathFileDefault;
    }    
    
}

//echo "<pre>";
//print_r($dataTL);

//***********
//ESPECIFICACIONES ITEM
//***********
//tipo de persona
$generoPrenda = array();
$generoPrenda = forGenero();

//***********
//SITE MAP
//***********

$rootLevel = "tienda";
$sectionLevel = "level";
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
    
    <link rel="stylesheet" href="../appweb/plugins/fileimput/fileimput.css">
    <style>
        .kv-avatar .file-preview-frame,.kv-avatar .file-preview-frame:hover {
            margin: 0 auto;            
            padding: 0;
            border: none;
            box-shadow: none;
                       
        }
        .kv-avatar .file-input {
            display: table;
            max-width: 160px;            
            margin: 0 auto;
            border: 1px dashed #c4c4c4;
            text-align: center;
            padding-bottom: 7px;
        }
        .kv-avatar .file-input .file-preview,
        .kv-avatar .file-input .file-drop-zone{
            border: 0px solid transparent;
            
        }
    </style>
    
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="../appweb/plugins/iCheck/all.css">            
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
            
            <div class="nav navbar-nav navbar-right margin-right-xs">
                <a href="<?php echo $pathmm.$admiDir."/custom/prods/levels/"; ?>" class="btn btn-default" type="button">
                    <i class="fa fa-cog margin-right-xs"></i> Categorías
                </a>
                <a href="<?php echo $pathmm.$admiDir."/custom/prods/features/"; ?>" class="btn btn-default" type="button">
                    <i class="fa fa-cog margin-right-xs"></i> Especificaciones
                </a>                                      
            </div>
            
            <h1>
            <small>Productos </small> / Detalles
            </h1>
            <a href="<?php echo $pathmm.$admiDir."/tienda/"; ?>" class="ch-backbtn">
                <i class="fa fa-arrow-left"></i>
                Lista de productos
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
                                                               
                <div class="row wrapdivsection">
                    <?php
                    /*
                    /*
                    /*PORTADAD LABEL ITEM
                    /*
                    */
                    ?>
                    <div class="col-xs-12 col-sm-4">                         
                        <?php if(!isset($portadaFile)){ ?>
                        <div class="form-group ">
                            <div class="kv-avatar " >
                                <input id="valida-upload" name="fotoprod" type="file" class="fileimg" ><!--class=file-loading -->
                            </div>
                            <div id="kv-avatar-errors-2" class="center-block" style="width:90%; margin:5px auto; display:none"></div>
                            <div id="successupload" class="center-block" style="width:90%; margin:5px auto;"></div>
                        </div>
                        <?php }else{ ?>
                        <div class="form-group " id="wplabelfield">
                            <button type="button" class="btn btn-default pull-right btn-sm editfieldbtn" data-this="labelfield"> 
                                <i class="fa fa-pencil"></i>
                            </button>                            
                            <img src="<?php echo $portadaFile; ?>" class="img-thumbnail img-redounded center-block" style="height:150px;">
                        </div>
                        <div class="form-group wefield" id="welabelfield" >
                            <button type="button" class="btn btn-default pull-right btn-sm canceleditfieldbtn" data-this="labelfield"> 
                                <i class="fa fa-times"></i> Cancelar
                            </button>
                            <div class="kv-avatar " >
                                <input id="valida-upload" name="fotoprod" type="file" class="fileimg" ><!--class=file-loading -->
                            </div>
                            <div id="kv-avatar-errors-2" class="center-block" style="width:90%; margin:5px auto; display:none"></div>
                            <div id="successupload" class="center-block" style="width:90%; margin:5px auto;"></div>
                        </div>
                        <?php } ?>
                    </div>
                    
                    <div class="col-xs-12 col-sm-8 ">
                        <?php
                        /*
                        /*
                        /*NOMBRE PRODUCTO
                        /*
                        */
                        ?>
                        <div id="nameitemform" class="form-group">
                            <input type="text" name="nomeprod" class="form-control" value ="<?php echo $nameItem; ?>" placeholder="Nombre del producto" data-post="<?php echo $itemVarGET; ?>" data-field="nameitemform">
                        </div>
                        <div id="errnameitemform"></div>
                        
                        <?php
                        /*
                        /*
                        /*SKU PRODUCTO
                        /*
                        */
                        ?>
                        <div id="skuitemform" class="form-group">
                            <input type="text" name="codventa" class="form-control" value ="<?php echo $codVentaItem; ?>" placeholder="SKU | ID | Referencia" data-post="<?php echo $itemVarGET; ?>" data-field="skuitemform">
                        </div>
                        <div id="errskuitemform"></div>
                        
                        
                        <?php
                        /*
                        /*
                        /*CATEGORIA PRODUCTO
                        /*
                        */
                        ?>
                        
                        <div class="form-group wefield" id="wpcategofield">
                            <button type="button" class="btn btn-default pull-right btn-sm editfieldbtn" data-this="categofield"> 
                                <i class="fa fa-pencil"></i>
                            </button> 
                            <?php if($categoLayout==""){ ?>
                            <div class="form-group">
                                <div class="alert no-padmarg box25">
                                    <div class="media">
                                        <div class=" media-left">
                                            <i class="fa fa-bell-o fa-3x text-blue"></i>
                                        </div>
                                        <div class="media-body">                                        
                                            <p style="font-size:1.232em;">No se ha definido una categoría para este item</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php }else{ echo $categoLayout; } ?>
                        </div>
                        <div class="form-group wefield" id="wecategofield">
                            <div id="categoitemform">
                                <button type="button" class="btn btn-default pull-right btn-sm canceleditfieldbtn catecancelbtn" data-this="categofield"> 
                                    <i class="fa fa-times"></i> Cancelar
                                </button>
                                <select class="form-control " name="categoitem" data-post="<?php echo $itemVarGET; ?>" data-field="categoitemform">
                                    <option value="" selected>Selecciona una categoría</option>                                    
                                <?php 
                                $printLevelList = array();
                                $printLevelList = getLevelsList();

                                $prevVarGender = "";
                                $prevVarItemKit = "";
                                $prevVarItemCat = "";
                                $prevVarItemSub = "";

                                $lyBrowseCat = ""; 

                                if(is_array($printLevelList)){
                                    foreach($printLevelList as $pllKey){
                                        $nameL1CataList = $pllKey['nome_depart_prod'];
                                        $idL1CataList = $pllKey['id_depart_prod'];
                                        $tagL1CataList = $pllKey['tags_depatament_produsts']; //H - M
                                        $idL2CataList = $pllKey['id_catego_product'];
                                        $nameL2CataList = $pllKey['nome_catego_product'];// FORMAL - SPORT - CLASICO
                                        //$nameCataList = $pllKey['descri_catego_prod'];
                                        $kitCataList = $pllKey['tipo_kit_4user']; //CALIDO FRIO                    
                                        $idL3CataList = $pllKey['id_subcatego_producto'];
                                        $nameL3CataList = $pllKey['nome_subcatego_producto']; // NOMBRE PRENDA




                                        /*//======IMPRIME LAYOUT ITEM KIT
                                        if($prevVarItemCat != $idL2CataList){
                                            if($prevVarItemCat != ""){
                                                $lyBrowseCat .= "</optgroup>";//////CIERRA ITEM KIT DOTACION
                                                //$lyBrowseCat .= "</ul>";////CIERRA wrap KIT DOTACION   

                                            } */                                                                                                                  

                                            //======IMPRIME LAYOUT ITEM PACK DOTACION
                                            if($prevVarItemKit != $kitCataList){

                                                if($prevVarItemKit != ""){
                                                    $lyBrowseCat .= "</optgroup>";//CIERRA ITEM PACK DOTACION
                                                    //$lyBrowseCat .= "</ul>";//CIERRA wrap PACK DOTACION
                                                }//CIERRA ITEM PACK DOTACION


                                                //======IMPRIME LAYOUT MASCULINO FEMENINO
                                                if($prevVarGender != $tagL1CataList){

                                                    if($prevVarGender != ""){
                                                        $lyBrowseCat .= "</optgroup>";//CIERRA L1
                                                       // $lyBrowseCat .= "</ul>";//CIERRA wrap DEPTO
                                                    }//CIERRA ITEM L1 DOTACION    

                                                     //======IMPRIME ITEM PACK
                                                    $lyBrowseCat .= "<optgroup class='txtUppercase text-blue' label='".$tagL1CataList."'>";//ITEM L1
                                                    //$lyBrowseCat .= "<a href='#'><strong class='titupackdot'>".$nameItemDpto."</strong></a>";
                                                   // $lyBrowseCat .= "<ul class='treeview-menu'>";////wrap PACK DPTO     

                                                    $prevVarGender = $tagL1CataList;

                                                }

                                                //======FIN IMPRIME LAYOUT MASCULINO FEMENINO


                                                //======IMPRIME ITEM KIT
                                                $lyBrowseCat .= "<optgroup class='txtCapitalice' label='".$kitCataList."'>";//ITEM PACK DOTACION             
                                                //$lyBrowseCat .= "<a href='#'><strong class='titupackdot'>Kit ".$nameItemKit."</strong></a>";
                                                //$lyBrowseCat .= "<ul class='treeview-menu'>";////wrap KIT DOTACION          

                                                $prevVarItemKit = $kitCataList;
                                            }

                                            /*//======IMPRIME ITEM KIT
                                            $lyBrowseCat .= "<optgroup class='txtCapitalice' label='".$nameL2CataList."'>";//////ITEM KIT DOTACION ////////WRAP ITEM PRENDA

                                            $prevVarItemCat = $idL2CataList;
                                        }//CIERRA ITEM ITEM KIT*/

                                        //======IMPRIME LAYOUT ITEM PRENDA
                                        $lyBrowseCat .= "<option value='".$idL3CataList."' class='txtCapitalice categooption' datalcat='".$idL2CataList."' data-tagl1='".$tagL1CataList."'>".$nameL3CataList."&nbsp;&nbsp;(".$kitCataList."-".$nameL2CataList.")</option>";////////ITEM PRENDA

                                    }    
                                }

                                //$lyBrowseCat .= "</ul>";////////WRAP ITEM PRENDA
                                $lyBrowseCat .= "</optgroup>";//////CIERRA ITEM KIT DOTACION                
                                //$lyBrowseCat .= "</ul>";////wrap KIT DOTACION 
                                $lyBrowseCat .= "</optgroup>";//////CIERRA ITEM DEPTO                
                                //$lyBrowseCat .= "</ul>";////wrap KIT DEPTO
                                $lyBrowseCat .= "</optgroup>";//ITEM PACK DOTACION
                                echo $lyBrowseCat;

                                ?>
                                </select>
                            </div>
                            <div id="errcategoitemform"></div>
                        </div>
                                             
                    </div>  
                    <hr class="linesection"/>
                </div>
                                
                <?php
                /*
                /*
                /*PRECIO PRODUCTO
                /*
                */
                ?>
                <div class="row wrapdivsection">
                    <div class="col-xs-12 col-sm-4">
                        <h4>Precio</h4>
                        <p class="help-block">Define un valor de venta para este item</p>
                    </div>                                           
                    <div class="col-xs-12 col-sm-8">
                        <div class="form-group">
                            <div class="input-group" id="priceitemform">                                            
                                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                <input type="text" name="precioprod" class="form-control" value ="<?php echo $priceItem; ?>" placeholder="Escribe el número sin simbolos, puntos ni decimales" data-post="<?php echo $itemVarGET; ?>" data-field="priceitemform">
                            </div>                            
                        </div>
                        <div id="errpriceitemform"></div>
                    </div>      
                    <hr class="linesection"/>
                </div>
                                
                <?php
                /*
                /*
                /*PESPECIFICACIONES
                /*
                */
                ?>
                <div class="row wrapdivsection">
                    <div class="col-xs-12 col-sm-4">
                        <h4>Especificaciones</h4>
                        <p class="help-block">Escoje las tallas, colores y materiales para este item</p>
                    </div>                                           
                    <div class="col-xs-12 col-sm-8">
                        <div class="wrapdivsection">
                            <?php
                            /*
                            /*
                            /*TALLAS
                            /*
                            */
                            ?>                        
                            
                            <div class="form-group wefield" id="wptallafield" ><!--/tallas definidas--->
                                <div class="box100 padd-verti-xs padd-hori-xs bg-gray img-rounded">
                                    <button type="button" class="btn btn-default pull-right btn-sm editfieldbtn" data-this="tallafield" style="margin-top:-5px;"> 
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <?php echo "<strong>Grupo de tallas  -  Tamaños</strong>"; ?>
                                </div>
                                <div class="row margin-top-xs">
                                <?php if($tallaLayout==""){ ?>
                                    <div class="form-group">
                                        <div class="alert no-padmarg box25">
                                            <div class="media">
                                                <div class=" media-left">
                                                    <i class="fa fa-bell-o fa-3x text-blue"></i>
                                                </div>
                                                <div class="media-body">                                        
                                                    <p style="font-size:1.232em;">No se ha definido tallas para este item</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }else{ echo $tallaLayout; }  ?>
                                
                                </div>
                            </div><!--/tallas definidas--->

                            <div class="form-group wefield" id="wetallafield"><!--/wrap edit tallas--->
                                <div class="box100 padd-verti-xs padd-hori-xs bg-gray img-rounded">
                                    <button type="button" class="btn btn-default pull-right btn-sm canceleditfieldbtn " data-this="tallafield" id="canceltallaeditbtn" style="margin-top:-5px;"> 
                                        <i class="fa fa-times"></i> Cancelar
                                    </button>
                                    <?php echo "<strong>Grupo de tallas&nbsp;" .$nameGrupoTallaPrendaItem."</strong>"; ?>
                                </div>

                                <?php
                                /*
                                /*
                                /*TIPO DE COLECCION- GRUPO DE TALLAS - TALLAS
                                /*
                                */
                                ?>
                                <?php 
                                    $optionList = "";
                                    $prevGrupo = "";
                                    $prevHM = "";
                                    if(is_array($dataGrupoTallaEdit) && count($dataGrupoTallaEdit) > 0){   
                                ?>
                                <div id="tallaitemform" class="form-group  margin-top-xs"><!---///tallas--->   
                                    <?php                                                                                                             
                                    
                                        foreach($dataGrupoTallaEdit as $etpKey){
                                            $idGrupoTalla = $etpKey['id_grupo_talla'];
                                            $idTallaTablas = $etpKey['id_talla_tablas'];
                                            $nameGrupoTalla = $etpKey['talla_tipo_prenda'];
                                            $tipoPrendaGrupoTalla = $etpKey['name_talla_tipo_prenda'];   
                                            $tagGrupoTalla = $etpKey['genero_talla'];
                                            $dataTallaItem = $tagGrupoTalla."_".$tipoPrendaGrupoTalla;

                                            if($prevGrupo != $tipoPrendaGrupoTalla){
                                                if($prevGrupo != ""){
                                                    $optionList .="</div>";
                                                    //$optionList .="</div>";
                                                }

                                                if($prevHM != $tagGrupoTalla){
                                                    if($prevHM != ""){
                                                        $optionList .="</div>";
                                                        //$optionList .="</div>";
                                                    }

                                                    $optionList .="<div id='wt".$tagGrupoTalla."'>";
                                                    $prevHM = $tagGrupoTalla;
                                                }                                                                                                                                   
                                                //$optionList .="<div id='wti".$dataTallaItem."' class='row tallaitem' datatallaitem='".$dataTallaItem."'>";
                                                $optionList .="<div class='row no-padmarg' >";

                                                $prevGrupo = $tipoPrendaGrupoTalla;

                                            }

                                            //TALLAS CHECK
                                            $actiTalla = "";
                                            if(is_array($dataTLCheck)){
                                                foreach($dataTLCheck as $dtcKey){
                                                    $idTallaCheck = $dtcKey['id_talla_tablas'];

                                                    if($idTallaTablas === $idTallaCheck)
                                                        $actiTalla =  "checked";                                                    
                                                }
                                            }

                                            $optionList .="<div class='col-xs-4' >"; //datatallaitem='".$dataTallaItem."' 
                                            $optionList .="<label>";
                                            $optionList .="<input type='checkbox' name='tallaslist[]' class='flat-red tallaslist' value='" .$idTallaTablas ."' data-gt='".$idGrupoTalla."' ".$actiTalla." data-post='".$itemVarGET."' data-field='tallaitemform' />&nbsp;&nbsp;";   
                                            $optionList .= $nameGrupoTalla; 
                                            $optionList .="</label>";
                                            $optionList .="</div>";                                                                        
                                        }
                                        
                                        $optionList .="</div>";
                                        $optionList .="</div>";
                                        echo $optionList;                                                                     

                                    ?>
                                    <hr>
                                    <div class="text-right">
                                        <button type="button" class="btn btn-info" id="savetallasedit">
                                            <i class="fa fa-save margin-right-xs"></i>
                                            Guardar tallas
                                        </button>
                                    </div>
                                </div><!--/tallaitemform-->
                                
                                <?php }else{ ?>
                                
                                <div id="tallaitemform" class="form-group  margin-top-xs"><!---///WRAP NEW tallas--->   
                                    <div class="form-group"><!---/ropa para--->
                                    <?php

                                    $lyoutGenero = "<select name='nomeprod' class='form-control generopz'>"; 
                                    $lyoutGenero .= "<option value='0' select>Escoje una colección</option>";
                                    if(is_array($generoPrenda)){
                                        foreach($generoPrenda as $gpKey){
                                            $idL1Item = $gpKey['id_depart_prod'];
                                            $nameL1Item = $gpKey['nome_depart_prod'];
                                            $tagL1Item = $gpKey['nome_clean_depa_prod'];


                                            $lyoutGenero .= "<option value='".$tagL1Item."'>";
                                            $lyoutGenero .= $nameL1Item;
                                            $lyoutGenero .= "</option>";


                                        }
                                    }
                                    $lyoutGenero .= "</select>"; 
                                    echo $lyoutGenero;
                                    ?> 
                                    </div><!--/ropa para--->
                                    <div class="form-group">
                                        <select name="grupotallalist" class="grupotallalist form-control"></select>
                                    </div>
                                    <div class="form-group"><!---///tallas--->   
                                    <?php 
                                    $ettp = array();
                                    $ettp = ettpQ();     

                                    $optionList = "";
                                    $prevGrupo = "";
                                    $prevHM = "";
                                    if(is_array($ettp)){
                                        foreach($ettp as $etpKey){
                                            $idGrupoTalla = $etpKey['id_grupo_talla'];
                                            $idTallaTablas = $etpKey['id_talla_tablas'];
                                            $nameGrupoTalla = $etpKey['talla_tipo_prenda'];
                                            $tipoPrendaGrupoTalla = $etpKey['name_talla_tipo_prenda'];   
                                            $tagGrupoTalla = $etpKey['genero_talla'];
                                            $dataTallaItem = $tagGrupoTalla."_".$tipoPrendaGrupoTalla;


                                            if($prevGrupo != $tipoPrendaGrupoTalla){
                                                if($prevGrupo != ""){
                                                    $optionList .="</div>";
                                                    //$optionList .="</div>";
                                                }

                                                if($prevHM != $tagGrupoTalla){
                                                    if($prevHM != ""){
                                                        $optionList .="</div>";
                                                        //$optionList .="</div>";
                                                    }

                                                    $optionList .="<div id='wt".$tagGrupoTalla."'>";
                                                    $prevHM = $tagGrupoTalla;
                                                }                                                                                                                                   
                                                $optionList .="<div id='wti".$dataTallaItem."' class='row no-padmarg tallaitemnew' datatallaitem='".$dataTallaItem."'>";
                                                $optionList .="<h4 class='txtCapitalice'>".$tipoPrendaGrupoTalla."</h4>";

                                                $prevGrupo = $tipoPrendaGrupoTalla;

                                            }

                                            $optionList .="<div class='col-xs-4' >"; 
                                            $optionList .="<label>";
                                            $optionList .="<input type='checkbox' name='tallaslist[]' class='flat-red tallaslist ' value='" .$idTallaTablas ."' data-gt='".$idGrupoTalla."' data-post='".$itemVarGET."' data-field='tallaitemform'/>&nbsp;&nbsp;";
                                            $optionList .= $nameGrupoTalla;
                                            $optionList .="</label>";
                                            $optionList .="</div>";                                                                        
                                        }

                                        $optionList .="</div>";
                                        $optionList .="</div>";
                                        echo $optionList;

                                    }
                                        
                                    ?>
                                    <hr>
                                    <div class="text-right" id="savenewtalla">
                                        <button type="button" class="btn btn-info" id="savetallasedit">
                                            <i class="fa fa-save margin-right-xs"></i>
                                            Guardar tallas
                                        </button>
                                    </div>
                                    </div><!---///tallas--->    
                                    
                                    
                                </div><!--/tallaitemform  |   WRAPP NEW TALLA -->
                                <?php } ?>
                                <div id="errtallaitemform"></div>

                            </div><!---///wrap edit tallas--->   
                            
                                                                                                                                            
                        </div><!---/wrapdivsection--->
                        
                        
                        
                        <div class="wrapdivsection">
                            <?php
                            /*
                            /*
                            /*COLORES
                            /*
                            */
                            ?>                        
                            
                            <div class="form-group wefield" id="wpcolorsfield" ><!--/colores definidas--->
                                <div class="box100 padd-verti-xs padd-hori-xs bg-gray img-rounded">
                                    <button type="button" class="btn btn-default pull-right btn-sm editfieldbtn" data-this="colorsfield" style="margin-top:-5px;"> 
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <?php echo "<strong>Colores</strong>"; ?>
                                </div>
                                <div class="row margin-top-xs">
                                <?php if($colorsLayout==""){ ?>
                                    <div class="form-group">
                                        <div class="alert no-padmarg box25">
                                            <div class="media">
                                                <div class=" media-left">
                                                    <i class="fa fa-bell-o fa-3x text-blue"></i>
                                                </div>
                                                <div class="media-body">                                        
                                                    <p style="font-size:1.232em;">No se ha definido colores para este item</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }else{ echo $colorsLayout; } ?>                                
                                </div>
                            </div><!--/colores definidas--->

                            <div class="form-group wefield" id="wecolorsfield"><!--/wrap colores edit--->
                                <div class="box100 padd-verti-xs padd-hori-xs bg-gray img-rounded">
                                    <button type="button" class="btn btn-default pull-right btn-sm canceleditfieldbtn " data-this="colorsfield" id="cancelcolorseditbtn" style="margin-top:-5px;"> 
                                        <i class="fa fa-times"></i> Cancelar
                                    </button>
                                    <?php echo "<strong>Colores</strong>"; ?>
                                </div>

                                <?php
                                /*
                                /*
                                /*COLORES EDIT
                                /*
                                */
                                ?>
                                <div id="colorsitemform" class="form-group margin-top-xs">  
                                    <?php                                                                                                             
                                    $colorList = array();
                                    $colorList = colorFeature();

                                    $colorListLayout="";
                                    $colorListLayout .="<div class='row no-padmarg' >";
                                    if(is_array($colorList) && count($colorList)>0){
                                        foreach($colorList as $clKey){
                                            $idColor = $clKey['id_color'];
                                            $nameColor = $clKey['nome_color'];
                                            $hexaColor = $clKey['color_hexa'];
                                            
                                            //COLORES CHECK
                                            $actiColor = "";
                                            if(is_array($dataColorCheck)){
                                                foreach($dataColorCheck as $dccKey){
                                                    $idColorCheck = $dccKey['id_color'];

                                                    if($idColor === $idColorCheck)
                                                        $actiColor =  "checked";                                                    
                                                }
                                            }

                                            $colorListLayout .="<div class='col-xs-4' >"; 
                                            $colorListLayout .="<label>";
                                            $colorListLayout .= "<span  style='position:absolute; right:20px; top:0px; float:right; display:block; width:20px; height:20px; margin: 0; -webkit-box-shadow: 0px 0px 1px 0px rgba(0, 0, 0, 0.35); -moz-box-shadow: 0px 0px 1px 0px rgba(0, 0, 0, 0.35); box-shadow: 0px 0px 1px 0px rgba(0, 0, 0, 0.35); background-color:" .$hexaColor .";'>";
                                            $colorListLayout .= "</span>";
                                            $colorListLayout .="<input type='checkbox' name='tipocolor[]' class='flat-red tipocolor' value='" .$idColor ."' ".$actiColor." data-post='".$itemVarGET."' data-field='colorsitemform'/>&nbsp;&nbsp;";
                                            $colorListLayout .= $nameColor;                                                
                                            $colorListLayout .="</label>";
                                            $colorListLayout .="</div>";

                                        }                                                                                
                                    }
                                    $colorListLayout .="</div>";
                                    echo $colorListLayout;
                                    

                                    ?>
                                    <hr>
                                    <div class="text-right">
                                        <button type="button" class="btn btn-info" id="savecoloredit">
                                            <i class="fa fa-save margin-right-xs"></i>
                                            Guardar colores
                                        </button>
                                    </div>
                                </div><!--/colorsitemform-->
                                <div id="errcolorsitemform"></div>

                            </div><!--/wrap colores edit--->                
                           
                            
                        </div><!---/wrapdivsection--->
                        
                        
                        
                        <div class="wrapdivsection">
                            <?php
                            /*
                            /*
                            /*MATERIALES
                            /*
                            */
                            ?>                         
                            <div class="form-group wefield" id="wpmatersfield" ><!--/materiales definidas--->
                                <div class="box100 padd-verti-xs padd-hori-xs bg-gray img-rounded">
                                    <button type="button" class="btn btn-default pull-right btn-sm editfieldbtn" data-this="matersfield" style="margin-top:-5px;"> 
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                    <?php echo "<strong>Materiales</strong>"; ?>
                                </div>
                                <div class="row margin-top-xs">                                 
                                <?php if($materLayout==""){ ?>
                                <div class="form-group">
                                    <div class="alert no-padmarg box25">
                                        <div class="media">
                                            <div class=" media-left">
                                                <i class="fa fa-bell-o fa-3x text-blue"></i>
                                            </div>
                                            <div class="media-body">                                        
                                                <p style="font-size:1.232em;">No se han definido materiales para este item</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                        
                                <?php }else{ echo $materLayout; } ?>
                                </div>
                            </div><!--/materiales definidas--->

                            <div class="form-group wefield" id="wematersfield"><!--/wrap materiales edit--->
                                <div class="box100 padd-verti-xs padd-hori-xs bg-gray img-rounded">
                                    <button type="button" class="btn btn-default pull-right btn-sm canceleditfieldbtn " data-this="matersfield" id="cancelmaterseditbtn" style="margin-top:-5px;"> 
                                        <i class="fa fa-times"></i> Cancelar
                                    </button>
                                    <?php echo "<strong>Materiales</strong>"; ?>
                                </div>

                                <?php
                                /*
                                /*
                                /*MATERIALES EDIT
                                /*
                                */
                                ?>
                                <div id="matersitemform" class="form-group margin-top-xs">  
                                    <?php                                                                                                             
                                    $materialList = array();
                                    $materialList = materialFeature();

                                    $materialListLayout="";
                                    $materialListLayout .="<div class='row no-padmarg' >";
                                    if(is_array($materialList) && count($materialList) > 0){
                                        foreach($materialList as $mlKey){
                                            $idMaterial = $mlKey['id_material'];
                                            $nameMaterial = $mlKey['nome_material'];
                                            $valoraMaterial = empty($mlKey['valor_material'])? "": "&#40;&nbsp;".$mlKey['valor_material'] ."&#41;&nbsp;" ;
                                            
                                            
                                            
                                            //MATERIALES CHECK
                                            $actiMater = "";
                                            if(is_array($dataMaterialCheck)){
                                                foreach($dataMaterialCheck as $dmiKey){
                                                    $idMaterCheck = $dmiKey['id_material'];

                                                    if($idMaterial === $idMaterCheck)
                                                        $actiMater = "checked";                                                    
                                                }
                                            }

                                            $materialListLayout .="<div class='col-xs-4' >"; 
                                            $materialListLayout .="<label>";
                                            $materialListLayout .= "<span  style='position:absolute; right:20px; top:0px; float:right; display:block;'>";
                                            $materialListLayout .= $valoraMaterial;
                                            $materialListLayout .= "</span>";
                                            $materialListLayout .="<input type='checkbox' name='tipomaterial[]' class='flat-red tipomaterial' value='" .$idMaterial ."' data-post='".$itemVarGET."' data-field='matersitemform' ".$actiMater."/>&nbsp;&nbsp;";
                                            $materialListLayout .= $nameMaterial;                                                
                                            $materialListLayout .="</label>";
                                            $materialListLayout .="</div>";

                                        }
                                        
                                    }
                                    $materialListLayout .="</div>";
                                    echo $materialListLayout;
                                    

                                    ?>
                                    <hr>
                                    <div class="text-right">
                                        <button type="button" class="btn btn-info" id="savematerialedit">
                                            <i class="fa fa-save margin-right-xs"></i>
                                            Guardar materiales
                                        </button>
                                    </div>
                                </div><!--/matersitemform-->
                                <div id="errmatersitemform"></div>

                            </div><!--/wrap materiales edit--->                
                                                      
                        </div><!---/wrapdivsection--->
                    </div>
                    <hr class="linesection"/>
                </div>                                                                                
                <div class="row wrapdivsection">
                    <div class="col-xs-12 col-sm-4">
                        <h4>Descripción</h4>
                        <p class="help-block"></p>
                    </div>
                    <div class="col-xs-12 col-sm-8">
                        <div id="descriitemform"  class="form-group">
                            <textarea id="descri-prod" name="descriprod" class="form-control" placeholder="Características, detalles, beneficios," style="width: 100%; height: 240px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" data-post="<?php echo $itemVarGET; ?>" data-field="descriitemform"><?php echo $descriItem; ?></textarea>
                        </div>
                        <div id="errdescriitemform"></div>
                    </div>
                    <hr class="linesection"/>
                </div>
                <div class="row wrapdivsection">
                    <div class="col-xs-12 col-sm-4">
                        <h4>Status</h4>
                        <p class="help-block">Por defecto se guarda en estado de REVISIÓN, es decir, será creada como un <b>Borrador</b>, no se mostrará en el catálogo hasta que decidas que hacer con ella</p>
                    </div>
                    <div class="col-xs-12 col-sm-8">
                        <div id="statusitemform" class="form-group">
                            <select class="form-control " name="categoitem" data-post="<?php echo $itemVarGET; ?>" data-field="statusitemform">
                                    <option value="" selected>Selecciona una opcion</option> 
                        <?php 
                        /*$statusLayaout = "";
                        
                        $db->where ('id_estado_contrato', '3', '!=');
                        $db->where ('id_estado_contrato', '4', '!=');
                        $db->where ('id_estado_contrato', '6', '!=');
                        $db->orderBy("nome_estado_contrato","Asc");			
                        $statusQuedy = $db->get('estado_contrato');                        
                        if(is_array($statusQuedy)) {
                            foreach($statusQuedy as $sqKey){
                                $idStatusTbl = $sqKey['id_estado_contrato'];
                                $nameStatusTbl = $sqKey['nome_estado_contrato'];                                
                                
                                $actiStatus = "";
                                if($idStatusTbl === $statusItem)
                                    $actiStatus = "checked";
                                
                                $statusLayaout .= "<p>";
                                $statusLayaout .= "<label>";
                                $statusLayaout .= "<input type='radio' name='statusprod[]' value='".$idStatusTbl."' class='flat-red statusprod' data-post='".$itemVarGET."' data-field='statusitemform' ".$actiStatus."> ";
                                //$statusLayaout .= "<span class=' margin-left-md'>".$nameStatusTbl."</span>";
                                $statusLayaout .= $nameStatusTbl;
                                $statusLayaout .= "</label>";
                                $statusLayaout .= "</p>";                                                                
                            }                                                    
                        }   
                        echo $statusLayaout; */
    
    
                        $statusLayaout = "";
                        
                        $db->where ('id_estado_contrato', '3', '!=');
                        $db->where ('id_estado_contrato', '4', '!=');
                        $db->where ('id_estado_contrato', '6', '!=');
                        $db->orderBy("nome_estado_contrato","Asc");			
                        $statusQuedy = $db->get('estado_contrato');                        
                        if(is_array($statusQuedy)) {
                            foreach($statusQuedy as $sqKey){
                                $idStatusTbl = $sqKey['id_estado_contrato'];
                                $nameStatusTbl = $sqKey['nome_estado_contrato'];                                
                                
                                $actiStatus = "";
                                if($idStatusTbl === $statusItem)
                                    $actiStatus = "selected";
                                
                                //$statusLayaout .= "<p>";
                                //$statusLayaout .= "<label>";
                                $statusLayaout .= "<option value='".$idStatusTbl."' class='flat-red statusprod' ".$actiStatus."> ";
                                //$statusLayaout .= "<span class=' margin-left-md'>".$nameStatusTbl."</span>";
                                $statusLayaout .= $nameStatusTbl;
                                $statusLayaout .= "</option>";
                                //$statusLayaout .= "</p>";                                                                
                            }                                                    
                        }   
                        echo $statusLayaout;
                        
                        ?>                                                               
                        </div>  
                        <div id="errstatusitemform"></div>
                    </div>
                    <hr class="linesection"/>
                </div>

                <div class="row wrapdivsection">                        
                    <input name="newprod" type="hidden" value="ok">
                    <input type="hidden" name="codeitemform" id="codeitemform" value="<?php echo $itemVarGET; ?>">
                    <input type="hidden" name="labelitemform" id="labelitemform" value="<?php echo $fotoItem; ?>">
                    
                </div>
                            
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
                <div id="left-barbtn" class="nav navbar-nav margin-left-md padd-verti-xs">
                    <a href="<?php echo $pathmm.$admiDir."/tienda/"; ?>" type="button" class="btn btn-default">
                        <i class='fa fa-th-list fa-lg'></i>
                        <span>lista de productos</span>                        
                    </a> 
                    
                    <a href="<?php echo $pathmm.$admiDir."/tienda/new.php"; ?>" type="button" class="btn btn-info ">
                        <i class='fa fa-plus fa-lg'></i>
                        <span>Nuevo producto</span>                     
                    </a>
                </div>
                <div id="right-bartbtn" class="nav navbar-nav navbar-right margin-right-md padd-verti-xs">                    
                    <a href="<?php echo $pathmm.$admiDir."/tienda/item-edit.php?trash=ok&coditemget=".$itemVarGET; ?>" class="btn btn-default trashtobtn" name="" title="Eliminar item" data-msj="Perderás toda la información para este producto. Deseas continuar?" data-remsj="">
                        <i class='fa fa-trash fa-lg'></i>
                        <span>Eliminar</span>                        
                    </a>                                                                                                       
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
                            <a href="<?php echo $pathmm.$admiDir."/tienda/"; ?>" type="button" class="btn btn-default">
                                <i class='fa fa-th-list fa-lg'></i>
                                <span>lista de productos</span>                        
                            </a> 
                        </div>
                    
                        <div class="btn-group text-center">                            
                            <a href="<?php echo $pathmm.$admiDir."/tienda/new.php"; ?>" type="button" class="btn btn-info ">
                                <i class='fa fa-plus fa-lg'></i>
                                <span>Nuevo producto</span>                     
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
<script type="text/javascript" src="edit-item-functions.js"></script>    

<!-- InputMask -->
<script src="../appweb/plugins/input-mask/jquery.inputmask.js"></script>
<script src="../appweb/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="../appweb/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- iCheck 1.0.1 -->
<script src="../appweb/plugins/iCheck/icheck.min.js"></script>
    
<script src="../appweb/plugins/fileimput/fileinput.js" type="text/javascript"></script>        
<script src="../appweb/plugins/fileimput/themes/fa/theme.js"></script>    
<script src="../appweb/plugins/fileimput/locales/es.js"></script> 
<script type="text/javascript">
$(document).ready(function() {   
    /*var editlabel = $("#editlabel").hide();
    var wraplabel = $("#wraplabel").show();    
    
    $("#editlabelbtn").click(function(){
        wraplabel.hide();
        editlabel.show();        
    });
    
    $("#canceleditlabelbtn").click(function(){
        wraplabel.show();
        editlabel.hide();        
    });*/
    
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
    
                        
    $inputSingleImg = $(".fileimg");
    $inputSingleImg.fileinput({        
        theme: "fa",
        language: 'es',
        fileTypeSettings: 'image',        
        maxFileSize: 1700,
        maxImageWidth: 1600,
        maxImageHeight: 1600,            
        maxFilesNum: 1,        
        //overwriteInitial: true,   
        showUpload: false, // hide upload button
        showRemove: false, // hide remove button
        showClose: false,
        showCaption: false,
        showBrowse: false,
        browseOnZoneClick: true,
        removeLabel: '',        
        removeTitle: 'Cancel or reset changes',
        elErrorContainer: '#kv-avatar-errors-2',
        msgErrorClass: 'alert alert-block alert-danger',
        defaultPreviewContent: '<img src="../../img/camera-icon.png" style="width:80px; margin-bottom:4px;">',        
        allowedFileExtensions: ["jpg", "png", "png"],                                 
        uploadAsync: false,
        uploadUrl: "../appweb/inc/upload-imgfile.php",
        uploadExtraData: function() {
            return {
                codeitem: $("#codeitemform").val(),                
                nameportadaitem: $("#labelitemform").val()                
            };
        }
    }).on("filebatchselected", function(event, files) {        
        $inputSingleImg.fileinput("upload");
    });
    
    /*$(".fileimg").on('filebatchuploadsuccess', function(event, data, previewId, index) {
        var form = data.form, files = data.files, extra = data.extra,
            response = data.response, reader = data.reader;
        //console.log(response);
        $("#successupload").html(response);
    });*/
    
    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });
    
    //CARGA SELECTS
    
    $(".generopz").change(function(){
        var id=$(this).val();
        var dataString = 'idgpz='+ id+'&fieldq=gpz';
        //alert(dataString);
        $.ajax({
            type: "POST",
            url: "../appweb/inc/query-selects.php",
            data: dataString,
            cache: false,
            success: function(html){
                $(".grupotallalist").html(html);                
            } 
        });
    });
    $(".tallaitemnew").hide();
    $("#savenewtalla").hide(); 
    
    $(".grupotallalist").change(function(){        
        var id=$(this).val();
        
        $('.tallaitemnew').each(function(k,v1) { 
            var tallaitem = $(v1).attr("datatallaitem");
            
            if(id === tallaitem){                
                $('.tallaitemnew').fadeOut(function(){
                    $("#wti"+tallaitem).show();    
                    $("#savenewtalla").show();    
                    
                });
                    
            }                       
         });
                
    });    
});                                    
</script>     
</body>
</html>
