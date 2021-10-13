<?php require_once '../../../appweb/lib/MysqliDb.php'; ?>
<?php require_once '../../../cxconfig/config.inc.php'; ?>
<?php require_once '../../../cxconfig/global-settings.php'; ?>
<?php require_once '../../../appweb/inc/sessionvars.php'; ?>
<?php require_once '../../../appweb/lib/gump.class.php'; ?>
<?php require_once '../../../appweb/inc/site-tools.php'; ?>
<?php require_once '../../../appweb/inc/query-feactures.php'; ?>
<?php require_once '../../../i18n-textsite.php'; ?>
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
        $fieldItemTBL = "id_color";  
        $tblItemTBL = "tipo_color";
        $trashItem = deleteFieldDB($itemVarGET, $fieldItemTBL, $tblItemTBL);
    }
    
    $statusCancel = 1;
            
}


//***********
//LISTA COLORES
//***********


//COLORES
$dataQueryTbl = array();
$dataQueryTbl = queryColores();

$layoutColor = "";
if(is_array($dataQueryTbl)){
    foreach($dataQueryTbl as $dqKey){
        $idColor = $dqKey['id_color'];
        $nameColor = $dqKey['nome_color'];
        $hexaColor = $dqKey['color_hexa'];
        
        $layoutColor .= "<div class='col-xs-4 col-sm-2 margin-bottom-xs'>";                
        $layoutColor .= "<a href='".$pathmm.$admiDir."/custom/prods/features/?trash=ok&coditemrefget=".$idColor."' class='cancelOrder trashtobtn' name='".$nameColor."' title='Eliminar Color' data-msj='Estas seguro que deseas eliminar este color?'><i class='fa fa-trash fa-lg'></i></a>";
        $layoutColor .= "<div class='img-thumbnail' style='display:block; width:100%;'>";
        $layoutColor .= "<div style='height:70px; display:block; background-color:".$hexaColor."'>";
        $layoutColor .= "</div>";
        $layoutColor .= "<p class='text-center margin-top-xs'>";                
        $layoutColor .= "<b>".$nameColor."</b>";
        $layoutColor .= "</p>";
        $layoutColor .= "</div>";
        $layoutColor .= "</div>";
    }
    
}
//echo "<pre>";
//print_r($dataQueryTbl);

//***********
//SITE MAP
//***********

$rootLevel = "especificaciones";
$sectionLevel = "productos";
$subSectionLevel = "customprod";

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
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="../../../appweb/plugins/colorpicker/bootstrap-colorpicker.min.css">
          
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
    <?php include '../../../appweb/tmplt/header.php';  ?>           
    <?php
    /*
    /
    ////SIDEBAR
    /
    */
    ?>
    <?php include '../../../appweb/tmplt/side-mm.php';  ?>
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
                    Nuevo color
                </button>                
            </div>                    
            <h1><small>Especificaciones productos / </small> Colores</h1>
                                             
        </section>

        <?php
        /*
        /*****************************//*****************************
        /MAIN WRAPPER CONTEN
        /*****************************//*****************************
        */
        ?>
        
        
        <section class="content ">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="nav nav-tabs">
                        <li role="presentation" class="active"><a href="<?php echo $pathmm.$admiDir."/custom/prods/features/"; ?>">Colores</a></li>
                        <li role="presentation"><a href="<?php echo $pathmm.$admiDir."/custom/prods/features/tallas.php"; ?>">Tallas</a></li>
                        <li role="presentation"><a href="<?php echo $pathmm.$admiDir."/custom/prods/features/materiales.php"; ?>">Materiales</a></li>
                    </ul>
                </div>
            </div>
                                            
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Paleta de colores</h3>
                </div>                
                <div class="box-body ">
                    <div class="row">
                    <?php echo $layoutColor; ?>
                    </div>   
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
    <?php //include '../../../appweb/tmplt/right-side.php';  ?>
    <aside class="control-sidebar control-sidebar-light" style="max-height: calc(100% - 50px); overflow-y: auto; margin-bottom:2%;">        
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">          
            <li>
                <a href="!#" data-toggle="control-sidebar">
                    <i class="fa fa-times margin0right-xs"></i> Cerrar                    
                </a>
            </li>            
        </ul>
        
        <div class="box100 "  >
            <form id="newitem" method="POST" enctype="text/plain" autocomplete="off">                                                   
                        
            <div class="row wrapdivsection"><!---color--->   
                <div class="col-xs-12 ">
                    <h4>Publicar un color</h4>
                    <div class="form-group">                        
                        <label>Seleccione un color</label>
                        <input type="text" class="form-control colorpicker" name="coloritem">
                    </div> 
                                        
                    <div class="form-group">                        
                        <label>Nombre</label>
                        <input type="text" name="namecolor" class="form-control" placeholder="Nombre para este color" />
                    </div> 
                                      
                </div>  
                <hr class="linesection"/>
            </div><!---color---> 
                            
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
                        <button type="button" class="btn btn-info margin-hori-xs " id="additembtn" data-field="coloradd">
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
                     
</div>

<?php echo _JSFILESLAYOUT_ ?>
<!-- bootstrap color picker -->
<script src="../../../appweb/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>     
<script type="text/javascript" src="crud-newitem.js"></script>  
<script>
    $(function () {
        //Colorpicker
        $(".colorpicker").colorpicker();
    });
</script>    
</body>
</html>
