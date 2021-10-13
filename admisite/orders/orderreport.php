<?php require_once '../appweb/lib/MysqliDb.php'; ?>
<?php require_once '../cxconfig/config.inc.php'; ?>
<?php require_once '../cxconfig/global-settings.php'; ?>
<?php require_once '../appweb/inc/sessionvars.php'; ?>
<?php require_once '../appweb/lib/gump.class.php'; ?>
<?php require_once '../appweb/inc/site-tools.php'; ?>
<?php require_once '../appweb/inc/query-orders.php'; ?>
<?php require_once '../i18n-textsite.php'; ?>

<?php 
//recibe datos de PEDIDOS
$idOrder = "";
$dataOrders = array();
$dataOrders = ordersQuery($idOrder);



//echo "<pre>";
//print_r($dataOrders);

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
    
<body onload="window.print();"> 

    
<div class="wrapper">            
    
        <?php
        /*
        /*****************************//*****************************
        /MAIN WRAPPER CONTEN
        /*****************************//*****************************
        */
        ?>
        <section class="content">

            <div class="box">
                <div class="box-header margin-bottom-xs">
                    <h3 class="box-title">Ordenes de pedido realizadas</h3>                    
                </div>                
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th># Pedido</th>
                                <th>Ciudad Envio</th>
                                <th>Cant.</th>
                                <th>Ref.</th>
                                <th>Ropa</th>
                                <th>Clima</th>
                                <th>Kit</th>
                                <th>Descripción</th>
                                <th>Funcionario</th>
                                <th>Cedula</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th>Ciudad</th>
                                <th>Entidad compradora</th>
                                <th>Nit</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th>Ciudad</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
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
                                if(is_array($dataSotreOrder)){            

                                    foreach($dataSotreOrder as $dsokey){                
                                        $nameStore = $dsokey['nombre_account_empre'];
                                        $nitStore = $dsokey['nit_empresa'];
                                        $logoStore = $dsokey['logo_account_empre'];
                                        $mailStore = $dsokey['mail_account_empre'];
                                        $tel1Store = $dsokey['tel_account_empre1'];
                                        $tel2Store = $dsokey['tel_account_empre2'];
                                        $dirStore = $dsokey['dir_account_empre'];
                                        $cityStore = $dsokey['ciudad_account_empre'];

                                    }

                                }

                                //SOBRE EL USUARIO               
                                if(is_array($dataUserOrder)){

                                    foreach($dataUserOrder as $duokey){                
                                        $nameUser = $duokey['nombre_account_user'];
                                        $documentUser = $duokey['cedula_user'];                
                                        $mailUser = $duokey['mail_account_user'];
                                        $tel1User = $duokey['tel_account_user'];
                                        $tel2User = $duokey['tel_account_user2'];
                                        $dirUser = $duokey['dir_account_user'];
                                        $cityUser = $duokey['ciudad_account_user'];

                                    }

                                }


                                //SOBRE EL PEDIDO                
                                $totalItemsORder = count($dataItemsOrder);
                                $cantItem = 1;
                                $layoutReport = "";
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


                                        $layoutReport .= "<tr>";
                                        $layoutReport .= "<td>".$dateOrder."</td>";
                                        $layoutReport .= "<td>".$timeOrder."</td>";
                                        $layoutReport .= "<td>".$refOrder."</td>";
                                        $layoutReport .= "<td>".$cityDeliveryOrder."</td>";
                                        $layoutReport .= "<td>".$cantItemOrder."</td>";
                                        $layoutReport .= "<td>".$skuItemOrder."</td>";
                                        $layoutReport .= "<td>".$generoKitOrder."</td>";
                                        $layoutReport .= "<td>".$climaItemOrder."</td>";
                                        $layoutReport .= "<td>".$kitItemOrder."</td>";
                                        $layoutReport .= "<td>".$skuFullItemOrder."</td>";
                                        $layoutReport .= "<td>".$nameUser."</td>";
                                        $layoutReport .= "<td>".$documentUser."</td>";
                                        $layoutReport .= "<td>".$mailUser."</td>";
                                        $layoutReport .= "<td>".$tel1User."</td>";
                                        $layoutReport .= "<td>".$dirUser."</td>";
                                        $layoutReport .= "<td>".$cityUser."</td>";
                                        $layoutReport .= "<td>".$nameStore."</td>";
                                        $layoutReport .= "<td>".$nitStore."</td>";
                                        $layoutReport .= "<td>".$mailStore."</td>";
                                        $layoutReport .= "<td>".$tel1User."</td>";
                                        $layoutReport .= "<td>".$dirStore."</td>";
                                        $layoutReport .= "<td>".$cityStore."</td>";
                                        $layoutReport .= "</tr>";
                                        
                                        echo $layoutReport;
                                        
                                        $cantItem += $cantItem;

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
   
</body>
</html>
