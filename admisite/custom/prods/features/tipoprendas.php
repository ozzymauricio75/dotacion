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
        $fieldItemTBL = "id_grupo_talla";  
        $tblItemTBL = "grupo_tallas";
        $trashItem = deleteFieldDB($itemVarGET, $fieldItemTBL, $tblItemTBL);
    }
    
    $statusCancel = 1;
            
}

//***********
//ESPECIFICACIONES ITEM
//***********
//tipo coleccion
$generoPrenda = array();
$generoPrenda = forGenero();


//***********
//LISTA ITEM
//***********

$dataQueryTbl = array();
$dataQueryTbl =  queryGrupTallaXprenda();
//id_grupo_talla, genero_ropa, tipo_prenda,tipo_prenda_tag
$layoutQuery = "";
$prevColection = "";
if(is_array($dataQueryTbl)){
    foreach($dataQueryTbl as $dqKey){
        $idPrenda = $dqKey['id_grupo_talla'];
        $nameColection = $dqKey['genero_ropa'];
        $namePrenda = $dqKey['tipo_prenda'];
        $tagTipoTalla = $dqKey['tipo_prenda_tag'];
        
        if($prevColection != $nameColection){
            if($prevColection != ""){
                $layoutQuery .= "</div></div>";
            }
            
            $layoutQuery .= "<h3 class='txtCapitalice no-padmarg margin-bottom-xs'>".$nameColection."</h3><div class='well well-xs'><div class='row'>";
        
            
            $prevColection = $nameColection;
        }
        
        $layoutQuery .= "<div class='col-xs-4 col-sm-2 margin-bottom-xs'>";                
        $layoutQuery .= "<a href='".$pathmm.$admiDir."/custom/prods/features/tipoprendas.php?trash=ok&coditemrefget=".$idPrenda."' class='cancelOrder trashtobtn' name='".$namePrenda."' title='Eliminar prenda' data-msj='Estas seguro que deseas eliminar esta prenda?'><i class='fa fa-trash fa-lg'></i></a>";
        $layoutQuery .= "<div class='img-thumbnail' style='display:block; width:100%;'>";        
        $layoutQuery .= "<p class='text-center margin-top-xs txtCapitalice'>";                
        $layoutQuery .= "<b>".$namePrenda."</b>";
        $layoutQuery .= "<span style='display:block;' class=''>".$nameColection."</span>";
        $layoutQuery .= "</p>";
        $layoutQuery .= "</div>";
        $layoutQuery .= "</div>";
    }
    
    //$layoutQuery .= "</div>";
    
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
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
    
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
                    Nueva prenda
                </button>                
            </div>                    
            <h1><small>Especificaciones productos / Tallas / </small> Tipo prenda</h1>
                                             
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
                                <li role="presentation"><a href="<?php echo $pathmm.$admiDir."/custom/prods/features/tallas.php"; ?>">Tallas letras</a></li>
                                <li role="presentation"><a href="<?php echo $pathmm.$admiDir."/custom/prods/features/tallasnum.php"; ?>">Tallas n®≤meros</a></li>
                                <li role="presentation" class="active"><a href="<?php echo $pathmm.$admiDir."/custom/prods/features/tipoprendas.php"; ?>">Tipo de prendas</a></li>
                                <li role="presentation" ><a href="<?php echo $pathmm.$admiDir."/custom/prods/features/grupotallas.php"; ?>">Grupos de tallas</a></li>
                            </ul>
                        </div>
                        <div class="col-xs-12 col-sm-10 bg-white padd-hori-md padd-verti-md">
                            <div class="box100">
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
                    <h4>Publicar tipo de prenda</h4>
                    <div class="form-group"><!--/ropa para--->
                        <label>Tipo colecci&oacute;n</label>
                        <?php

                        $lyoutGenero = "<select name='tipocolection' class='form-control'>"; 
                        $lyoutGenero .= "<option value='' selected>Selecciona una colecci&oacute;n</option>";
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
                        <label>Tipo de tallas</label>
                        <select class="form-control" name="tipotalla">
                            <option value="" selected>Selecciona una</option>
                            <option value="tl">Tallas letras</option>
                            <option value="tn">Tallas n√∫meros</option>
                            <option value="unica">Tallas unica</option>
                        </select>
                    </div>                                       
                    <div class="form-group">                        
                        <label>Nombre</label>
                        <input type="text" name="nameprenda" class="form-control" placeholder="Nombre de la prenda" />
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
                        <button type="button" class="btn btn-info margin-hori-xs " id="additembtn" data-field="prendaadd">
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
