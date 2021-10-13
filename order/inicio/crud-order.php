<?php require_once '../../appweb/lib/MysqliDb.php'; ?>
<?php require_once '../../cxconfig/config.inc.php'; ?>
<?php require_once '../../cxconfig/global-settings.php'; ?>
<?php require_once '../../appweb/inc/sessionvars.php'; ?>
<?php require_once '../../appweb/lib/gump.class.php'; ?>
<?php require_once '../../appweb/inc/site-tools.php'; ?>
<?php require_once '../../appweb/inc/query-prods.php'; ?>
<?php require_once '../../appweb/inc/valida-pedido-tmp.php'; ?>
<?php 

$validator = new GUMP();

/////////////////////////
//RECIBE DATOS A EDITAR
/////////////////////////


$fielEdit = (!isset($_POST['value']))? "" : $_POST['value']; //--> cant
$idPost = (!isset($_POST['post']))? "" : $_POST['post'];
$fieldPost = (!isset($_POST['fieldedit']))? "" : $_POST['fieldedit'];
$costoPost = (!isset($_POST['priceedit']))? "" : $_POST['priceedit'];
$ventaPost = (!isset($_POST['unitedit']))? "" : $_POST['unitedit'];



$itemEditRecive = "cpe".$idPost;  

$response = array();

/*
//ADD PROD ORDER
*/

