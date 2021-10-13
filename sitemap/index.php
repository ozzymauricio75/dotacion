<?php require_once '../appweb/lib/MysqliDb.php'; ?>
<?php require_once '../cxconfig/config.inc.php'; ?>
<?php require_once '../cxconfig/global-settings.php'; ?>
<?php require_once '../appweb/inc/sessionvars.php'; ?>
<?php require_once '../appweb/lib/gump.class.php'; ?>
<?php require_once '../appweb/inc/site-tools.php'; ?>
<?php require_once '../appweb/inc/query-prods.php'; ?>
<?php require_once '../appweb/inc/valida-pedido-tmp.php'; ?>
<?php require_once '../appweb/inc/process-shop.php'; ?>
<?php require_once '../appweb/inc/proceso-compra.php'; ?>
<?php require_once '../appweb/inc/query-levels.php' ?>
<?php 

/*
*SITE MAP - ESQUEMA LINKS
*/
$actiSecc = "sitemap";

?>
<!DOCTYPE html>
<html lang="<?php echo LANG ?>">
<head>
    <meta charset="utf-8">
    <title>QUEST - Toma Pedidos</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">    
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <meta name="author" content="massin">
    <link rel="stylesheet" type="text/css" href="../appweb/plugins/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="../appweb/plugins/slick/slick-theme.css"/>
    <?php echo _CSSFILESLAYOUT_ ?>         
    <?php echo _FAVICON_TOUCH_ ?>
