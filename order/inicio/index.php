<?php require_once '../../appweb/lib/MysqliDb.php'; ?>
<?php require_once '../../cxconfig/config.inc.php'; ?>
<?php require_once '../../cxconfig/global-settings.php'; ?>
<?php require_once '../../appweb/inc/sessionvars.php'; ?>
<?php require_once '../../appweb/lib/gump.class.php'; ?>
<?php require_once '../../appweb/inc/site-tools.php'; ?>
<?php require_once '../../appweb/inc/query-prods.php'; ?>
<?php require_once '../../appweb/inc/valida-pedido-tmp.php'; ?>
<?php require_once '../../appweb/inc/process-shop.php'; ?>
<?php require_once '../../appweb/inc/proceso-compra.php'; ?>
<?php 

//IMPRIME KIT ROPA HABILITADOS PARA EL USUARIO
$k4u = "";
if(isset($_GET['k4u']) && $_GET['k4u']){
    $k4u = (string)$_GET['k4u'];
}
$printCatalogoHome = array();
$printCatalogoHome = catalogoQuery($typeColection, $k4u);

//RESET VARIABLES CONTROL
//$totalPZasOrder = 0;
//$totalPZasOrderGLOB = 0;
//$totalPzKit = 1;
//$cantPzCatego = 0;
//$totalPZasOrder = 1;


