<?php
require_once '../lib/MysqliDb.php';
require_once "../../cxconfig/config.inc.php";
require_once '../../cxconfig/global-settings.php';
require_once "../lib/gump.class.php";
require_once "site-tools.php"; 


//========================================
//========================================
//CRUD NEW PRODUCTO
//========================================
//========================================
    
/////////////////////////////////////////////////
/*$_POST['fieldedit'] = "additem";
$_POST['codeitem_data'] = "347";
$_POST['nameprod_data'] = 'cualquier nombre de producto - 4 #123 34% de 42"';
$_POST['skuprod_data'] = "asdasd31232 qwee123";
$_POST['precioprod_data'] = "12312123";
$_POST['categoprod_data'] = "12";
$_POST['l2prod_data'] = "1";
$_POST['codegrupotallas_data'] = "1";
$_POST['tagl1prod_data'] = "masculino";    
$_POST['tallas_data'] = "2,3,5,1";
$_POST['colors_data'] = "3,12,4,6";    
$_POST['material_data'] = "1,6";     
$_POST['status_data'] = "2";
$_POST['descriprod_data'] = 'lo que se me ocurra para este nuevo producto de comentarios $123123 23% dcto. (dfsdf) ASDFASDFASDF ';*/

/////////////////////////////////////////////////////


$fieldPost = $_POST['fieldedit'];    
$response = array();
$lastItemDB = "";    
$validaGrupoTallas = "";
$validaTallas = "";
$validaColores = "";
$validaMateriales = "";
    
//////////////////////////////////
//================NEW ITEM
//////////////////////////////////
    
