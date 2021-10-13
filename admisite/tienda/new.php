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

        $pordDataIns = array(    
            'fecha_publicacion_promo' => $dateFormatDB,
            'hora_publi' => $horaFormatDB,       
            'datetime_publi' => $timeStamp
        );
        $newProdIns = $db->insert ('productos', $pordDataIns);
        if(!$newProdIns){ 
            $erroQuery = $db->getLastError(); 
        }else{ 
            $_SESSION['newitem'] = $newProdIns; // echo "ultimo producto ".$newProdIns;
            $codeNewProd = $_SESSION['newitem'];
        }

    }
    
}


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
    <!-- Select2 -->
    <link rel="stylesheet" href="../appweb/plugins/select2/select2.min.css">
    
    
    
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
            <small>Productos</small> / Crear Item
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
                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group ">
                            <div class="kv-avatar " style="width:100px">
                                <input id="valida-upload" name="fotoprod" type="file" class="fileimg" ><!--class=file-loading -->
                            </div>
                            <div id="kv-avatar-errors-2" class="center-block" style="width:90%; margin:5px auto; display:none"></div>
                            <div id="successupload" class="center-block" style="width:90%; margin:5px auto;"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-8 ">
                        <div class="form-group">
                            <input type="text" name="nomeprod" class="form-control" value ="" placeholder="Nombre del producto">
                        </div>
                        <div class="form-group">
                            <input type="text" name="codventa" class="form-control" value ="" placeholder="SKU | ID | Referencia">
                        </div>
                        <div class="form-group">
                            <select class="form-control " name="categoitem">
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
                                    $lyBrowseCat .= "<option value='".$idL3CataList."' class='txtCapitalice categooption' data-l2='".$idL2CataList."' data-tagl1='".$tagL1CataList."'>".$nameL3CataList."&nbsp;&nbsp;(".$kitCataList."-".$nameL2CataList.")</option>";////////ITEM PRENDA

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
                    </div>  
                    <hr class="linesection"/>
                </div>

                <div class="row wrapdivsection">
                    <div class="col-xs-12 col-sm-4">
                        <h4>Precio</h4>
                        <p class="help-block">Define un valor de venta para este item</p>
                    </div>                                           
                    <div class="col-xs-12 col-sm-8">
                        <div class="form-group">
                            <div class="input-group">                                            
                                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                <input type="text" name="precioprod" class="form-control" value ="" placeholder="Escribe el número sin simbolos, puntos ni decimales">
                            </div>
                        </div>
                    </div>      
                    <hr class="linesection"/>
                </div>

                <div class="row wrapdivsection">
                    <div class="col-xs-12 col-sm-4">
                        <h4>Especificaciones</h4>
                        <p class="help-block">Escoje las tallas, colores y materiales para este item</p>
                    </div>                                           
                    <div class="col-xs-12 col-sm-8">
                        <div class="form-group"><!--/ropa para--->
                        <?php

                        $lyoutGenero = "<select name='nomeprod' class='form-control generopz'>"; 
                        $lyoutGenero .= "<option value='0' select>Escoje una colección</option>";
                        if(is_array($generoPrenda)){
                            foreach($generoPrenda as $gpKey){
                                $idL1Item = $gpKey['id_depart_prod'];
                                $nameL1Item = $gpKey['nome_depart_prod'];
                                $tagL1Item = $gpKey['nome_clean_depa_prod'];


                                /*$lyoutGenero = "<div class='col-xs-6'>";                                
                                $lyoutGenero .= "<div class='form-group' >";
                                $lyoutGenero .= "<label>";
                                $lyoutGenero .= "<input type='radio' name='generopz' class='generopz flat-red' value='" .$tagL1Item ."'/>&nbsp;&nbsp;&nbsp;&nbsp;";
                                $lyoutGenero .= $nameL1Item;
                                $lyoutGenero .= "</label>";
                                $lyoutGenero .= "</div>";
                                $lyoutGenero .= "</div>";*/
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
                        <div class="form-group margin-bottom-xs"><!---///tallas--->   
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
                                        $optionList .="<div id='wti".$dataTallaItem."' class='row tallaitem' datatallaitem='".$dataTallaItem."'>";
                                        $optionList .="<h4 class='txtCapitalice'>".$tipoPrendaGrupoTalla."</h4>";

                                        $prevGrupo = $tipoPrendaGrupoTalla;

                                    }

                                    $optionList .="<div class='col-xs-4' >"; //datatallaitem='".$dataTallaItem."' 
                                    $optionList .="<label>";
                                    $optionList .="<input type='checkbox' name='tallaslist[]' class='flat-red tallaslist' value='" .$idTallaTablas ."' data-gt='".$idGrupoTalla."'/>&nbsp;&nbsp;";
                                    $optionList .= $nameGrupoTalla;
                                    $optionList .="</label>";
                                    $optionList .="</div>";                                                                        
                                }
                                
                                $optionList .="</div>";
	                            $optionList .="</div>";
	                            echo $optionList;

                            }

                        ?>
                        </div><!---///tallas--->                                
                        <div class="form-group"><!---colores - materiales--->
                            <!-- Custom Tabs -->
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#color_tab" data-toggle="tab">Colores</a></li>
                                    <li><a href="#material_tab" data-toggle="tab">Materiales</a></li>                                      
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="color_tab"><!-- /colores -->
                                    <?php
                                    $colorList = array();
                                    $colorList = colorFeature();

                                    $colorListLayout="";
                                    $colorListLayout .="<div class='row no-padmarg' >";
                                    if(is_array($colorList)){
                                        foreach($colorList as $clKey){
                                            $idColor = $clKey['id_color'];
                                            $nameColor = $clKey['nome_color'];
                                            $hexaColor = $clKey['color_hexa'];

                                            $colorListLayout .="<div class='col-xs-4' >"; //datatallaitem='".$dataTallaItem."' 
                                            $colorListLayout .="<label>";
                                            $colorListLayout .= "<span  style='position:absolute; right:20px; top:0px; float:right; display:block; width:20px; height:20px; margin: 0; -webkit-box-shadow: 0px 0px 1px 0px rgba(0, 0, 0, 0.35); -moz-box-shadow: 0px 0px 1px 0px rgba(0, 0, 0, 0.35); box-shadow: 0px 0px 1px 0px rgba(0, 0, 0, 0.35); background-color:" .$hexaColor .";'>";
                                            $colorListLayout .= "</span>";
                                            $colorListLayout .="<input type='checkbox' name='tipocolor[]' class='flat-red tipocolor' value='" .$idColor ."'/>&nbsp;&nbsp;";
                                            $colorListLayout .= $nameColor;                                                
                                            $colorListLayout .="</label>";
                                            $colorListLayout .="</div>";

                                        }
                                    }
                                    $colorListLayout .="</div>";
                                    echo $colorListLayout;

                                    ?>
                                    </div><!-- /colores -->
                                    <div class="tab-pane" id="material_tab"><!-- /materiales -->
                                    <?php
                                    $materialList = array();
                                    $materialList = materialFeature();

                                    $materialListLayout="";
                                    $materialListLayout .="<div class='row no-padmarg' >";
                                    if(is_array($materialList)){
                                        foreach($materialList as $mlKey){
                                            $idMaterial = $mlKey['id_material'];
                                            $nameMaterial = $mlKey['nome_material'];
                                            $valoraMaterial = empty($mlKey['valor_material'])? "": "&#40;&nbsp;".$mlKey['valor_material'] ."&#41;&nbsp;" ;

                                            $materialListLayout .="<div class='col-xs-4' >"; //datatallaitem='".$dataTallaItem."' 
                                            $materialListLayout .="<label>";
                                            $materialListLayout .= "<span  style='position:absolute; right:20px; top:0px; float:right; display:block;'>";
                                            $materialListLayout .= $valoraMaterial;
                                            $materialListLayout .= "</span>";
                                            $materialListLayout .="<input type='checkbox' name='tipomaterial[]' class='flat-red tipomaterial' value='" .$idMaterial ."'/>&nbsp;&nbsp;";
                                            $materialListLayout .= $nameMaterial;                                                
                                            $materialListLayout .="</label>";
                                            $materialListLayout .="</div>";

                                        }
                                    }
                                    $materialListLayout .="</div>";
                                    echo $materialListLayout;

                                    ?>
                                    </div><!-- /materiales -->                                                               
                                </div>                                
                            </div>
                        </div><!---///colores - materiales--->                                
                    </div>      
                    <hr class="linesection"/>
                </div>                                                                                
                <div class="row wrapdivsection">
                    <div class="col-xs-12 col-sm-4">
                        <h4>Descripción</h4>
                        <p class="help-block"></p>
                    </div>
                    <div class="col-xs-12 col-sm-8">
                        <div class="form-group">
                            <textarea id="descri-prod" name="descriprod" class="form-control" placeholder="Características, detalles, beneficios," style="width: 100%; height: 240px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        </div>
                    </div>
                    <hr class="linesection"/>
                </div>
                <div class="row wrapdivsection">
                    <div class="col-xs-12 col-sm-4">
                        <h4>Status</h4>
                        <p class="help-block">Por defecto se guarda en estado de REVISIÓN, es decir, será creada como un <b>Borrador</b>, no se mostrará en el catálogo hasta que decidas que hacer con ella</p>
                    </div>
                    <div class="col-xs-12 col-sm-8">
                        <div class="form-group">
                        <?php 
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
                                if($idStatusTbl == "5"){
                                    $actiStatus = "checked";
                                }
                                
                                $statusLayaout .= "<p>";
                                $statusLayaout .= "<label>";
                                $statusLayaout .= "<input type='radio' name='statusprod' value='".$idStatusTbl."' class='flat-red' ".$actiStatus.">";
                                $statusLayaout .= "<span class=' margin-left-md'>".$nameStatusTbl."</span>";
                                $statusLayaout .= "</label>";
                                $statusLayaout .= "</p>";                                                                
                            }                                                    
                        }   
                        echo $statusLayaout; 
                        
                        ?>
                            <!--<p>
                                <label>
                                    <input type="radio" name="statusprod" value="4" class="flat-red" checked>                                        
                                    Borrador
                                </label>
                            </p>
                            <p>
                                <label>
                                    <input type="radio" name="statusprod" value="5" class="flat-red">                                        
                                    Revisión
                                </label>
                            </p>
                            <p>
                                <label>
                                    <input type="radio" name="statusprod" value="1" class="flat-red">                                        
                                    Activado
                                </label>
                            </p>
                            <p>
                                <label>
                                    <input type="radio" name="statusprod" value="2" class="flat-red">                                        
                                    Suspendido
                                </label>
                            </p>-->
                        </div>    
                    </div>
                    <hr class="linesection"/>
                </div>

                <div class="row wrapdivsection">                        
                    <input name="newprod" type="hidden" value="ok">
                    <input type="hidden" name="codeitemform" id="codeitemform" value="<?php echo $codeNewProd; ?>">                         
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
                <div id="left-barbtn" class="nav navbar-nav margin-left-md padd-verti-xs" style="display:none;">
                    <a href="<?php echo $pathmm.$admiDir."/tienda/new.php"; ?>" class="btn btn-info margin-hori-xs">
                        <i class="fa fa-plus fa-lg margin-right-xs"></i>
                        <span>Nuevo producto</span>
                    </a>
                    
                    <a href="<?php echo $pathmm.$admiDir."/tienda/new.php?trash=ok&coditemget=".$codeNewProd; ?>" class="btn btn-default trashtobtn" name="" title="Eliminar item" data-msj="Perderás toda la información para este producto. Deseas continuar?" data-remsj="">
                        <i class="fa fa-trash fa-lg margin-right-xs"></i>
                        <span>Eliminar</span>
                    </a>
                </div>
                <div id="right-bartbtn" class="nav navbar-nav navbar-right margin-right-md padd-verti-xs">
                    <a href="<?php echo $pathmm.$admiDir."/tienda/new.php?trash=ok&coditemget=".$codeNewProd; ?>" class="btn btn-default trashtobtn" name="" title="Eliminar item" data-msj="Perderás toda la información para este producto. Deseas continuar?" data-remsj="">
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
<script type="text/javascript" src="crud-newprod.js"></script>    

<!-- Select2 -->
<script src="../appweb/plugins/select2/select2.full.min.js"></script>
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
    $(".tallaitem").hide();
    $(".grupotallalist").change(function(){        
        var id=$(this).val();
        
        $('.tallaitem').each(function(k,v1) { 
            var tallaitem = $(v1).attr("datatallaitem");
            
            if(id === tallaitem){                
                $('.tallaitem').fadeOut(function(){
                    $("#wti"+tallaitem).show();    
                });
                    
            }                       
         });
                
    });    
});                                    
</script>     
</body>
</html>
