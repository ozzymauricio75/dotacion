<?php require_once '../../../appweb/lib/MysqliDb.php'; ?>
<?php require_once '../../../cxconfig/config.inc.php'; ?>
<?php require_once '../../../cxconfig/global-settings.php'; ?>
<?php require_once '../../../appweb/inc/sessionvars.php'; ?>
<?php require_once '../../../appweb/lib/gump.class.php'; ?>
<?php require_once '../../../appweb/inc/site-tools.php'; ?>
<?php require_once '../../../appweb/inc/query-prods.php'; ?>
<?php require_once '../../../appweb/inc/query-levels.php'; ?>
<?php require_once '../../../i18n-textsite.php'; ?>
<?php 

//***********
//ESQUEMA CATGEGORIAS
//***********
//////////////////////////////////////////////////


$printLevelList = array();
$printLevelList = queryLevelsFull();//getLevelsList();

$lyBrowseCat = "";
$lyBrowseCat .="<div class='box box75 padd-hori-md'>  
                    <div class='box-header'></div>
                    <div class='box-body'>
                    <ul id='categoesquema'>";


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

                                    $lyBrowseCat .= "<li style='margin-bottom:25px;' id='wrapplevel1".$idLevel1."'>";////wrap PACK DPTO                                         
                                    $lyBrowseCat .= "<h3 class='no-padmarg' id='wpeditl1_".$idLevel1."'>";
                                    $lyBrowseCat .= "<div class='btn-group btn-group-sm pull-right' role='group'>";                                    
                                    $lyBrowseCat .= "<button class='btn btn-info editfieldbtn' data-this='editl1_".$idLevel1."'><i class='fa fa-pencil '></i></button>";
                                    //$lyBrowseCat .= "<button class='btn '><i class='fa fa-trash '></i></button>";
                                    $lyBrowseCat .="<a class='btn btn-default deletelevel' data-post='".$idLevel1."' data-field='trashl1' data-thislevel='level1' type='button' name='".$nameLevel1."' title='Eliminar Categoría' data-msj='Estas a punto de eliminar esta categoría del catálogo. Si continuas, perderás las informaciones asociadas a ella. Estas seguro que deseas continuar? '><i class='fa fa-trash'></i></a>";
                                    $lyBrowseCat .= "</div>";//btn-group
                                    $lyBrowseCat .= "<span id='wrappupdatenamel1".$idLevel1."'>".$nameLevel1."</span>";
                                    $lyBrowseCat .= "<small id='wrappupdatedescril1".$idLevel1."' style='display:block;'>".$descriLevel1."</small>";
                                    $lyBrowseCat .= "</h3>";
                                    
                                    $lyBrowseCat .= "<div id='errtrashl1".$idLevel1."'></div>";
                                    
                                    $lyBrowseCat .= "<div id='weeditl1_".$idLevel1."' class='wefield'>";//WRAP EDIT LEVEL1
                                    $lyBrowseCat .= "<button class='btn btn-sm canceleditfieldbtn pull-right' data-this='editl1_".$idLevel1."'><i class='fa fa-times '></i> Cerrar</button>";
                                    //$lyBrowseCat .= "<button class='btn btn-sm btn-success closeeditfieldbtn pull-right' data-this='editl1_".$idLevel1."' style='display:none;'><i class='fa fa-check '></i> Terminar</button>";
                                    $lyBrowseCat .= "<div class='form-group' id='updatenamel1".$idLevel1."'>";
                                    $lyBrowseCat .= "<input type='text' class=' form-control domedit' name='updatenamel1' value='".$nameLevel1."' data-post='".$idLevel1."' data-field='updatenamel1'  placeholder='Nombre categoría'/>";                                    
                                    $lyBrowseCat .= "</div>";//form-group  
                                    $lyBrowseCat .= "<div id='errupdatenamel1".$idLevel1."'></div>";
                                    
                                    $lyBrowseCat .= "<div class='form-group' id='updatedescril1".$idLevel1."'>";
                                    $lyBrowseCat .= "<textarea class=' form-control domedit' name='updatedescril1' data-post='".$idLevel1."' data-field='updatedescril1' placeholder='Descripción para esta categoría (Opcional)' style='resize:none; width:100%; height:60px;'>".$descriLevel1."</textarea>";
                                    $lyBrowseCat .= "</div>";//form-group
                                    $lyBrowseCat .= "<div id='errupdatedescril1".$idLevel1."'></div>";
                                    $lyBrowseCat .= "</div>";//FIN WRAP EDIT LEVEL1
                                    
                                    
                                    $lyBrowseCat .= "<ul style='margin-top:20px;'>";//INICIA CONTENEDOR LEVEL2

                                    $prevVarGender = $idLevel1;                                    
                                }
                                //======FIN IMPRIME LAYOUT MASCULINO FEMENINO


                            //======IMPRIME ITEM KIT                    
                            $lyBrowseCat .= "<li style='margin-top:15px;' ><span class='txtUppercase'>".$kitLevel2."</span><ul class='well well-sm' style='margin-top:5px; padding-left:10px; padding-right:10px; padding-top:10px; padding-bottom:10px;'>";////wrap KIT DOTACION
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
                        $lyBrowseCat .= "</div>";
                        $lyBrowseCat .= "<div class='col-xs-2'>";
                        $lyBrowseCat .= "<span id='wrappupdatepzsl2".$idLevel2."'>".$pzsLevel2."</span>&nbsp;Pzs";
                        $lyBrowseCat .= "</div>";
                        
                        $lyBrowseCat .= "<div class='col-xs-3'>";
                        $lyBrowseCat .= "<div class='btn-group btn-group-sm pull-right' role='group'>";                                    
                        $lyBrowseCat .= "<button class='btn btn-info editfieldbtn' data-this='editl2_".$idLevel2."'><i class='fa fa-pencil '></i></button>";
                        //$lyBrowseCat .= "<button class='btn '><i class='fa fa-trash '></i></button>";
                        $lyBrowseCat .="<a class='btn btn-default deletelevel' data-post='".$idLevel2."' data-field='trashl2' data-thislevel='level2' type='button' name='".$nameLevel2."' title='Eliminar Categoría' data-msj='Estas a punto de eliminar esta categoría del catálogo. Si continuas, perderás las informaciones asociadas a ella. Estas seguro que deseas continuar? '><i class='fa fa-trash'></i></a>";
                        $lyBrowseCat .= "</div>";//btn-group
                        $lyBrowseCat .= "</div>";
                                                                        
                        $lyBrowseCat .= "</div>";//wpeditl2_
                        
                        $lyBrowseCat .= "<div id='errtrashl2".$idLevel2."'></div>";
                        
                        $lyBrowseCat .= "<div id='weeditl2_".$idLevel2."' class='wefield padd-verti-xs padd-hori-xs' style='border:1px dashed #ccc; '>";//WRAP EDIT LEVEL2
                        $lyBrowseCat .= "<div class='box100 row'>";
                        $lyBrowseCat .= "<button class='btn btn-sm canceleditfieldbtn pull-right' data-this='editl2_".$idLevel2."'><i class='fa fa-times '></i> Cerrar</button>";//wrap-btn cancelar
                        $lyBrowseCat .= "</div>";//box100 row
                                                
                        $lyBrowseCat .= "<div class='row'>";
                        $lyBrowseCat .= "<div class='col-xs-12 col-sm-9'>";
                        
                        $lyBrowseCat .= "<div class='form-group' id='updatenamel2".$idLevel2."'>";
                        $lyBrowseCat .= "<input type='text' class=' form-control domedit' name='namel2' value='".$nameLevel2."' data-post='".$idLevel2."' data-field='updatenamel2'  placeholder='Nombre categoría'/>";
                        $lyBrowseCat .= "</div>";//form-group
                        $lyBrowseCat .= "<div id='errupdatenamel2_".$idLevel2."'></div>";
                        
                        $lyBrowseCat .= "<div class='form-group' id='updatesubnamel2".$idLevel2."'>";
                        $lyBrowseCat .= "<input type='text' class=' form-control domedit' name='subnamel2' value='".$descriLevel2."' data-post='".$idLevel2."' data-field='updatesubnamel2' placeholder='Sub nome categoría' />";
                        $lyBrowseCat .= "</div>";//form-group
                        $lyBrowseCat .= "<div id='errupdatesubnamel2".$idLevel2."'></div>";
                        
                        $lyBrowseCat .= "</div>";//col-sm-9
                        
                        $lyBrowseCat .= "<div class='col-xs-12 col-sm-3'>";
                        
                        $lyBrowseCat .= "<div class='form-group' id='updatepzsl2".$idLevel2."'>";
                        $lyBrowseCat .= "<input type='text' class=' form-control domedit' name='pzsl2' value='".$pzsLevel2."' data-post='".$idLevel2."' data-field='updatepzsl2' placeholder='Cant. piezas en esta categoría' />";
                        $lyBrowseCat .= "</div>";//form-group
                        $lyBrowseCat .= "<div id='errupdatepzsl2".$idLevel2."'></div>";
                        
                        $lyBrowseCat .= "</div>";//col
                        $lyBrowseCat .= "</div>";//row
                        
                        $lyBrowseCat .= "</div>";//FIN WRAP EDIT LEVEL2
                        
                        
                        $lyBrowseCat .= "<ul>";//INICIA CONTENEDOR LEVEL 3
                        
                        $prevVarItemCat = $idLevel2;                        
                    }//CIERRA ITEM ITEM KIT
                                                            
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
                            $pathPortada = "../../../../files-display/tienda/img-catego/".$labelLevel3;

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
                            
                            $lyBrowseCat .= "</div>";//col-xs-7
                            
                            $lyBrowseCat .= "<div class='col-xs-3'>";
                            $lyBrowseCat .= "<div class='btn-group btn-group-sm pull-right' role='group'>";                                    
                            $lyBrowseCat .= "<button class='btn btn-info editfieldbtn' data-this='editl3_".$idLevel3."'><i class='fa fa-pencil '></i></button>";
                            //$lyBrowseCat .= "<button class='btn '><i class='fa fa-trash '></i></button>";
                            $lyBrowseCat .="<a class='btn btn-default deletelevel' data-post='".$idLevel3."' data-field='trashl3' data-thislevel='level3' type='button' name='".$nameLevel3."' title='Eliminar Categoría' data-msj='Estas a punto de eliminar esta categoría del catálogo. Si continuas, perderás las informaciones asociadas a ella. Estas seguro que deseas continuar? '><i class='fa fa-trash'></i></a>";
                            $lyBrowseCat .= "</div>";//btn-group
                            $lyBrowseCat .= "</div>";//col-xs-3
                                                                                    
                            $lyBrowseCat .= "</div>";//wpeditl3_                      
                            
                            $lyBrowseCat .= "<div id='errtrashl3".$idLevel3."'></div>";
                                                        
                            $lyBrowseCat .= "<div id='weeditl3_".$idLevel3."' class='wefield padd-verti-xs padd-hori-xs' style='border:1px dashed #ccc; '>";//WRAP EDIT LEVEL3
                            $lyBrowseCat .= "<div class='box100 row'>";
                            $lyBrowseCat .= "<button class='btn btn-sm canceleditfieldbtn pull-right' data-this='editl3_".$idLevel3."'><i class='fa fa-times '></i> Cerrar</button>";
                            $lyBrowseCat .= "</div>";//wrap-btn cancelar
                            $lyBrowseCat .= "<div class='row'>";
                            
                            $lyBrowseCat .= "<div class='col-xs-12 col-sm-3'>";//sobre la imagen de la categoria
                            //$lyBrowseCat .= "<img class='media-object' src='".$portadaFile."' style='height:60px;'>";
                                                                                                                
                            $lyBrowseCat .= "<div class='form-group ' id='wplabelfield_".$idLevel3."'>";
                            $lyBrowseCat .= "<button type='button' class='btn btn-default pull-right btn-sm editfieldbtn' data-this='labelfield_".$idLevel3."'>"; 
                            $lyBrowseCat .= "<i class='fa fa-pencil'></i>";
                            $lyBrowseCat .= "</button>";       
                            $lyBrowseCat .= "<img class='media-object' src='".$portadaFile."' style='height:90px;'>";
                            $lyBrowseCat .= "</div>";//form-group
                            
                            $lyBrowseCat .= "<div class='form-group wefield' id='welabelfield_".$idLevel3."' >";
                            $lyBrowseCat .= "<button type='button' class='btn btn-default pull-right btn-sm canceleditfieldbtn margin-bottom-xs' data-this='labelfield_".$idLevel3."'>"; 
                            $lyBrowseCat .= "<i class='fa fa-times'></i> Cerrar";
                            $lyBrowseCat .= "</button>";
                            
                            $lyBrowseCat .= "<form method='post' name='' id='editlabell3form_".$idLevel3."' enctype='multipart/form-data'>"; 
                            $lyBrowseCat .= "<div class='kv-avatar ' id='wraplabell3".$idLevel3."'>";
                            $lyBrowseCat .= "<input id='labell3".$idLevel3."' name='labell3' type='file' class='editlabel' data-idlabel='".$idLevel3."'  >";
                            $lyBrowseCat .= "<button class='editlabell3btn btn btn-xs btn-success pull-right' type='button' data-post='".$idLevel3."' data-namefile='".$labelLevel3."'>Guardar</button>";
                            $lyBrowseCat .= "</div>";                            
                            $lyBrowseCat .= "</form>"; 
                            $lyBrowseCat .= "</div>";//form-group     
                            
                            $lyBrowseCat .= "</div>";//sobre la imagen de la categoria
                            
                            $lyBrowseCat .= "<div class='col-xs-12 col-sm-9'>";
                            
                            $lyBrowseCat .= "<div class='form-group' id='updatenamel3".$idLevel3."'>";                              
                            $lyBrowseCat .= "<input type='text' class=' form-control domedit' name='namel3' value='".$nameLevel3."' data-post='".$idLevel3."' data-field='updatenamel3' placeholder='Nombre categoría'/>";
                            $lyBrowseCat .= "</div>";//form-group
                            $lyBrowseCat .= "<div id='errupdatenamel3".$idLevel3."'></div>";
                                                                                     
                            $lyBrowseCat .= "<div class='form-group' id='updatedescril3".$idLevel3."'>";
                            $lyBrowseCat .= "<textarea type='text' class=' form-control domedit' name='descril3' data-post='".$idLevel3."' data-field='updatedescril3' placeholder='Descripción categoría' style='resize:none; width:100%; height:60px;'>".$descriLevel3."</textarea>";
                            $lyBrowseCat .= "</div>";//form-group
                            $lyBrowseCat .= "<div id='errupdatedescril3".$idLevel3."'></div>";
                            
                            $lyBrowseCat .= "</div>";//row
                            
                            $lyBrowseCat .= "</div>"; //box100 
                            
                            $lyBrowseCat .= "<div id='errwraplabell3".$idLevel3."' class='margin-top-xs'></div>";
                            $lyBrowseCat .= "<div id='successwraplabell3".$idLevel3."' class='margin-top-xs'></div>";
                            
                            $lyBrowseCat .= "</div>";//FIN WRAP EDIT LEVEL3
                                                                                    
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
//GENERO USUARIO
//***********
//tipo de persona
$generoPrenda = array();
$generoPrendaSC = array();
$generoPrenda = forGenero();
$generoPrendaSC = forGenero();

