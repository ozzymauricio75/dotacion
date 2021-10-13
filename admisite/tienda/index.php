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

//recibe datos de catalgoo
$dataCatalogo = array();
$dataCatalogo = getCatalogoFull();

//***********
//SITE MAP
//***********

$rootLevel = "tienda";
$sectionLevel = "list";
$subSectionLevel = "";
?>

<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo METATITLE ?></title>    
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <meta name="author" content="massin">
    <?php echo _CSSFILESLAYOUT_ ?>    
    <link rel="stylesheet" href="../appweb/plugins/datatables/dataTables.bootstrap.css">
    <?php echo _FAVICON_TOUCH_ ?>    
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
                <a href="new.php" class="btn btn-info" type="button" >
                    <i class="fa fa-plus margin-right-xs"></i>
                    Publicar
                </a>                
            </div>
            
            <h1>
            Productos            
            </h1>
            <!--<ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">Blank page</li>
            </ol>-->
            
            
        </section>

        <?php
        /*
        /*****************************//*****************************
        /MAIN WRAPPER CONTEN
        /*****************************//*****************************
        */
        ?>
        <section class="content">

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
                                <th>Categor&iacute;a</th>
                                <th>Status</th>
                                <th style='width:80px;'>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(is_array($dataCatalogo)){
                            foreach($dataCatalogo as $dcKey){
                                if(is_array($dcKey)){
                                    foreach($dcKey as $dcVal){
                                        //guarda datos
                                        $namel1Item = $dcVal['tags_depatament_produsts'];
                                        $tipoKit = $dcVal['tipo_kit_4user'];
                                        $namel2Item = $dcVal['nome_catego_product'];
                                        $namel3Item = $dcVal['nome_subcatego_producto'];
                                        $idItem = $dcVal['id_producto'];
                                        $nameItem = $dcVal['nome_producto'];
                                        $skuItem = $dcVal['cod_venta_prod'];
                                        $labelItem = $dcVal['foto_producto'];
                                        $statusItem = $dcVal['id_estado_contrato'];
                                        $stockItem = $dcVal['agotado'];

                                        //PATH FOTO DEFAULT
                                        $pathFileDefault = $pathmm."img/nopicture.png";
                                        //PORTADA
                                        $pathPortada = "../../files-display/tienda/img200/".$labelItem;
                                                                               
                                        if (file_exists($pathPortada)) {
                                            $portadaFile = $pathPortada;
                                        } else {
                                            $portadaFile = $pathFileDefault;
                                        }
                                        
                                        clearstatcache(true, $portadaFile);


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
                                        $layoutDataItem .= "<td><img src='".$portadaFile."' class='labelitemlyt'/></td>";
                                        $layoutDataItem .= "<td>";//detalles
                                        $layoutDataItem .= "<h4>".$nameItem."</h4>";
                                        $layoutDataItem .= "<small class='text-red'>Ref: ".$skuItem."</small>";
                                        $layoutDataItem .= "</td>";//fin detalles

                                        $layoutDataItem .= "<td>";//categoria                                    
                                        $layoutDataItem .= "<strong >".$namel3Item."</strong>";
                                        $layoutDataItem .= "<p><span class='txtUppercase'>".$namel1Item."</span>&nbsp;>&nbsp;<span class='txtCapitalice'>".$tipoKit."&nbsp;>&nbsp;".$namel2Item."</span></p>";
                                        //$layoutDataItem .= "<p class='txtCapitalice'>".$namel2Item."</p>";
                                        //$layoutDataItem .= "<p class='txtCapitalice'>".$namel3Item."</p>";
                                        $layoutDataItem .= "</td>";//fin categoria
                                        $layoutDataItem .= "<td>";//status
                                        $layoutDataItem .= "<p>Estado: ".$printStatusItem."</p>";
                                        $layoutDataItem .= "<p>Stock: ".$printStockItem."</p>";
                                        $layoutDataItem .= "</td>";//fin stratus
                                        $layoutDataItem .= "<td>";//opciones

                                        $layoutDataItem .= "<div class='btn-group'>";
                                        $layoutDataItem .= "<a href='newrefitem.php?coditemget=".$idItem."' type='button' class='btn btn-info'>Referencias</a>";
                                        $layoutDataItem .= "<button type='button' class='btn btn-info dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
                                        $layoutDataItem .= "<span class='caret'></span>";
                                        $layoutDataItem .= "<span class='sr-only'>edititem</span>";
                                        $layoutDataItem .= "</button>";
                                        $layoutDataItem .= "<ul class='dropdown-menu pull-right'>";
                                        //$layoutDataItem .= "<li><a href='#'>Detalles</a></li>";
                                        $layoutDataItem .= "<li><a href='item-edit.php?coditemget=".$idItem."'><i class='fa fa-pencil margin-right-xs'></i>Editar</a></li>";                                    
                                        $layoutDataItem .= "<li role='separator' class='divider'></li>";
                                        //$layoutDataItem .= "<li><a href='#'><i class='fa fa-trash margin-right-xs'></i>Eliminar</a></li>";
                                        $layoutDataItem .= "<li><a href='".$pathmm.$admiDir."/tienda/?trash=ok&coditemget=".$idItem."' class='trashtobtn' name='".$nameItem."' title='Eliminar item' data-msj='Estas a punto de eliminar este producto, si lo haces, perder¨¢s toda la informaci¨®n para este producto. Deseas continuar?' data-remsj=''><i class='fa fa-trash margin-right-xs'></i>Eliminar</a></li>";
                                        $layoutDataItem .= "</ul>";
                                        $layoutDataItem .= "</div>";

                                        $layoutDataItem .= "</td>";//fin opciones
                                        $layoutDataItem .= "</td>";
                                        $layoutDataItem .= "</tr>";

                                        echo $layoutDataItem;
                                    }
                                }

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
    <?php include '../appweb/tmplt/right-side.php';  ?>
</div>
<?php echo _JSFILESLAYOUT_ ?>
<!-- DataTables -->
<script src="../appweb/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../appweb/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
  $(function () {
    
    $('#printdatatbl').DataTable({        
        "scrollX": false,
        "ordering": false,
        "autoWidth": false
    });
  });
</script>    
</body>
</html>
