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
        
        //ELIMINAR ITEM
        $fieldItemTBL = "id_prod_filing";  
        $tblItemTBL = "productos_filing";
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
$detallesItem = queryDetallesItemRef($itemVarGET);

$dataCatego = array();
$dataTL = array();
$dataColor = array();
$dataFotos = array();
$dataTLCheck = array();
$dataColorCheck = array();
$dataMaterialCheck = array();

//echo "<pre>";
//print_r($detallesItem);

if(is_array($detallesItem)){
    foreach($detallesItem as $diKey){
            
        //$categoItem = $diKey['id_catego_product'];
        //$subCateItem = $diKey['id_subcatego_producto'];
        $idProdItemRef = $diKey['id_prod_filing'];           
        $idProdItem = $diKey['id_producto'];
        $statusItem = $diKey['id_estado_contrato'];
        $actiStockItem = $diKey['agotado_filing'];
        $codVentaItem = $diKey['cod_venta_prod_filing'];
        $codVentaFullItem = $diKey['cod_venta_descri_filing'];
        $nameItem = $diKey['nome_producto_filing'];
        $fotoItem = $diKey['foto_producto_filing'];
        $refAlbumItemRef = $diKey['ref_album_prod_filing'];
        $cantItem = $diKey['cant_exist_prod_filing'];
        $minCantItem = $diKey['min_exist_prod_filing'];  
        $dataTL = $diKey['tallaletraref'];
        $dataTN = $diKey['tallanumeref'];
        $dataColor = $diKey['colorref'];
        //$dataMaterial = $diKey['materialitem'];
        $dataFotos = $diKey['fotosref'];
        
            
        //$dataTLCheck = $diKey['tallasitem'];
        //$dataColorCheck = $diKey['coloritem'];
        //$dataMaterialCheck = $diKey['materialitem'];
        
        /*//SOBRE CATEGORIA
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
            
        }*/
        
        //SOBRE TALLAS
        $tallaLayout = "";        
        if(is_array($dataTL)){
            foreach($dataTL as $tallaKey){
            
            	if(count($tallaKey)>0){
	                
	                $idgrupoTallaItem = $tallaKey['id_talla_letras'];                
	                $nameTallaItem = $tallaKey['nome_talla_letras']; 
	                
	                $tallaLayout .= "<p>";
	                $tallaLayout .= "Talla:&nbsp;&nbsp;<span class='img-thumbnail margin-right-xs padd-hori-xs'>".$nameTallaItem."</span>";                
	                $tallaLayout .= "</p>";
	    	}
                                                                
            }
            
        }
        
        //SOBRE TALLAS
        $tallaNumeLayout = "";        
        if(is_array($dataTN) && count($dataTN)>0){
            foreach($dataTN as $tnKey){
            
            	if(count($tnKey)>0){
                
	                $idgrupoTallaNumItem = $tnKey['id_talla_numer'];      
	                $nameTallaNumItem = $tnKey['talla_numer']; 
	                
	                $tallaNumeLayout .= "<p>";
	                $tallaNumeLayout .= "Talla:&nbsp;&nbsp;<span class='img-thumbnail margin-right-xs padd-hori-xs'>".$nameTallaNumItem."</span>";                
	                $tallaNumeLayout .= "</p>";
	    	}
                                                                
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
                                                
                $colorsLayout .="<p> Color:&nbsp;&nbsp;"; 
                $colorsLayout .="<label>";
                $colorsLayout .= "<span  style='position:relative; margin-left:20px; top:0px; float:right; display:inline-block; width:20px; height:20px; -webkit-box-shadow: 0px 0px 1px 0px rgba(0, 0, 0, 0.35); -moz-box-shadow: 0px 0px 1px 0px rgba(0, 0, 0, 0.35); box-shadow: 0px 0px 1px 0px rgba(0, 0, 0, 0.35); background-color:" .$hexaColorItem .";'>";
                $colorsLayout .= "</span>";                
                $colorsLayout .= $nameColorItem;                                                
                $colorsLayout .="</label>";
                $colorsLayout .="</p>";   

                
            }
            
        }
        
        //SOBRE FOTOS
        /*//PATH FOTO DEFAULT
        $pathFileDefault = $pathmm."img/nopicture.png";
        //PORTADA
        $pathPortada = "../../appweb/files-display/album/labels/".$fotoItem;

        if (file_exists($pathPortada)) {
            $portadaFile = $pathPortada;
        } else {
            $portadaFile = $pathFileDefault;
        }*/

        //FOTOS ALBUM
        $pathFotos = "../../files-display/album/200/";
        
        $fotosLayout = "";
        if(is_array($dataFotos)){
            foreach($dataFotos as $fKey){ 
                $idAlbumItem = $fKey['id_albun'];
                $idfotoItem = $fKey['id_foto'];
                $fileFotoItem = $fKey['img_foto'];
                $nameFotoItem = $fKey['nome_foto'];
                $descriFotoItem = $fKey['descri_foto'];
                
                //$fileLabelItem[0] = $fKey['img_foto'];
                //$LabelItem = implode("",$fileLabelItem);
                
                $nameAlbumItem = $fKey['nome_albun'];
                $labelAlbumItem = $fKey['portada_album'];
                $refAlbumItem = $fKey['ref_album'];
                                                
                $fotosLayout .="<div class='col-xs-3 margin-bottom-xs' id='img_".$idfotoItem."'>"; 
                $fotosLayout .="<div class='img-thumbnail margin-right-xs padd-hori-xs'>";
                //$fotosLayout .= "<a href='!#' class='cancelOrder trashtobtn' name='".$nameFotoItem."' title='Eliminar Foto' data-msj='Estas seguro que deseas eliminar esta foto del album?'><i class='fa fa-trash fa-lg'></i></a>";
                
                $fotosLayout .="<a href='!#' type='button' class='cancelOrder trashtobtn deleteitempto' data-post='".$idfotoItem."' data-field='".$fileFotoItem."' type='button' name='".$fileFotoItem."' title='Eliminar Foto' data-msj='Estas seguro que deseas eliminar esta foto del album?'><i class='fa fa-times'></i></a>";
                
                $fotosLayout .= "<img src='".$pathFotos.$fileFotoItem."' class='img-responsive'>";
                $fotosLayout .= "<div class='caption'>";
                if(isset($nameFotoItem)){
                $fotosLayout .= "<strong>".$nameFotoItem."</strong>";                
                }
                if(isset($descriFotoItem)){
                $fotosLayout .= "<p>".$descriFotoItem."</p>";                                                               
                }
                $fotosLayout .="</div>";//caption
                $fotosLayout .="</div>";//thumbnail
                $fotosLayout .="</div>";//col                                    
                
            }
            
        }
    }
    
    //PATH FOTO DEFAULT
    $pathFileDefault = $pathmm."img/nopicture.png";
    //PORTADA
    $pathPortada = "../../files-display/album/labels/".$fotoItem;

    if (file_exists($pathPortada)) {
    $portadaFile = $pathPortada;
        } else {
    $portadaFile = $pathFileDefault;
    }
    
}

