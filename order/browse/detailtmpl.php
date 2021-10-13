<?php
require_once '../../appweb/lib/MysqliDb.php';
require_once "../../cxconfig/config.inc.php";
require_once "../../cxconfig/global-settings.php";

//recibe datos
$id = empty($_POST['variable1'])? "" :  $_POST['variable1']; //"extensiones-mltitomas"; //"-arlante-anotec-nt-p2207";//
$idStore = empty($_POST['variable2'])? "" :  $_POST['variable2'];  //"58"; //"313";//



if($id){
    $idprodNow = (string)$id;
    $idstoreNow = (int)$idStore;
    
    $idprodNow = $db->escape($idprodNow); 
    $idstoreNow = $db->escape($idstoreNow); 

    //PRODUCTOS
    $db->where ('url_amigable_prod', $idprodNow);    									
    $prodQuery = $db->get('productos', 1, 'id_producto, nome_producto, foto_producto, foto_producto, precio_producto, cod_venta_prod, id_estado_contrato, agotado, agotado_imp');

    //if ($db->count > 0){
    if(count($prodQuery)>0){
        
        foreach ($prodQuery as $TOprodKey) {   //$TOprodKey -> temporal order product key
            
            $idProdDB = $TOprodKey['id_producto'];
            $nomeProdDB = $TOprodKey['nome_producto'];
            $fotoProdDB = $TOprodKey['foto_producto'];
            $precioCostoProdDB = $TOprodKey['precio_producto'];
            $refProdDB = $TOprodKey['cod_venta_prod'];
            $estadoProdDB = $TOprodKey['id_estado_contrato'];

            //estados de producto y stock
            $agotadoProdDB = $TOprodKey['agotado'];
            $agotadoProdImpDB = $TOprodKey['agotado_imp'];
            
            $pathFileLabelProd = "../../files-display/tienda/img200/".$fotoProdDB;                
            $pathImgDefault = $pathmm."img/nopicture.png";

            //VERIFICAR PORTADA
            if (file_exists($pathFileLabelProd)) {
                $printLAbelProd = $pathmm."files-display/tienda/img200/".$fotoProdDB;                                       
            } else {
                $printLAbelProd = $pathImgDefault;
            }
                        
            //CUBICAJE -PRECIO IMP                                      
            $db->where ('id_producto', $idProdDB);    									
            $cubiProdQuery = $db->getOne('cubicaje', 'id_producto, cubi1, cubi2, cubi3, totalCubi, puntaje, totalPuntaje, preciodll, cantempaque, cubiuni, costoprodimp');
            
            if(count($cubiProdQuery) > 0){
                $idProdcubiDB = $cubiProdQuery['id_producto'];
                $cubi1DB = $cubiProdQuery['cubi1'];
                $cubi2DB = $cubiProdQuery['cubi2'];
                $cubi3DB = $cubiProdQuery['cubi3'];
                $totalCubiDB = $cubiProdQuery['totalCubi'];
                $puntajeDB = $cubiProdQuery['puntaje'];
                $totalPuntajeDB = $cubiProdQuery['totalPuntaje'];
                $preciodllDB = $cubiProdQuery['preciodll'];
                $cantempaqueDB = $cubiProdQuery['cantempaque'];
                $cubiuniDB = $cubiProdQuery['cubiuni'];
                
                //if($idProdcubiDB == $idProdDB){
                    $costoprodimpDB = $cubiProdQuery['costoprodimp'];
                //}
            }
            
            
            //ESTADOS PRODUCTO  ACTI NAL - ACTI IMP
            $agotadoNal = "";
            $agotadoImp = "";
            $actiStockNal = "";
            $actiStockImp = "";
            
            if(isset($precioCostoProdDB) && $precioCostoProdDB != 0){ 
            
                switch($agotadoProdDB){
                    case "1":
                        $agotadoNal = "Agotado";
                        break;
                    case "0":
                        $agotadoNal = "En stock";
                        break;	
                }
            }else{
                $actiStockNal = "No se trabaja NAL";
            }
            
            
            if(isset($costoprodimpDB) && $costoprodimpDB != 0){ 
                
                switch($agotadoProdImpDB){
                    case "1":
                        $agotadoImp = "Agotado";
                        break;
                    case "0":
                        $agotadoImp = "En stock";
                        break;	
                }
            }else{
                $actiStockImp = "No se trabaja IMP";
            }
            
            //HISTORICO COMPRA CLIENTE
            $db->where ('id_producto', $idProdDB);
            $db->where ('id_account_empre', $idstoreNow);
            $db->orderBy ('fecha_historico', 'desc');            
            $historyClientQuery = $db->getOne('historico_precios', 'id_producto, precio_venta_historico, fecha_historico');

            $ventaHistoryDB = 0;

            if(count($historyClientQuery) > 0){
                $idProdHistoryDB = $historyClientQuery['id_producto'];
                
                //if($idProdHCIMP == $idProdDB){ -> si activo esta condicion... ME GENERA ERROR
                // EN EL MOMENTO DE DARLE CLICK AL BOTN CARRITO
                // EN EL CASO DE QUE EL CLIENTE YA HAYA COMPRADO ESTE PRODUCTO
                    $ventaHistoryDB = $historyClientQuery['precio_venta_historico'];    
                //}
            }
            
            //FORMAT PRECIOS
            $precioCostoProdDBFormat = (!isset($precioCostoProdDB))? "" : number_format($precioCostoProdDB,2,",","."); 
            $costoprodimpDBFormat = (!isset($costoprodimpDB))? "" :  number_format($costoprodimpDB,2,",","."); 
            $ventaHistoryDBFormat = (!isset($ventaHistoryDB))? "" :   number_format($ventaHistoryDB,2,",","."); 
                                             
        }
        
                                
        //DATA PROD ARRAY                               
        $dataProdAdd = array(  
            'idprod' => $idProdDB,
            'nameprod' => $nomeProdDB,
            'skuprod' => $refProdDB,
            'precioHistoryFormat' => (!isset($ventaHistoryDBFormat))? "" : $ventaHistoryDBFormat,
            'precioNal' => (!isset($precioCostoProdDB))? "" : $precioCostoProdDB,
            'precioImp' => (!isset($costoprodimpDB))? "" : $costoprodimpDB,
            'precioNalFormat' => (!isset($precioCostoProdDBFormat))? "" : $precioCostoProdDBFormat,
            'precioImpFormat' => (!isset($costoprodimpDBFormat))? "" : $costoprodimpDBFormat,
            'labelprod' => $printLAbelProd 
        );
        
        echo json_encode($dataProdAdd);
    }	
//}
}