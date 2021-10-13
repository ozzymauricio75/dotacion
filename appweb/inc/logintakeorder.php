<?php

//define datos
$useraccount = "";
$passaccount = "";
$errValidaTmpl = "";
$status = 0;

if(isset($_POST['tologin']) && $_POST['tologin'] == "ok"){
	$validator = new GUMP();
    //$passhash = new PassHash();
    
	//recibe datos    
    $useraccount = empty($_POST['username'])? "" : $_POST['username'];        
    $passaccount = empty($_POST['passuser'])? "" : $_POST['passuser'];    
        
	$_POST = array(        
        'userlogin' => $useraccount,
        'passlogin' => $passaccount        
	);		
	
	$_POST = $validator->sanitize($_POST); 
    
    //$validator->validation_rules(array(
	$rules = array(        
        'userlogin' =>'required|alpha_space|max_len,20|min_len,4', 
        'passlogin' => 'required|alpha_space|max_len,20|min_len,4'        
	);
    //$validator->filter_rules(array(
	$filters = array(        
        'userlogin' => 'trim|sanitize_string',
        'passlogin' => 'trim|sanitize_string'        
	);
	
    $validated = $validator->validate($_POST, $rules);
    $_POST = $validator->filter($_POST, $filters);
    
    
    // Check if validation was successful
	if($validated === TRUE){
                                		
        //valida info user
        $userDB = $db->escape($useraccount);
        $passaDB = $db->escape($passaccount);
                
        $db->where ('account_pseudo_user', $userDB);
        //$db->where ('pass_account_user', crypt($passaDB, $passaDBCryp));
        //$db->where ('estado_cuenta', 1);        
        $loginUser = $db->getOne('account_user', 'id_account_user, id_account_empre, nombre_account_user, pass_account_user, mail_account_user, account_pseudo_user, tipo_kit_user, coleccion_user, cedula_user, ciudad_account_user, estado_cuenta'); 
        
        if($loginUser){
                        
            $idDBUser = $loginUser['id_account_user'];
            //$codDBUser = $loginUser['id_mb_account_seller'];
            $idCompanyDbUser = $loginUser['id_account_empre'];
            $pseudoDBUser = $loginUser['account_pseudo_user'];
            $nameDBUser = $loginUser['nombre_account_user'];
            $emailDBUser = $loginUser['mail_account_user'];
            $kitDBUser = $loginUser['tipo_kit_user'];
            $generoDBUser = $loginUser['coleccion_user'];
            $passUser = $loginUser['pass_account_user'];
            $cedulaUser = $loginUser['cedula_user'];
            $cityUser = $loginUser['ciudad_account_user'];            
            $estadoDBUser = $loginUser['estado_cuenta'];
            
            //consulta info empresa
            $db->where ('id_account_empre', $idCompanyDbUser);            
            $db->where ('id_estado', 1);        
            $companyEmploy = $db->getOne('account_empresa', 'id_account_empre, nombre_account_empre, ciudad_account_empre'); 

            $companyName = $companyEmploy['nombre_account_empre'];
            $companyCity = $companyEmploy['ciudad_account_empre'];
            
            switch($estadoDBUser){
                case "1":
                                        
                    if($pseudoDBUser == $userDB && password_verify($passaDB, $passUser)){

                        $_SESSION['pseudouser_account']=array(
                            'iduser' => $idDBUser,
                            //'coduser' => $codDBUser,
                            'spseudouser' => $pseudoDBUser,
                            'nameuser' => $nameDBUser,
                            'mailuser' => $emailDBUser, 
                            'genderuser' => $generoDBUser, 
                            'kituser' => $kitDBUser,
                            'cedulauser' =>$cedulaUser,
                            'companyuser' =>$companyName,
                            'citycompanyuser' => (empty($companyCity))? $cityUser : $companyCity
                        );

                        //acti order

                        $lastOrderTemp = actiOrder($idCompanyDbUser, $idDBUser, $nameDBUser);

                        if($lastOrderTemp !== false){
                            $fileDestiny = $takeOrderDir."/inicio/?otmp=".$lastOrderTemp;
                            gotoRedirect($fileDestiny);   
                        }else{
                            $errValidaTmpl .= "<section class='box50 padd-verti-xs'>";
                            $errValidaTmpl .= "<ul class='list-group text-left'>";
                            $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Algo salio mal</b>
                                <br>Opciones:
                                <br>Erro: ".$lastOrderTemp."
                                <br>Puedes intentar nuevamente
                                <br>Si este error continua, por favor comunicate con soporte</li>";
                            $errValidaTmpl .= "</ul>";
                            $errValidaTmpl .= "</section>";    
                        }

                        exit;
                    }else{
                        $errValidaTmpl .= "<section class='box50 padd-verti-xs'>";
                        $errValidaTmpl .= "<ul class='list-group text-left'>";
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>LogIn</b>
                            <br>Por favor verifica tu usuario y contrase«Ða.</li>";
                        $errValidaTmpl .= "</ul>";
                        $errValidaTmpl .= "</section>";                
                    }
                    //fin login user
                    
                    
                break;
                case "2":
                    $errValidaTmpl .= "<section class='box50 padd-verti-xs'>";
                    $errValidaTmpl .= "<ul class='list-group text-left'>";
                    $errValidaTmpl .= "<li class='list-group-item list-group-item-info'><b>LogIn</b>
                        <br>Este usuario ha sido identificado, con solicitud de pedido realizado. 
                        <br>Si piensas que se trata de un error, por favor comunicate con soporte. </li>";
                    $errValidaTmpl .= "</ul>";
                    $errValidaTmpl .= "</section>";    
                break;
            }
                
        }else{//sino login

            $erroQuery = $db->getLastError();   

            if($erroQuery){            
                $errValidaTmpl .= "<section class='box50 padd-verti-xs'>";
                $errValidaTmpl .= "<ul class='list-group text-left'>";
                $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Algo salio mal</b>
                    <br>Opciones:
                    <br>Erro: ".$erroQuery."
                    <br>Puedes intentar nuevamente
                    <br>Si este error continua, por favor comunicate con soporte</li>";
                $errValidaTmpl .= "</ul>";
                $errValidaTmpl .= "</section>";
            }

            $errValidaTmpl .= "<section class='box50 padd-verti-xs'>";
            $errValidaTmpl .= "<ul class='list-group text-left'>";
            $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>LogIn</b>
                <br>Por favor verifica tu usuario y contraseÃ±a.</li>";
            $errValidaTmpl .= "</ul>";
            $errValidaTmpl .= "</section>";
        }

    }else{//si existen errores validacion de datos post

        $errValidaTmpl .= "<section class='box50 padd-verti-xs'>";
        $errValidaTmpl .= "<ul class='list-group text-left'>";

        //errores de validacion
        $valRules = array();
        $recibeRules = array();
        $recibeRules[] = $validated;

        $resuValidate = count($recibeRules);
        if($resuValidate>0){
            foreach($recibeRules as $keyRules => $valRules){     
                if (is_array($valRules)) {
                    foreach($valRules as $key => $v){

                        $errFiel = $v['field'];
                        $errValue = $v['value'];
                        $errRule = $v['rule'];
                        $errParam = $v['param'];

                        switch($errFiel){                            
                            case 'userlogin' :
                                $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Usuario</b>
                                <br>Escribe el nombre de usuario de tu cuenta</li>";

                            break;
                            case 'passlogin' :
                                $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>ContraseÃ±a</b>
                                <br>Por favor verifica tu contraseÃ±a e intentalo de nuevo</li>";
                            break;                            
                        }//fin switch
                    }//fin foreach valores errores
                }//comprueba si existe un array o  tiene elementos el array

            }//fin foreach recibe erreres
        }//fin count errores

        $errValidaTmpl .= "</ul>";
        $errValidaTmpl .= "</section>";
    }//fin valida campos post
              
}//fin post formulario new registro

