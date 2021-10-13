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
                
        $db->where ('pseudo_user_empresa', $userDB);
        
        //SELECT `id_account_empre`, `id_estado`, `ref_account_empre`, `nombre_account_empre`, `nit_empresa`, `logo_account_empre`, `mail_account_empre`, `pseudo_user_empresa`, `pass_account_empre`, `tel_account_empre1`, `tel_account_empre2`, `url_empre`, `dir_account_empre`, `ciudad_account_empre`, `pais_account_empre`, `nome_representante`, `cargo_repre_empresa`, `comentarios_empresa`, `recibe_order`, `cargo_recibe_order`, `fecha_alta_empresa` FROM `account_empresa` WHERE 1
        
        
        $db->where ('id_estado', 1);        
        $loginUser = $db->getOne('account_empresa', 'id_account_empre, nombre_account_empre, mail_account_empre, pseudo_user_empresa, pass_account_empre, ciudad_account_empre, nome_representante'); 
        
        if($loginUser){
                        
            $idDBUser = $loginUser['id_account_empre'];                        
            $pseudoDBUser = $loginUser['pseudo_user_empresa'];
            $passUser = $loginUser['pass_account_empre'];            
            $nameDBUser = $loginUser['nombre_account_empre'];
            $emailDBUser = $loginUser['mail_account_empre'];            
            $nameRepreDBUser = $loginUser['nome_representante'];                                                
            $cityUser = $loginUser['ciudad_account_empre'];
            
            
            if($pseudoDBUser == $userDB && password_verify($passaDB, $passUser)){
                
                $_SESSION['boss_account']=array(
                    'iduser' => $idDBUser,                    
                    'spseudouser' => $pseudoDBUser,
                    'nameuser' => $nameDBUser,
                    'mailuser' => $emailDBUser,                    
                    'companyuser' =>$nameDBUser,
                    'citycompanyuser' => $cityUser
                );

                //acti order

                //$lastOrderTemp = actiOrder($idDBUser, $nameDBUser);
                
                //if($lastOrderTemp !== false){
                if(is_array($_SESSION['boss_account'])){
                    $fileDestiny = $bossDir."/inicio/";
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
                    <br>Por favor verifica tu usuario y contrase&ntilde;a.</li>";
                $errValidaTmpl .= "</ul>";
                $errValidaTmpl .= "</section>";                
            }
            //fin login user
                
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
                <br>Por favor verifica tu usuario y contrase&ntilde;a.</li>";
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
                                $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Contrase&ntilde;a</b>
                                <br>Por favor verifica tu contrase&ntilde;a e intentalo de nuevo</li>";
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

