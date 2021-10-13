<?php require_once '../../appweb/lib/MysqliDb.php'; ?>
<?php require_once '../../cxconfig/config.inc.php'; ?>
<?php require_once '../../cxconfig/global-settings.php'; ?>
<?php require_once '../../appweb/lib/gump.class.php'; ?>
<?php require_once '../../appweb/inc/site-tools.php'; ?>
<?php require_once '../../appweb/inc/sessionvars-boss.php'; ?>
<?php require_once '../../appweb/inc/query-orders-staff.php'; ?>
<?php /*require_once '../../appweb/inc/valida-new-store.php';*/ ?>
<?php /*require_once '../../appweb/inc/valida-pedido-tmp.php';*/ ?>
<?php require_once '../../appweb/inc/query-prods-boss.php'; ?>
<?php //require_once '../../appweb/inc/valida-pedido-tmp-boss.php'; ?>

<?php 
//IMPRIME CATEGORIAS - CATALOGO

$printStaff = array();
$printStaff = staffCompany();

//total empleados
$totalStaff = count($printStaff);

//echo "<pre>";
//print_r($printStaff);
//total pedidos
$totalOrderStaff = ordersStaff();

//echo "<pre>";
//print_r($totalOrderStaff);
$pocentPedidosFormat = 0;
if($totalStaff>0){

    $pocentPedidos = ($totalOrderStaff/$totalStaff)*100;
$pocentPedidosFormat = number_format($pocentPedidos,0,"",",");  
    
}    

//PATH FOTO DEFAULT
$pathFileDefault = $pathmm."img/nopicture.png";

