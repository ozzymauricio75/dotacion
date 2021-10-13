<?php
require_once '../lib/MysqliDb.php';
require_once "../../cxconfig/config.inc.php";
require_once '../../cxconfig/global-settings.php';
require_once "../lib/gump.class.php";
require_once "site-tools.php"; 
require_once "../lib/password.php";


//========================================
//========================================
//CRUD ITEM EDIT
//========================================
//========================================
    
$response = array();

/////////////////////////
//RECIBE DATOS A EDITAR
/////////////////////////

$fieldEdit = empty($_POST['value'])? "" : $_POST['value'];
$idPost = empty($_POST['post'])? "" : $_POST['post'];
$fieldPost = empty($_POST['fieldedit'])? "" : $_POST['fieldedit'];


/*
/*===========================
/*NOMBRE REPRESENTANTE
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "namerepreitemform"){
        
    $fielvalid = validaAlphaSpace($fieldEdit, $idPost);
    
    if($fielvalid === true){
        $idRow = $idPost;
        $fieldRow = "nome_representante";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_account_user";
        $tbl = "account_user";
        $tituSqlERR = "NOMBRE REPRESENTANTE";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){            
            $response = $fieldRowEdit;                                    
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "Nombre representante";
        $ruleERR = "Parece, que estas usando caracteres prohibidos"; 
        $exERR = "Escribe un nombre real de persona"; 
        
        $response['error']= printErrValida($fielvalid, $tituERR, $ruleERR, $exERR);            
        
    }
    
    exit(json_encode($response));
}

/*
/*===========================
/*CARGO REPRESENTANTE
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "cargorepreitemform"){
        
    $fielvalid = validaAlphaSpace($fieldEdit, $idPost);
    
    if($fielvalid === true){
        $idRow = $idPost;
        $fieldRow = "cargo_repre_empresa";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_account_user";
        $tbl = "account_user";
        $tituSqlERR = "CARGO REPRESENTANTE";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){            
            $response = $fieldRowEdit;                                    
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "Cargo representante";
        $ruleERR = "Escribe el cargo del representante"; 
        $exERR = ""; 
        
        $response['error']= printErrValida($fielvalid, $tituERR, $ruleERR, $exERR);            
        
    }
    
    exit(json_encode($response));
}


/*
/*===========================
/*REFERENCIA
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "refitemform"){
        
    $fielvalid = validaAlphaSpace($fieldEdit, $idPost);
    
    if($fielvalid === true){
        $idRow = $idPost;
        $fieldRow = "ref_account_empre";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_account_user";
        $tbl = "account_user";
        $tituSqlERR = "REFERENCIA EMPRESA";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){            
            $response = $fieldRowEdit;                                    
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "Referencia empresa";
        $ruleERR = "Puedes usar letras números y los caracteres (.-_)"; 
        $exERR = ""; 
        
        $response['error']= printErrValida($fielvalid, $tituERR, $ruleERR, $exERR);            
        
    }
    
    exit(json_encode($response));
}


/*
/*===========================
/*NOMBRE USUARIO
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "nameitemform"){
        
    $fielvalid = validaAlphaSpace($fieldEdit, $idPost);
    
    if($fielvalid === true){
        $idRow = $idPost;
        $fieldRow = "nombre_account_user";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_account_user";
        $tbl = "account_user";
        $tituSqlERR = "NOMBRE USUARIO";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){            
            $response = $fieldRowEdit;                                    
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "Nombre usuario";
        $ruleERR = "Puedes usar letras números y los caracteres"; 
        $exERR = ""; 
        
        $response['error']= printErrValida($fielvalid, $tituERR, $ruleERR, $exERR);            
        
    }
    
    exit(json_encode($response));
}

/*
/*===========================
/*CEDULA EMPRESA
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "ceduitemform"){
        
    $fielvalid = validaAlphaSpace($fieldEdit, $idPost);
    
    if($fielvalid === true){
        $idRow = $idPost;
        $fieldRow = "cedula_user";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_account_user";
        $tbl = "account_user";
        $tituSqlERR = "CEDULA";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){            
            $response = $fieldRowEdit;                                    
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "Cedula";
        $ruleERR = "Escribe un numero de cedula valido"; 
        $exERR = ""; 
        
        $response['error']= printErrValida($fielvalid, $tituERR, $ruleERR, $exERR);            
        
    }
    
    exit(json_encode($response));
}

/*
/*===========================
/*TELEFONO USUARIO
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "tel1itemform"){
        
    $fielvalid = validaPhoneNumber($fieldEdit, $idPost);
    
    if($fielvalid === true){
        $idRow = $idPost;
        $fieldRow = "tel_account_user";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_account_user";
        $tbl = "account_user";
        $tituSqlERR = "TEL/CEL USUARIO";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){            
            $response = $fieldRowEdit;                                    
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "Tel/Cel usuario";
        $ruleERR = "Escribe un número de teléfono valido"; 
        $exERR = "(57) 2 555 55 55 Ext. 555"; 
        
        $response['error']= printErrValida($fielvalid, $tituERR, $ruleERR, $exERR);            
        
    }
    
    exit(json_encode($response));
}


/*
/*===========================
/*TELEFONO USUARIO 2
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "tel2itemform"){
        
    $fielvalid = validaPhoneNumber($fieldEdit, $idPost);
    
    if($fielvalid === true){
        $idRow = $idPost;
        $fieldRow = "tel_account_user2";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_account_user";
        $tbl = "account_user";
        $tituSqlERR = "TEL/CEL USUARIO";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){            
            $response = $fieldRowEdit;                                    
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "Tel/Cel usuario";
        $ruleERR = "Escribe un número de teléfono valido"; 
        $exERR = "(57) 2 555 55 55 Ext. 555"; 
        
        $response['error']= printErrValida($fielvalid, $tituERR, $ruleERR, $exERR);            
        
    }
    
    exit(json_encode($response));
}


/*
/*===========================
/*EMAIL
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "emailitemform"){
        
    $fielvalid = validaEmail($fieldEdit, $idPost);
    
    if($fielvalid === true){
        $idRow = $idPost;
        $fieldRow = "mail_account_user";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_account_user";
        $tbl = "account_user";
        $tituSqlERR = "EMAIL";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){            
            $response = $fieldRowEdit;                                    
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "Email";
        $ruleERR = "Escribe una cuenta de Email valida"; 
        $exERR = "usuario@sitioweb.com"; 
        
        $response['error']= printErrValida($fielvalid, $tituERR, $ruleERR, $exERR);            
        
    }
    
    exit(json_encode($response));
}

/*
/*===========================
/*DIRECCION
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "diritemform"){
        
    $fielvalid = validaAddress($fieldEdit, $idPost);
    
    if($fielvalid === true){
        $idRow = $idPost;
        $fieldRow = "dir_account_user";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_account_user";
        $tbl = "account_user";
        $tituSqlERR = "DIRECCION";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){            
            $response = $fieldRowEdit;                                    
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "Dirección";
        $ruleERR = "Escribe la dirección del usuario"; 
        $exERR = "Carrera/Calle 123 #55-55 Nombre del barrio"; 
        
        $response['error']= printErrValida($fielvalid, $tituERR, $ruleERR, $exERR);            
        
    }
    
    exit(json_encode($response));
}


/*
/*===========================
/*CIUDAD
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "cityitemform"){
        
    $fielvalid = validaAlphaSpace($fieldEdit, $idPost);
    
    if($fielvalid === true){
        $idRow = $idPost;
        $fieldRow = "ciudad_account_user";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_account_user";
        $tbl = "account_user";
        $tituSqlERR = "CIUDAD";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){            
            $response = $fieldRowEdit;                                    
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "Ciudad";
        $ruleERR = "Escribe la ciudad de la empresa"; 
        $exERR = "Cali - Valle"; 
        
        $response['error']= printErrValida($fielvalid, $tituERR, $ruleERR, $exERR);            
        
    }
    
    exit(json_encode($response));
}

/*
/*===========================
/*USUARIO
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "useritemform"){
        
    $fielvalid = validaUserName($fieldEdit, $idPost);
    
    if($fielvalid === true){
        $idRow = $idPost;
        $fieldRow = "account_pseudo_user";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_account_user";
        $tbl = "account_user";
        $tituSqlERR = "NOMBRE DE USUARIO";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){            
            $response = $fieldRowEdit;                                    
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "Nombre de usuario";
        $ruleERR = "Escribe un nombre de usuario entre 4 y 12 caracteres. Puedes usar letras, números y (._-)"; 
        $exERR = ""; 
        
        $response['error']= printErrValida($fielvalid, $tituERR, $ruleERR, $exERR);            
        
    }
    
    exit(json_encode($response));
}


/*
/*===========================
/*PASSWORD
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "passitemform"){
        
    $fielvalid = validaPassUser($fieldEdit, $idPost);
    
    if($fielvalid === true){
                                        
        $datasUpload = array(
            'pass_account_user' => password_hash($fieldEdit, PASSWORD_BCRYPT, array("cost" => 10)),
            'pass_human' => $fieldEdit
        );
                
        $db->where ('id_account_user', $idPost );
                
        if($db->update ('account_user', $datasUpload)){                                    
            $response = $fieldEdit;                                    
        }else{
            $erroQuery = $db->getLastErrno();
            $response['error']= "Ocurrio un problema al actualizar la contraseña<br><b>Error:</b> ".$erroQuery."<br>";
                       
        }                
    }else{
        $tituERR = "Contraseña usuario";
        $ruleERR = "Escribe un una contraseña entre 4 y 12 caracteres. Puedes usar letras, números y (!@#$%&()+.-_)"; 
        $exERR = ""; 
        
        $response['error']= printErrValida($fielvalid, $tituERR, $ruleERR, $exERR);            
        
    }
    
    exit(json_encode($response));
}


/*
/*===========================
/*STATUS ITEM
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "statusitemform"){
        
    $fielvalid = validaInteger($fieldEdit, $idPost);
    
    if($fielvalid === true){
        $idRow = $idPost;
        $fieldRow = "estado_cuenta";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_account_user";
        $tbl = "account_user";
        $tituSqlERR = "STATUS PUBLICACIÓN";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){            
            $response = $fieldRowEdit;                                    
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "status publicación";
        $ruleERR = "Selecciona una de las opciones de STATUS disponibles"; 
        $exERR = "Revisión - Activado - Suspendido"; 
        
        $response['error']= printErrValida($fielvalid, $tituERR, $ruleERR, $exERR);            
        
    }
    
    exit(json_encode($response));
}


/*
/*===========================
/*STATUS ITEM
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "colectionuserform"){
        
    $fielvalid = validaInteger($fieldEdit, $idPost);
    
    if($fielvalid === true){
        $idRow = $idPost;
        $fieldRow = "coleccion_user";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_account_user";
        $tbl = "account_user";
        $tituSqlERR = "COLECCIÓN USUARIO";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){            
            $response = $fieldRowEdit;                                    
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "Colección usuario";
        $ruleERR = "Selecciona una de las opciones disponibles"; 
        $exERR = "Masculino - Femenino"; 
        
        $response['error']= printErrValida($fielvalid, $tituERR, $ruleERR, $exERR);            
        
    }
    
    exit(json_encode($response));
}



/*
/*===========================
/*KITS USUARIO
/*===========================
*/

