<?php
require_once '../lib/MysqliDb.php';
require_once "../../cxconfig/config.inc.php";
require_once '../../cxconfig/global-settings.php';
require_once "../lib/gump.class.php";
require_once "site-tools.php"; 


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
/*NOMBRE ITEM
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "nameitemform"){
        
    $fielvalid = validaAlphaSpace($fieldEdit, $idPost);
    
    if($fielvalid === true){
    
    	
    
        $idRow = $idPost;
        $fieldRow = "nome_producto";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_producto";
        $tbl = "productos";
        $tituSqlERR = "NOMBRE PRODUCTO";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){            
		
            
            	//CONSULTA REFERENCIAS PRODUCTO
		$coddescri_array = array();
		
		$db->where('id_producto', $idPost);
		$query_prodref = $db->get('productos_filing', null, 'id_prod_filing, cod_venta_descri_filing');        
		//print_r($query_prodref);
		if(count($query_prodref) > 0){
			foreach($query_prodref as $qprKey){
				$id_prod_ref = $qprKey['id_prod_filing'];
				$coddescri_prod_ref = $qprKey['cod_venta_descri_filing'];	
				
				//CREA NUEVO COD DESCRI PRODUCTO REF
				$coddescri_array = explode("&nbsp;", $coddescri_prod_ref);
				if(is_array($coddescri_array)){
					foreach($coddescri_array as $cdaKey){
						$nombre_prodref = $coddescri_array[0];
						$skuitem_prodref = $coddescri_array[1];
						$talla_prodref = $coddescri_array[2];		
						$color_prodref = $coddescri_array[3];	
						//FORMATO CODE DESCRI ->>>    $skuFull =  $nameItemGB."&nbsp;".$skuItemGB."&nbsp;".$nameTN."&nbsp;".$nameColor;
						$new_coddescri_prodref = $fieldRowEdit."&nbsp;".$skuitem_prodref."&nbsp;".$talla_prodref."&nbsp;".$color_prodref;																	
					}
				}
				
				//MODIFICA EL CODE DESCRI DEL PRODUCTO	
				
				//datos para editar cod desdri prod
				$tbl_prodref = "productos_filing";
				$id_field_tbl_prodref = "id_prod_filing";
				$field_row_prodref = "cod_venta_descri_filing";
				$id_row_prodref = $id_prod_ref;
				$field_row_edit_prodref = $new_coddescri_prodref;
				$titu_sql_err_prodref = "CODIGO VENTA DETALLE";
			
				$goEditProdRef = editFielDB($id_row_prodref, $field_row_prodref, $field_row_edit_prodref, $id_field_tbl_prodref, $tbl_prodref, $titu_sql_err_prodref);
				
				if(!$goEditProdRef){           
			            $response['error']= $goEditProdRef;            
			        }
			        
			        //datos para editar nombre producto referencia
				$tbl_name_prodref = "productos_filing";
				$id_field_tbl_name_prodref = "id_prod_filing";
				$field_row_name_prodref = "nome_producto_filing";
				$id_row_name_prodref = $id_prod_ref;
				$field_row_edit_name_prodref =$fieldRowEdit;
				$titu_sql_err_name_prodref = "NOMBRE PRODUCTO REF";
			
				$goEditNameProdRef = editFielDB($id_row_name_prodref, $field_row_name_prodref, $field_row_edit_name_prodref, $id_field_tbl_name_prodref, $tbl_name_prodref, $titu_sql_err_name_prodref);
				
				if(!$goEditNameProdRef){           
			            $response['error']= $goEditProdRef;            
			        }	
			}
		}
		//CONSULTA REFERENCIA PRODUCTO
		//////////////////////////////
            	$response = $fieldRowEdit;
                                                
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "Nombre producto";
        $ruleERR = "Parece, que estas usando caracteres prohibidos. Puedes usar letras y números"; 
        $exERR = "Nombre del producto"; 
        
        $response['error']= printErrValida($fielvalid, $tituERR, $ruleERR, $exERR);            
        
    }
    
    exit(json_encode($response));
}

/*
/*===========================
/*SKU ITEM
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "skuitemform"){
        
    $fielvalid = validaAlphaSpace($fieldEdit, $idPost);
    
    if($fielvalid === true){
        $idRow = $idPost;
        $fieldRow = "cod_venta_prod";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_producto";
        $tbl = "productos";
        $tituSqlERR = "SKU PRODUCTO";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){ 
		//CONSULTA REFERENCIAS PRODUCTO
				
		$db->where('id_producto', $idPost);
		$query_prodref = $db->get('productos_filing', null, 'id_prod_filing');        
		//print_r($query_prodref);
		if(count($query_prodref) > 0){
			foreach($query_prodref as $qprKey){
				$id_prod_ref = $qprKey['id_prod_filing'];
								
				//MODIFICA EL SKU DEL PRODUCTO	
				
				//datos para editar cod desdri prod
				$tbl_prodref = "productos_filing";
				$id_field_tbl_prodref = "id_prod_filing";
				$field_row_prodref = "cod_venta_prod_filing";
				$id_row_prodref = $id_prod_ref;
				$field_row_edit_prodref = $fieldEdit;
				$titu_sql_err_prodref = "SKU PRODUCTO REFERENCIA";
			
				$goEditProdRef = editFielDB($id_row_prodref, $field_row_prodref, $field_row_edit_prodref, $id_field_tbl_prodref, $tbl_prodref, $titu_sql_err_prodref);
				
				if(!$goEditProdRef){           
			            $response['error']= $goEditProdRef;            
			        }
			  	
			}
		}
		//CONSULTA REFERENCIA PRODUCTO
		//////////////////////////////
            	//$response = $fieldRowEdit;
                   
            $response = $fieldRowEdit;                                    
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "SKU producto";
        $ruleERR = "Parece, que estas usando caracteres prohibidos. Puedes usar letras y números"; 
        $exERR = "00021231-ABC"; 
        
        $response['error']= printErrValida($fielvalid, $tituERR, $ruleERR, $exERR);            
        
    }
    
    exit(json_encode($response));
}

/*
/*===========================
/*CATEGO ITEM
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "categoitemform"){    
        
    $l2prod = $_POST['l2prod_data'];
    $tagl1prod = $_POST['tagl1prod_data'];
    
    $fielvalid = validaInteger($fieldEdit, $idPost);
    $fielvalidL2 = validaInteger($l2prod, $idPost);
    $fielvalidTAG = validaAlphaSpace($tagl1prod, $idPost);
    
    if($fielvalid === true && $fielvalidL2 === true && $fielvalidTAG === true){
        /*$idRow = $idPost;
        $fieldRow = "cod_venta_prod";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_producto";
        $tbl = "productos";
        $tituSqlERR = "SKU PRODUCTO";*/
        
        $datasUpload = array(
            'id_catego_product' => $l2prod,
            'id_subcatego_producto' => $fieldEdit,
            'tags_depart_prods' => $tagl1prod
        );
        
        $datasUpload_filing = array(
            'id_subcatego_producto' => $fieldEdit
        );
        
        //actualizar campo en base de datos                                 
        //$goEditTAG = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        $db->where ('id_producto', $idPost );
                
        if($db->update ('productos', $datasUpload)){
		$db->where ('id_producto', $idPost );
		if($db->update ('productos_filing', $datasUpload_filing)){ 
			$response = $fieldEdit;                                    
		}else{          
			$erroQuery_levels_filing = $db->getLastErrno();   
			$response['error']= $erroQuery_levels_filing;            
		} 
            //$response = $fieldEdit;                                    
        }else{          
            $erroQuery_levels = $db->getLastErrno();   
            $response['error']= $erroQuery_levels;            
        }                
    }else{
        $tituERR = "Categoría producto";
        $ruleERR = "Selecciona una de las opciones del menú"; 
        $exERR = ""; 
        
        $response['error']= printErrValida($fielvalid, $tituERR, $ruleERR, $exERR);            
        
    }
    
    exit(json_encode($response));
}