/*
*SITE MAP - ESQUEMA LINKS
*/
$actiSecc = "inicio";
?>
<!DOCTYPE html>
<html lang="<?php echo LANG ?>">
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
    
    <title>QUEST - Toma Pedidos</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">    
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <meta name="author" content="massin">
    <?php echo _CSSFILESLAYOUT_ ?>         
    <link rel="stylesheet" href="../../appweb/plugins/datatables/dataTables.bootstrap.css">
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
        <div class="content-wrapper">
            <?php
            /*
                *
                *---------------------------
                *PAGE HEADER - BREAD CRUMB
                *---------------------------
                *    
            */  

            /*
            <!--<section class="content-header">
                  <h1>
                    Blank page
                    <small>it all starts here</small>
                  </h1>
                  <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="#">Examples</a></li>
                    <li class="active">Blank page</li>
                  </ol>
                </section>-->

            */      
            ?>
            <?php /*echo $headClienteActi_tmpl;*/ ?>
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
            
            
            <section class="container">
                <header class="catalagohead clearfix">                                        
                    <?php echo "<h1>".$companySSUser."</h1>"; ?>
                    <span>Dotaci¨®n Staff</span>
                </header> 
                                                
                <div class="main">
                    
                    <div class="box box-default ">
                        <div class="box-header">
                            <h3 class="box-title">Sobre los KITs de dotaci¨®n</h3>    
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                                    <h1><?php echo $totalStaff; ?></h1>
                                    <h3>Total Funcionarios</h3>   
                                </div>
                                <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                                    <h1><?php echo $totalOrderStaff; ?></h1>
                                    <h3>Pedidos realizados</h3>   
                                </div>
                                <div class="col-xs-4 text-center" >
                                    <input type="text" class="knob" value="<?php echo $pocentPedidosFormat; ?>" data-skin="tron" data-thickness="0.2" data-width="120" data-height="120" data-fgColor="#E42727" data-readonly="true">                  
                                    <h3 >% pedidos realizados</h3>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row margin-bottom-lg margin-top-md">
                        <div class="col-xs-12">
                        <?php if(is_array($printStaff)){ ?>    
                            
                            <div class="box">
                                <!-- <div class="box-header">
                                  <h3 class="box-title">Hover Data Table</h3>
                                </div>
                                /.box-header -->
                                <div class="box-body ">
                                  <table id="example2" class="table">
                                    <thead>
                                    <tr>                                      
                                      <th>
                                        <div class="col-xs-2">Cedula</div>
                                          <div class="col-xs-3">Nombre</div>
                                          <div class="col-xs-5 text-center"></div>
                                          <div class="col-xs-2 text-center">Status</div>
                                        </th>
                                      <!--<th>Nombre</th>
                                      <th>Dotaci&oacute;n</th>
                                      <th>Status</th>-->
                                    </tr>
                                    </thead>
                                    <tbody>
                                    
                                    <?php
                                    
                                   
                                    
                                                                                        
                                            //$itemsOrder = array();
                                            
                                    foreach($printStaff as $psKey){
                                        $idUserStaff = $psKey['id_account_user'];
                                        $nameUserStaff = $psKey['nombre_account_user'];
                                        $cedulaUserStaff = $psKey['cedula_user'];
                                        $idColectionUserStaff = $psKey['coleccion_user'];
                                        $idKitUserStaff = $psKey['tipo_kit_user'];                                        
                                        
                                        /*///                                        
                                        ///IMPRIME KIT DE USUARIO
                                        ///*/
                                                                                
                                        $level1User = $db->subQuery ("cu");
                                        $level1User->where ("id_depart_prod", $idColectionUserStaff);
                                        $level1User->get("departamento_prods");

                                        $db->join($level1User, "kit.id_depart_prod=cu.id_depart_prod");        
                                        //$db->orderBy("cat.nome_catego_product","asc");    
                                        //$db->orderBy("kit.posi_sub_cate_prod","asc");    
                                        $level2User = $db->where("kit.id_catego_product",$idKitUserStaff);    
                                        $level2User = $db->getOne ("categorias_productos kit", "cu.nome_depart_prod, kit.nome_catego_product, kit.descri_catego_prod, kit.cant_pz_kit");
                                        
                                        $colectionUser = $level2User['nome_depart_prod'];
                                        $nameKitUser = $level2User['nome_catego_product'];
                                        $subNameKitUser = $level2User['descri_catego_prod'];
                                        
                                        $db->where("id_catego_product",$idKitUserStaff);    
                                        $level3User = $db->getOne ("sub_categorias_productos", "COUNT(id_subcatego_producto) as totalpz");
                                        $totalPZ = $level3User['totalpz'];
                                        
                                        
                                        /*///                                        
                                        ///CONSULTA DETALLES ORDEN DE USUARIO
                                        ///*/                 
                                        $dataEspeciOrder = array();
                                        
                                        
                                        //CONSULTA ORDEN
                                        $db->where ("id_account_user", $idUserStaff);    								
                                        $orderUser = $db->getOne('solicitud_pedido','id_account_user, id_solici_promo, cod_orden_compra, estado_solicitud, fecha_solicitud, hora_solicitud');
                                        $idOrderUser = $orderUser['id_solici_promo'];
                                        $statusOrderUser = $orderUser['estado_solicitud'];
                                        $idUserOrder = $orderUser['id_account_user'];
                                        $dateUserOrder = date("d/m/Y", strtotime($orderUser['fecha_solicitud']));
                                        $timeUserOrder = $orderUser['hora_solicitud'];
                                        $refUserOrder = $orderUser['cod_orden_compra'];
                                                                                                                        
                                        
                                        //if($idUserOrder == $idUserStaff){
                                            $dataEspeciOrder = itemsOrder($idOrderUser);//$idOrderUser
                                       // }
                                            $countDEO = count($dataEspeciOrder); 
                                                                                                                        
                                        //DEFINE DETALLES ORDEN USUSARIO
                                        $statusPrint = (isset($statusOrderUser))? "<span class='badge bg-green'>Realizado</span>" : "<span class='badge bg-black'>No Realizado</span>";
                                        
                                        //LAYOUT DETALLES USER
                                        $layoutItem = "<tr>";// item subcate                                        
                                        $layoutItem .= "<td style='padding:0px;'>";
                                        
                                        $layoutItem .= "<div class='box collapsed-box no-padmarg' style='border-top: 0px solid #d2d6de; box-shadow: 0 0px 0px rgba(0, 0, 0, 0.1); background: #transparent;'>";
                                        $layoutItem .= "<div class='box-header box-header-hover'>";
                                                                                
                                        $layoutItem .= "<div class='col-xs-2'>".$cedulaUserStaff."</div>";
                                        $layoutItem .= "<div class='col-xs-3'>".$nameUserStaff."</div>";
                                                                                                                                                                                                                                                                                                                                
                                        
                                        $layoutItem .= "<div class='col-xs-5'>";                                      
                                        //$layoutItem .= "<h4 class='no-padmarg'>".$colectionUser;
                                        //$layoutItem .= "<span class='pull-right'><b>".$totalPZ."</b><small>Pzs</small></span>";
                                        //$layoutItem .= "</h4>";
                                        //$layoutItem .= "<strong class='no-padmarg'>".$nameKitUser."&nbsp;".$subNameKitUser."</strong>"; 
                                        $layoutItem .= "</div>";
                                        
                                        $layoutItem .= "<div class='col-xs-2 text-center'>".$statusPrint."</div>";
                                        
                                        if($countDEO > 0){
                                        $layoutItem .= "<div class='box-tools pull-right'>";
                                        $layoutItem .= "<button type='button' class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-plus'></i>";
                                        $layoutItem .= "</button>";
                                        $layoutItem .= "</div>";//box-tools                                        
                                        }
                                        $layoutItem .= "</div>";//box-header
                                        
                                        $layoutItem .= "<div class='box-body'>";
                                        
                                        $layoutItem .= "<div class='box75'>";//detalles order
                                        
                                        $layoutItem .= "<div class='row padd-verti-xs bg-gray-light'>";
                                        $layoutItem .= "<div class='col-xs-3'>";
                                        $layoutItem .= "<strong>Cod. Pedido";
                                        $layoutItem .= "<span class='badge bg-blue margin-left-xs'>".$refUserOrder."</span>";
                                        $layoutItem .= "</strong>";
                                        $layoutItem .= "</div>";//col
                                        $layoutItem .= "<div class='col-xs-6'>";
                                        $layoutItem .= "<strong>Fecha";
                                        $layoutItem .= "<span class='badge bg-blue margin-left-xs'>".$dateUserOrder."</span>";
                                        $layoutItem .= "</strong>";
                                        //$layoutItem .= "</div>";//col
                                       // $layoutItem .= "<div class='col-xs-3'>";
                                        $layoutItem .= "<strong class=' margin-left-md'>Hora";                                        
                                        $layoutItem .= "<span class='badge bg-blue margin-left-xs'>".$timeUserOrder."</span>";
                                        $layoutItem .= "</strong>";
                                        $layoutItem .= "</div>";//col
                                        $layoutItem .= "</div>";//row
                                        
                                        $layoutItem .= "<div class='row padd-hori-xs'>";//item prod
                                        $layoutItem .= "<ul class='products-list product-list-in-box'>";
                                        
                                        //CONSULTA ITEMS
                                        if(is_array($dataEspeciOrder)){
                                            foreach($dataEspeciOrder as $ioKey){
                                            if(is_array($ioKey)){
                                                foreach($ioKey as $itemVal){
                                                $idOrderTmpItem = $itemVal['id_espci_prod_pedido'];
                                                $idProdItem = $itemVal['id_prod_filing'];
                                                $SKUProdItem = $itemVal['cod_venta_prod_filing'];
                                                $nomeProdItem = $itemVal['nome_producto_filing'];                                                
                                                $labelProdItem = $itemVal['foto_producto_filing'];
                                                $descriRefProdItem = $itemVal['cod_venta_descri_filing'];
                                                
                                                $pathPortadaItemOrder = "../../files-display/album/labels/".$labelProdItem;

                                                if (file_exists($pathPortadaItemOrder)) {
                                                    $portadaFileItemOrder = $pathPortadaItemOrder;
                                                } else {
                                                    $portadaFileItemOrder = $pathFileDefault;
                                                }
                                                                                                    
                                                $layoutItemOrder = "<li class='item'>";
                                                $layoutItemOrder .= "<div class='product-img'>";
                                                $layoutItemOrder .= "<img src='".$portadaFileItemOrder."' >";
                                                $layoutItemOrder .= "</div>";
                                                $layoutItemOrder .= "<div class='product-info'>";
                                                $layoutItemOrder .= "<h4 class='product-title no-padmarg' >";
                                                $layoutItemOrder .= $nomeProdItem;                                                
                                                $layoutItemOrder .= "</h4>";
                                                $layoutItemOrder .= "<small style='display:block;' class='no-padmarg text-red'><strong>Ref:&nbsp;".$SKUProdItem."</strong></small>";
                                                $layoutItemOrder .= "<span class='product-description'>";                                                
                                                $layoutItemOrder .= $descriRefProdItem;
                                                $layoutItemOrder .= "</span>";
                                                $layoutItemOrder .= "</div>";//product-info
                                                $layoutItemOrder .= "</li>";    
                                                                                                    
                                                $layoutItem .= (empty($layoutItemOrder))? "" : $layoutItemOrder;
                                            }
                                                
                                            }
                                            
                                            }
                                            
                                            $layoutItem .= "</ul>";
                                            $layoutItem .= "</div>";//fin item prod     
                                        }
                                        
                                        $layoutItem .= "</div>";//detalles order
                                        
                                        $layoutItem .= "</div>";//body                                        
                                        $layoutItem .= "</div>";//box
                                        
                                        $layoutItem .= "</td> "; 
                                        $layoutItem .= "</tr> ";// item subcate

                                        echo $layoutItem;                        

                                    }//FIN FOREACH STAFF   
                                    
                                    ?>
                                    
                                                                          
                                    </tbody>                                    
                                  </table>
                                </div>
                                <!-- /.box-body -->
                              </div>
                              <!-- /.box -->  
                            <?php }else{ ?>
                            
                            <div class="box50">
                                <div class="alert alert-danger text-center padd-verti-xs padd-hori-xs">
                                    <i class="ion ion-information-circled cria-icon-3x"></i>
                                    <h3>O "CERO" funcionarios registrados</h3>
                                </div>
                                <!--<div class="btn-group">
                                    <a href="" class="btn btn-md btn-success">Publicar guia</a>   
                                </div>-->
                            </div>    


                            <?php } ?>
                            
                        </div>                                        
                    </div>                                                                                                    
                </div>
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
        <?php include '../../appweb/tmplt/footer-boss.php'; ?>
        <?php
        /*
            *
            *---------------------------
            *CONTROL SIDE - LIST ORDER
            *---------------------------
            *    
        */
        ?>
        <?php //include '../../appweb/tmplt/order-list-tomapedido.php'; ?>
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
   
    <?php echo _JSFILESLAYOUT_ ?>   
    <!-- jQuery Knob -->
    <script src="../../appweb/plugins/knob/jquery.knob.js"></script>
    <!-- DataTables -->
    <script src="../../appweb/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../appweb/plugins/datatables/dataTables.bootstrap.min.js"></script>
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
    <script>
        
        $(function () {
    /* jQueryKnob */

    $(".knob").knob({
      /*change : function (value) {
       //console.log("change : " + value);
       },
       release : function (value) {
       console.log("release : " + value);
       },
       cancel : function () {
       console.log("cancel : " + this.value);
       },*/
      draw: function () {

        // "tron" case
        if (this.$.data('skin') == 'tron') {

          var a = this.angle(this.cv)  // Angle
              , sa = this.startAngle          // Previous start angle
              , sat = this.startAngle         // Start angle
              , ea                            // Previous end angle
              , eat = sat + a                 // End angle
              , r = true;

          this.g.lineWidth = this.lineWidth;

          this.o.cursor
          && (sat = eat - 0.3)
          && (eat = eat + 0.3);

          if (this.o.displayPrevious) {
            ea = this.startAngle + this.angle(this.value);
            this.o.cursor
            && (sa = ea - 0.3)
            && (ea = ea + 0.3);
            this.g.beginPath();
            this.g.strokeStyle = this.previousColor;
            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
            this.g.stroke();
          }

          this.g.beginPath();
          this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
          this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
          this.g.stroke();

          this.g.lineWidth = 2;
          this.g.beginPath();
          this.g.strokeStyle = this.o.fgColor;
          this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
          this.g.stroke();

          return false;
        }
      }
    });
             });
        
        
      $(function () {        
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": false,
          "info": true,
          "autoWidth": false
        });
      });
    </script>
    <script type="text/javascript">
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
