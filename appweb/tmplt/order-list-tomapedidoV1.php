<?php
$showList = "";
if($totalPZasOrder > 1 && ($totalPZasOrder == $cantPzCatego)){ $showList = "control-sidebar-open"; }

//LISTA PEDIDO
$pedido = array();
$pedido = queryOrderTmpOne($otNOW);


    //<!-- Control Sidebar -->
    $listOrder ="<aside class='control-sidebar ".$showList."  control-sidebar-light ' id='tolsidebar'>";//control-sidebar-open
    $listOrder .="<div class='control-sidebar-header'>
              <div class='col-xs-5 unlateralpadding'>
                  <span class='csh-title'><i class='fa fa-file fa-1x'></i>&nbsp;&nbsp;Pedido</span>
              </div>";          
    $listOrder .="<div class='col-xs-7 unlateralpadding'>";

    //if($cantPzCatego == $totalPZasOrder){
    if($totalPZasOrderGLOB == $totalPzKit){

        $listOrder .="<div class='btn-group btn-group-sm pull-right' role='group' aria-label='...'>
                    <a href='".$pathmm.$takeOrderDir."/browse/?ordersend=ok&ordernow=".$idOrderNow."' type='button' class='btn'><i class='fa fa-check'></i> Enviar</a>";    
    }else{
        $listOrder .="<div class='btn-group btn-group-sm pull-right' role='group' aria-label='...'>
                    <a href='#' type='button' class='btn sendbtn' title='Enviar pedido' data-msj='Para poder enviar el pedido, debes seleccionar la totalidad de piezas asignadas a tu dotación.'><i class='fa fa-check'></i> Enviar</a>";    
    }    
    $listOrder .="<button type='button' class='btn trashtobtn' data-toggle='control-sidebar'><i class='fa fa-times padd-hori-xs'></i></button>";            
    $listOrder .="</div>";//btn-group
    $listOrder .="</div>";//col-xs-7

    $listOrder .="</div>";//control-sidebar-header
if(!is_array($pedido) || count($pedido) == 0){     
    
    $listOrder .="<div class='msjzero box25 padd-verti-md padd-hori-xs text-center'>
              <h4>Cero items</h4>
          </div>";
    
}else{
    
    $listOrder .="<div class='control-sidebar-cliente' >
                <div class='media'>
                  <div class='media-left '>
                    <span class='fa-stack fa-lg'>
                      <i class='fa fa-circle fa-stack-2x'></i>
                      <i class='fa fa-user fa-stack-1x fa-inverse'></i>
                    </span>
                  </div>
                  <div class='media-body media-middle'>
                    <h4 class='media-heading'>".$nomeClienteOrder."</h4>            
                  </div>
                </div>
            </div>";
    /*$listOrder .="<div class='control-sidebar-totalorder'>
              <span id='totalTO'>0</span>
          </div>";*/

    $listOrder .="<div id='wraporder' class='padd-bottom-xs margin-verti-xs'>";


        $totalItems = "";
        foreach($pedido as $elemOrder){

            $nomeClienteOrder = $elemOrder['representante_empresa'];
            $idTEMPOrder = $elemOrder['id_producto'];

            $listOrder .= printProdsListTmp($idTEMPOrder);
            //echo $idTEMPOrder."<br>";
            //echo $printPLTO;

        }
       
    $listOrder .="</div>";//wraporder
    
     $listOrder .="<div class='msjzero box25 padd-verti-md padd-hori-xs text-center margin-bottom-lg'>
              <h5>- Fin pedido -</h5>
          </div>";
    
}
          
  $listOrder .="</aside>";
  $listOrder .="<div class='control-sidebar-bg'></div>";
  //$listOrder .="";
echo $listOrder;


    