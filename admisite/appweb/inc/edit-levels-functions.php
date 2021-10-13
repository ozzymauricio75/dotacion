<?php
require_once '../lib/MysqliDb.php';
require_once "../../cxconfig/config.inc.php";
require_once '../../cxconfig/global-settings.php';
require_once "../lib/gump.class.php";
require_once "site-tools.php"; 

//========================================
//========================================
//EDITA LABEL CATEGORIA
//========================================
//========================================


$fileValida = "";
$successUpload = null;
$response = [];

if(isset($_POST['datafield']) && $_POST['datafield'] == "editlabelsubcate"){
    //recibe datas post file
    $filePost = $_FILES['labell3']; //empty($_POST['fotoprod'])? "" : $_POST['fotoprod'];  
    $filePostName = $_FILES['labell3']['name'];
    $filePostTmpName = $_FILES['labell3']['tmp_name'];
    $filePostType = $_FILES['labell3']['type'];
    $filePostSize = $_FILES['labell3']['size'];
    $filePostErro = $_FILES['labell3']['error'];
    
    //$idLevel3 = $_POST['codeitem'];//codeitem: $(this).attr("data-idlabel"),
    
    //echo $filePost;
    //echo $idLevel3;
    //$response = $filePost;
    //name portada
    $nameLabelPost = empty($_POST['nameportadaitem']) ? "" : $_POST['nameportadaitem'];
    

    if(isset($nameLabelPost) && $nameLabelPost != ""){    
        //name file
        $nameFileGet = explode(".", $nameLabelPost); 
        $nameFile = $nameFileGet[0];    
        $nameFileTBL = $nameLabelPost;    
    }else{
        //name file
        $nameFile = "IMG_".$dateFormatPost;
        $nameFileTBL = $nameFile.".jpg";    
    }
    
    //id post
    $idPost = empty($_POST['codeitem']) ? "" : $_POST['codeitem'];
    //valor edit post
    $fielEdit = $nameFileTBL;



    //tratar file    
    $fileCheck = array();
    if(!empty($filePostName)){
        validafile($filePost, $filePostName, $filePostTmpName, $filePostType, $filePostSize, $filePostErro);
        if(isset($err) && $err != ""){
            //print_r($err);
            $fileValida = "error";
            $fileCheck[] = $err;            
        }
    }
    
    if($fileValida != "error"){
                
        if(upimgfile($filePostName, $filePostTmpName)){
            
            $rutaLAbelExist = "../../../files-display/album/labels/".$fielEdit;	
            
            if (file_exists($rutaLAbelExist)){
                unlink($rutaLAbelExist);
            }
            //if(unlink($rutaLAbelExist)){
                        
            $patFileEnd = "tienda/img-catego/"; //define el directorio final de la imagen   
            $squareFile = "600";  //define dimensiones de imagen

            if(redimensionaImgFile($filePostName, $filePostType, $nameFile, $patFileEnd, $squareFile)){

               /*if(redimensionaImgFile($filePostName, $filePostType, $nameFile, $patFileEnd400, $squareFile400) && redimensionaImgFile($filePostName, $filePostType, $nameFile, $patFileEnd800, $squareFile800) && redimensionaImgFile($filePostName, $filePostType, $nameFile, $patFileEnd1200, $squareFile1200)){*/

                    if($nameLabelPost == ""){ 

                        $idRow = $idPost;
                        $fieldRow = "mg_subcate_prod";
                        $fieldRowEdit = $fielEdit;
                        $idFieldTbl = "id_subcatego_producto";
                        $tbl = "sub_categorias_productos";
                        $tituSqlERR = "FOTO PORTADA";

                        //actualizar campo en base de datos
                        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);

                        if($goEdit === true){

                            $response = $fieldRowEdit;     


                        }else{

                            $response['error']= $goEdit;

                        }
                    }

                    //$reloadDir = "files-display/album/labels/";
                    //gotoRedirect($reloadDir);

                    $response = ['uploaded'=>'Subio correctamente'];

                /*}else{//si redimension fue positivo
                    $errRedesize = 1;       
                    $response = ['error'=>'no se pudo crear as copias'];
                }//si redimension fue negativo
                //$response = ['uploaded'=>'subio correctamente'];*/

            }else{//si redimension fue positivo
                $errRedesize = 1;       
                $response = ['error'=>'No se pudo crear el thumb'];
            }//si redimension fue negativo
            //$response = ['uploaded'=>'subio correctamente'];
            //}else{
                //$response = ['error'=>'no se pudo eliminar la portada actual'];                
            //}

        }else{//si upload fue positivo
            $errUpLoad = 1; 
            $response = ['error'=>'No se pudo subir al servidor la imágen que seleccionaste'];
        }//si upload fue negativo
        
    }else{
        $erroFileUL = printFileErr($fileCheck);
        //$success = false;    
        //$erroFileULLayout = "<section class='box50 padd-verti-xs'>";
        $erroFileULLayout = "<ul class='list-group box75 text-left'>";
        $erroFileULLayout .= $erroFileUL;
        $erroFileULLayout .= "</ul>";
        //$erroFileULLayout .= "</section>";
        
        $response = ['error'=>$erroFileULLayout];
    }
    
    
    echo json_encode($response);
}