//***********
//SITE MAP
//***********

$rootLevel = "especificaciones";
$sectionLevel = "productos";
$subSectionLevel = "customlevels";

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
    <link rel="stylesheet" href="../../../appweb/plugins/fileimput/fileimput.css">
    <style>
        .kv-avatar .file-preview-frame,.kv-avatar .file-preview-frame:hover {
            margin: 0px auto;            
            padding: 0;
            border: none;
            box-shadow: none;
                       
        }
        .kv-avatar .file-input {
            display: table;
            max-width: 100px;            
            margin: 8px auto;
            border: 1px dashed #c4c4c4;
            text-align: center;
            padding-bottom: 7px;
            padding-top: 7px;
        }
        .kv-avatar .file-input .file-preview,
        .kv-avatar .file-input .file-drop-zone{
            border: 0px solid transparent;            
        }
    </style>
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="../../../appweb/plugins/iCheck/all.css">
    <!---switchmaster--->    
    <link rel="stylesheet" href="../../../appweb/plugins/switchmaster/css/bootstrap3/bootstrap-switch.min.css">
    <!--jquery bonsai--->
    <link rel="stylesheet" href="../../../appweb/plugins/jquery-bonsai/jquery.bonsai.css">
          
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
                    Nueva categoría
                </button>                
            </div>                    
            <h1>
            <h1><small>Especificaciones productos / </small> Categorías</h1>
            </h1>                                               
        </section>

        <?php
        /*
        /*****************************//*****************************
        /MAIN WRAPPER CONTEN
        /*****************************//*****************************
        */
        ?>
        
        
        <section class="content padd-bottom-lg padd-top-md">
            <div class="maxwidth-layout margin-bottom-md"><h3 class="text-center">Esquema categorías catálogo</h3></div>
            
            <?php echo $lyBrowseCat; ?>            
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
    <aside class="control-sidebar control-sidebar-light" >        
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">          
            <li>
                <a href="!#" data-toggle="control-sidebar">
                    <i class="fa fa-times margin0right-xs"></i> Cerrar                    
                </a>
            </li>            
        </ul>
        
        <div class="box100 "  >
            <form id="levels-form" method="POST" enctype="multipart/form-data">
                <div class="row wrapdivsection">            
                    <div class="col-xs-12 ">                       
                        <div class="form-group">                        
                            <label>Nombre</label>
                            <input type="text" name="namecatego" class="form-control" placeholder="Nombre categoría" />
                        </div>
                        <div class="form-group">                        
                            <label>Descripción<small class='margin-left-xs'>(Opcional)</small></label>
                            <textarea name="descricatego" class="form-control" placeholder="Una pequeña redacción introductoría o descriptiva para esta categoría " style="resize:none; width:100%; height:70px;"/></textarea>
                        </div>
                    </div>
                    <hr class="linesection margin-bottom-md"/>
                    <div class="col-xs-12 margin-top-xs">
                        <p class="help-block"><b>Quieres crear una sub categoría?</b><br>Puedes escoger entre las siguientes opciones, según el esquema que hayas creado</p>
                        <div class="form-group"> 
                            <Span class='pull-right'>
                                <input id="switchcat" type="radio" name="opcicatego" value="catkit" data-size="mini" >
                            </Span>
                            <span class="margin-right-xs">Esto es un KIT</span>                                                
                        </div>                    
                        <div class="form-group"> 
                            <Span class='pull-right'>
                                <input id="switchsubcat" type="radio" name="opcicatego" value="catprenda" data-size="mini" >
                            </Span>
                            <span class="margin-right-xs">Esto es una prenda de KIT</span>

                        </div> 
                    </div>
                    <hr class="linesection"/>
                </div>

                <div id="wrapcat" class="padd-hori-xs">   
                    <div class="row wrapdivsection">
                        <button type="button" class="btn btn-default pull-right btn-sm canceloptioncatego" data-this="cat"> 
                            <i class="fa fa-times"></i> Cancelar
                        </button>
                        <h4>Categoría KIT</h4>      
                        <div class="form-group">                        
                            <label>Sub Nombre</label>
                            <p class="help-block">Por razones de diseño del sistema de pedido, escribe el clima especifico para este kit. Será complemento del nombre del KIT</p>
                            <input type="text" name="subnamecatego" class="form-control" placeholder="Clima frio | clima calido" />
                        </div>
                        <div class="form-group"><!--/ropa para--->
                            <label>Tipo colección</label>
                            <?php

                            $lyoutGenero = "<select name='tipocolection' class='form-control'>"; 
                            $lyoutGenero .= "<option value='' selected>Selecciona una colección</option>";
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
                            <label>Tipo de Kit</label>
                            <select class="form-control" name="tipokit">
                                <option value="" selected>Seleccionar uno</option>
                                <option value="calido">Calido</option>
                                <option value="frio">Frio</option>
                                <option value="zapatos">Calzado</option>
                                <option value="adicional">Unitario</option>
                            </select>
                        </div> 

                        <div class="form-group"><!---cantidades--->
                            <label>Cant. Prendas</label>
                            <input type="text" value="" name="cantpzas" id="cantprod" class="form-control" placeholder="No. de piezas para este kit" />
                        </div>                                                            
                    </div>                
                </div>

                <div id="wrapsubcat">
                    <div class="row wrapdivsection">
                        <div class="col-xs-12 ">
                            <button type="button" class="btn btn-default pull-right btn-sm canceloptioncatego" data-this="subcat"> 
                                <i class="fa fa-times"></i> Cancelar
                            </button>
                            <h4>Categoría Prenda </h4>  
                            <div class="form-group ">
                                <label>Foto categoría</label>
                                <div class="kv-avatar " >
                                    <input id="valida-upload" name="fotoprod" type="file" class="fileimg" >
                                </div>
                                <div id="kv-avatar-errors-2" class="center-block" style="width:90%; margin:5px auto; display:none"></div>
                                <div id="successupload" class="center-block" style="width:90%; margin:5px auto;"></div>
                            </div>                    
                                                                                   
                            <div class="form-group"><!--/ropa para--->
                                <label>Tipo colección</label>
                                <?php

                                $lyoutGeneroL3 = "<select name='tipocolectionl3' class='form-control generopz'>"; 
                                $lyoutGeneroL3 .= "<option value='' selected>Selecciona una colección</option>";
                                if(is_array($generoPrendaSC)){
                                    foreach($generoPrendaSC as $gpscKey){
                                        $idL1ItemL3 = $gpscKey['id_depart_prod'];
                                        $nameL1ItemL3 = $gpscKey['nome_depart_prod'];
                                        $tagL1ItemL3 = $gpscKey['nome_clean_depa_prod'];

                                        $lyoutGeneroL3 .= "<option value='".$tagL1ItemL3."'>";
                                        $lyoutGeneroL3 .= $nameL1ItemL3;
                                        $lyoutGeneroL3 .= "</option>";


                                    }
                                }
                                $lyoutGeneroL3 .= "</select>"; 
                                echo $lyoutGeneroL3;
                                ?> 
                            </div><!--/ropa para--->
                            
                            <div class="form-group">
                                <label>Tipo de KIT</label>
                                <select name="tipokitl3" class="tipokitl3 form-control"></select>
                            </div>
                            
                            <div class="form-group">
                                <label>Grupo de tallas</label>
                                <select name="grupotallalist" class="grupotallalist form-control"></select>
                            </div>
                            
                            <div class="form-group">                        
                                <label>Tipo de tallas</label>
                                <p class="help-block">Esta opción es importante para la consulta por filtros del producto</p>
                                <select class="form-control" name="tipotalla">
                                    <option value="" selected>Selecciona una</option>
                                    <option value="tl">Tallas letras</option>
                                    <option value="tn">Tallas números</option>
                                    <option value="unica">Tallas unica</option>
                                </select>
                            </div>
                        </div>
                    </div>                                
                </div>

                <?php
                /*
                /*****************************//*****************************
                /FOOTER CONTENT - BOTTOM NAV
                /*****************************//*****************************
                */
                ?>
                <section class="bottonnav bottomtools" style="position:fixed; top:auto; bottom:0px; "><!---/main-footer navbar-fixed-bottom z-index:999; width:100%;-->
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
<!-- iCheck 1.0.1 -->
<script src="../../../appweb/plugins/iCheck/icheck.min.js"></script>
<!--jquery bonsai--->
<script src="../../../appweb/plugins/jquery-bonsai/jquery.bonsai.js"></script>
<!--fileimput--->
<script src="../../../appweb/plugins/fileimput/plugins/sortable.js" type="text/javascript"></script>        
<script src="../../../appweb/plugins/fileimput/fileinput.js" type="text/javascript"></script>        
<script src="../../../appweb/plugins/fileimput/themes/fa/theme.js"></script>    
<script src="../../../appweb/plugins/fileimput/locales/es.js"></script>      