/*
/*===========================
/*PRECIO ITEM
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "priceitemform"){
        
    $fielvalid = validaMoneda($fieldEdit, $idPost);
    
    if($fielvalid === true){
        $idRow = $idPost;
        $fieldRow = "precio_producto";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_producto";
        $tbl = "productos";
        $tituSqlERR = "PRECIO PRODUCTO";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){            
            $response = $fieldRowEdit;                                    
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "Precio producto";
        $ruleERR = "Escribe un precio real, no uses simbolos, ni puntuaciónes, si deseas poner decimales utiliza el PUNTO (.)"; 
        $exERR = "525500.55"; 
        
        $response['error']= printErrValida($fielvalid, $tituERR, $ruleERR, $exERR);            
        
    }
    
    exit(json_encode($response));
}


/*
/*===========================
/*TALLAS ITEM
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "tallaitemform"){
    
    $validaTallas = "";
    $validaGrupoTallas = "";
    $validTalla = array();
    $tallasItemARR = array();
    
    //RECIBE DATOS
    $tallasItemPOST = empty($_POST['tallas_data'])? "" : $_POST['tallas_data'];        
    $idGrupoTalla = $_POST['codegrupotallas_data'];
                
    //TRATAR ARRAY CON TALLAS
    $tallasItemARR = empty($tallasItemPOST)? "0" : explode(',', $tallasItemPOST);
    
    //""""""""BUSCANDO ERRORES EN DATOS EN TALLAS
    if(is_array($tallasItemARR)){
        foreach($tallasItemARR as $tKey){
            $tallaCheck = $tKey;                                    
            $validTalla[] = validaInteger($tallaCheck, $idPost);                        
        }                                           
    }
    //""""""""IMPRIMIENDO ERRORES ENCONTRADOS EN TALLAS
    if(is_array($validTalla)){
        foreach($validTalla as $errK){
            $tituERR = "TALLAS";
            $ruleERR = "Son permitidos unicamente valores enteros";
            $exERR = "1,2,3,4";
            
            if(is_array($errK)){
                $layoutTalla = printErrValida($errK, $tituERR, $ruleERR, $exERR);
                $response['error']= $layoutTalla;
                $validaTallas = "error";
                
            }                        
        }
    }
    
    //""""""""BUSCANDO ERRORES EN DATOS EN GRUPO TALLA
    if($idGrupoTalla != ""){
        
        $validGrupoTalla = validaInteger($idGrupoTalla, $idPost);
        
        $tituERR = "GRUPO TALLAS";
        $ruleERR = "Son permitidos unicamente valores enteros";
        $exERR = "1,2,3,4";
        
        if(is_array($validGrupoTalla)  && count($validGrupoTalla) > 0){            
            $layoutGruTalla = printErrValida($validGrupoTalla, $tituERR, $ruleERR, $exERR);
            $response['error']= $layoutGruTalla;
            $validaGrupoTallas = "error";            
        } 
    }
    
            
    if($validaGrupoTallas != "error" && $validaTallas != "error"){
        
        //ELIMINA LAS TALLAS EXISTENTES         
        $fieldTallaTBL = "id_producto";  
        $tblTallaTBL = "especifica_grupo_talla";      
        $trashTallaItem = deleteFieldDB($idPost, $fieldTallaTBL, $tblTallaTBL);
        
        
        //INGRESA LAS NUEVAS TALLAS        
        if(is_array($tallasItemARR) && count($tallasItemARR)>0){
            foreach($tallasItemARR as $tKey){
                $tallaFeatu = $tKey;                                    
                //$validTalla[] = validaInteger($tallaCheck, $idPost);  

                $dataTallaFeatureItem = array(
                    'id_grupo_talla'=>$idGrupoTalla,
                    'id_talla_tablas'=> $tallaFeatu, 
                    'id_producto'=> $idPost                                                
                );

                $idTF = $db->insert ('especifica_grupo_talla', $dataTallaFeatureItem);

                if(!$idTF){ 
                    $erroQuery_idTF = $db->getLastError();
                    $response['error']= "Ocurrio un problema al guardar las tallas<br><b>Error:</b> ".$erroQuery_idTF."<br>"; 
                }else{
                    $response = $fieldEdit;      
                }                                
            }                                           
        }
              
    }
    
    exit(json_encode($response));
}


/*
/*===========================
/*COLORES ITEM
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "colorsitemform"){
    
    $validaColores = "";
    $validColors = array();
    $colorsItemARR = array();
    
    //RECIBE DATOS
    $colorsItemPOST = empty($_POST['colors_data'])? "" : $_POST['colors_data'];        
                    
    //TRATAR ARRAY CON COLORES
    $colorsItemARR = empty($colorsItemPOST)? "0" : explode(',', $colorsItemPOST);
    
    //""""""""BUSCANDO ERRORES EN DATOS EN COLORES
    if(is_array($colorsItemARR)){
        foreach($colorsItemARR as $cKey){
            $colorCheck = $cKey;                                    
            $validColors[] = validaInteger($colorCheck, $idPost);                        
        }                                           
    }
    //""""""""IMPRIMIENDO ERRORES ENCONTRADOS EN COLORES
    if(is_array($validColors)){
        foreach($validColors as $errK){
            $tituERR = "COLORES";
            $ruleERR = "Son permitidos unicamente valores enteros";
            $exERR = "1,2,3,4";
            
            if(is_array($errK)){
                $layoutColor = printErrValida($errK, $tituERR, $ruleERR, $exERR);
                $response['error']= $layoutColor;
                $validaColores = "error";
                
            }                        
        }
    }
    
            
    if($validaColores != "error"){
        
        //ELIMINAR ESPECIFICACIONES COLOR    
        $fieldColorTBL = "id_producto";  
        $tblColorTBL = "especifica_product_tipo_color";      
        $trashColorItem = deleteFieldDB($idPost, $fieldColorTBL, $tblColorTBL);
        
        
        //INGRESA LAS NUEVAS COLORES                 
        if(is_array($colorsItemARR) && count($colorsItemARR) > 0){
            foreach($colorsItemARR as $cKey){
                $colorFeatu = $cKey;                                    

                $dataColorFeatureItem = array(                    
                    'id_color'=> $colorFeatu,
                    'id_producto'=> $idPost                                                
                );

                $idCF = $db->insert ('especifica_product_tipo_color', $dataColorFeatureItem);

                if(!$idCF){ 
                    $erroQuery_idCF = $db->getLastError();
                    $response['error']= "Ocurrio un problema al guardar los colores<br><b>Error:</b> ".$erroQuery_idCF."<br>"; 
                }else{
                    $response = $fieldEdit;      
                }                                 
            }                                           
        }
              
    }
    
    exit(json_encode($response));
}


/*
/*===========================
/*MATERIALES ITEM
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "matersitemform"){
    
    $validaMateriales = "";
    $validMater = array();
    $materialItemARR = array();
    
    //RECIBE DATOS
    $materialItemPOST = empty($_POST['material_data'])? "" : $_POST['material_data'];        
                    
    //TRATAR ARRAY CON COLORES
    $materialItemARR = empty($materialItemPOST)? "0" : explode(',', $materialItemPOST);
    
    //""""""""BUSCANDO ERRORES EN DATOS EN MATERIALES
    if(is_array($materialItemARR)){
        foreach($materialItemARR as $mKey){
            $mateCheck = $mKey;                                    
            $validMater[] = validaInteger($mateCheck, $idPost);                        
        }                                           
    }
    //""""""""IMPRIMIENDO ERRORES ENCONTRADOS EN MATERIALES
    if(is_array($validMater)){
        foreach($validMater as $errK){
            $tituERR = "MATERIALES";
            $ruleERR = "Son permitidos unicamente valores enteros";
            $exERR = "1,2,3,4";
            
            if(is_array($errK)){
                $layoutMater = printErrValida($errK, $tituERR, $ruleERR, $exERR);
                $response['error']= $layoutMater;
                $validaMateriales = "error";
                
            }                        
        }
    }
    
            
    if($validaMateriales != "error"){
                
        //ELIMINAR ESPECIFICACIONES MATERIALES    
        $fieldMaterTBL = "id_producto";  
        $tblMaterTBL = "especifica_prod_material";     
        $trashMaterItem = deleteFieldDB($idPost, $fieldMaterTBL, $tblMaterTBL);
        
        
        //INGRESA NUEVOS MATERIAL           
        if(is_array($materialItemARR) && count($materialItemARR) > 0){
            foreach($materialItemARR as $mKey){
                $materFeatu = $mKey;                                    

                $dataMaterFeatureItem = array(                    
                    'id_material'=> $materFeatu,
                    'id_producto'=> $idPost                                                
                );

                $idMF = $db->insert ('especifica_prod_material', $dataMaterFeatureItem);

                if(!$idMF){ 
                    $erroQuery_idMF = $db->getLastError();
                    $response['error']= "Ocurrio un problema al guardar los materiales<br><b>Error:</b> ".$erroQuery_idMF."<br>"; 
                }else{
                    $response = $fieldEdit;      
                }                               
            }                                           
        }
              
    }
    
    exit(json_encode($response));
}


/*
/*===========================
/*DESCCRIPCION ITEM
/*===========================
*/

if(isset($fieldPost) && $fieldPost == "descriitemform"){
        
    $fielvalid = validaAlphaSpace($fieldEdit, $idPost);
    
    if($fielvalid === true){
        $idRow = $idPost;
        $fieldRow = "caracteristicas_producto";
        $fieldRowEdit = $fieldEdit;
        $idFieldTbl = "id_producto";
        $tbl = "productos";
        $tituSqlERR = "DESCRIPCIÓN PRODUCTO";
        
        //actualizar campo en base de datos
        $goEdit = editFielDB($idRow, $fieldRow, $fieldRowEdit, $idFieldTbl, $tbl, $tituSqlERR);
        
        if($goEdit === true){            
            $response = $fieldRowEdit;                                    
        }else{            
            $response['error']= $goEdit;            
        }                
    }else{
        $tituERR = "Descripción producto";
        $ruleERR = "Parece, que estas usando caracteres prohibidos. Puedes usar letras, números, signos de puntuación"; 
        $exERR = "Esta es una descripción para mi producto o servicio"; 
        
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
        $idFieldTbl = "id_producto";
        $tbl = "productos";
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