<?php
require_once '../lib/MysqliDb.php';
require_once "../../cxconfig/config.inc.php";
require_once '../../cxconfig/global-settings.php';
require_once "../lib/gump.class.php";
require_once "../lib/password.php";
require_once "site-tools.php"; 

/*$_POST['fieldedit']= "additem";
$_POST['codeitemform'] ='Cheo feliciano';

$_POST['company'] ='';
$_POST['nomeuser'] =' El gran combo';        
$_POST['cedulauser'] ='12312312-12';
$_POST['tel1user'] ='4360766';
$_POST['tel2user'] ='3101234333434';
$_POST['emailuser'] ='contacto@gramcombo.com';//
$_POST['cityuser'] ='calle 5ta No. 43A-12 Barrio departamental';
$_POST['userstore'] ='Cali colombia';
$_POST['pass'] ='';

$_POST['adduserkit'] ='c.feliciano';
$_POST['zapuserkit'] ='3421%&(asASD';                            
$_POST['ropuserkit'] ='3421%&(asASD'; */ 

$fieldPost = $_POST['fieldedit'];
$response = array();

$idUser = "";
$kitAddUser = "";
$kitZapatoUser = "";
$kitRopaUser = "";
$companyUser = "";
$nomeUser = "";
$cedulaUser = "";
$fijoUser = "";
$celUser = "";
$emailUser = "";
$dirUser = "";
$cityUser = "";
$userUser = "";
$passUser = "";

$dataPackDotacion = array();

