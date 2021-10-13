<?php
//define datos
$useraccount = "";
$passaccount = "";
$errValidaTmpl = "";
$status = 0;

if(isset($_POST['tologin']) && $_POST['tologin'] == "ok"){
	$validator = new GUMP();
	
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
	if($validated === TRUE)
	{
		
        //valida info user
        $userDB = $db->escape($useraccount);
        $passaDB = $db->escape($passaccount);
            
        $db->where ('account_pseudo_seller', $userDB);
        $db->where ('pass_account_seller', $passaDB);
        $db->where ('estado_cuenta', 1);        
        $loginUser = $db->getOne('account_vendedor', 'id_account_seller, id_mb_account_seller, nombre_account_seller, mail_account_seller, account_pseudo_seller'); 
                        
        if($loginUser){
            
            $idDBUser = $loginUser['id_account_seller'];
            $codDBUser = $loginUser['id_mb_account_seller'];
            $pseudoDBUser = $loginUser['account_pseudo_seller'];
            $nameDBUser = $loginUser['nombre_account_seller'];
            $emailDBUser = $loginUser['mail_account_seller'];
            
            //$_SESSION['nome_user']=$nameUser;
            //$_SESSION['sobrenome_user']=$sobreNomeUser;
            $_SESSION['pseudouser_account']=array(
                'iduser' => $idDBUser,
                'coduser' => $codDBUser,
                'spseudouser' => $pseudoDBUser,
                'nameuser' => $nameDBUser,
                'mailuser' => $emailDBUser 
            );
                        
            //$_SESSION['Useraccount_vende_Site'] =  $userManagerLogin;
            //$_SESSION['UserGroup_vende_Site'] = $loginStrGroup;
            
            $fileDestiny = "trade/inicio/";            
            gotoRedirect($fileDestiny);
            //echo $jumpSite;
            //echo $fileDestiny;
            
            exit;
            
        }else{
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
                <br>Por favor verifica tu usuario y contraseña.</li>";
            $errValidaTmpl .= "</ul>";
            $errValidaTmpl .= "</section>";
        }
        
		//exit;
	}
	else
	{
        //print_r($validated);
		
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
                                $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Contraseña</b>
                                <br>Por favor verifica tu contraseña e intentalo de nuevo</li>";
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