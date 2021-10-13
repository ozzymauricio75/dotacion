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
    
    if(isset($_GET['coditemrefget'])){
        
        $itemVarGET = (int)$_GET['coditemrefget'];
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

$tallaRef = array();
$colorRef = array();
$tallaRef = tallaFeatureREF($itemVarGET);
$colorRef = colorFeatureREF($itemVarGET);

//ITEMS REFERENCIA
$dataCatalogo = array();
$dataCatalogo = itemRefQuery($itemVarGET);//30
//echo "<pre>";
//print_r($dataCatalogo);

//***********
//SITE MAP
//***********

$rootLevel = "tienda";
$sectionLevel = "level";
$subSectionLevel = "";

?>

<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=big5">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo METATITLE ?></title>    
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <meta name="author" content="massin">
    <?php echo _CSSFILESLAYOUT_ ?>        
    <link rel="stylesheet" href="../appweb/plugins/datatables/dataTables.bootstrap.css">
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
                <button type="button" class="btn btn-info" data-toggle="control-sidebar">
                    <i class="fa fa-plus margin-right-xs"></i>
                    Nueva referencia
                </button>                
            </div>                    
            <h1>
            <small>Productos</small> / Items Referencia
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
        
        
        <section class="content ">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Productos publicados en catalogo</h3>
                </div>                
                <div class="box-body ">
                    <table id="printdatatbl" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Detalles</th>
                                <th>Existencias</th>
                                <th>Status</th>
                                <th style='width:80px;'>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        
                        if(is_array($dataCatalogo)){
                            foreach($dataCatalogo as $dcVal){
                            
                            	
                                                                                    
                                //if(is_array($dcKey)){
                                    //foreach($dcKey as $dcVal){
                                        //guarda datos
                                        //$namel1Item = $dcVal['tags_depatament_produsts'];
                                        //$tipoKit = $dcVal['tipo_kit_4user'];
                                        //$namel2Item = $dcVal['nome_catego_product'];
                                        //$namel3Item = $dcVal['nome_subcatego_producto'];
                                        $idItem = $dcVal['id_prod_filing'];
                                        $nameItem = $dcVal['nome_producto_filing'];
                                        $skuItem = $dcVal['cod_venta_prod_filing'];
                                        $skuFullItem = $dcVal['cod_venta_descri_filing'];
                                        $labelItem = $dcVal['foto_producto_filing'];
                                        $statusItem = $dcVal['id_estado_contrato'];
                                        $stockItem = $dcVal['agotado_filing'];
                                        $refAlbumItem = $dcVal['ref_album_prod_filing'];
                                        $cantItem = $dcVal['cant_exist_prod_filing'];
                                        $minCantItem = $dcVal['min_exist_prod_filing'];
                                        
                                        //SOBRE LA TALLA LETRA                                        
                                        $tallaLetraItem[] = $dcVal['tallaletraref'];
                                        if(is_array($tallaLetraItem)){
                                            foreach($tallaLetraItem as $tlKey){
                                                $idTLItem = $tlKey['id_talla_letras'];
                                                $nameTLItem = $tlKey['nome_talla_letras'];
                                            }
                                        }
                                        //SOBRE LA TALLA NUMEROS                                       
                                        $tallaNumeItem[] = $dcVal['tallanumeref'];
                                        if(is_array($tallaNumeItem)){
                                            foreach($tallaNumeItem as $tnKey){
                                                $idTNItem = $tnKey['id_talla_numer'];
                                                $nameTNItem = $tnKey['talla_numer'];
                                            }
                                        }
                                        //SOBRE COLOR
                                        $colorItem[] = $dcVal['colorref'];
                                        if(is_array($colorItem)){
                                            foreach($colorItem as $colorKey){
                                                $idColorItem = $colorKey['id_color'];
                                                $nameColorItem = $colorKey['nome_color'];
                                                $hexaColorItem = $colorKey['color_hexa'];
                                            }
                                        }
                                        

                                        //PATH FOTO DEFAULT
                                        $pathFileDefault = $pathmm."img/nopicture.png";
                                        //PORTADA
                                        $pathPortada = "../../files-display/album/labels/".$labelItem;
                                        
                                        clearstatcache(true, $pathPortada);

                                        if (file_exists($pathPortada)) {
                                            $portadaFile = $pathPortada;
                                        } else {
                                            $portadaFile = $pathFileDefault;
                                        }
                                        
                                        


                                        //STAUTS PRODUCTO (ACTIVO = SUSPENDIDO)
                                        switch($statusItem){
                                            case "1":
                                                $printStatusItem = "<span class='label label-success'>Activado</span>";
                                                break;
                                            case "2":
                                                $printStatusItem = "<span class='label label-warning'>Suspendido</span>";
                                                break;
                                            case "4":
                                                $printStatusItem = "<span class='label label-default'>Desactivado</span>";
                                            break;																		
                                            case "5":
                                                $printStatusItem = "<span class='label label-info'>Revisi&oacute;n</span>";
                                            break;
                                            case "6":
                                                $printStatusItem = "<span class='label label-danger'>Agotado</span>";
                                            break;																	
                                        }

                                        //EXISTENCIAS - STOCK 
                                        $printStockItem="";
                                        switch($stockItem){
                                            case "1":
                                                $printStockItem = "<span class='label label-warning'>Agotado</span>";
                                                break;
                                            case "0":
                                                $printStockItem = "<span class='label label-success'>Existencias</span>";
                                                break;	
                                        }



                                        //LAYOUT TABLE ITEM                                    
                                        $layoutDataItem = "";
                                        $layoutDataItem .= "<tr>";
                                        //$layoutDataItem .= "<td><img src='".$portadaFile."' class='labelitemlyt'/></td>";
                                        $layoutDataItem .= "<td><img src='".$portadaFile."' class='labelitemlyt'/></td>";
                                        $layoutDataItem .= "<td>";//detalles
                                        $layoutDataItem .= "<h4>".$skuFullItem."</h4>";
                                        $layoutDataItem .= "<small class='text-red'>Ref: ".$skuItem."</small>";
                                
                                        $layoutDataItem .= "<ul class='list-unstyled list-inline'>";
                                        $layoutDataItem .= "<li>";
                                        $layoutDataItem .= "<p><span class='margin-right-xs'>Talla:</span>";
                                        if(isset($nameTLItem)){
                                            $layoutDataItem .= "<strong>".$nameTLItem."</strong>";    
                                        }
                                        if(isset($nameTNItem)){
                                            $layoutDataItem .= "<strong>".$nameTNItem."</strong>";    
                                        }                                        
                                        $layoutDataItem .= "</p>";
                                        $layoutDataItem .= "</li>";
                                        $layoutDataItem .= "<li>";
                                        $layoutDataItem .= "<p><span class='margin-right-xs'>Color:</span>";
                                        $layoutDataItem .= "<strong style='display:inline-block;'>".$nameColorItem."</strong>";    
                                        $layoutDataItem .= "<span  style='position:relative; left:10px; top:0px; display:inline-block; width:20px; height:20px; margin: 0; -webkit-box-shadow: 0px 0px 1px 0px rgba(0, 0, 0, 0.35); -moz-box-shadow: 0px 0px 1px 0px rgba(0, 0, 0, 0.35); box-shadow: 0px 0px 1px 0px rgba(0, 0, 0, 0.35); background-color:" .$hexaColorItem .";'>";
                                        $layoutDataItem .= "</p>";
                                        $layoutDataItem .= "</li>";
                                        $layoutDataItem .= "</ul>";
                                                                        
                                        $layoutDataItem .= "</td>";//fin detalles

                                        $layoutDataItem .= "<td>";//existencias   
                                        $layoutDataItem .= "<p><span class='margin-right-xs'>Cant. Stock:</span>";
                                        $layoutDataItem .= "<strong style='display:inline-block;'>".$cantItem."</strong>"; 
                                        $layoutDataItem .= "</p>";
                                        $layoutDataItem .= "<p><span class='margin-right-xs'>Min. Cant. Stock:</span>";
                                        $layoutDataItem .= "<strong style='display:inline-block;'>".$minCantItem."</strong>"; 
                                        $layoutDataItem .= "</p>";                                        
                                        $layoutDataItem .= "</td>";//fin existencias
                                        $layoutDataItem .= "<td>";//status
                                        $layoutDataItem .= "<p>Estado: ".$printStatusItem."</p>";
                                        $layoutDataItem .= "<p>Stock: ".$printStockItem."</p>";
                                        $layoutDataItem .= "</td>";//fin stratus
                                        $layoutDataItem .= "<td>";//opciones

                                        $layoutDataItem .= "<div class='btn-group'>";
                                        $layoutDataItem .= "<a href='editref.php?coditemget=".$idItem."' type='button' class='btn btn-info'>Editar</a>";
                                        $layoutDataItem .= "<button type='button' class='btn btn-info dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
                                        $layoutDataItem .= "<span class='caret'></span>";
                                        $layoutDataItem .= "<span class='sr-only'>edititem</span>";
                                        $layoutDataItem .= "</button>";
                                        $layoutDataItem .= "<ul class='dropdown-menu pull-right'>";
                                        //$layoutDataItem .= "<li><a href='#'>Detalles</a></li>";
                                        //$layoutDataItem .= "<li><a href='newrefitem.php?coditemget=".$idItem."'>Referencias</a></li>";  
                                
                                        //$layoutDataItem .= "<li role='separator' class='divider'></li>";
                                        $layoutDataItem .= "<li><a href='".$pathmm.$admiDir."/tienda/newrefitem.php?trash=ok&coditemget=".$itemVarGET."&coditemrefget=".$idItem."' class='trashtobtn' name='".$skuFullItem."' title='Eliminar item' data-msj='Perder&aacute;s toda la informaci&oacute;n para este producto. Deseas continuar?' data-remsj=''><i class='fa fa-trash margin-right-xs'></i>Eliminar</a></li>";
                                        $layoutDataItem .= "</ul>";
                                        $layoutDataItem .= "</div>";

                                        $layoutDataItem .= "</td>";//fin opciones
                                        $layoutDataItem .= "</td>";
                                        $layoutDataItem .= "</tr>";
                                        
                                        

                                        echo $layoutDataItem;
                                   // }
                                //}
                                
                                

                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->   
                
            </div>        
        </section>    
                                                
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
    <?php //include '../appweb/tmplt/right-side.php';  ?>
    <aside class="control-sidebar control-sidebar-light" style="max-height: calc(100% - 50px); overflow-y: auto; margin-bottom:2%;">        
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">          
            <li>
                <a href="!#" data-toggle="control-sidebar">
                    <i class="fa fa-times margin0right-xs"></i> Cerrar                    
                </a>
            </li>            
        </ul>
        
        <div class="box100 "  >
            <form id="file-form" action="../appweb/inc/valida-new-prodref.php" method="POST" enctype="multipart/form-data">                                                   
            <!--<div class="row wrapdivsection">
                <div class="col-xs-12">
                    <h4>Foto portada</h4>
                    <div class="form-group ">
                        <div class="kv-avatar " >
                            <input id="valida-upload" name="fotoprod" type="file" class="fileimg" >
                        </div>
                        <div id="kv-avatar-errors-2" class="center-block" style="width:90%; margin:5px auto; display:none"></div>
                        <div id="successupload" class="center-block" style="width:90%; margin:5px auto;"></div>
                    </div>                    
                </div>
            </div>-->
            
            <div class="row wrapdivsection">
                <div class="col-xs-12 ">

                    <div class="form-group"><!---///tallas--->   
                        <h4>Talla</h4>
                    <?php 

                    $optionList = "";
                    $optionList .="<div class='row no-padmarg ' >";

                    if(is_array($tallaRef)){
                        foreach($tallaRef as $etpKey){  

                            $idTallaTablas = $etpKey['id_talla_tablas'];
                            $nameGrupoTalla = $etpKey['talla_tipo_prenda'];
                            $tipoTalla = $etpKey['tipo_talla']; 

                            $optionList .="<div class='col-xs-6' >";
                            $optionList .="<label>";
                            $optionList .="<input type='radio' name='tallaslist' class='flat-red tallaslist' value='" .$idTallaTablas ."' data-tipotalla='".$tipoTalla."'/>&nbsp;&nbsp;";
                            $optionList .= $nameGrupoTalla;
                            $optionList .="</label>";
                            $optionList .="</div>";   


                        }

                    }   
                        $optionList .= "</div>";
                        echo $optionList;
                    ?>
                    </div><!---///tallas--->   

                    <div class="form-group"><!---colores--->   
                        <h4>Color</h4>
                        <?php

                        $colorListLayout="";
                        $colorListLayout .="<div class='row no-padmarg ' >";
                        if(is_array($colorRef)){
                            foreach($colorRef as $clKey){
                                $idColor = $clKey['id_color'];
                                $nameColor = $clKey['nome_color'];
                                $hexaColor = $clKey['color_hexa'];

                                $colorListLayout .="<div class='col-xs-6' >"; //datatallaitem='".$dataTallaItem."' 
                                $colorListLayout .="<label>";
                                $colorListLayout .= "<span  style='position:absolute; right:20px; top:0px; float:right; display:block; width:20px; height:20px; margin: 0; -webkit-box-shadow: 0px 0px 1px 0px rgba(0, 0, 0, 0.35); -moz-box-shadow: 0px 0px 1px 0px rgba(0, 0, 0, 0.35); box-shadow: 0px 0px 1px 0px rgba(0, 0, 0, 0.35); background-color:" .$hexaColor .";'>";
                                $colorListLayout .= "</span>";
                                $colorListLayout .="<input type='radio' name='tipocolor' class='flat-red tipocolor' value='" .$idColor ."'/>&nbsp;&nbsp;";
                                $colorListLayout .= $nameColor;                                                
                                $colorListLayout .="</label>";
                                $colorListLayout .="</div>";

                            }
                        }
                        $colorListLayout .="</div>";
                        echo $colorListLayout;
                        ?>
                    </div><!-- /colores -->  
                </div>  
                <hr class="linesection"/>
            </div>
            <div class="row wrapdivsection">            
                <div class="col-xs-12 ">   
                    <h4>Existencias</h4>
                    <div class="form-group"><!---cantidades--->
                        <input type="text" value="" name="cantprod" id="cantprod" class="form-control" placeholder="Cant. Stock" />
                    </div>
                    <div class="form-group"><!---cantidades--->
                        <input type="text" value="" name="minprod" id="minprod" class="form-control" placeholder="Cant. Min. Stock" />
                    </div>
                </div>  
                <hr class="linesection"/>
            </div>
            
            <div class="row wrapdivsection">
                <div class="col-xs-12 ">
                    
                    <h4 class="no-padmarg">Album</h4>
                    <p class="help-block">Max. 5 fotos</p>
                    <div class="form-group">
                        <input id="imgmutifile" name="multifileimg[]" type="file" class="file-loading" multiple>
                        <div id="errorBlock" class="help-block"></div>  
                    </div>
                </div>
                <hr class="linesection"/>
            </div>
            
            <div class="row wrapdivsection">                        
                <input name="newprod" type="hidden" value="ok">
                <input type="hidden" name="codeitemform" id="codeitemform" value="<?php echo $itemVarGET; ?>">                         
            </div>


            <?php
            /*
            /*****************************//*****************************
            /FOOTER CONTENT - BOTTOM NAV
            /*****************************//*****************************
            */
            ?>
            <section class="bottonnav bottomtools" style="position:fixed; top:auto; bottom:0px; z-index:999; width:100%;"><!---/main-footer navbar-fixed-bottom-->
                <div id="wrapadditem"></div>
                <div id="erradditem"></div>       
                <nav class="">
                    <div id="left-barbtn" class="nav navbar-nav margin-left-md padd-verti-xs" style="display:none;"></div>
                    <div id="right-bartbtn" class="nav navbar-nav navbar-left padd-verti-xs">                        
                        <button type="button" class="btn btn-info margin-hori-xs " id="additembtn">
                            <i class='fa fa-save fa-lg margin-right-xs'></i>
                            <span>Guardar</span>                     
                        </button>                                                               
                    </div>
                </nav>
            </section>

            </form>
        </div>
        
    </aside>    
    <div class="control-sidebar-bg"></div>
    
            
    
    <?php echo "<input id='pathfile' type='hidden' value='".$pathmm."'/>"; ?>
    <?php echo "<input id='pathdir' type='hidden' value='".$admiDir."'/>"; ?>
    
</div>

<?php echo _JSFILESLAYOUT_ ?>
<!-- InputMask -->
<script src="../appweb/plugins/input-mask/jquery.inputmask.js"></script>
<script src="../appweb/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="../appweb/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- iCheck 1.0.1 -->
<script src="../appweb/plugins/iCheck/icheck.min.js"></script>
<!-- DataTables -->
<script src="../appweb/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../appweb/plugins/datatables/dataTables.bootstrap.min.js"></script>

<script src="../appweb/plugins/fileimput/plugins/sortable.js" type="text/javascript"></script>        
<script src="../appweb/plugins/fileimput/fileinput.js" type="text/javascript"></script>        
<script src="../appweb/plugins/fileimput/themes/fa/theme.js"></script>    
<script src="../appweb/plugins/fileimput/locales/es.js"></script>      

<script type="text/javascript" src="crud-newref.js"></script>  
    
<script type="text/javascript">
$(document).ready(function() {   
        
    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });
    
       
});                                    
</script> 
<script>
  $(function () {
    
    $('#printdatatbl').DataTable({        
        "scrollX": false,
        "ordering": false,
        "autoWidth": true
    });
  });
    
</script>    
</body>
</html>