//========================================
//========================================
//EDITA LABEL CATEGORIA
//========================================
//========================================


/////////////////////////
//RECIBE DATOS A EDITAR
/////////////////////////

$fieldEdit = empty($_POST['value'])? "" : $_POST['value'];
$idPost = empty($_POST['post'])? "" : $_POST['post'];
$fieldPost = empty($_POST['fieldedit'])? "" : $_POST['fieldedit'];
$namefieldPost = empty($_POST['field'])? "" : $_POST['field'];

/*
/*===========================
/*NAME LEVEL 1
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "updatenamel1"){
        
    $fielvalid = validaAlphaSpace($fieldEdit, $idPost);
    
    if($fielvalid === true){
        $idRow = $idPost;
        $fieldRow = "nome_depart_prod";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_depart_prod";
        $tbl = "departamento_prods";
        $tituSqlERR = "NOMBRE COLECCIÓN";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){            
            $response = $fieldRowEdit;                                    
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "Nombre colección";
        $ruleERR = "Escribe un nombre valido para esta categoría"; 
        $exERR = "Colección masculino, Colección femenino, Colección Infántil"; 
        
        $response['error']= printErrValida($fielvalid, $tituERR, $ruleERR, $exERR);            
        
    }
    
    exit(json_encode($response));
}


/*
/*===========================
/* DESCRI LEVEL 1
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "updatedescril1"){
        
    $fielvalid = validaAlphaSpace($fieldEdit, $idPost);
    
    if($fielvalid === true){
        $idRow = $idPost;
        $fieldRow = "descri_depart_prod";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_depart_prod";
        $tbl = "departamento_prods";
        $tituSqlERR = "DESCRIPCIÓN COLECCIÓN";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){            
            $response = $fieldRowEdit;                                    
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "Descripción colección";
        $ruleERR = "Escribir algún texto introductorio para esta categoría, puedes usar letras, números y signos de puntuación"; 
        $exERR = ""; 
        
        $response['error']= printErrValida($fielvalid, $tituERR, $ruleERR, $exERR);            
        
    }
    
    exit(json_encode($response));
}


/*
/*===========================
/*NAME LEVEL 2
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "updatenamel2"){
        
    $fielvalid = validaAlphaSpace($fieldEdit, $idPost);
    
    if($fielvalid === true){
        $idRow = $idPost;
        $fieldRow = "nome_catego_product";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_catego_product";
        $tbl = "categorias_productos";
        $tituSqlERR = "Nombre KIT";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){            
            $response = $fieldRowEdit;                                    
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "Nombre KIT";
        $ruleERR = "Escribir un nombre de Kit valido"; 
        $exERR = "Formal, Clasico, Sport"; 
        
        $response['error']= printErrValida($fielvalid, $tituERR, $ruleERR, $exERR);            
        
    }
    
    exit(json_encode($response));
}


/*
/*===========================
/*DESCRI LEVEL 2
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "updatesubnamel2"){
        
    $fielvalid = validaAlphaSpace($fieldEdit, $idPost);
    
    if($fielvalid === true){
        $idRow = $idPost;
        $fieldRow = "descri_catego_prod";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_catego_product";
        $tbl = "categorias_productos";
        $tituSqlERR = "Sub Nombre KIT";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){            
            $response = $fieldRowEdit;                                    
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "Sub Nombre KIT";
        $ruleERR = "Escribir un nombre de Kit valido"; 
        $exERR = "Clima calido, Clima frio"; 
        
        $response['error']= printErrValida($fielvalid, $tituERR, $ruleERR, $exERR);            
        
    }
    
    exit(json_encode($response));
}

/*
/*===========================
/*NUMERO PIEZAS LEVEL 2
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "updatepzsl2"){
        
    $fielvalid = validaInteger($fieldEdit, $idPost);
    
    if($fielvalid === true){
        $idRow = $idPost;
        $fieldRow = "cant_pz_kit";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_catego_product";
        $tbl = "categorias_productos";
        $tituSqlERR = "Cant. Piezas KIT";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){            
            $response = $fieldRowEdit;                                    
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "Cant. Piezas KIT";
        $ruleERR = "Escribe una cantidad valida, Sólo puedes usar números"; 
        $exERR = "2, 3, 4"; 
        
        $response['error']= printErrValida($fielvalid, $tituERR, $ruleERR, $exERR);            
        
    }
    
    exit(json_encode($response));
}


/*
/*===========================
/*NAME LEVEL 3
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "updatenamel3"){
        
    $fielvalid = validaAlphaSpace($fieldEdit, $idPost);
    
    if($fielvalid === true){
        $idRow = $idPost;
        $fieldRow = "nome_subcatego_producto";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_subcatego_producto";
        $tbl = "sub_categorias_productos";
        $tituSqlERR = "Nombre prenda Kit";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){            
            $response = $fieldRowEdit;                                    
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "Nombre prenda Kit";
        $ruleERR = "Escribir un nombre de prenda valido, puedes suar letras y números"; 
        $exERR = "Camisa, Camisa manga larga"; 
        
        $response['error']= printErrValida($fielvalid, $tituERR, $ruleERR, $exERR);            
        
    }
    
    exit(json_encode($response));
}


/*
/*===========================
/*DESCRI LEVEL 3
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "updatedescril3"){
        
    $fielvalid = validaAlphaSpace($fieldEdit, $idPost);
    
    if($fielvalid === true){
        $idRow = $idPost;
        $fieldRow = "descri_subcatego_prod";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_subcatego_producto";
        $tbl = "sub_categorias_productos";
        $tituSqlERR = "Descripción prenda KIT";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){            
            $response = $fieldRowEdit;                                    
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "Descripción prenda KIT";
        $ruleERR = "Escribir algún texto introductorio para esta categoría, puedes usar letras, números y signos de puntuación"; 
        $exERR = ""; 
        
        $response['error']= printErrValida($fielvalid, $tituERR, $ruleERR, $exERR);            
        
    }
    
    exit(json_encode($response));
}



//========================================
//========================================
//ELIMINA CATEGORIAS
//========================================
//========================================


/*
/*===========================
/*ELIMINA LEVEL 3
/*===========================
*/

