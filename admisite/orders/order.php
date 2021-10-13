<?php require_once '../appweb/lib/MysqliDb.php'; ?>
<?php require_once '../cxconfig/config.inc.php'; ?>
<?php require_once '../cxconfig/global-settings.php'; ?>
<?php require_once '../appweb/inc/sessionvars.php'; ?>
<?php require_once '../appweb/lib/gump.class.php'; ?>
<?php require_once '../appweb/inc/site-tools.php'; ?>
<?php require_once '../appweb/inc/query-orders.php'; ?>
<?php require_once '../i18n-textsite.php'; ?>

<?php 
//***********
//ESPECIFICACIONES ITEM 
//***********
$itemVarGET = "";
if(isset($_GET['coditemget'])){

    $itemVarGET = (int)$_GET['coditemget'];
    $itemVarGET = $db->escape($itemVarGET);
            
}

$dataOrders = array();
$dataOrders = ordersQuery($itemVarGET);

if(is_array($dataOrders)){
    foreach($dataOrders as $doKey){
        //SOBRE EL PEDIDO
        $idItem = $doKey['id_solici_promo'];
        $statusOrder = $doKey['estado_solicitud'];
        $refOrder = $doKey['cod_orden_compra'];
        $nameClientOrder = $doKey['nome_cliente'];
        $telClientOrder = $doKey['tel_cliente'];
        $mailCLientOrder = $doKey['mail_cliente'];
        $nameSotreOrder = $doKey['nome_empresa'];
        $repreStoreOrder = $doKey['representante_empresa'];
        $cityDeliveryOrder = $doKey['ciudad_empresa'];
        $dateOrder = $doKey['fecha_solicitud'];
        $timeOrder = $doKey['hora_solicitud']; 
        
        $dataSotreOrder = $doKey['datastore'];
        $dataUserOrder = $doKey['datauser'];
        $dataPackKitOrder = $doKey['datapackit'];
        $dataItemsOrder = $doKey['datadetaorder'];                
        
        //SOBRE LA TIENDA        
        $layoutDataStore = "";
        if(is_array($dataSotreOrder)){
            $layoutDataStore .= "<address>";
            
            foreach($dataSotreOrder as $dsokey){                
                $nameStore = $dsokey['nombre_account_empre'];
                $nitStore = $dsokey['nit_empresa'];
                $logoStore = $dsokey['logo_account_empre'];
                $mailStore = $dsokey['mail_account_empre'];
                $tel1Store = $dsokey['tel_account_empre1'];
                $tel2Store = $dsokey['tel_account_empre2'];
                $dirStore = $dsokey['dir_account_empre'];
                $cityStore = $dsokey['ciudad_account_empre'];
                
                $layoutDataStore .= $nameStore."<br>";
                $layoutDataStore .= "Nit.&nbsp;&nbsp;".$nitStore."<br>";
                $layoutDataStore .= "Email.&nbsp;&nbsp;".$mailStore."<br>";
                $layoutDataStore .= "Tel.&nbsp;&nbsp;".$tel1Store."<br>";
                if(isset($tel2Store)){
                $layoutDataStore .= "Tel.&nbsp;&nbsp;".$tel2Store."<br>";
                }
                $layoutDataStore .= $dirStore."<br>";
                $layoutDataStore .= $cityStore."<br>";                                                        
            }
            
            $layoutDataStore .= "</address>";
        }
        
        //SOBRE EL USUARIO       
        $layoutDataUser = "";
        if(is_array($dataUserOrder)){
            $layoutDataUser .= "<address>";                                            
            foreach($dataUserOrder as $duokey){                
                $nameUser = $duokey['nombre_account_user'];
                $documentUser = $duokey['cedula_user'];                
                $mailUser = $duokey['mail_account_user'];
                $tel1User = $duokey['tel_account_user'];
                $tel2User = $duokey['tel_account_user2'];
                $dirUser = $duokey['dir_account_user'];
                $cityUser = $duokey['ciudad_account_user'];
                
                $layoutDataUser .= $nameUser."<br>";
                $layoutDataUser .= "Cedula.&nbsp;&nbsp;".$documentUser."<br>";
                $layoutDataUser .= "Email.&nbsp;&nbsp;".$mailUser."<br>";
                $layoutDataUser .= "Tel.&nbsp;&nbsp;".$tel1User."<br>";
                if(isset($tel2User)){
                $layoutDataUser .= "Tel.&nbsp;&nbsp;".$tel2User."<br>";
                }
                $layoutDataUser .= $dirUser."<br>";
                $layoutDataUser .= $cityUser."<br>";                                                        
            }
            
            $layoutDataUser .= "</address>";
        }
        
        
        //SOBRE EL PEDIDO        
        $layoutDataItemsOrder = "";
        $totalItemsORder = count($dataItemsOrder);
        $cantItem = 1;
        if(is_array($dataItemsOrder)){
                                                                               
            foreach($dataItemsOrder as $eokey){                
                
                $idOrder = $eokey['id_solici_promo'];
                $cantItemOrder = $eokey['cant_pedido'];
                $idItemOrder = $eokey['id_prod_filing'];
                //$nameItemOrder = $eokey['nombre_account_user'];
                $skuItemOrder = $eokey['cod_venta_prod_filing'];
                $skuFullItemOrder = $eokey['cod_venta_descri_filing'];
                $climaItemOrder = $eokey['tipo_kit_4user'];
                $kitItemOrder = $eokey['nome_catego_product'];
                $generoKitOrder = $eokey['tags_depatament_produsts'];
                $labelItemOrder = $eokey['foto_producto_filing'];
                
                
                $layoutDataItemsOrder .= "<tr>"; 
                $layoutDataItemsOrder .= "<td>".$cantItem."</td>";
                $layoutDataItemsOrder .= "<td>".$cantItemOrder."</td>";
                $layoutDataItemsOrder .= "<td>";//categoria
                $layoutDataItemsOrder .= "<span class='txtCapitalice margin-right-xs'>".$generoKitOrder."</span>";
                $layoutDataItemsOrder .= "<span class='txtCapitalice margin-right-xs'>".$climaItemOrder."</span>";
                $layoutDataItemsOrder .= "<span class='txtCapitalice margin-right-xs'>".$kitItemOrder."</span>";
                $layoutDataItemsOrder .= "</td>";//fin categoria
                $layoutDataItemsOrder .= "<td>".$skuItemOrder."</td>";
                $layoutDataItemsOrder .= "<td>".$skuFullItemOrder."</td>";
                $layoutDataItemsOrder .= "</tr>";
                
                                    
                $cantItem += $cantItem;
                                                                      
            }
            
            
        }
        
        
    }
}
//echo "<pre>";
//print_r($dataItemsOrder);

