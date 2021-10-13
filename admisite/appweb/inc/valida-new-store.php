<?php
require_once '../lib/MysqliDb.php';
require_once "../../cxconfig/config.inc.php";
require_once '../../cxconfig/global-settings.php';
require_once "../lib/gump.class.php";
require_once "../lib/password.php";
require_once "site-tools.php"; 

/*$_POST['fieldedit']= "additem";
$_POST['nomerepre'] ='Cheo feliciano';
$_POST['cargorepre'] ='diretor ed orquesta';

$_POST['refcompany'] ='';
$_POST['namestore'] =' El gran combo';        
$_POST['nitstore'] ='12312312-12';
$_POST['landlinestore'] ='4360766';
$_POST['cellstore'] ='3101234333434';
$_POST['emailstore'] ='contacto@gramcombo.com';//
$_POST['addressstore'] ='calle 5ta No. 43A-12 Barrio departamental';
$_POST['citystore'] ='Cali colombia';
$_POST['commentrepre'] ='';

$_POST['userstore'] ='c.feliciano';
$_POST['passstore'] ='3421%&(asASD'; */                           

$fieldPost = $_POST['fieldedit'];
$response = array();

$newStore = "";
$refRepre = "";
$nomeRepre = "";
$commentRepre = "";
$nomeStore = "";
$nitStore = "";
$emailStore = "";
$fijoStore = "";
$celStore = "";
$adressStore = "";
$cityStore = "";
$userStore = "";
$passStore = "";       