//echo "<pre>";
//print_r($fileLabelItem);

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
            </div>
            
            <h1>
            <small>Productos / Detalles </small> / Item referencia
            </h1>
            <a href="<?php echo $pathmm.$admiDir."/tienda/newrefitem.php?coditemget=".$idProdItem; ?>" class="ch-backbtn">
                <i class="fa fa-arrow-left"></i>
                Lista de productos referencia
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
                            <?php echo "<h3>".$codVentaFullItem."</h3>"; ?>
                        </div>                                            
                        <?php
                        /*
                        /*
                        /*SKU PRODUCTO
                        /*
                        */
                        ?>
                        <div id="skuitemform" class="form-group">
                            <?php echo "<strong class='text-red'>Ref:&nbsp;&nbsp;".$codVentaItem."</strong>"; ?>
                        </div>
                        
                        <div class="wrapdivsection">
                            <?php
                            /*
                            /*
                            /*ESPECIFICACIONES
                            /*
                            */
                            ?>
                            <div class="form-group" >
                            <?php
                                if($tallaLayout !=""){ echo $tallaLayout; }
                                if($tallaNumeLayout !=""){ echo $tallaNumeLayout; }
                                if($colorsLayout!=""){ echo $colorsLayout; }                         
                            ?>
                            </div>
                        
                            <?php
                            /*
                            /*
                            /*EXISTENCIAS
                            /*
                            */
                            ?>
                            
                            <div id="cantstockform" class="form-group">
                                <label>Cant. Existencias</label>
                                <input type="text" value="<?php echo $cantItem; ?>" name="cantprod" class="form-control" placeholder="Cant." data-post="<?php echo $itemVarGET; ?>" data-field="cantstockform"/>
                            </div>
                            <div id="errcantstockform"></div>    
                            <div id="mincantstockform" class="form-group">
                                <label>Min. Cant. Existencias</label>
                                <input type="text" value="<?php echo $minCantItem; ?>" name="minprod" class="form-control" placeholder="Min Cant." data-post="<?php echo $itemVarGET; ?>" data-field="mincantstockform"/>
                            </div>
                            <div id="errmincantstockform"></div>
                        </div><!---/wrapdivsection--->
                    </div>  
                    <hr class="linesection"/>
                </div>
                
                <?php
                /*
                /*
                /*ALBUM FOTOS
                /*
                */
                ?>
                <div class="row wrapdivsection">
                    <div class="col-xs-12 col-sm-4">
                        <h4>Album</h4>
                        <p class="help-block">Las fotos que has publicado para este item</p>
                    </div>                                           
                    <div class="col-xs-12 col-sm-8">
                        <div class="row padd-bottom-xs" id="wpeditalbumref">
                            <div class="row">
                                <button class="btn btn-default pull-right btn-sm editfieldbtn" type="button" data-this="editalbumref">
                                    <i class="fa fa-pencil"></i>
                                    Editar Album
                                </button>
                            </div>
                        <?php echo $fotosLayout;  ?>
                        </div>
                        <div class="wefield" id="weeditalbumref">                            
                            <div class="col-xs-12 ">
                                <div class="row">
                                    <button type="button" class="btn btn-default pull-right btn-sm canceleditfieldbtn" data-this="editalbumref"> 
                                        <i class="fa fa-times"></i> Cancelar
                                    </button>
                                </div>
                                <h4 class="no-padmarg">Album</h4>
                                <p class="help-block">Max. 5 fotos</p>
                                <div class="form-group">
                                    <input id="imgmutifile" name="editmultifileimg[]" type="file" class="file-loading" multiple>
                                    <div id="errorBlock" class="help-block"></div>  
                                </div>
                            </div>
                            <hr class="linesection"/>
                        </div>
                        <div id="errweeditalbumref"></div>
                    </div>      
                    <hr class="linesection"/>
                </div>
                                
                <?php
                /*
                /*
                /*STATUS ITEM
                /*
                */
                ?>                                                                            
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
                            </select>
                        </div>  
                        <div id="errstatusitemform"></div>
                    </div>
                    <hr class="linesection"/>
                </div>
                                                                            
                <div class="row wrapdivsection">                        
                    <input name="newprod" type="hidden" value="ok">
                    <input type="hidden" name="codeitemform" id="codeitemform" value="<?php echo $itemVarGET; ?>">
                    <input type="hidden" name="labelitemform" id="labelitemform" value="<?php echo $fotoItem; ?>">
                    <input type="hidden" name="labelalbumform" id="labelalbumform" value="<?php echo $refAlbumItemRef; ?>">
                    <input type="hidden" name="codealbumform" id="codelalbumform" value="<?php echo (!empty($idAlbumItem))? $idAlbumItem : '';  ?>">
                    
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
                    <a href="<?php echo $pathmm.$admiDir."/tienda/editref.php?trash=ok&coditemget=".$itemVarGET; ?>" class="btn btn-default trashtobtn" name="" title="Eliminar item" data-msj="Perder&aacute;s toda la informaci&oacute;n para este producto. Deseas continuar?" data-remsj="">
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
<script type="text/javascript" src="edit-ref-functions.js"></script>    

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
        allowedFileExtensions: ["jpg", "jpeg", "png"],                                 
        uploadAsync: false,
        uploadUrl: "../appweb/inc/upload-imgref.php",
        uploadExtraData: function() {
            return {
                codeitem: $("#codeitemform").val(),                
                nameportadaitem: $("#labelitemform").val(), 
                labelalbumform: $("#labelalbumform").val() 
                
            };
        }
    }).on("filebatchselected", function(event, files) {        
        $inputSingleImg.fileinput("upload");
    });
    
    var $inputMultiImg = $("#imgmutifile");
    $inputMultiImg.fileinput({
        theme: "fa",
        language: 'es',        
        maxFileCount: 5,
        fileTypeSettings: 'image',        
        maxFileSize: 1700,
        maxImageWidth: 1600,
        maxImageHeight: 1600,  
        showUpload: false,
        showRemove: false,       
        showBrowse: false,
        browseOnZoneClick: true,
        //layoutTemplates: {main2: '{preview}  {remove} {browse}'},
        allowedFileExtensions: ["jpg", "jpeg", "png"],                                 
        uploadAsync: false,
        uploadUrl: "../appweb/inc/upload-imgref.php", 
        uploadExtraData: function() {
            return {
                codeitem: $("#codeitemform").val(),                
                nameportadaitem: $("#labelitemform").val(), 
                labelalbumform: $("#labelalbumform").val(),
                codealbumform: $("#codelalbumform").val(),
                
            };
        }
        
    }).on("filebatchselected", function(event, files) {                
        $inputMultiImg.fileinput("upload");
    });
    
        
});                                    
</script>     
</body>
</html>