/*
*SITE MAP - ESQUEMA LINKS
*/
$actiSecc = "inicio";

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
    <link rel="stylesheet" type="text/css" href="../../appweb/plugins/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="../../appweb/plugins/slick/slick-theme.css"/>
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
        <?php include '../../appweb/tmplt/header-tomapedido.php'; ?>        
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
                                <li role="presentation" class="<?php echo $acti_home_migaja; ?>"><a href="<?php echo $pathmm.$takeOrderDir."/inicio/?steps=dos"; ?>">Inicio</a></li>
                                <?php echo $layout_migaja; ?>
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
            <!--<section class="content">                    
                <div class="box50 padd-verti-md padd-hori-xs text-center msjstart">
                    <i class="fa fa-info-circle fa-lg"></i>
                    <h3>Debes seleccionar un cliente para realizar el pedido</h3>        
                </div>
            </section> --> 
            <section class="content bg-gray-light padd-top-xs padd-bottom-lg" > 
            
                <section class="container padd-bottom-lg">
                    <header class="catalagohead clearfix">                      
                        <h1>Catálogo Dotación</h1>
                        <?php 
                            if($genderSSUser==1){
                                echo "<span>Colección</span>";// Masculino
                            }else if($genderSSUser==2){
                                echo "<span>Colección</span>";// Femenina
                            }
                        ?>

                    </header>
                    <?php if($ssGET == "uno"){ ?>
                     
                    
                    <!-- Widget: user widget style 1 -->
                    <div class="box box-widget widget-user">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-yellow">
                            <h2 class="no-padmarg">BIENVENIDO</h2>
                            <h3 class="widget-user-username"><?php echo $nameSSUser; ?></h3>
                            <!--<h5 class="widget-user-desc">Founder &amp; CEO</h5>-->
                        </div>
                        <div class="widget-user-image">
                            <img class="img-circle" src="../../appweb/img/def-ciudad.png" alt="User Avatar">
                        </div>
                        <div class="box-body">

                            <div class="box50 padd-verti-md">
                                <div class="alert no-padmarg">
                                    <div class="media">
                                        <div class=" media-left">
                                            <i class="fa fa-bell-o fa-4x text-blue"></i>
                                        </div>
                                        <div class="media-body">
                                            <h3 class="no-padmarg">Hola!</h3>
                                            <p style="font-size:1.232em;">Para darte un mejor servicio. Necesitamos que nos indiques la ciudad donde deseas que llegue tu dotación.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">            
                            <div class="row box25">
                                <form method="get" action="<?php echo $pathFile; ?>" id="to_cityuser">                
                                <div class="col-sm-12">
                                    <div class="form-group" id="preselctcity">
                                        <select class="deptolist form-control" name="deptouser">
                                            <option value="" selected>Selecciona un Departamento</option>
                                            <?php
                                                //SELECT `id_estado_user`, `id_estado_rel`, `name_estado_user`, `tag_estado_user` FROM `estado_user` WHERE 1

                                                $db->orderBy("name_estado_user","Asc");	                                          
                                                $septoSelect = $db->get("estado_user");

                                                if ($db->count > 0){
                                                    foreach ($septoSelect as $dptoKey) { 
                                                        $idDptoSelect = $dptoKey['id_estado_rel'];
                                                        $nomeDptoSelect = $dptoKey['name_estado_user'];

                                                        echo "<option value='".$idDptoSelect."'>".$nomeDptoSelect."</option>";	
                                                    }
                                                }	
                                            ?>                                        
                                        </select>                        
                                    </div>
                                    <div  id="youcity">
                                        <div class="form-group">
                                            <select class="citylist form-control" name="cityuser" data-validation-depends-on="deptouser" data-validation="required" data-validation-error-msg="Selecciona una ciudad"></select>
                                        </div>
                                        <div class="form-group text-center">
                                            <button type="submit" class="btn btn-md btn-warning">OK</button>
                                        </div>
                                    </div>                     
                                </div> 
                                <input type="hidden" name="defcity" value="ok" />    
                                <input type="hidden" name="steps" value="dos" />
                                </form>
                            </div>
                            <!-- /.row -->
                        </div>
                    </div>
                    <!-- /.widget-user -->


                    <!--<div class="howwork">-->
                    <div class="modal fade" id="howwork" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">                                
                                    <h4 class="modal-title no-padmarg" id="myModalLabel">Dotaciones QUEST<smal style="display:block;">Aprende cómo realizar tu pedido de dotación</smal></h4>
                                </div>
                                <div class="modal-body">

                                    <div class="wrapgallery">
                                        <div>                                        
                                            <div class=" wrapitemhw bg-blue padd-verti-md">
                                                <h5 class="headeritemhw">Tu ciudad</h5>
                                                <div class="bodyitemhw  ">
                                                    <i class="fa fa-map-marker"></i>    
                                                    <p>Selecciona la ciudad donde deseas que tu dotación sea enviada</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class=" wrapitemhw bg-green padd-verti-md">
                                                <h5 class="headeritemhw">Paquetes de KITs</h5>
                                                <div class="bodyitemhw  ">
                                                    <i class="fa fa-th-large"></i>    
                                                    <p>Identifica los KITs que te fueron asignados. Ingresa a cada uno de ellos para conocer cuales prendas tienes disponibles</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class=" wrapitemhw bg-yellow padd-verti-md">
                                                <h5 class="headeritemhw">Prendas</h5>
                                                <div class="bodyitemhw  ">
                                                    <i class="fa fa-search"></i>    
                                                    <p>Selecciona la talla y el color que buscas, resuelve dudas con nuestra <br><b>GUIA DE TALLAS</b>.<br>Cuando encuentres tu prenda presiona AGREGAR.<br>El resumen de tu pedido estará siempre disponiblepresionando el boton  <i class="fa fa-shopping-cart fa-lg"></i></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <div class=" wrapitemhw bg-red padd-verti-md">
                                                <h5 class="headeritemhw">Navegación</h5>
                                                <div class="bodyitemhw  ">
                                                    <div class="row">
                                                        <div class="col-xs-3">
                                                            <i class="fa fa-th-large"></i>
                                                        </div>
                                                        <div class="col-xs-3">
                                                            <img src="../../appweb/img/ropa-masculino.png" />
                                                        </div>                                                    
                                                        <div class="col-xs-3">
                                                            <i class="fa fa-percent"></i>
                                                        </div>
                                                        <div class="col-xs-3">
                                                            <i class="fa fa-comment-o"></i>
                                                        </div>
                                                    </div>                                                    
                                                    <p>Conoce la cantidad de piezas disponibles por KIT, Sigue constantemente el proceso de tu pedido y las piezas que seleccionaste. Necsitas ayuda?, tenemos un CHAT en tiempo real para resolver tus dudas</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <div class=" wrapitemhw bg-black padd-verti-md">                                            
                                                <div class="bodyitemhw  ">
                                                    <i class="fa fa-envelope"></i>                                                      
                                                    <p>Cuando hayas completado la totalidad de piezas que te asignaron, presiona <i class="fa fa-shopping-cart fa-lg"></i> y luego presiona <b>ENVIAR</b>, la confirmación de tu pedido llegará a tu correo Email.<br>
                                                    Es fácil, es rapido, y ahora es el momento de experimentar</p>
                                                    <button type="button" class="endhw" data-dismiss="modal">OK</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">SALTAR</button>                                
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--</div>-->

                    <?php } ?>

                    <?php if($ssGET == "dos"){ ?>
	                    <?php //if($layout_categoria_usuario != ""){ 
	                    if(is_array($grupoCategoriasUsuario) && count($grupoCategoriasUsuario)>0){
	                    ?>

	                    <div class="box50">
	                        <div class="alert alert-dismissible bg-gray">
	                            <div class="media">
	                                <div class=" media-left">
	                                    <i class="fa fa-bell-o fa-4x text-blue"></i>
	                                </div>
	                                <div class="media-body">
	                                    <h3 class="no-padmarg">Hola!</h3>
	                                    <p style="font-size:1.232em; line-height:1;">Tienes habilitadas las siguientes prendas para tu dotación.<br>
	                                        <span class="text-info">Recuerda seleccionar la totalidad de prendas disponibles, para poder realizar el pedido</span>
	                                    </p>
	                                    <button  data-dismiss="alert" class="close pull-left" aria-hidden="true">Entiendo :&#41;</button>
	                                </div>
	
	                            </div>
	                        </div>
	                    </div>
	                    <?php  echo $layout_categoria_usuario; ?>
	                    <?php }else{ ?>
	                    <div class="box50">
	                        <div class="alert alert-dismissible bg-gray">
	                            <div class="media">
	                                <div class=" media-left">
	                                    <i class="fa fa-bell-o fa-4x text-red"></i>
	                                </div>
	                                <div class="media-body">
	                                    <h3 class="no-padmarg">Hola!</h3>
	                                    <p style="font-size:1.232em; line-height:1;">Tu dotación aun no fue asignada<br>
	                                        <span class="text-info">Por favor entra en contacto con soporte para más ayuda. Gracias</span>
	                                    </p>
	                                    <button  data-dismiss="alert" class="close pull-left" aria-hidden="true">Entiendo :&#41;</button>
	                                </div>
	
	                            </div>
	                        </div>
	                    </div>
	                    <?php } ?>

                    <?php } ?>

                    <?php if($ssGET == "tres"){ ?>

                    <div class="main">
                        <ul class="cbp-ig-grid">                                            
                        <?php echo $layout_kit_usuario; ?>                                                
                        </ul>
                    </div>

                    <?php } ?>

                    <?php if($ssGET == "cuatro"){ ?>

                    <div class="row box50 padd-verti-md">                                            
                        <?php echo $tmplLayoutItem; ?>
                    </div>

                    <?php } ?>

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
        <?php include "../../appweb/tmplt/footer-tomapedido2.php"; ?>    

        
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
    <?php include '../../appweb/tmplt/order-list-tomapedido.php'; ?>
       
    <?php echo _JSFILESLAYOUT_ ?>     
    <script type="text/javascript" src="../../appweb/plugins/form-validator/jquery.form-validator.min.js"></script>
    <script type="text/javascript" src="../../appweb/plugins/slick/slick.js" ></script>
    <script type="text/javascript" src="crud-order.js"></script>
    <!-- pdf view -->
    <script type='text/javascript' src='../../appweb/lib/pdfobject.min.js' ></script>            
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
                    $("#preselctcity").append("<div class='loader'><img src='../../appweb/img/loadingcart.gif'/></div>").fadeIn("slow");
                }else{
                    $("#preselctcity").append("<div class='loader'><img src='../../appweb/img/loadingcart.gif'/></div>").fadeIn("slow");                
                    
                }
                
                $.ajax({
                    type: "POST",
                    url: "../../appweb/inc/select-city.php",
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
