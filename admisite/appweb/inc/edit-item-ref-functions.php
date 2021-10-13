<?php
require_once '../lib/MysqliDb.php';
require_once "../../cxconfig/config.inc.php";
require_once '../../cxconfig/global-settings.php';
require_once "../lib/gump.class.php";
require_once "site-tools.php"; 


//========================================
//========================================
//CRUD ITEM REF EDIT
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
/*CANTIDAD SSTOCK ITEM
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "cantstockform"){
        
    $fielvalid = validaInteger($fieldEdit, $idPost);
    
    if($fielvalid === true){
        $idRow = $idPost;
        $fieldRow = "cant_exist_prod_filing";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_prod_filing";
        $tbl = "productos_filing";
        $tituSqlERR = "EXISTENCIAS PRODUCTO";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){            
            $response = $fieldRowEdit;                                    
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "Existencias producto";
        $ruleERR = "Escribe un número entero"; 
        $exERR = "12, 24, 36"; 
        
        $response['error']= printErrValida($fielvalid, $tituERR, $ruleERR, $exERR);            
        
    }
    
    exit(json_encode($response));
}

/*
/*===========================
/*MIN STOCK ITEM REFERENCIA
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "mincantstockform"){
        
    $fielvalid = validaInteger($fieldEdit, $idPost);
    
    if($fielvalid === true){
        $idRow = $idPost;
        $fieldRow = "min_exist_prod_filing";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_prod_filing";
        $tbl = "productos_filing";
        $tituSqlERR = "MIN EXISTENCIAS PRODUCTO";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){            
            $response = $fieldRowEdit;                                    
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "Min. existencias producto";
        $ruleERR = "Escribe un número entero"; 
        $exERR = "12, 24, 36";  
        
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
        $fieldRow = "id_estado_contrato";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_prod_filing";
        $tbl = "productos_filing";
        $tituSqlERR = "STATUS PRODUCTO";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){            
            $response = $fieldRowEdit;                                    
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "status producto";
        $ruleERR = "Selecciona una de las opciones de STATUS disponibles"; 
        $exERR = "Revisión - Activado - Suspendido"; 
        
        $response['error']= printErrValida($fielvalid, $tituERR, $ruleERR, $exERR);            
        
    }
    
    exit(json_encode($response));
}


/*
/*===========================
/*ELIMINAR FOTOS DE ALBUM
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "deletefoto"){
    //$response = "llego al delete"; 
    $fielvalid = validaAlphaSpace($fieldEdit, $idPost);
            
    if($fielvalid === true){                
        $idRow = $idPost;
        $fileRow = $fieldEdit;
        $tituSqlERR = "ELIMINAR FOTO";
        
        $trashFoto = deleteFile($idRow, $fileRow, $tituSqlERR);
        
        if($trashFoto===true){
            $response = true;    
        }else{            
            $response['error']= $trashFoto;    
        }
                        
    }else{
        
        $response['error']= "Si deseas eliminar una foto del album, sólo debes dar click en el botón eliminar de la foto correspondiente.";
    }
    exit(json_encode($response));
}