<script type="text/javascript" src="crud-newlevel.js"></script>  
<!---switchmaster---> 
<script src="../../../appweb/plugins/switchmaster/js/bootstrap-switch.min.js" type="text/javascript"></script>    
    
<script type="text/javascript">
$(document).ready(function() {  
    //esquema explorador - bonsai 
    $('ul#categoesquema').bonsai({
        expandAll: true        
    });
    
    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    }); 
    
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


    //GESTIONA KITS USUARIO
    //========switchmaster
    $("[name='opcicatego']").bootstrapSwitch();
    
      
    //========OPCIONES CATEGORIAS 
    $("#wrapcat").hide();
    $("#wrapsubcat").hide();    
    $("#switchcat").on('switchChange.bootstrapSwitch', function(event, state) {
        if($(this).is(':checked')) {
            $("#wrapcat").show();        
            $("#wrapsubcat").hide(); 
        }else{
            $("#wrapcat").hide();            
        }
    });
    $("#switchsubcat").on('switchChange.bootstrapSwitch', function(event, state) {
        if($(this).is(':checked')) {
            $("#wrapsubcat").show(); 
            $("#wrapcat").hide();
        }else{
            $("#wrapsubcat").hide();            
        }
    });
    
    //CANCELA OPTION CATEGO
    $('button.canceloptioncatego').each(function(){
        var field = $(this).attr("data-this");  
                            
        $(this).click(function(){        
            switch(field){
                case "subcat":
                    $("#wrapsubcat").hide();        
                    $("#switchsubcat").bootstrapSwitch('toggleState');    
                break;
                case "cat":
                    $("#wrapcat").hide();        
                    $("#switchcat").bootstrapSwitch('toggleState');    
                break;
                    
            }
                        
        });
                         
    });
    
    //CERRAR EDITAR WRAP
    //$(".closeeditfieldbtn").hide();
    $('button.closeeditfieldbtn').each(function(){
        var field = $(this).attr("data-this");  

        $(this).click(function(){        
            switch(field){
                case "subcat":
                    $("#wrapsubcat").hide();        
                    $("#switchsubcat").bootstrapSwitch('toggleState');    
                break;
                case "cat":
                    $("#wrapcat").hide();        
                    $("#switchcat").bootstrapSwitch('toggleState');    
                break;

            }

        });

    });
    
    //CARGA SELECTS    
    $(".generopz").change(function(){
        var id=$(this).val();
        var dataString = 'idgpz='+ id+'&fieldq=gpz';
        //alert(dataString);
        $.ajax({
            type: "POST",
            url: "../../../appweb/inc/query-selects.php",
            data: dataString,
            cache: false,
            success: function(html){                
                $(".grupotallalist").html(html);               
            } 
        });
    });
    
    $(".generopz").change(function(){
        var id=$(this).val();
        var dataString = 'idgpz='+ id+'&fieldCatq=catl2';
        //alert(dataString);
        $.ajax({
            type: "POST",
            url: "../../../appweb/inc/query-selects.php",
            data: dataString,
            cache: false,
            success: function(html){
                
                $(".tipokitl3").html(html);                
            } 
        });
    });
    $("#listatallas").hide();
    $(".grupotallalist").change(function(){ 
        $("#listatallas").show();                
    });
                
 });           
</script>    
</body>
</html>