//$fieldPost = $_POST['fieldedit'];
//$response = array();

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
        
    //SOBRE LOS KIT ASIGNADOS
    
    //TIPO COLECCION
    $tipoColection = (empty($_POST['colectioncheck']))? "" : $_POST['colectioncheck'];
    
    $kitRopaUserJson = $_POST['ropakituser'];
    $kitRopaUser = json_decode($kitRopaUserJson, true);
    $kitUnitarioUserJson = $_POST['unitariokituser'];
    $kitUnitarioUser = json_decode($kitUnitarioUserJson, true);
    
    
    //ELIMINAR LOS KITS ACTUALES D ESTE USUARIO
    //SELECT `id_pack_dot_user`, `id_categoria_catalogo`, `id_account_user`, `kit`, `id_catego_product`, `id_subcatego_producto`, `cant_pz_kit`, `tags_depatament_produsts` FROM `pack_dotacion_user` WHERE 1
    $db->where('id_account_user', $idUser);
    $deleteKit = $db->delete('pack_dotacion_user');
    $errDeleteDatas = $db->getLastErrno();
    
    
	if(!$errDeleteDatas){
        
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
        
       
        if(is_array($dataPackDotacion) && count($dataPackDotacion)>0){
            foreach ($dataPackDotacion as $name => $datas) {
                $idPDU = $db->insert('pack_dotacion_user', $datas);
                if (!$idPDU){
                    $response['error'] = "Error al insertar el paquete de dotación: ".$db->getLastQuery();// ."\n". $db->getLastError() $db->getLastQuery()    
                }else{
                    
                    $response = $idPDU;   
                }                    
            }
        }
            
            
                
    }else{
        
        $errValidaTmpl = "";
        $errValidaTmpl .= "<ul class='list-group text-left box75'>";               
        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Editar Kit</b>
                        <br>Ocurrio un problema con el servidor en el momento de modificar el paquete de kits para este usuario 
                        <br>Por favor intentalo de nuevo más tarde</li>";
        $errValidaTmpl .= "</ul>";
        $response['error']= $errValidaTmpl;
        
    }

    echo json_encode($response);   
}