if(isset($fieldPost) && $fieldPost == "addpot"){
    
    //recibe datos

    $pedidoPost = $_POST['pedido_data'];
    $prodPost = $_POST['prod_data'];
    $cantPost = $_POST['cant_data'];
    $costoPost = $_POST['costo_data'];            
    $ventaPost = $_POST['venta_data'];
    $utilidad_percenvarPost = $_POST['utilidad_percendata'];
    $utilidadPost = $_POST['utilidad_data'];
    $subtotalPost = $_POST['subtotal_data'];
    
        
    $_POST = array( 
        'codpedidoins'=> $pedidoPost,                        
        'codprodins' => $prodPost,
        'cantins' => $cantPost,
        'costoins' => $costoPost,
        'ventains' => $ventaPost,
        'utiliporcentins' => $utilidad_percenvarPost,
        'utiliins' => $utilidadPost,
        'subtotalins' => $subtotalPost
	);		
	
	$_POST = $validator->sanitize($_POST); 
    
    //$validator->validation_rules(array(
	$rules = array(
        'codpedidoins' => 'integer|max_len,8',
        'codprodins'  => 'integer|max_len,8',
        'cantins'  => 'integer|max_len,4',
        'costoins' => 'float|max_len,20',
        'ventains'  => 'float|max_len,20',
        'utiliporcentins' => 'float|max_len,20',
        'utiliins' => 'float|max_len,20',
        'subtotalins' =>'float|max_len,20'
	);
    //$validator->filter_rules(array(
	$filters = array(
        'codpedidoins' => 'trim|sanitize_string',
        'codprodins'  => 'trim|sanitize_string',
        'cantins'  => 'trim|sanitize_string',
        'costoins' => 'trim|sanitize_string',
        'ventains'  => 'trim|sanitize_string',
        'utiliporcentins' => 'trim|sanitize_string',
        'utiliins' => 'trim|sanitize_string',
        'subtotalins' =>'trim|sanitize_string'
	);
	
    $validated = $validator->validate($_POST, $rules);
    $_POST = $validator->filter($_POST, $filters);
    
    // Check if validation was successful
	if($validated === TRUE){
        
        $nuevoPost = array();
        $nuevoPost[] = $_POST;
                              
        foreach($nuevoPost as $valInsert => $valPost){
            $dataInsert = array(                                                                                 
                'id_solici_promo' => empty($valPost['codpedidoins'])? "" : $valPost['codpedidoins'],
                'id_producto'=> empty($valPost['codprodins'])? "" : $valPost['codprodins'],
                'cant_pedido'=> empty($valPost['cantins'])? "" : $valPost['cantins'],
                'precio_costo'=> empty($valPost['costoins'])? "" : $valPost['costoins'],                                                             
                'precio_venta'=> empty($valPost['ventains'])? "" : $valPost['ventains'],               
                'utilidad_porcien'=> empty($valPost['utiliporcentins'])? "" : $valPost['utiliporcentins'],                
                'utilidad'=> empty($valPost['utiliins'])? "" : $valPost['utiliins'],  
                'subtotal_list'=> empty($valPost['subtotalins'])? "" : $valPost['subtotalins']/*,  
                'fecha_alta_empresa'=> $db->now()*/
            );            
        }
        
        $id = $db->insert ('especifica_prod_pedido', $dataInsert);
        if ($id == true){                
            $status= "ok";
            $idLastItemAdd = $id;
            
            /*//LISTA PEDIDO
            $pedidoRelow = array();
            $pedidoRelow = queryOrderTmpOne($pedidoPost);
            
            
            foreach($pedidoRelow as $ordreRelow){
                
                $idTEMPOrder = $ordreRelow['id_producto'];
                
                $listOrder = printProdsListTmp($idTEMPOrder);

                $response[] = $listOrder;                                

            }*/
            //$listOrder = "";
            //$listOrder .= printLastItemAdd($idLastItemAdd);
            //$response[] = printLastItemAdd($idLastItemAdd);
            $response = true;
        }else{
            
            $erroQuery = $db->getLastErrno();
            //$response['error']= $erroQuery;
            
            $errValidaTmpl ="<div class='alert alert-danger alert-dismissible padd-verti-xs text-center' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
            $errValidaTmpl .="<h4>";
            $errValidaTmpl .="ERROR EN SERVIDOR<br>";      
            $errValidaTmpl .="<small style='color:#fff;'>".$erroQuery."</small>";      
            $errValidaTmpl .="</h4>";
            $errValidaTmpl .="</div>";
            
            $response['error']= $errValidaTmpl;
                
        }
                                
    }else{
        //$tituERR = "CEP CRIATORIO";
        //$ruleERR = "Deve escrever un CEP valido y con o padrão certo"; 
        //$exERR = "00000-000"; 
        //$errValidaTmplEdit = printErrValida($addressDetailValid, $tituERR, $ruleERR, $exERR); 
        $errValidaTmpl ="<div class='alert alert-danger alert-dismissible padd-verti-xs text-center' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
        $errValidaTmpl .="<h4>";
        $errValidaTmpl .="ERROR<br>";      
        $errValidaTmpl .="<small style='color:#fff;'>Verifica los valores que ingresaste, intentalo de nuevo</small>";      
        $errValidaTmpl .="</h4>";
        $errValidaTmpl .="</div>";
        
        
        $response['error']= $errValidaTmpl;
    }
    
                                   
    /*$fielvalid = validaAlphaSpace($fielEdit, $idPost);
            
    if($fielvalid === true){
        $idRow = $idPost;
        $fieldRow = "cep_criatorio";
        $fieldRowEdit = $fielEdit;
        $idFieldTbl = "id_guia";
        $tbl = "guia";
        $tituSqlERR = "CEP CRIATORIO";
                                       
        //////////////////////////////////////
                
        $dataCepEdit = Array (
            'cep_criatorio' => $userzip,            
            'addressfull_criatorio' => $locationFull,            
            'geo_latitud' => $latstore,            
            'geo_longitud' => $lngstore,            
            'pais' => $userpais,            
            'estado' => $userstate,            
            'ciudad' => $usercity,            
            'geo_mapa' => $idPlace                       
        );            
        $db->where ($idFieldTbl, $idRow);
                       
        /////////////////////////////////////
        
        if($db->update ($tbl, $dataCepEdit)){
            $tmplMap = "<label>CEP:&nbsp;&nbsp;</label>";
            $tmplMap .= "<span>".$userzip."</span>";
            $tmplMap .= "<div class='clearfix'></div>";
            $tmplMap .= "<label>Ubicação:&nbsp;&nbsp;</label>";
            $tmplMap .= "<span>".$usercity .", " .$userstate .", " .$userpais ."</span>";            
            $tmplMap .= "<div class='clearfix'></div>";
            $tmplMap .= "<label>GeoMapa</label>";
            $tmplMap .= "<div class='embed-responsive embed-responsive-4by3'><iframe class='embed-responsive-item' src='https://www.google.com/maps/embed/v1/place?q=place_id:".$idPlace."&key=AIzaSyDiFiDAvnvxcwpoJEu3YyoDH5BZrKZ4ZxE' width='100%' height='250' frameborder='0' style='border:0' allowfullscreen></iframe></div>";
            $response = $tmplMap;
        }else{
            $erroQuery = $db->getLastErrno();
            $response['error']= $erroQuery;
        }
        
    }else{
        $tituERR = "CEP CRIATORIO";
        $ruleERR = "Deve escrever un CEP valido y con o padrão certo"; 
        $exERR = "00000-000"; 
        //$errValidaTmplEdit = printErrValida($addressDetailValid, $tituERR, $ruleERR, $exERR); 
        $errValidaTmplEdit ="<section class='alert alert-danger alert-dismissible box50 padd-verti-xs' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
        $errValidaTmplEdit .="<ul class='list-group text-left'>";
        $errValidaTmplEdit .="<li class='list-group-item list-group-item-danger'><b>".$tituERR."</b>
        <br>Regras:
        <br>Você escreveu <b>".$cepProfileEdit."</b>
        <br>".$ruleERR."
        <br>Ex. ".$exERR."</li>";      
        $errValidaTmplEdit .="</ul>";
        $errValidaTmplEdit .="</section>";
        $response['error']= $errValidaTmplEdit;
    }*/
    exit(json_encode($response));
}







