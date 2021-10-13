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

$fieldEdit = $_POST['value'];
$idPost = $_POST['post'];
$fieldPost = $_POST['fieldedit'];


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
        $idFieldTbl = "id_account_empre";
        $tbl = "account_empresa";
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
        $idFieldTbl = "id_account_empre";
        $tbl = "account_empresa";
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
        $idFieldTbl = "id_account_empre";
        $tbl = "account_empresa";
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
/*NOMBRE EMPRESA
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "nameitemform"){
        
    $fielvalid = validaAlphaSpace($fieldEdit, $idPost);
    
    if($fielvalid === true){
        $idRow = $idPost;
        $fieldRow = "nombre_account_empre";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_account_empre";
        $tbl = "account_empresa";
        $tituSqlERR = "NOMBRE EMPRESA";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){            
            $response = $fieldRowEdit;                                    
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "Nombre empresa";
        $ruleERR = "Puedes usar letras números y los caracteres"; 
        $exERR = ""; 
        
        $response['error']= printErrValida($fielvalid, $tituERR, $ruleERR, $exERR);            
        
    }
    
    exit(json_encode($response));
}

/*
/*===========================
/*NIT EMPRESA
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "nititemform"){
        
    $fielvalid = validaAlphaSpace($fieldEdit, $idPost);
    
    if($fielvalid === true){
        $idRow = $idPost;
        $fieldRow = "nit_empresa";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_account_empre";
        $tbl = "account_empresa";
        $tituSqlERR = "NIT EMPRESA";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){            
            $response = $fieldRowEdit;                                    
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "Nit empresa";
        $ruleERR = "Escribe el NIT de la empresa"; 
        $exERR = ""; 
        
        $response['error']= printErrValida($fielvalid, $tituERR, $ruleERR, $exERR);            
        
    }
    
    exit(json_encode($response));
}

/*
/*===========================
/*TELEFONO EMPRESA
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "tel1itemform"){
        
    $fielvalid = validaPhoneNumber($fieldEdit, $idPost);
    
    if($fielvalid === true){
        $idRow = $idPost;
        $fieldRow = "tel_account_empre1";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_account_empre";
        $tbl = "account_empresa";
        $tituSqlERR = "TEL/CEL EMPRESA";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){            
            $response = $fieldRowEdit;                                    
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "Tel/Cel empresa";
        $ruleERR = "Escribe un número de teléfono valido"; 
        $exERR = "(57) 2 555 55 55 Ext. 555"; 
        
        $response['error']= printErrValida($fielvalid, $tituERR, $ruleERR, $exERR);            
        
    }
    
    exit(json_encode($response));
}


/*
/*===========================
/*TELEFONO EMPRESA 2
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "tel2itemform"){
        
    $fielvalid = validaPhoneNumber($fieldEdit, $idPost);
    
    if($fielvalid === true){
        $idRow = $idPost;
        $fieldRow = "tel_account_empre2";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_account_empre";
        $tbl = "account_empresa";
        $tituSqlERR = "TEL/CEL EMPRESA";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){            
            $response = $fieldRowEdit;                                    
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "Tel/Cel empresa";
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
        $fieldRow = "mail_account_empre";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_account_empre";
        $tbl = "account_empresa";
        $tituSqlERR = "EMAIL EMPRESA";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){            
            $response = $fieldRowEdit;                                    
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "Email empresa";
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
        $fieldRow = "dir_account_empre";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_account_empre";
        $tbl = "account_empresa";
        $tituSqlERR = "DIRECCION EMPRESA";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){            
            $response = $fieldRowEdit;                                    
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "Dirección empresa";
        $ruleERR = "Escribe la dirección del establecimiento"; 
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
        $fieldRow = "ciudad_account_empre";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_account_empre";
        $tbl = "account_empresa";
        $tituSqlERR = "CIUDAD EMPRESA";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){            
            $response = $fieldRowEdit;                                    
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "Ciudad empresa";
        $ruleERR = "Escribe la ciudad de la empresa"; 
        $exERR = "Cali - Valle"; 
        
        $response['error']= printErrValida($fielvalid, $tituERR, $ruleERR, $exERR);            
        
    }
    
    exit(json_encode($response));
}

/*
/*===========================
/*COMENTARIOS
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "commentitemform"){
        
    $fielvalid = validaAlphaSpace($fieldEdit, $idPost);
    
    if($fielvalid === true){
        $idRow = $idPost;
        $fieldRow = "comentarios_empresa";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_account_empre";
        $tbl = "account_empresa";
        $tituSqlERR = "COMENTARIOS EMPRESA";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){            
            $response = $fieldRowEdit;                                    
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "Comentarios empresa";
        $ruleERR = "Parece que estas usando caracteres prohibidos en este campo, puedes usar letra, números y signos de puntuación"; 
        $exERR = ""; 
        
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
        $fieldRow = "pseudo_user_empresa";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_account_empre";
        $tbl = "account_empresa";
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
            'pass_account_empre' => password_hash($fieldEdit, PASSWORD_BCRYPT, array("cost" => 10)),
            'pass_human' => $fieldEdit
        );
                
        $db->where ('id_account_empre', $idPost );
                
        if($db->update ('account_empresa', $datasUpload)){                                    
            $response = $fieldRowEdit;                                    
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
        $fieldRow = "id_estado";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_account_empre";
        $tbl = "account_empresa";
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