//if(isset($_POST['newstore']) && $_POST['newstore'] == "ok"){
if(isset($fieldPost) && $fieldPost == "additem"){    
    
    //***********
    //RECIBE DATOS 
    //***********
    $nomeRepre = (empty($_POST['nomerepre']))? "" : $_POST['nomerepre'];
    $cargoRepre = (empty($_POST['cargorepre']))? "" : $_POST['cargorepre'];
    
    $refRepre = (empty($_POST['refcompany']))? "" : $_POST['refcompany'];    
    $nomeStore = (empty($_POST['namestore']))? "" : $_POST['namestore'];        
    $nitStore = (empty($_POST['nitstore']))? "" : $_POST['nitstore'];
    $fijoStore = (empty($_POST['landlinestore']))? "" : $_POST['landlinestore'];
    $celStore = (empty($_POST['cellstore']))? "" : $_POST['cellstore'];
    $emailStore = (empty($_POST['emailstore']))? "" : $_POST['emailstore'];
    $adressStore = (empty($_POST['addressstore']))? "" : $_POST['addressstore'];
    $cityStore = (empty($_POST['citystore']))? "" : $_POST['citystore'];
    $commentStore = (empty($_POST['commentrepre']))? "" : $_POST['commentrepre'];
    
    $userStore = (empty($_POST['userstore']))? "" : $_POST['userstore'];
    $passStore = (empty($_POST['passstore']))? "" : $_POST['passstore'];
    
    
    $_POST = array( 
        'reprename'=> $nomeRepre,
        'reprecargo'=> $cargoRepre,
        'refstore'=> $refRepre,
        'storename' => $nomeStore,
        'storenit' => $nitStore,
        'landlinestore' => $fijoStore,
        'celstore' => $celStore,
        'emailstore' => $emailStore,
        'storeaddress' => $adressStore,        
        'storecity' => $cityStore,                
        'reprecomment' => $commentRepre,        
        'userstore' => $userStore,
        'passstore' => $passStore
	);		
	
	$_POST = $validfield->sanitize($_POST); 
    
    //$validfield->validation_rules(array(
	$rules = array(
        'reprename'=> 'required|valid_name|max_len,40',
        'reprecargo'=> 'required|alpha_space|max_len,40',
        'refstore'=> 'alpha_dash|max_len,20',
        'storename' => 'required|alpha_space|max_len,60',
        'storenit' => 'required|alpha_dash|max_len,20',
        'landlinestore' => 'required|phone_number|max_len,18',
        'celstore' => 'phone_number|max_len,18',
        'emailstore' => 'required|valid_email',
        'storeaddress' => 'required|street_address|max_len,60',
        'storecity' => 'required|alpha_space|max_len,30',
        'reprecomment' => 'alpha_space|max_len,140',
        'userstore' => 'required|user|min_len,4|max_len,12',
        'passstore' => 'required|pass|min_len,4|max_len,12',        
	);
    //$validfield->filter_rules(array(  
	$filters = array(
        'reprename'=> 'trim|sanitize_string',
        'reprecargo'=> 'trim|sanitize_string',
        'refstore'=> 'trim|sanitize_string',
        'storename' => 'trim|sanitize_string',
        'storenit' => 'trim|sanitize_string',
        'landlinestore' => 'trim|sanitize_string',
        'celstore' => 'trim|sanitize_string',
        'emailstore' => 'trim|sanitize_email',
        'storeaddress' => 'trim|sanitize_string',
        'storecity' => 'trim|sanitize_string',
        'reprecomment' => 'trim|sanitize_string',
        'userstore' => 'trim|sanitize_string',
        'passstore' => 'trim|sanitize_string',
	);
	
    $validated = $validfield->validate($_POST, $rules);
    $_POST = $validfield->filter($_POST, $filters);
    //echo "<pre>";
    ///print_r($validated);
    // Check if validation was successful
	if($validated === TRUE){
	
	
	//VALIDAR SI USUARIO EXISTE
        $tablaExiQ = "account_empresa";
        $campoExiQ = "nit_empresa";
        $colValExiQ = $nitStore;
        $existeUsuario = existPost($tablaExiQ, $campoExiQ, $colValExiQ);

        if($existeUsuario === false){

            $response['error']= "Este NIT <b>".$cedulaUser."</b> ya fue registrado, por favor verificalo e intentalo de nuevo";
            echo json_encode($response);
            exit;
        }
	
        
        $nuevoPost = array();
        $nuevoPost = $_POST;
       
        //foreach($nuevoPost as $valInsert => $valPost){
        foreach($nuevoPost as $valInsert){
            $dataInsert = array(                 
                'nome_representante' =>  $nuevoPost['reprename'],
                'cargo_repre_empresa' => $nuevoPost['reprecargo'],
                'ref_account_empre' =>$nuevoPost['refstore'],
                'nombre_account_empre'=>  $nuevoPost['storename'],                
                'nit_empresa'=> $nuevoPost['storenit'],                                                             
                'mail_account_empre' =>$nuevoPost['emailstore'],
                'tel_account_empre1'=> $nuevoPost['landlinestore'],               
                'tel_account_empre2'=> $nuevoPost['celstore'],                
                'dir_account_empre'=> $nuevoPost['storeaddress'],  
                'ciudad_account_empre' => $nuevoPost['storecity'],
                'comentarios_empresa'=> $nuevoPost['reprecomment'],
                'pseudo_user_empresa' => $nuevoPost['userstore'],
                'pass_account_empre' => password_hash($nuevoPost['passstore'], PASSWORD_BCRYPT, array("cost" => 10)),                                      
                'pass_human' => $nuevoPost['passstore'],
                'fecha_alta_empresa'=> $dateFormatDB
            );         
        }
        //echo "<pre>";
        //print_r($dataInsert);
        $idStore_order = $db->insert('account_empresa', $dataInsert);
        if($idStore_order == true){                
            $response =$idStore_order;
        }else{
            $errInsertDatas = $db->getLastErrno();
                
            $errQueryTmpl_ins ="<ul class='list-group text-left'>";
            $errQueryTmpl_ins .="<li class='list-group-item list-group-item-danger'><b>*** Algo salio mal ***</b><br>
                <br>Wrong: <b>No se pudo crear esta empresa</b>
                <br>Erro: ".$errInsertDatas."
                <br>Puedes intentar de nuevo
                <br>Si el error continua, por favor entre en contacto con soporte</li>";
            $errQueryTmpl_ins .="</ul>";


            $response['error']= $errQueryTmpl_ins;
                                    
        }
                
    }else{
        
        $errValidaTmpl = "";
                
        $errValidaTmpl .= "<ul class='list-group text-left box75'>";
                                           
        //ERRORES VALIDACION DATOS
        $recibeRules = array();
        $recibeRules[] = $validated;
                                
        foreach($recibeRules as $keyRules => $valRules){
            foreach($valRules as $key => $v){
                                
                $errFiel = $v['field'];
                $errValue = $v['value'];
                $errRule = $v['rule'];
                $errParam = $v['param'];
                
                if(empty($errValue)){
                    $usertyped = "Por favor completa este campo";                    
                }else{
                    $usertyped = "Escribiste&nbsp;&nbsp;<b>" .$errValue ."</b>";
                }
                
                switch($errFiel){
                    case 'reprename' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Representante</b>
                        <br>".$usertyped."
                        <br>Reglas:
                        <br>Debes escribir el nombre del representante
                        <br>Escribe un nombre de persona real</li>";
                    break;                        
                    case 'reprecargo' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Cargo Representante</b>
                        <br>".$usertyped."
                        <br>Reglas:
                        <br>Debes escribir el cargo del represnetante</li>";
                    break;
                    case 'refstore' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Ref. Empresa</b>
                        <br>".$usertyped."
                        <br>Reglas:
                        <br>Escribe un código, o identificación para esta empresa
                        <br>Puedes usar letras, números y los caracteres <b>- _</b>
                        <br>No dejes espacios</li>";
                    break;                         
                    case 'storename' :
                        $errValidaTmpl .=  "<li class='list-group-item list-group-item-danger'><b>Nombre de empresa</b>
                        <br>".$usertyped."
                        <br>Reglas:
                        <br>Escribe el nombre de la empresa, o razon social
                        <br>Sólo puedes usar letras y números</li>";
                        
                    break;
                    case 'storenit' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>NIT</b>
                        <br>".$usertyped."
                        <br>Reglas:
                        <br>Escribe un número NIT valido
                        <br>Puedes usar letras, números y los caracteres <b>- _</b>
                        <br>No dejes espacios</li>";
                        
                    break;                    
                    case 'emailstore' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Email</b>
                        <br>".$usertyped."
                        <br>Reglas:
                        <br>Escribe una cuenta de email valida
                        <br>Ej. nombredeusuario@sitioweb.com</li>";
                        
                    break; 
                    case 'landlinestore' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Teléfono fijo</b>
                        <br>".$usertyped."
                        <br>Reglas:
                        <br>Escrebe un número de telefono valido
                        <br>Ej. (5) 555 5555</li>";
                        
                    break; 
                    case 'celstore' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Teléfono celular</b>
                        <br>".$usertyped."
                        <br>Reglas:
                        <br>Escribe un número de celular valido
                        <br>Ej. 555 555 5555</li>";
                        
                    break; 
                    case 'storeaddress' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Dirección empresa</b>
                        <br>".$usertyped."
                        <br>Reglas:                        
                        <br>Escribe una dirección del establecimiento valida
                        <br>Carrera 55 # 55-55 Nombre del barrio</li>";                        
                    break;  
                    case 'reprecomment' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Comentarios de empresa</b>
                        <br>".$usertyped."
                        <br>Reglas:
                        <br>Escribe alguna descripción corta de esta empresa.</li>";
                        
                    break;
                    case 'userstore' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Usuario</b>
                        <br>".$usertyped."
                        <br>Reglas:
                        <br>Escribe un nombre de usuario
                        <br>Debe tener entre 4 y 12 caracrteres
                        <br>Puedes usar letras, números y los caracteres (._-)</li>";
                        
                    break;
                    case 'passstore' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Contraseña</b>
                        <br>".$usertyped."
                        <br>Reglas:
                        <br>Escribe una contraseña valida
                        <br>Debe tener entre 4 y 12 caracrteres
                        <br>Puedes usar letras, números y los caracteres (!@#$%&()+.-_)</li>";
                        
                    break;
                }
            }
            
        }
        
        $errValidaTmpl .= "</ul>";
        $response['error']= $errValidaTmpl;
        
    }
    
    echo json_encode($response);
    
}