</head>
<body class="hold-transition skin-black layout-top-nav ">
    <!-- Site wrapper -->
    <div class="wrapper">
        <?php
        /*
            *
            *---------------------------
            *HEADER
            *---------------------------
            *    
        */  
    
        ?>
        <?php include '../appweb/tmplt/header-tomapedido.php'; ?>        
        <?php
        /*
            *
            *---------------------------
            *CONTAINS PAGE - WRAPER
            *---------------------------
            *    
        */  
        ?>        
        <div class="content-wrapper">
            <?php
            /*
                *
                *---------------------------
                *PAGE HEADER - BREAD CRUMB
                *---------------------------
                *    
            */             
            ?>
            <?php echo $headClienteActi_tmpl; ?>
            
            <section class=" row ">
                <div class="col-xs-12 unlateralpadding">
                    <div class=" maxwidth-layout">
                        <section class="content-header">
                            <h1 class="pull-left padd-right-xs">Dotaciones QUEST</h1>
                            
                            <ul class="nav nav-tabs  fa-lg">
                                <li role="presentation" class=""><a href="<?php echo $pathmm.$takeOrderDir."/inicio/?steps=dos"; ?>">Inicio</a></li>
                                <li role="presentation" class="active"><a href="#!">Mapa del sitio</a></li>
                                
                            </ul>
                            
                        </section>
                    </div>
                </div>  
            </section>
            
            
            <?php
            /*
                *
                *---------------------------
                *MAIN CONTENT
                *---------------------------
                *    
            */
            ?>    
            
            <section class="content bg-gray-light padd-top-xs padd-bottom-lg" > 
            
                <section class="container padd-bottom-lg">
                    <header class="catalagohead clearfix">                      
                        <h1>Mapa del sitio</h1>
                        <span>Catalogo dotaciones Quest</span>
                    </header>
                    
                    
                    
                    <div class="box50">
                        
                        
                        <div>
                        <?php 
                            //echo "<pre>";
                            //print_r($paquete_dotacion_noadd);   
                            //***********
                            //ESQUEMA CATGEGORIAS
                            //***********
                            //////////////////////////////////////////////////


                            $printLevelList = array();
                            $printLevelList = mapaDotacionUsuario();//getLevelsList();

                            $lyBrowseCat = "";
                            $lyBrowseCat .="<div class='box box75 padd-hori-md'>  
                                                <div class='box-header'></div>
                                                <div class='box-body'>
                                                <ul class='list-unstyled'>";


                                $prevVarGender = "";
                                $prevVarItemKit = "";
                                $prevVarItemCat = "";
                                $prevVarItemSub = "";

                                if(is_array($printLevelList)){
                                    foreach($printLevelList as $pllKeyUp){
                                        if(is_array($pllKeyUp)){
                                        foreach($pllKeyUp as $pllKey){
                                        
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
                                                                
                                                                $lyBrowseCat .= "<span id='wrappupdatenamel1".$idLevel1."'>".$nameLevel1."</span>";
                                                                $lyBrowseCat .= "<small id='wrappupdatedescril1".$idLevel1."' style='display:block;'>".$descriLevel1."</small>";
                                                                $lyBrowseCat .= "</h3>";

                                                                
                                                                $lyBrowseCat .= "<ul style='margin-top:20px;' class='list-unstyled'>";//INICIA CONTENEDOR LEVEL2

                                                                $prevVarGender = $idLevel1;                                    
                                                            }
                                                            //======FIN IMPRIME LAYOUT MASCULINO FEMENINO


                                                        //======IMPRIME ITEM KIT                   
                                                        $lyBrowseCat .= "<li style='margin-top:15px; text-transform: capitalize;' >";
                                                        
                                                        $lyBrowseCat .= "<a href='".$pathmm.$takeOrderDir."/inicio/?steps=tres&tagcat=".$kitLevel2."'>";  
                                                        $lyBrowseCat .= "<strong class='txtUppercase fa-lg'>".$kitLevel2."</strong>";
                                                        $lyBrowseCat .= "</a>";  
                                                        
                                                        $lyBrowseCat .= "<ul class='list-unstyled' style='margin-top:5px; padding-left:10px; padding-right:10px; padding-top:10px; padding-bottom:10px;'>";////wrap KIT DOTACION
                                                        
                                                        $prevVarItemKit = $kitLevel2;                            
                                                    }                       

                                                    //======IMPRIME ITEM KIT                        
                                                    $lyBrowseCat .= "<li id='wrapplevel2".$idLevel2."'>";
                                                    $lyBrowseCat .= "<div id='wpeditl2_".$idLevel2."' class='row no-padmarg padd-verti-xs' style='border:1px dashed #ccc; '>";
                                                    $lyBrowseCat .= "<div class='col-xs-9'>";
                                                    
                                                    $lyBrowseCat .= "<a href='".$pathmm.$takeOrderDir."/inicio/?l2=".$idLevel2."&tagcat=".$kitLevel2."&steps=cuatro'>";
                                                    
                                                    $lyBrowseCat .= "<p class='no-padmarg'>";
                                                    $lyBrowseCat .= "<strong id='wrappupdatenamel2".$idLevel2."'>".$nameLevel2."</strong>";
                                                    $lyBrowseCat .= "<span style='display:block;' id='wrappupdatesubnamel2".$idLevel2."'>".$descriLevel2."</span>";
                                                    $lyBrowseCat .= "</p>";
                                                    
                                                    $lyBrowseCat .= "</a>";
                                                    
                                                    $lyBrowseCat .= "</div>";
                                                    $lyBrowseCat .= "<div class='col-xs-3'>";
                                                    $lyBrowseCat .= "<span id='wrappupdatepzsl2".$idLevel2."'>".$pzsLevel2."</span>&nbsp;Pzs";
                                                    $lyBrowseCat .= "</div>";

                                                    $lyBrowseCat .= "</div>";//wpeditl2_

                                                    $lyBrowseCat .= "<ul class='list-unstyled padd-left-xs'>";//INICIA CONTENEDOR LEVEL 3

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

                                                        $lyBrowseCat .= "<div id='wpeditl3_".$idLevel3."' class='row no-padmarg padd-verti-xs' style=''>";
                                                        $lyBrowseCat .= "<div class='col-xs-12'>";

                                                        $lyBrowseCat .= "<a href='".$pathmm.$takeOrderDir."/browse/?catego=".$idLevel3."&l2=".$idLevel2."&tagcat=".$kitLevel2."&gender=".$tagLevel1."'>";
                                                        $lyBrowseCat .= "<h4 class='media-heading' id='wrappupdatenamel3".$idLevel3."'>".$nameLevel3."</h4>";
                                                        $lyBrowseCat .= "<span id='wrappupdatedescril3".$idLevel3."'>".$descriLevel3."</span>";
                                                        $lyBrowseCat .= "</a>";
                                                        

                                                        $lyBrowseCat .= "</div>";//col-xs-12

                                                        $lyBrowseCat .= "</div>";//wpeditl3_                      

                                                        $lyBrowseCat .= "</li>";////////ITEM PRENDA

                                                    }//fin foreach $datasLevel3
                                                }//fin is_array $datasLevel3

                                            }//fin foreach $datasLevel2
                                        }//fin is_array $datasLevel2  
                                    }
                                    } 
                                    }
                                }   

                            $lyBrowseCat .="</ul>";
                            $lyBrowseCat .="</div><!--//body-->";
                            $lyBrowseCat .="</div><!--//CATALOGO-->";

                            ///////////////////////////////////////////////////
                            
                            echo $lyBrowseCat;
                            
                        ?>
                        </div>
                        
                    </div>
                </section>
            </section>
        </div><!--/content-wrapper-->
        
        <?php
        /*
            *
            *---------------------------
            *FOOTER
            *---------------------------
            *    
        */
        ?>        
        <?php include "../appweb/tmplt/footer-tomapedido2.php"; ?>    

        
    </div><!-- /Site wrapper --> 
    
    
    <div class="modal fade" id="polidev" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">            
                <div class="modal-body">
                    <div id="showpolidev"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>                                
                </div>
            </div>
        </div>
    </div>
    <?php echo "<span id='pathfile' class='hidden'>".$pathmm."</span>"; ?>
    
    
    <?php
    /*
        *
        *---------------------------
        *CONTROL SIDE - LIST ORDER
        *---------------------------
        *    
    */
    ?>
    <?php include '../appweb/tmplt/order-list-tomapedido.php'; ?>
       
    <?php echo _JSFILESLAYOUT_ ?>     
    <script type="text/javascript" src="../appweb/plugins/form-validator/jquery.form-validator.min.js"></script>
    <script type="text/javascript" src="../appweb/plugins/slick/slick.js" ></script>
    <!-- pdf view -->
    <script type='text/javascript' src='../appweb/lib/pdfobject.min.js' ></script>            
    <script type='text/javascript'>
        var pathSite = $("#pathfile").html();
        var optionsPDFview = {
            height: "480px",
            pdfOpenParams: { view: 'FitV', page: '1' }
        };
        PDFObject.embed(pathSite+'legal/politicas-devolucion-quest.pdf', '#showpolidev', optionsPDFview);
    </script>
    <script type="text/javascript">                                               
    //como funcona
    $(document).ready(function(){
        $('.wrapgallery').slick({
            arrows: true,
            dots: false,
            infinite: false,
            speed: 500,
            fade: false,
            slidesToShow: 1,
             slidesToScroll: 1,
            adaptiveHeight: true
        });
    });
    </script>
    <script type="text/javascript">                
        //validaciones	
        $.validate({
            modules : 'logic, jsconf',            
            onModulesLoaded : function() {                
                var configIdenti = {           
                    validate : {
                        '.deptolist' : {
                            validation : 'required',
                            'error-msg' : 'Por favor selecciona un departamento'
                        }
                    }
                  };                
                $.setupValidation(configIdenti);
            }
        });
                
        
        $(document).ready(function(){
            //DOS SELECTS
            $("#youcity").hide();
            $(".deptolist").change(function(){
                var id=$(this).val();
                var dataString = 'depto='+ id;
                                            
                if($("#preselctcity").find(".ok").length){
                    $("#preselctcity"+" .ok").remove();
                    $("#preselctcity"+" .loader").remove();                    
                    $("#preselctcity").append("<div class='loader'><img src='../appweb/img/loadingcart.gif'/></div>").fadeIn("slow");
                }else{
                    $("#preselctcity").append("<div class='loader'><img src='../appweb/img/loadingcart.gif'/></div>").fadeIn("slow");                
                    
                }
                
                $.ajax({
                    type: "POST",
                    url: "../appweb/inc/select-city.php",
                    data: dataString,
                    cache: false,
                    success: function(html){  
                        $("#preselctcity"+" .loader").fadeOut(function(){                            
                            //$("#youcity").show();   
                            //$(".citylist").html(html);
                            if($(".citylist").html(html)){
                                $("#youcity").fadeIn();   
                            }
                        });                                                                      
                    } 
                });
            });            
        });                   
    </script>
    <script>
    $('a.sendbtn').click(function(e) {
        e.preventDefault(); 
        //var linkURL = $(this).attr('href');
        //var nameProd = $(this).attr('name');
        var titleEv = $(this).attr('title');
        var msjProd = $(this).attr('data-msj');
        //var reMsjProd = $(this).attr('data-remsj');
        confiSendOrder(titleEv, msjProd);
      });

    function confiSendOrder(titleEv, msjProd) {
        swal({
          title: titleEv, 
          text: '<span style=color:#DB4040; font-weight:bold;>Oops</span><br>' + msjProd, 
          type: 'warning',
          showCancelButton: false,
          closeOnConfirm: false,
          closeOnCancel: false,
          animation: false,
          html: true
        });
      }
        
        
    $('a.pzskit').click(function(e) {
        e.preventDefault(); 
        //var linkURL = $(this).attr('href');
        var nameProd = $(this).attr('name');
        var titleEv = $(this).attr('title');
        var msjProd = $(this).attr('data-msj');
        //var reMsjProd = $(this).attr('data-remsj');
        checkPzas(titleEv, nameProd, msjProd);
      });

    function checkPzas(titleEv, nameProd, msjProd) {
        swal({
          title: titleEv, 
          text: '<span style=color:#DB4040; font-weight:bold; font-size:15px;>' + nameProd + '</span><br>' + msjProd, 
          type: 'warning',
          showCancelButton: false,
          closeOnConfirm: false,
          closeOnCancel: false,
          animation: false,
          html: true
        });
      }
        
       $('#howwork').modal('show');
       $('#polidev').modal('hidden');

    </script>
</body>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/580923a9304e8e7585607da6/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
</html>
