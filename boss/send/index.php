<?php if(isset($_GET['readysend']) && $_GET['readysend'] == "ok"){ ?>

<?php require_once '../../appweb/lib/MysqliDb.php'; ?>
<?php require_once '../../cxconfig/config.inc.php'; ?>
<?php require_once '../../cxconfig/global-settings.php'; ?>
<?php require_once '../../appweb/lib/gump.class.php'; ?>
<?php require_once '../../appweb/inc/site-tools.php'; ?>
<?php require_once '../../appweb/inc/sessionvars-boss.php'; ?>
<?php require_once '../../appweb/inc/query-prods-boss.php'; ?>
<?php require_once '../../appweb/inc/valida-pedido-tmp-boss.php'; ?>

<?php require_once 'send.php'; ?>
<?php 
$totalPZasOrder = 0;
$totalPZasOrderGLOB = 0;
$totalPzKit = 1;

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
        <?php include '../../appweb/tmplt/header-boss.php'; ?>        
        <?php
        /*
            *
            *---------------------------
            *CONTAINS PAGE - WRAPER
            *---------------------------
            *    
        */  
        ?>        
        <div class="content-wrapper padd-bottom-lg">
            <?php
            /*
                *
                *---------------------------
                *PAGE HEADER - BREAD CRUMB
                *---------------------------
                *    
            */  
            ?>
            
            <?php
            /*
                *
                *---------------------------
                *MAIN CONTENT
                *---------------------------
                *    
            */
            ?>    
            <?php if(!isset($statusmail) || $statusmail ==2){ ?>                      
            <div class="box50 padd-verti-lg">
                <div class="alert  bg-danger">
                    <div class="media">
                        <div class=" media-left">
                            <i class="fa fa-bell-o fa-4x text-red"></i>
                        </div>
                        <div class="media-body">
                            <h3 class="no-padmarg">Ooops!</h3>
                            <p style="font-size:1.232em; line-height:1;">Lamentamos informarte, que no logramos enviarte la confirmación de tu pedido a tu cuenta Email. Parece que algo salio mal con el servidor en el momento de intentar enviar la solicitud. Pero no te preocupes tu pedido, fue registrado en nuestra base de datos.<br><br>
                                Si deseas recibir la confirmación de tu pedido, por favor contacta con <b>SOPORTE TÉCNICO QUEST</b>, intentaremos resolver los inconvenientes.                                
                            </p>                            
                        </div>
                    </div>                    
                </div>
                <a href="../logout/?uss=out" class="guia-tallas">CONTINUAR <i class="fa fa-arrow-right fa-lg" ></i></a>
            </div>
            <?php }else if(isset($statusmail) && $statusmail ==1){  ?>  
            <div class="box75 padd-top-lg">
                <!-- Widget: user widget style 1 -->
                <div class="box box-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-green">
                        <h2 class="no-padmarg">FELICIDADES</h2>
                        <h3 class="widget-user-username"><?php echo $nameSSUser; ?></h3>
                        <h5 class="widget-user-desc">Orden de pedido: <?php echo $codePedidoSend; ?></h5>
                    </div>
                    <div class="widget-user-image img-circle bg-white">                        
                        <i class="fa fa-check fa-5x text-green padd-hori-xs padd-verti-xs"></i>
                    </div>
                    <div class="box-body">

                        <div class="box50 padd-verti-md">
                            <div class="alert no-padmarg">
                                <div class="media">
                                    <div class=" media-left">
                                        <i class="fa fa-bell-o fa-4x text-blue"></i>
                                    </div>
                                    <div class="media-body">
                                        <h3 class="no-padmarg">Orden de pedido enviada con exito</h3>
                                        <p style="font-size:1.232em;">Recibirás en tu cuenta Email la confirmación de tu pedido. Para QUEST ha sido un placer atenderte.<br><br> A continuación te mostramos el resumen de tu orden</p>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class=" box25 pull-right">
                            <a href="../logout/?uss=out" type="submit" class="btn btn-md btn-success">CONTINUAR <i class="fa fa-arrow-right fa-lg margin-left-xs"></i></a>
                        </div>
                    </div>                    
                </div>
                <!-- /.widget-user -->
            </div>
            
            <?php                 
                $printResuOrder = "<div class='box box75 padd-top-lg'>";
                $printResuOrder .=$tmplatesend;
                $printResuOrder .= "</div>";
                echo $printResuOrder;
            ?>
            
            <?php } ?>                      
            
            
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
        <?php include '../../appweb/tmplt/footer-tomapedido2.php'; ?>
            
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
    <!-- pdf view -->
    <script type='text/javascript' src='../../appweb/lib/pdfobject.min.js' ></script>            
    <script type='text/javascript'>
        var pathSite = $("#pathfile").html();
        var optionsPDFview = {
            height: "480px",
            pdfOpenParams: { view: 'FitV', page: '1' }
        };
        PDFObject.embed(pathSite+'legal/politicas-devolucion-quest.pdf', '#showpolidev', optionsPDFview);
        
        $('#polidev').modal('hidden');                   
    </script>
</body>
</html>
<?php }else{  ?>
<?php 
echo ":{/";
?>
<?php } ?>