/*
//ADD PROD ORDER - DESDE SHOWROOM
*/

if(isset($fieldPost) && $fieldPost == "addpotsr"){
    
    //recibe datos
    //var dataString = "pedido_data="+pedido_var+"&prod_data="+prod_var+"&prodfiling_data="+prodfiling_var+"&kitcode_data="+kitcode_var+"&cant_data="+cant_var+"&fieldedit=addpotsr";

    $pedidoPost = $_POST['pedido_data'];
    $prodPost = $_POST['prod_data'];
    $cantPost = $_POST['cant_data'];
    $prodFilingPost = $_POST['prodfiling_data'];
    $kitCodePost = $_POST['kitcode_data'];  
    $itemKitPost = $_POST['itemkit_data'];  
    
    
    //$costoPost = $_POST['costo_data'];            
    //$ventaPost = $_POST['venta_data'];
    //$utilidad_percenvarPost = $_POST['utilidad_percendata'];
    //$utilidadPost = $_POST['utilidad_data'];
    //$subtotalPost = $_POST['subtotal_data'];
    
        
    $_POST = array( 
        'codpedidoins'=> $pedidoPost,                        
        'codprodins' => $prodPost,
        'cantins' => $cantPost,
        'profilingins' => $prodFilingPost,
        'kitcodeins' => $kitCodePost,
        'itemkitins' => $itemKitPost
	);		
	
	$_POST = $validator->sanitize($_POST); 
    
    //$validator->validation_rules(array(
	$rules = array(
        'codpedidoins'=> 'integer|max_len,8',                        
        'codprodins' => 'integer|max_len,8',
        'cantins' => 'integer|max_len,2',
        'profilingins' => 'integer|max_len,8',
        'kitcodeins' => 'integer|max_len,3',
        'itemkitins' => 'integer|max_len,3'
	);
    //$validator->filter_rules(array(
	$filters = array(
        'codpedidoins'=> 'trim|sanitize_string',                        
        'codprodins' => 'trim|sanitize_string',
        'cantins' => 'trim|sanitize_string',
        'profilingins' => 'trim|sanitize_string',
        'kitcodeins' => 'trim|sanitize_string',
        'itemkitins' => 'trim|sanitize_string'
	);
	
    $validated = $validator->validate($_POST, $rules);
    $_POST = $validator->filter($_POST, $filters);
    
    // Check if validation was successful
	if($validated === TRUE){
        
        $nuevoPost = array();
        $nuevoPost[] = $_POST;
                              
        foreach($nuevoPost as $valInsert => $valPost){
            $dataInsert = array(                                                                                 
                'id_solici_promo' => empty($valPost['codpedidoins'])? "" : $valPost['codpedidoins'],
                'id_producto'=> empty($valPost['codprodins'])? "" : $valPost['codprodins'],
                'cant_pedido'=> empty($valPost['cantins'])? "" : $valPost['cantins'],
                'id_catego_prod'=> empty($valPost['kitcodeins'])? "" : $valPost['kitcodeins'],
                'id_subcatego_producto'=> empty($valPost['itemkitins'])? "" : $valPost['itemkitins'],
                'id_prod_filing'=> empty($valPost['profilingins'])? "" : $valPost['profilingins']
                
                
                //'precio_costo'=> empty($valPost['costoins'])? "" : $valPost['costoins'],                                                             
                //'precio_venta'=> empty($valPost['ventains'])? "" : $valPost['ventains'],               
                //'utilidad_porcien'=> empty($valPost['utiliporcentins'])? "" : $valPost['utiliporcentins'],                
                //'utilidad'=> empty($valPost['utiliins'])? "" : $valPost['utiliins'],  
                //'subtotal_list'=> empty($valPost['subtotalins'])? "" : $valPost['subtotalins'],  
                //'fecha_alta_empresa'=> $db->now()
            );            
        }
        
        $id = $db->insert ('especifica_prod_pedido', $dataInsert);
        if ($id == true){                
            $status= "ok";
            $idLastItemAdd = $id;
            
            //LISTA PEDIDO
            /*$pedidoRelow = array();
            $pedidoRelow = queryOrderTmpOne($pedidoPost);
            
            
            foreach($pedidoRelow as $ordreRelow){
                
                $idTEMPOrder = $ordreRelow['id_producto'];
                
                $listOrder = printProdsListTmp($idTEMPOrder);

                $response[] = $listOrder;                                

            }*/
            //$listOrder = "";
            //$listOrder .= printLastItemAdd($idLastItemAdd);
            //$response = printLastItemAdd($idLastItemAdd);
            //print_r($listaaaa);
            
            $response = true;
        }else{
            
            $erroQuery = $db->getLastErrno();
            //$response['error']= $erroQuery;
            
            $errValidaTmpl ="<div class='alert alert-danger alert-dismissible padd-verti-xs text-center' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
            $errValidaTmpl .="<h4>";
            $errValidaTmpl .="ERROR EN SERVIDOR<br>";      
            $errValidaTmpl .="<small style='color:#fff;'>".$erroQuery."</small>";      
            $errValidaTmpl .="</h4>";
            $errValidaTmpl .="</div>";
            
            $response['error']= $errValidaTmpl;
                
        }
                                
    }else{
        //$tituERR = "CEP CRIATORIO";
        //$ruleERR = "Deve escrever un CEP valido y con o padrão certo"; 
        //$exERR = "00000-000"; 
        //$errValidaTmplEdit = printErrValida($addressDetailValid, $tituERR, $ruleERR, $exERR); 
        $errValidaTmpl ="<div class='alert alert-danger alert-dismissible padd-verti-xs text-center' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
        $errValidaTmpl .="<h4>";
        $errValidaTmpl .="ERROR<br>";      
        $errValidaTmpl .="<small style='color:#fff;'>Verifica los valores que ingresaste, intentalo de nuevo</small>";      
        $errValidaTmpl .="</h4>";
        $errValidaTmpl .="</div>";
        
        
        $response['error']= $errValidaTmpl;
    }   
    exit(json_encode($response));
}








