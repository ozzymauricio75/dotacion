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
//$dataOrders = unique_multidim_array($dataOrders, 'cod_orden_compra');

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
            Pedidos            
            </h1>                                    
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
                <div class="box-header margin-bottom-xs">
                    <h3 class="box-title">Ordenes de pedido realizadas</h3>
                    <div class="box-tools pull-right">                        
                        <!--<a href="<?php //echo $pathmm.$admiDir."/orders/orderreport.php"; ?>" type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Imprime desde el navegador" target="_blank">
                            <i class="fa fa-print fa-lg" ></i>
                        </a>-->
                        <a href="<?php echo $pathmm.$admiDir."/orders/orderreport-xls.php"; ?>" type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Archivo Excel" target="_blank">
                            <i class="fa fa-download fa-lg margin-right-xs" ></i> <span class="fa-lg">Exportar</span>
                        </a>
                    </div>
                </div>                
                <div class="box-body ">
                    <table id="printdatatbl" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Código</th>
                                <th>Usuario</th>
                                <th>Entidad</th>
                                <th>Status</th>
                                <th style='width:80px;'>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(is_array($dataOrders)){
                            foreach($dataOrders as $qKey){//$doKey
                                /*//SOBRE EL PEDIDO
                                $idItem = $doKey['id_solici_promo'];
                                $statusOrder = $doKey['estado_solicitud'];
                                $refOrder = $doKey['cod_orden_compra'];
                                $nameClientOrder = $doKey['nome_cliente'];
                                $telClientOrder = $doKey['tel_cliente'];
                                $mailCLientOrder = $doKey['mail_cliente'];
                                $nameSotreOrder = $doKey['nome_empresa'];
                                $repreStoreOrder = $doKey['representante_empresa'];
                                $cityDeliveryOrder = $doKey['ciudad_solicitud'];
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
                                        
                                        
                                        //STAUTS PRODUCTO (ACTIVO = SUSPENDIDO)
                                        switch($statusOrder){
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
                                                $printStatusItem = "<span class='label label-info'>Revisión</span>";
                                            break;
                                            case "6":
                                                $printStatusItem = "<span class='label label-danger'>Agotado</span>";
                                            break;																	
                                        }
                                        
                                        //LAYOUT TABLE ITEM                                    
                                        $layoutDataItem = "";
                                        $layoutDataItem .= "<tr>";
                                        $layoutDataItem .= "<td><p>".$dateOrder." / ".$timeOrder."</p></td>";
                                        $layoutDataItem .= "<td><p>".$refOrder."</p></td>";

                                        $layoutDataItem .= "<td>";//usuario                                  
                                        $layoutDataItem .= "<strong >".$nameClientOrder."</strong>";
                                        $layoutDataItem .= "<p>Tel:&nbsp;&nbsp;".$telClientOrder."</p>";
                                        $layoutDataItem .= "<p>Email:&nbsp;&nbsp;".$mailCLientOrder."</p>";
                                        $layoutDataItem .= "<p>Ciudad Envio:&nbsp;&nbsp;".$cityDeliveryOrder."</p>";
                                        $layoutDataItem .= "</td>";//fin usuario

                                        $layoutDataItem .= "<td>";//store                                
                                        $layoutDataItem .= "<strong >".$nameSotreOrder."</strong>";
                                        $layoutDataItem .= "<p>Representante:&nbsp;&nbsp;".$repreStoreOrder."</p>";                                        
                                        $layoutDataItem .= "</td>";//store

                                        $layoutDataItem .= "<td>";//status
                                        $layoutDataItem .= "<p>Status: ".$printStatusItem."</p>";                                        
                                        $layoutDataItem .= "</td>";//fin stratus

                                        $layoutDataItem .= "<td>";//opciones

                                        $layoutDataItem .= "<div class='btn-group'>";
                                        $layoutDataItem .= "<a href='order.php?coditemget=".$idItem."' type='button' class='btn btn-info'>Más detalles</a>";
                                        $layoutDataItem .= "<button type='button' class='btn btn-info dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
                                        $layoutDataItem .= "<span class='caret'></span>";
                                        $layoutDataItem .= "<span class='sr-only'>edititem</span>";
                                        $layoutDataItem .= "</button>";
                                        $layoutDataItem .= "<ul class='dropdown-menu pull-right'>";
                                        //$layoutDataItem .= "<li><a href='#'>Detalles</a></li>";
                                        //$layoutDataItem .= "<li><a href='item-edit.php?coditemget=".$idItem."'><i class='fa fa-pencil margin-right-xs'></i>Editar</a></li>";                                    
                                        //$layoutDataItem .= "<li role='separator' class='divider'></li>";
                                        $layoutDataItem .= "<li><a href='#'><i class='fa fa-trash margin-right-xs'></i>Eliminar</a></li>";
                                        $layoutDataItem .= "</ul>";
                                        $layoutDataItem .= "</div>";//btn-group

                                        $layoutDataItem .= "</td>";//fin opciones


                                        $layoutDataItem .= "</tr>";

                                        echo $layoutDataItem;

                                                                                
                                        $cantItem += $cantItem;

                                    }


                                }*/
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                //if(is_array($doKey)){
                                    //foreach($doKey as $doVal){
                                //SOBRE EL PEDIDO
                                $idItem = $qKey['id_solici_promo'];
                                $statusOrder = $qKey['estado_solicitud'];
                                $refOrder = $qKey['cod_orden_compra'];
                                $nameClientOrder = $qKey['nome_cliente'];
                                $telClientOrder = $qKey['tel_cliente'];
                                $mailCLientOrder = $qKey['mail_cliente'];
                                $nameSotreOrder = $qKey['nome_empresa'];
                                $repreStoreOrder = $qKey['representante_empresa'];
                                $cityDeliveryOrder = $qKey['ciudad_solicitud'];
                                $dateOrder = $qKey['fecha_solicitud'];
                                $timeOrder = $qKey['hora_solicitud'];



                                //STAUTS PRODUCTO (ACTIVO = SUSPENDIDO)
                                switch($statusOrder){
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
                                        $printStatusItem = "<span class='label label-info'>Revisión</span>";
                                    break;
                                    case "6":
                                        $printStatusItem = "<span class='label label-danger'>Agotado</span>";
                                    break;																	
                                }

                                //LAYOUT TABLE ITEM                                    
                                $layoutDataItem = "";
                                $layoutDataItem .= "<tr>";
                                $layoutDataItem .= "<td><p>".$dateOrder." / ".$timeOrder."</p></td>";
                                $layoutDataItem .= "<td><p>".$refOrder."</p></td>";

                                $layoutDataItem .= "<td>";//usuario                                  
                                $layoutDataItem .= "<strong >".$nameClientOrder."</strong>";
                                $layoutDataItem .= "<p>Tel:&nbsp;&nbsp;".$telClientOrder."</p>";
                                $layoutDataItem .= "<p>Email:&nbsp;&nbsp;".$mailCLientOrder."</p>";
                                $layoutDataItem .= "<p>Ciudad Envio:&nbsp;&nbsp;".$cityDeliveryOrder."</p>";
                                $layoutDataItem .= "</td>";//fin usuario

                                $layoutDataItem .= "<td>";//store                                
                                $layoutDataItem .= "<strong >".$nameSotreOrder."</strong>";
                                $layoutDataItem .= "<p>Representante:&nbsp;&nbsp;".$repreStoreOrder."</p>";                                        
                                $layoutDataItem .= "</td>";//store

                                $layoutDataItem .= "<td>";//status
                                $layoutDataItem .= "<p>Status: ".$printStatusItem."</p>";                                        
                                $layoutDataItem .= "</td>";//fin stratus

                                $layoutDataItem .= "<td>";//opciones

                                $layoutDataItem .= "<div class='btn-group'>";
                                $layoutDataItem .= "<a href='order.php?coditemget=".$idItem."' type='button' class='btn btn-info'>Más detalles</a>";
                                $layoutDataItem .= "<button type='button' class='btn btn-info dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
                                $layoutDataItem .= "<span class='caret'></span>";
                                $layoutDataItem .= "<span class='sr-only'>edititem</span>";
                                $layoutDataItem .= "</button>";
                                $layoutDataItem .= "<ul class='dropdown-menu pull-right'>";
                                //$layoutDataItem .= "<li><a href='#'>Detalles</a></li>";
                                //$layoutDataItem .= "<li><a href='item-edit.php?coditemget=".$idItem."'><i class='fa fa-pencil margin-right-xs'></i>Editar</a></li>";                                    
                                //$layoutDataItem .= "<li role='separator' class='divider'></li>";
                                $layoutDataItem .= "<li><a href='#'><i class='fa fa-trash margin-right-xs'></i>Eliminar</a></li>";
                                $layoutDataItem .= "</ul>";
                                $layoutDataItem .= "</div>";//btn-group

                                $layoutDataItem .= "</td>";//fin opciones


                                $layoutDataItem .= "</tr>";

                                echo $layoutDataItem;
                                    //}
                                //}

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
        "ordering": true,
        "autoWidth": false
    });
  });
</script>    
</body>
</html>