//if(isset($_POST['newstore']) && $_POST['newstore'] == "ok"){
if(isset($fieldPost) && $fieldPost == "additem"){    
    
    //***********
    //RECIBE DATOS 
    //***********
    
    $idUser = (empty($_POST['codeitemform']))? "" : $_POST['codeitemform'];
            
    $companyUser = (empty($_POST['company']))? "" : $_POST['company'];  
        
    $nomeUser = (empty($_POST['nomeuser']))? "" : $_POST['nomeuser'];        
    $cedulaUser = (empty($_POST['cedulauser']))? "" : $_POST['cedulauser'];
    $fijoUser = (empty($_POST['tel1user']))? "" : $_POST['tel1user'];
    $celUser = (empty($_POST['tel2user']))? "" : $_POST['tel2user'];
    $emailUser = (empty($_POST['emailuser']))? "" : $_POST['emailuser']; 
    $dirUser = (empty($_POST['adressuser']))? "" : $_POST['adressuser']; 
    $cityUser = (empty($_POST['cityuser']))? "" : $_POST['cityuser'];
        
    $userUser = (empty($_POST['userstore']))? "" : $_POST['userstore'];
    $passUser = (empty($_POST['pass']))? "" : $_POST['pass'];
    
    

    //SOBRE LOS KIT ASIGNADOS
    
    //TIPO COLECCION
    $tipoColection = (empty($_POST['colectioncheck']))? "" : $_POST['colectioncheck'];
    
    $kitRopaUserJson = $_POST['ropakituser'];
    $kitRopaUser = json_decode($kitRopaUserJson, true);
    $kitUnitarioUserJson = $_POST['unitariokituser'];
    $kitUnitarioUser = json_decode($kitUnitarioUserJson, true);
    
    
    //VALIDACION DE DATOS POST
    $_POST = array( 
        'iduser'=> $idUser,
        'companyuser'=> $companyUser,
        'tipocoleccion' => $tipoColection,
        'nameuser'=> $nomeUser,
        'ceduuser' => $cedulaUser,
        'fijouser' => $fijoUser,
        'celuser' => $celUser,
        'emailuser' => $emailUser,
        'diruser' => $dirUser,
        'cityuser' => $cityUser,                
        'useraccount' => $userUser,
        'passaccount' => $passUser
	);		
	
	$_POST = $validfield->sanitize($_POST); 
    
    //$validfield->validation_rules(array(
	$rules = array(
        'iduser'=> 'integer',
        'companyuser'=> 'required|integer',
        'tipocoleccion' => 'required|integer',
        'nameuser'=> 'required|valid_name|max_len,40',
        'ceduuser' => 'required|numeric|max_len,20',
        'fijouser' => 'required|phone_number|max_len,18',
        'celuser' => 'phone_number|max_len,18',
        'emailuser' => 'required|valid_email',
        'diruser' => 'required|street_address',
        'cityuser' => 'required|alpha_space|max_len,30',           
        'useraccount' => 'required|user|min_len,4|max_len,12',
        'passaccount' => 'required|pass|min_len,4|max_len,12'      
	);
    //$validfield->filter_rules(array(  
	$filters = array(
        'iduser'=> 'trim|sanitize_string',
        'companyuser'=> 'trim|sanitize_string',
        'tipocoleccion' => 'trim|sanitize_string',
        'nameuser'=> 'trim|sanitize_string',
        'ceduuser' => 'trim|sanitize_string',
        'fijouser' => 'trim|sanitize_string',
        'celuser' => 'trim|sanitize_string',
        'emailuser' => 'trim|sanitize_email',
        'diruser' => 'trim|sanitize_string',
        'cityuser' => 'trim|sanitize_string',      
        'useraccount' => 'trim|sanitize_string',
        'passaccount' => 'trim|sanitize_string'
	);
	
    $validated = $validfield->validate($_POST, $rules);
    $_POST = $validfield->filter($_POST, $filters);
    //echo "<pre>";
    ///print_r($validated);
    // Check if validation was successful
	if($validated === TRUE){
        
        
        //VALIDAR SI USUARIO EXISTE
        $tablaExiQ = "account_user";
        $campoExiQ = "cedula_user";
        $colValExiQ = $cedulaUser;
        $existeUsuario = existPost($tablaExiQ, $campoExiQ, $colValExiQ);

        if($existeUsuario === false){

            $response['error']= "Este número de cedula <b>".$cedulaUser."</b> ya fue registrado, por favor verificalo e intentalo de nuevo";
            echo json_encode($response);
            exit;
        }
        
        
        $nuevoPost = array();
        $nuevoPost = $_POST;
       
        //foreach($nuevoPost as $valInsert => $valPost){
        foreach($nuevoPost as $valInsert){
            $dataInsert = array(                                              
                'id_account_empre' =>  $nuevoPost['companyuser'],
                'nombre_account_user' => $nuevoPost['nameuser'],
                'cedula_user' =>$nuevoPost['ceduuser'],
                'mail_account_user'=>  $nuevoPost['emailuser'],                
                'tel_account_user'=> $nuevoPost['fijouser'],                                                             
                'tel_account_user2' =>$nuevoPost['celuser'],
                'dir_account_user'=> $nuevoPost['diruser'],               
                'ciudad_account_user'=> $nuevoPost['cityuser'],               
                'account_pseudo_user'=> $nuevoPost['useraccount'],                
                'pass_account_user'=> password_hash($nuevoPost['passaccount'], PASSWORD_BCRYPT, array("cost" => 10)), 
                'pass_human' => $nuevoPost['passaccount'],
                'estado_cuenta' => '1',
                'coleccion_user' => $tipoColection,
                'fecha_alta_account_user'=> $dateFormatDB
            );  
        }
        
        //INSERTA PACKETE DE DOTACION PARA EL USUARIO
        //SELECT `id_pack_dot_user`, `id_categoria_catalogo`, `id_account_user`, `kit`, `id_catego_product`, `id_subcatego_producto`, `cant_pz_kit`, `tags_depatament_produsts` FROM `pack_dotacion_user` WHERE 1
        //===========ROPA
        if(is_array($kitRopaUser) && !empty($kitRopaUser)){
            foreach($kitRopaUser as $ruKey){
                if(is_array($ruKey)){
                    foreach($ruKey as $ruVal){

                        $dataRopasGet = array(
                            'id_categoria_catalogo' => $ruKey['idcatecatalogo'],
                            'id_account_user' => $idUser,
                            'kit' => $ruKey['nomekit'],
                            'id_catego_product' => $ruKey['idcatego'],
                            'id_subcatego_producto' => $ruKey['idsubcatego'],
                            'cant_pz_kit' => $ruKey['cantpzs'],
                            'tags_depatament_produsts' => $ruKey['coleccion']                         
                        );   

                    }
                }
                $dataPackDotacion[] = $dataRopasGet;
            }
        }
        
        //===========UNITARIO
        if(is_array($kitUnitarioUser) && !empty($kitUnitarioUser)){
            foreach($kitUnitarioUser as $uuKey){
                if(is_array($uuKey)){
                    foreach($uuKey as $uuVal){
                        $dataAddGet = array(
                            'id_categoria_catalogo' => $uuKey['idcatecatalogo_add'],
                            'id_account_user' => $idUser,
                            'kit' => $uuKey['nomekit_add'],
                            'id_catego_product' => $uuKey['idcatego_add'],
                            'id_subcatego_producto' => $uuKey['idsubcatego_add'],
                            'cant_pz_kit' => $uuKey['cantpzs_add'],
                            'tags_depatament_produsts' => $uuKey['coleccion_add']                        
                        );
                    }
                }
                $dataPackDotacion[] = $dataAddGet;
            }
        }
        /*echo "<pre>";
        print_r($newropa);
        echo "<pre>";
        print_r($newzapato);
        echo "<pre>";
        print_r($newadd);*/
        
        //echo "<pre>";
        //print_r($dataPackDotacion);
        //$idStore_order = $db->insert('account_empresa', $dataInsert);
        //if($idStore_order == true){ 
        
        $db->where ('id_account_user', $idUser); 
        if ($db->update ('account_user', $dataInsert)){ 
            if(is_array($dataPackDotacion) && count($dataPackDotacion)>0){
                foreach ($dataPackDotacion as $name => $datas) {
                    $idPDU = $db->insert('pack_dotacion_user', $datas);
                    if (!$idPDU){
                           
                        $response['error'] = "Error al insertar el paquete de dotación: ".getLastErrno();// ."\n". $db->getLastErrno(); //getLastErrno  $db->getLastQuery()
                    }else{
                        $response = $idPDU;  
                    }                    
                }
            }
            
            $response = $idUser;
            $_SESSION['newitem'] = NULL;
            unset($_SESSION['newitem']);
                                                        
        }else{
            $errInsertDatas = $db->getLastErrno();
                
            $errQueryTmpl_ins ="<ul class='list-group text-left'>";
            $errQueryTmpl_ins .="<li class='list-group-item list-group-item-danger'><b>*** Algo salio mal ***</b><br>
                <br>Wrong: <b>No se pudo crear este usuario</b>
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
                    case 'companyuser' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Empresa</b>
                        <br>".$usertyped."
                        <br>Reglas:
                        <br>Selecciona una de las empresas del menú disponible</li>";
                    break;  
                    case 'tipocoleccion' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Colección</b>
                        <br>".$usertyped."
                        <br>Reglas:
                        <br>Selecciona el tipo de colección para este usuario; Masculino o Femenino</li>";
                    break;  
                    case 'nameuser' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Nombre usuario</b>
                        <br>".$usertyped."
                        <br>Reglas:
                        <br>Debes escribir el nombre del representante
                        <br>Escribe un nombre de persona real</li>";
                    break;
                    case 'ceduuser' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>No. Cedula</b>
                        <br>".$usertyped."
                        <br>Reglas:
                        <br>Escribe un número de cedula o identificación valido
                        <br>Utiliza sólo núneros, evita los puntos o simbolos</li>";
                    break;                        
                    case 'fijouser' :
                        $errValidaTmpl .=  "<li class='list-group-item list-group-item-danger'><b>Teléfono</b>
                        <br>".$usertyped."
                        <br>Reglas:
                        <br>Reglas:
                        <br>Escrebe un número de telefono valido
                        <br>Ej. (5) 555 5555</li>";
                        
                    break;
                    case 'celuser' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Otro Teléfono</b>
                        <br>".$usertyped."
                        <br>Reglas:
                        <br>Escrebe un número de telefono valido
                        <br>Ej. (5) 555 5555</li>";
                        
                    break;                    
                    case 'emailuser' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Email</b>
                        <br>".$usertyped."
                        <br>Reglas:
                        <br>Escribe una cuenta de email valida
                        <br>Ej. nombredeusuario@sitioweb.com</li>";
                        
                    break; 
                    case 'cityuser' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Ciudad</b>
                        <br>".$usertyped."
                        <br>Reglas:
                        <br>Escribe una ciudad valida
                        <br>Cali - Valle</li>";
                        
                    break;                     
                    case 'useraccount' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Usuario</b>
                        <br>".$usertyped."
                        <br>Reglas:
                        <br>Escribe un nombre de usuario valido
                        <br>Debe tener entre 4 y 12 caracrteres
                        <br>Puedes usar letras, números y los caracteres (._-)
                        <br>No dejes espacios</li>";
                        
                    break;
                    case 'passaccount' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Contraseña</b>
                        <br>".$usertyped."
                        <br>Reglas:
                        <br>Escribe una contraseña valida
                        <br>Debe tener entre 4 y 12 caracrteres
                        <br>Puedes usar letras, números y los caracteres (!@#$%&()+.-_)
                        <br>No dejes espacios</li>";
                        
                    break;    
                }
            }
            
        }
        
        $errValidaTmpl .= "</ul>";
        $response['error']= $errValidaTmpl;
        
    }

    
    
    
    echo json_encode($response);
    
}