if(isset($fieldPost) && $fieldPost == "additem"){

    //$response = "entro alemnos";
    //***********
    //RECIBE DATOS A EDITAR
    //***********
    $idItemPOST = empty($_POST['codeitem_data'])? "" : $_POST['codeitem_data'];
    $nameItemPOST = empty($_POST['nameprod_data'])? "" : $_POST['nameprod_data'];
    $skuItemPOST = empty($_POST['skuprod_data'])? "" : $_POST['skuprod_data'];
    $precioItemPOST = empty($_POST['precioprod_data'])? "" : $_POST['precioprod_data'];
    $categoItemPOST = empty($_POST['categoprod_data'])? "" : $_POST['categoprod_data'];
    $l2ItemPOST = empty($_POST['l2prod_data'])? "" : $_POST['l2prod_data'];
    $tagL1ItemPOST = empty($_POST['tagl1prod_data'])? "" : $_POST['tagl1prod_data'];         
    $grupoTallasItemPOST = empty($_POST['codegrupotallas_data'])? "" : $_POST['codegrupotallas_data'];       
    $tallasItemPOST = empty($_POST['tallas_data'])? "" : $_POST['tallas_data'];       
    $colorsItemPOST = empty($_POST['colors_data'])? "" : $_POST['colors_data'];    
    $materialItemPOST = empty($_POST['material_data'])? "" : $_POST['material_data'];     
    $statusItemPOST = empty($_POST['status_data'])? "" : $_POST['status_data'];
    $descriItemPOST = empty($_POST['descriprod_data'])? "" : $_POST['descriprod_data'];
    
    
    //***********
    //TRATAMIENTO VARIABLES ARRAY
    //***********
    
    //DATAS ARRAY              
    $tallasItemARR = empty($tallasItemPOST)? "0" : explode(',', $tallasItemPOST);
    $colorsItemARR = empty($colorsItemPOST)? "0" : explode(',', $colorsItemPOST);
    $materialItemARR = empty($materialItemPOST)? "0" : explode(',', $materialItemPOST);
    
    $validTalla = array();
    $validColors = array();
    $validMater = array();
    
        
    //""""""""BUSCANDO ERRORES EN DATOS EN TALLAS
    if(is_array($tallasItemARR)){
        foreach($tallasItemARR as $tKey){
            $tallaCheck = $tKey;                                    
            $validTalla[] = validaInteger($tallaCheck, $idItemPOST);                        
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
    if($grupoTallasItemPOST != ""){
        
        $validGrupoTalla = validaInteger($grupoTallasItemPOST, $idItemPOST);
        
        $tituERR = "GRUPO TALLAS";
        $ruleERR = "Son permitidos unicamente valores enteros";
        $exERR = "1,2,3,4";
        
        if(is_array($validGrupoTalla)  && count($validGrupoTalla) > 0){            
            $layoutGruTalla = printErrValida($validGrupoTalla, $tituERR, $ruleERR, $exERR);
            $response['error']= $layoutGruTalla;
            $validaGrupoTallas = "error";            
        } 
    }
        
    //""""""""BUSCANDO ERRORES EN DATOS EN COLORES
    if(is_array($colorsItemARR)){
        foreach($colorsItemARR as $cKey){
            $colorCheck = $cKey;                                    
            $validColors[] = validaInteger($colorCheck, $idItemPOST);                        
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
    
    //""""""""BUSCANDO ERRORES EN DATOS EN MATERIALES
    if(is_array($materialItemARR)){
        foreach($materialItemARR as $mKey){
            $mateCheck = $mKey;                                    
            $validMater[] = validaInteger($mateCheck, $idItemPOST);                        
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
    
    
    //***********
    //REFERENCIAS PRODUCTO
    //***********
    
    //CREA NOMBRE CLEAN
    $nameItem_dash = format_uri($nameItemPOST);
    
    //LAST ITEM TABLE
    $tablaQ = "productos";
    $campoQ = "id_producto";    
    $lastItemDB = lastIDRegis($tablaQ, $campoQ);
    $lastItemDB = $lastItemDB + 1;    
    
    switch($lastItemDB) {
		
		case ($lastItemDB < 10):
			$prefijo = "00000";
			$lastItemDB = $prefijo.$lastItemDB;
		break;	
		
		case ($lastItemDB < 100):
			$prefijo = "0000";
			$lastItemDB = $prefijo.$lastItemDB;
		break;
		
		case ($lastItemDB < 1000):
			$prefijo = "000";
			$lastItemDB = $prefijo.$lastItemDB;
		break;	
	
		case ($lastItemDB < 10000):
			$prefijo = "00";
			$lastItemDB = $prefijo.$lastItemDB;
		break;	
		
		case ($lastItemDB < 100000):
			$prefijo = "0";
			$lastItemDB = $prefijo.$lastItemDB;
		break;
	
		case ($lastItemDB >= 100000):
			$lastItemDB = $lastItemDB;
		break;
	}
    
    //final sku
    $skuItem_dash = format_uri($skuItemPOST);
    $skuItemNew = empty($skuItemPOST)? $lastItemDB : $skuItemPOST;
    $skuItemNew_dash = empty($skuItemPOST)? $lastItemDB : $skuItem_dash;

    //name clean
    $nameClean = $nameItem_dash."-".$skuItemNew_dash;
    
    
    //***********
    //VALIDACION DATOS RECIBIDOS
    //***********
    
    $_POST = array(      
        'iditem'=> $idItemPOST,
        'nameitem' => $nameItemPOST,
        'skuitem' => $skuItemNew,
        'priceitem' => $precioItemPOST,
        'categoitem' =>$l2ItemPOST,
        'subcategoitem' => $categoItemPOST,
        'tagl1item' => $tagL1ItemPOST,
        'statusitem' => $statusItemPOST,
        'descriitem' => $descriItemPOST
	);		
	
	$_POST = $validfield->sanitize($_POST); 
    
    
	$rules = array(
        'iditem'=> 'required|integer',
        'nameitem' => 'required|alpha_space|max_len,60',
        'skuitem' => 'required|alpha_space|max_len,20',
        'priceitem' => 'float',
        'categoitem' =>'required|integer',
        'subcategoitem' => 'required|integer',
        'tagl1item' => 'required|alpha',
        'statusitem' => 'integer',
        'descriitem' => 'alpha_space'
	);
    
	$filters = array(
        'iditem'=> 'trim|sanitize_string',
        'nameitem' => 'trim|sanitize_string',
        'skuitem' => 'trim|sanitize_string',
        'priceitem' => 'trim|sanitize_string',
        'categoitem' =>'trim|sanitize_string',
        'subcategoitem' => 'trim|sanitize_string',
        'tagl1item' => 'trim|sanitize_string',
        'statusitem' => 'trim|sanitize_string',
        'descriitem' => 'trim|sanitize_string'
	);
	
    $validated = $validfield->validate($_POST, $rules);
    $_POST = $validfield->filter($_POST, $filters);
    
    /*echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    echo "===============================+++++++++++++++++++++++====================================";
    echo "<pre>";
    print_r($validated);
    echo "</pre>";*/
    
    //"""""""""" SI LOS DATOS ESTAN LIMPIOS
    if($validated === TRUE && $validaTallas != "error" && $validaColores != "error" && $validaMateriales != "error" && $validaGrupoTallas !="error"){
               
        //***********
        //INSERTAR DATAS NUEVO ITEN
        //***********
        $datasPOST = array();
        $datasPOST = $_POST;
        
        //foreach($datasPOST as $dpKey =>  $dpVal){
        foreach($datasPOST as $dpKey){
            $dataNewItem = array(                                                
                'id_producto'=> $datasPOST['iditem'],
                'id_estado_contrato' => $datasPOST['statusitem'],
                'id_catego_product' =>$datasPOST['categoitem'],
                'id_subcatego_producto' => $datasPOST['subcategoitem'],
                'cod_venta_prod' => $datasPOST['skuitem'],
                'nome_producto' => $datasPOST['nameitem'],
                'ref_album'=> $nameClean,
                'precio_producto' => $datasPOST['priceitem'],
                'caracteristicas_producto' => $datasPOST['descriitem'],
                'url_amigable_prod'=> $nameClean,
                'tags_depart_prods' => $datasPOST['tagl1item']                                                                                                                
            );                                
        }
                                                
        $db->where ('id_producto', $idItemPOST ); 
        if ($db->update ('productos', $dataNewItem)){                       
            //$response = true;
            
                                    
            //***********
            //INSERTAR ESPECIFICACIONES
            //***********

            //TALLAS        
            if(is_array($tallasItemARR) && count($tallasItemARR)>0){
                foreach($tallasItemARR as $tKey){
                    $tallaFeatu = $tKey;                                    
                    //$validTalla[] = validaInteger($tallaCheck, $idItemPOST);  

                    $dataTallaFeatureItem = array(
                        'id_grupo_talla'=>$grupoTallasItemPOST,
                        'id_talla_tablas'=> $tallaFeatu, 
                        'id_producto'=> $idItemPOST                                                
                    );

                    $idTF = $db->insert ('especifica_grupo_talla', $dataTallaFeatureItem);

                    if(!$idTF){ 
                        $erroQuery_idTF = $db->getLastErrno();
                        $response['error']= "Ocurrio un problema al guardar las tallas<br><b>Error:</b> ".$erroQuery_idTF."<br>"; 
                    }                                
                }                                           
            }

            //COLORES        
            if(is_array($colorsItemARR) && count($colorsItemARR) > 0){
                foreach($colorsItemARR as $cKey){
                    $colorFeatu = $cKey;                                    

                    $dataColorFeatureItem = array(                    
                        'id_color'=> $colorFeatu,
                        'id_producto'=> $idItemPOST                                                
                    );

                    $idCF = $db->insert ('especifica_product_tipo_color', $dataColorFeatureItem);

                    if(!$idCF){ 
                        $erroQuery_idCF = $db->getLastError();
                        $response['error']= "Ocurrio un problema al guardar los colores<br><b>Error:</b> ".$erroQuery_idCF."<br>"; 
                    }                                
                }                                           
            }

            //MATERIAL           
            if(is_array($materialItemARR) && count($materialItemARR) > 0){
                foreach($materialItemARR as $mKey){
                    $materFeatu = $mKey;                                    

                    $dataMaterFeatureItem = array(                    
                        'id_material'=> $materFeatu,
                        'id_producto'=> $idItemPOST                                                
                    );

                    $idMF = $db->insert ('especifica_prod_material', $dataMaterFeatureItem);

                    if(!$idMF){ 
                        $erroQuery_idMF = $db->getLastError();
                        $response['error']= "Ocurrio un problema al guardar los materiales<br><b>Error:</b> ".$erroQuery_idMF."<br>"; 
                    }                                
                }                                           
            }
            
            $response = $idItemPOST;
            $_SESSION['newitem'] = NULL;
            unset($_SESSION['newitem']);
            

            
        }else{            
            $erroQuery_NI = $db->getLastErrno();   
            
            $errQueryTmpl_NI ="<ul class='list-group text-left'>";
            $errQueryTmpl_NI .="<li class='list-group-item list-group-item-danger'><b>*** Algo salio mal ***</b><br>
                <br>Wrong: <b>No se pudo guardar este item</b>
                <br>Erro: ".$erroQuery_NI."
                <br>Puedes intentar de nuevo
                <br>Si el error continua, por favor entre en contacto con soporte</li>";
            $errQueryTmpl_NI .="</ul>";
            
 
            $response['error']= $errQueryTmpl_NI;

        }
        
                                                                                                
    //"""""""""" SI LOS DATOS ESTAN CORROMPIDOS
    }else{
        
        $errQueryTmpl ="<ul class='list-group text-left'>";
                        
        //errores de validacion
        $recibeRules = array();
        $recibeRules[] = $validated;
        
        foreach($recibeRules as $keyRules => $valRules){
            if(is_array($valRules)){
                foreach($valRules as $key => $v){

                    $errFiel = $v['field'];
                    $errValue = $v['value'];
                    $errRule = $v['rule'];
                    $errParam = $v['param'];

                    switch($errFiel){
                        case 'iditem' :
                            $errQueryTmpl .="<li class='list-group-item list-group-item-danger'><b>No existe el ID del item que deseas publicar</b></li>";
                        break;                        
                        case 'nameitem' :
                            $errQueryTmpl .="<li class='list-group-item list-group-item-danger'><b>Nombre del producto</b>
                            <br>Reglas:
                            <br>Escribe letras y números
                            <br>Max. 60 caracteres</li>";

                        break;
                        case 'skuitem' :
                            $errQueryTmpl .="<li class='list-group-item list-group-item-danger'><b>Referencia roducto</b>
                            <br>Reglas:
                            <br>Escribe letras y números
                            <br>Max. 60 caracteres</li>";

                        break;
                        case 'priceitem' :
                            $errQueryTmpl .="<li class='list-group-item list-group-item-danger'><b>Precio producto</b>
                            <br>Reglas:
                            <br>Debes usar sólo números
                            <br>Sí deseas escribir decimales, separalos con PUNTO (.)
                            <br>Ej. #######.##</li>";

                        break;                    
                        case 'categoitem' :
                            $errQueryTmpl .="<li class='list-group-item list-group-item-danger'><b>Categoría</b>
                            <br>Reglas:
                            <br>Escoje una de las categorías mostradas en el menu</li>";

                        break;
                        case 'statusitem' :
                            $errQueryTmpl .="<li class='list-group-item list-group-item-danger'><b>Status</b>
                            <br>Reglas:
                            <br>Escoje una de las opciones de <b>Status</b> mostradas</li>";

                        break;
                        case 'descriitem' :
                            $errQueryTmpl .="<li class='list-group-item list-group-item-danger'><b>Descripcón</b>
                            <br>Reglas:
                            <br>Parece que estas utilizando, algun caracter invaliodo en la descripción del porducto</li>";

                        break;

                    }
                }
            }
            
        }
        
        $errQueryTmpl .="</ul>";    
        
        $response['error']= $errQueryTmpl;
    }
        
    echo json_encode($response);
    //exit(json_encode($response));
        
}//=========================NEW ITEM
