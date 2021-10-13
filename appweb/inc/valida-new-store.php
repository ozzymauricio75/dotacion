<?php

$validator = new GUMP();

$newStore = "";
$nomeRepre = "";
$commentRepre = "";
$nomeStore = "";
$nitStore = "";
$fijoStore = "";
$celStore = "";
$adressStore = "";

if(isset($_POST['newstore']) && $_POST['newstore'] == "ok"){
    
    //$newStore = $_POST['newstore'];
    
    //===================================================================================
    //PARA CREAR EL PEDIDO
    $tablaQ = "solicitud_pedido_temp"; 
    $campoQ = "id_solici_promo";
    $clave = lastIDRegis($tablaQ, $campoQ);
    $clave = $clave + 1;
    $lastOrderDB = $clave;
    switch($clave) {
		
		case ($clave < 10):
			$prefijo = "00000";
			$clave = $prefijo.$clave;
		break;	
		
		case ($clave < 100):
			$prefijo = "0000";
			$clave = $prefijo.$clave;
		break;
		
		case ($clave < 1000):
			$prefijo = "000";
			$clave = $prefijo.$clave;
		break;	
	
		case ($clave < 10000):
			$prefijo = "00";
			$clave = $prefijo.$clave;
		break;	
		
		case ($clave < 100000):
			$prefijo = "0";
			$clave = $prefijo.$clave;
		break;
	
		case ($clave >= 100000):
			$clave = $clave;
		break;
	}
    $fecha_order = date("Y-m-d");
	$cod_order = "INT-$clave";
    
    

    /*$idSponsor = $db->rawQuery("INSERT INTO solicitud_pedido_temp (id_account_empre, representante_empresa, cod_orden_compra, fecha_solicitud, id_account_seller) VALUES ('{$idStore_order}', '{$repreStore_order}', '{$cod_order}', '{$fecha_order}', '{$sellerID}')");
    
    if(!$idSponsor){
        $errsponsordb = "Failed to insert new SPONSOR:\n Erro:". $db->getLastErrno();
        $errDBSponsorArr[] = array($errsponsordb);
    }else{
        $newPedido= "ok";
        
        //$_SESSION['$nomeSession'] = $idSponsor;
        
        //$orderSessActi = $_SESSION['$nomeSession'];
    
    }*/
    
    //===================================================================================
    
    //recibe datos
    $nomeRepre = (empty($_POST['nomerepre']))? "" : $_POST['nomerepre'];
    $commentRepre = (empty($_POST['commentrepre']))? "" : $_POST['commentrepre'];
    $nomeStore = (empty($_POST['nomestore']))? "" : $_POST['nomestore'];
    $nitStore = (empty($_POST['nitstore']))? "" : $_POST['nitstore'];
    $fijoStore = (empty($_POST['landlinestore']))? "" : $_POST['landlinestore'];
    $celStore = (empty($_POST['cellstore']))? "" : $_POST['cellstore'];
    $adressStore = (empty($_POST['addressstore']))? "" : $_POST['addressstore'];
    $idSeller = (empty($_POST['idvendedor']))? "" : $_POST['idvendedor'];
    
    $_POST = array( 
        'reprename'=> $nomeRepre,                        
        'reprecomment' => $commentRepre,
        'storename' => $nomeStore,
        'storenit' => $nitStore,
        'landlinestore' => $fijoStore,
        'celstore' => $celStore,
        'storeaddress' => $adressStore,
        'sellerid' => $idSeller
	);		
	
	$_POST = $validator->sanitize($_POST); 
    
    //$validator->validation_rules(array(
	$rules = array(
        'reprename' => 'required|valid_name|max_len,40',
        'reprecomment'  => 'alpha_space|max_len,80',
        'storename'  => 'alpha_space|max_len,40',
        'storenit' => 'alpha_space|max_len,15',
        'landlinestore'  => 'phone_number|max_len,18',
        'celstore' => 'phone_number|max_len,18',
        'storeaddress' => 'alpha_space|max_len,80',
        'sellerid' =>'integer|max_len,8'
	);
    //$validator->filter_rules(array(
	$filters = array(
        'reprename' => 'trim|sanitize_string',
        'reprecomment'  => 'trim|sanitize_string',
        'storename'  => 'trim|sanitize_string',
        'storenit' => 'trim|sanitize_string',
        'landlinestore' => 'trim|sanitize_string',
        'celstore'  => 'trim|sanitize_string',
        'storeaddress' => 'trim|sanitize_string',
        'sellerid' => 'trim|sanitize_string'
	);
	
    $validated = $validator->validate($_POST, $rules);
    $_POST = $validator->filter($_POST, $filters);
    
    // Check if validation was successful
	if($validated === TRUE){
        
        $nuevoPost = array();
        $nuevoPost[] = $_POST;
       
        foreach($nuevoPost as $valInsert => $valPost){
            $dataInsert = array(                                                                                 
                'nome_representante' => empty($valPost['reprename'])? "" : $valPost['reprename'],
                'comentarios_empresa'=> empty($valPost['reprecomment'])? "" : $valPost['reprecomment'],
                'nombre_account_empre'=> empty($valPost['storename'])? "" : $valPost['storename'],
                'nit_empresa'=> empty($valPost['storenit'])? "" : $valPost['storenit'],                                                             
                'tel_account_empre1'=> empty($valPost['landlinestore'])? "" : $valPost['landlinestore'],               
                'tel_account_empre2'=> empty($valPost['celstore'])? "" : $valPost['celstore'],                
                'dir_account_empre'=> empty($valPost['storeaddress'])? "" : $valPost['storeaddress'],  
                'id_account_seller'=> empty($valPost['sellerid'])? "" : $valPost['sellerid'],  
                'fecha_alta_empresa'=> $db->now()
            );
         
            
            //para representantes tabla
            $nomeRepreInsert = $valPost['reprename'];
            $sellerID = $valPost['sellerid'];
            //$fechaRepreInsert = $fecha_order;
        }
        
        $idStore_order = $db->insert('account_empresa', $dataInsert);
        if ($idStore_order == true){                
            $status= "ok"; 
                                    
            /*$newOrderTemp = $db->rawQuery("INSERT INTO solicitud_pedido_temp (id_solici_promo, id_account_empre, representante_empresa, cod_orden_compra, fecha_solicitud, hora_solicitud, datetime_publi, id_account_seller) VALUES ('{$lastOrderDB}','{$idStore_order}', '{$nomeRepreInsert}', '{$cod_order}', '{$dateFormatDB}', '{$horaFormatDB}', '{$timeStamp}', '{$sellerID}')");
            $idNewOrderTemp = $db->getInsertId();
                            
            if($idNewOrderTemp){*/
            $newOrderTempData = array(
                /*'id_solici_promo' => $lastOrderDB,*/
                'id_account_empre' => $idStore_order,
                'representante_empresa' => $nomeRepreInsert,
                'cod_orden_compra' => $cod_order,
                'fecha_solicitud' => $dateFormatDB,
                'hora_solicitud' => $horaFormatDB,
                'datetime_publi' => $timeStamp,
                'id_account_seller' => $sellerID
            );

            /*$newOrderTemp = $db->rawQuery("INSERT INTO solicitud_pedido_temp (id_solici_promo, id_account_empre, representante_empresa, cod_orden_compra, fecha_solicitud, hora_solicitud, datetime_publi, id_account_seller) VALUES ('{$lastOrderDB}','{$idStore_order}', '{$repreStore_order}', '{$cod_order}', '{$dateFormatDB}', '{$horaFormatDB}', '{$timeStamp}', '{$sellerID}')");                    
            $idNewOrderTemp = $db->getInsertId();*/
            $idNewOrderTemp = $db->insert ('solicitud_pedido_temp', $newOrderTempData);

            if($idNewOrderTemp){
                
                 //$newPedido= "ok";
                $jumpNewOrder = "takeorder/browse/?otmp=".$idNewOrderTemp;
                gotoRedirect($jumpNewOrder);
            }else{
                $errsponsordb = "Failed to insert new ORDER:\n Erro:". $db->getLastErrno();
                $errDBSponsorArr[] = array($errsponsordb);
            }                        
        }else{
            echo "<br>NO PUBLICA LA EMPRESA";

        }
                
    }else{
        
        $errValidaTmpl = "";
        
        $errValidaTmpl .= "<section class='box50 padd-verti-xs'>";
        $errValidaTmpl .= "<ul class='list-group text-left'>";
                                           
        //ERRORES VALIDACION DATOS
        $recibeRules = array();
        $recibeRules[] = $validated;
                                
        foreach($recibeRules as $keyRules => $valRules){
            foreach($valRules as $key => $v){
                                
                $errFiel = $v['field'];
                $errValue = $v['value'];
                $errRule = $v['rule'];
                $errParam = $v['param'];
                
                switch($errFiel){
                    case 'reprename' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Representante</b>
                        <br>Regras:
                        <br>Debes escribir el nombre del representante
                        <br>Escribe un nombre de persona real</li>";
                    break;                        
                    case 'reprecomment' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Comentarios de empresa</b>
                        <br>Regras:
                        <br>Escribe alguna descripción corta de esta empresa.</li>";
                        
                    break;
                    case 'storename' :
                        $errValidaTmpl .=  "<li class='list-group-item list-group-item-danger'><b>Nombre de empresa</b>
                        <br>Regras:
                        <br>Sólo puedes usar letras y números</li>";
                        
                    break;
                    case 'storenit' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>NIT/CEDULA</b>
                        <br>Regras:
                        <br>Escribe un número de cedula ó NIT valido</li>";
                        
                    break;                    
                    case 'landlinestore' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Teléfono fijo</b>
                        <br>Regras:
                        <br>Escrebe un número de telefono valido
                        <br>Ej. (9) 555 5555</li>";
                        
                    break; 
                    case 'celstore' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Teléfono celular</b>
                        <br>Regras:
                        <br>Escribe un número de celular valido
                        <br>Ej. 555 555 5555</li>";
                        
                    break; 
                    case 'storeaddress' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Dirección empresa</b>
                        <br>Regras:                        
                        <br>Escribe una dirección de establecimiento valida
                        <br>Carrera 55 # 55-55 Nombre del barrio - Ciudad</li>";                        
                    break;                    
                }
            }
            
        }
        
        $errValidaTmpl .= "</ul>";
        $errValidaTmpl .= "</section>";
        
    }
    
}
