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
        $fieldItemTBL = "id_talla_letras";  
        $tblItemTBL = "talla_letras";
        $trashItem = deleteFieldDB($itemVarGET, $fieldItemTBL, $tblItemTBL);
    }
    
    $statusCancel = 1;
            
}


//***********
//LISTA COLORES
//***********


//COLORES
$dataQueryTbl = array();
$dataQueryTbl =  queryTallasLetras();

$layoutQuery = "";
if(is_array($dataQueryTbl)){
    foreach($dataQueryTbl as $dqKey){
        $idTalla = $dqKey['id_talla_letras'];
        $nameTalla = $dqKey['nome_talla_letras'];
        $posiTalla = $dqKey['posi_talla'];
        
        $layoutQuery .= "<div class='col-xs-4 col-sm-2 margin-bottom-xs'>";                
        $layoutQuery .= "<a href='".$pathmm.$admiDir."/custom/prods/features/tallas.php?trash=ok&coditemrefget=".$idTalla."' class='cancelOrder trashtobtn' name='".$nameTalla."' title='Eliminar Talla' data-msj='Estas seguro que deseas eliminar esta talla?'><i class='fa fa-trash fa-lg'></i></a>";
        $layoutQuery .= "<div class='img-thumbnail' style='display:block; width:100%;'>";
        //$layoutQuery .= "<div style='height:70px; display:block; background-color:".$hexaColor."'>";
        //$layoutQuery .= "</div>";
        $layoutQuery .= "<p class='text-center margin-top-xs'>";                
        $layoutQuery .= "<b>".$nameTalla."</b>";
        $layoutQuery .= "</p>";
        $layoutQuery .= "</div>";
        $layoutQuery .= "</div>";
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
                    Nueva talla
                </button>                
            </div>                    
            <h1><small>Especificaciones productos / Tallas / </small> Tallas letras</h1>
                                             
        </section>

        <?php
        /*
        /*****************************//*****************************
        /MAIN WRAPPER CONTEN
        /*****************************//*****************************
        */
        ?>
        
        
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="nav nav-tabs">
                        <li role="presentation"><a href="<?php echo $pathmm.$admiDir."/custom/prods/features/"; ?>">Colores</a></li>
                        <li role="presentation" class="active"><a href="<?php echo $pathmm.$admiDir."/custom/prods/features/tallas.php"; ?>">Tallas</a></li>
                        <li role="presentation"><a href="<?php echo $pathmm.$admiDir."/custom/prods/features/materiales.php"; ?>">Materiales</a></li>
                    </ul>
                </div>
            </div>
                                            
            <div class="box box-info" style="background-color:transparent; box-shadow:none;">
                <!--<div class="box-header">
                    <h3 class="box-title">Paleta de colores</h3>
                </div>-->                
                <div class="box-body no-padmarg">
                    <div class="row unlateralmargin">
                        <div class="col-xs-12 col-sm-2 unlateralpadding">
                            <ul class="nav nav-pills nav-stacked">
                                <li role="presentation" class="active"><a href="<?php echo $pathmm.$admiDir."/custom/prods/features/tallas.php"; ?>">Tallas letras</a></li>
                                <li role="presentation" ><a href="<?php echo $pathmm.$admiDir."/custom/prods/features/tallasnum.php"; ?>">Tallas números</a></li>
                                <li role="presentation" ><a href="<?php echo $pathmm.$admiDir."/custom/prods/features/tipoprendas.php"; ?>">Tipo de prendas</a></li>
                                <li role="presentation" ><a href="<?php echo $pathmm.$admiDir."/custom/prods/features/grupotallas.php"; ?>">Grupos de tallas</a></li>
                            </ul>
                        </div>
                        <div class="col-xs-12 col-sm-10 bg-white padd-hori-md padd-verti-md">
                            <div class="row">
                            <?php echo $layoutQuery; ?>
                            </div> 
                        </div>
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
                    <h4>Publicar talla letra</h4>                                                            
                    <div class="form-group">                        
                        <label>Nombre</label>
                        <input type="text" name="nametalla" class="form-control" placeholder="Nombre talla" />
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
                        <button type="button" class="btn btn-info margin-hori-xs " id="additembtn" data-field="tallaltadd">
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

<script type="text/javascript" src="crud-newitem.js"></script>  
  
</body>
</html>