if((isset($_POST['deletelevel']) && $_POST['deletelevel'] == "ok") && (isset($fieldPost) && $fieldPost == "trashl3")){
    
    $fielvalid = validaInteger($idPost, $idPost);
            
    if($fielvalid === true){
        
        $idRow = $idPost;        
        $idFieldTbl = "id_subcatego_producto";
        $tbl = "sub_categorias_productos";
                         
        $db->where($idFieldTbl, $idRow);
                     
        if($db->delete($tbl)){
            
            $response = true;
            
        }else{
        
            $erroQuery = $db->getLastErrno();
            $response['error']= $erroQuery;
        }
        
    }else{        
        $response['error']= "Si deseas eliminar una categoría, tan sólo dale click al boton eliminar, de la categoría correspondiente";
    }
    exit(json_encode($response));
}


/*
/*===========================
/*ELIMINA LEVEL 2
/*===========================
*/

if((isset($_POST['deletelevel']) && $_POST['deletelevel'] == "ok") && (isset($fieldPost) && $fieldPost == "trashl2")){
    
    $fielvalid = validaInteger($idPost, $idPost);
            
    if($fielvalid === true){
        
        $idRow = $idPost;        
        $idFieldTbl = "id_catego_product";
        $tbl = "categorias_productos";
                         
        $db->where($idFieldTbl, $idRow);
                     
        if($db->delete($tbl)){
            
            $response = true;
            
        }else{
        
            $erroQuery = $db->getLastErrno();
            $response['error']= $erroQuery;
        }
        
    }else{        
        $response['error']= "Si deseas eliminar una categoría, tan sólo dale click al boton eliminar, de la categoría correspondiente";
    }
    exit(json_encode($response));
}


/*
/*===========================
/*ELIMINA LEVEL 1
/*===========================
*/

if((isset($_POST['deletelevel']) && $_POST['deletelevel'] == "ok") && (isset($fieldPost) && $fieldPost == "trashl1")){
    
    $fielvalid = validaInteger($idPost, $idPost);
            
    if($fielvalid === true){
        
        $idRow = $idPost;        
        $idFieldTbl = "id_depart_prod";
        $tbl = "departamento_prods";
                         
        $db->where($idFieldTbl, $idRow);
                     
        if($db->delete($tbl)){
            
            $response = true;
            
        }else{
        
            $erroQuery = $db->getLastErrno();
            $response['error']= $erroQuery;
        }
        
    }else{        
        $response['error']= "Si deseas eliminar una categoría, tan sólo dale click al boton eliminar, de la categoría correspondiente";
    }
    exit(json_encode($response));
}