/*
//EDIT CANT PROD ORDER
*/

if((isset($_POST['editlpto']) && $_POST['editlpto'] == "ok") && (isset($fieldPost) && $fieldPost == $itemEditRecive)){

    
    /*$fielEdit = (!isset($_POST['value']))? "" : $_POST['value']; //--> cant
$idPost = (!isset($_POST['post']))? "" : $_POST['post'];
$fieldPost = (!isset($_POST['fieldedit']))? "" : $_POST['fieldedit'];
$costoPost = (!isset($_POST['priceedit']))? "" : $_POST['priceedit'];
$ventaPost = (!isset($_POST['unitedit']))? "" : $_POST['unitedit'];*/
    
    $subTotalEdit = $fielEdit*$ventaPost;
    $utilidadEdit = $ventaPost - $costoPost;
    $porcentUtilidadEdit = 100-(($costoPost/$ventaPost)*100) ;
    
    $fielvalid = validaInteger($fielEdit, $idPost);
            
    if($fielvalid === true){
        $idRow = $idPost;        
        $idFieldTbl = "id_espci_prod_pedido";
        $tbl = "especifica_prod_pedido";
        
                                       
        //////////////////////////////////////
                
        $dataCepEdit = Array (
            'cant_pedido' => $fielEdit,            
            'utilidad_porcien' => $porcentUtilidadEdit,            
            'utilidad' => $utilidadEdit,            
            'subtotal_list' => $subTotalEdit                
        );            
        $db->where ($idFieldTbl, $idRow);
                       
        /////////////////////////////////////
        
        if($db->update ($tbl, $dataCepEdit)){
            /*$pedidoRelow2 = array();
            $pedidoRelow2 = queryOrderTmpOne($otNOW);
            
            
            foreach($pedidoRelow2 as $ordreRelow2){
                
                $idTEMPOrder2 = $ordreRelow2['id_producto'];

                $response[] = printProdsListTmp($idTEMPOrder2);                                

            }*/
            $response[] = $fielEdit;
        }else{
            $erroQuery = $db->getLastErrno();
            $response['error']= $erroQuery;
        }
        
    }else{
        
        $response['error']= "error de validacion";
    }
    exit(json_encode($response));
    
}