//***********
//SITE MAP
//***********

$rootLevel = "pedidos";
$sectionLevel = "";
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
            
            <!--<div class="nav navbar-nav navbar-right margin-right-xs">                
                <a href="new.php" class="btn btn-info" type="button" >
                    <i class="fa fa-plus margin-right-xs"></i>
                    Publicar
                </a>                
            </div>-->
            
            <h1>
                <small>Pedidos </small> / Detalles
            </h1> 
            <a href="<?php echo $pathmm.$admiDir."/orders/"; ?>" class="ch-backbtn">
                <i class="fa fa-arrow-left"></i>
                Lista de pedidos
            </a> 
        </section>

        <?php
        /*
        /*****************************//*****************************
        /MAIN WRAPPER CONTEN
        /*****************************//*****************************
        */
        ?>
        
        <section class="invoice margin-verti-md">
            <!-- this row will not appear when printing -->
            <div class="row no-print margin-bottom-xs">
                <div class="col-xs-12">
                    <!--<a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
                    <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment
                    </button>
                    <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
                        <i class="fa fa-download"></i> Generate PDF
                    </button>-->
                    
                    <a href="<?php echo $pathmm.$admiDir."/orders/printorder.php?coditemget=".$idItem; ?>" type="button" class="btn btn-default btn-sm pull-right" data-toggle="tooltip" title="Imprime desde el navegador" target="_blank">
                        <i class="fa fa-print fa-lg margin-right-xs" ></i> Imprimir
                    </a>                    
                </div>
            </div>
            <!-- title row -->
            <div class="row">
                <div class="col-xs-12">                    
                    <img src="<?php echo $pathmm."appweb/img/logo_final3.png"; ?>" style="height:55px;">
                    <h2 class="page-header">                        
                        Orden de pedido Dotaciones Quest
                        <small class="pull-right">Fecha:&nbsp;&nbsp;<?php echo $dateOrder."&nbsp;&nbsp;/&nbsp;&nbsp;".$timeOrder; ?></small>
                    </h2>
                </div>
            <!-- /.col -->
            </div>
            
            
            
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-3 invoice-col">
                    <strong>Quest S.A.S</strong>
                    <address>
                        <!--<strong>Admin, Inc.</strong><br>-->
                        Nit. 805022296<br>
                        CALLE 24N # 5AN - 30<br>
                        Santiago de Cali - Valle del Cauca<br>
                        Tel: (572) 489 5000<br>
                        Email: licitaciones@quest.com.co
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-3 invoice-col">
                    <strong>Entidad Compradora</strong>
                    <?php echo $layoutDataStore; ?>
                </div>
                <!-- /.col -->
                <div class="col-sm-3 invoice-col">
                    <strong>Cliente</strong>
                    <?php echo $layoutDataUser; ?>
                </div>
                <!-- /.col -->
                <div class="col-sm-3 invoice-col">      
                    <p class="text-muted well well-sm no-shadow">
                        <b>Pedido #<?php echo $refOrder; ?></b><br>
                        <br>
                        <b>Fecha solicitud:</b> <?php echo $dateOrder; ?><br>
                        <b>Ciudad de envio:</b> <?php echo $cityDeliveryOrder; ?><br>       
                    </p>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Cant.</th>
                                <th>Categoría</th>
                                <th>Referencia</th>
                                <th>Descripción</th>                                
                            </tr>
                        </thead>
                        <tbody>
                        <?php echo $layoutDataItemsOrder; ?>                            
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
                        
        </section>
        <div class="clearfix"></div>
                           
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
        "ordering": true,
        "autoWidth": false
    });
  });
</script>    
</body>
</html>