/*
/DELETE ITEM LIST ORDER
*/

if((isset($_POST['deleteilpto']) && $_POST['deleteilpto'] == "ok") && (isset($fieldPost) && $fieldPost == $itemEditRecive)){
    //$response = "llego al delete"; 
    $fielvalid = validaInteger($fielEdit, $idPost);
            
    if($fielvalid === true){
        $idRow = $idPost;        
        $idFieldTbl = "id_espci_prod_pedido";
        $tbl = "especifica_prod_pedido";
        
                 
        $db->where($idFieldTbl, $idRow);
       // if($db->delete($tbl)) echo 'successfully deleted';
       
        
        if($db->delete($tbl)){
            /*$pedidoRelow2 = array();
            $pedidoRelow2 = queryOrderTmpOne($otNOW);
            
            
            foreach($pedidoRelow2 as $ordreRelow2){
                
                $idTEMPOrder2 = $ordreRelow2['id_producto'];

                $response[] = printProdsListTmp($idTEMPOrder2);                                

            }*/
            $response = true;
        }else{
        //$deletItemListProd = $db->delete($tbl);
        //if(!$deletItemListProd){
            $erroQuery = $db->getLastErrno();
            $response['error']= $erroQuery;
        }
        
    }else{
        
        $response['error']= "error de validacion";
    }
    exit(json_encode($response));
}
   
   
