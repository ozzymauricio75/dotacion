<?php
require_once '../lib/MysqliDb.php';
require_once "../../cxconfig/config.inc.php";
require_once '../../cxconfig/global-settings.php';
require_once "../lib/gump.class.php";
require_once "../lib/password.php";
require_once "site-tools.php"; 

/*$_POST['fieldedit']= "additem";
$_POST['namecatego'] ='Cheo feliciano';
$_POST['descricatego'] ='diretor ed orquesta';
$_POST['opcicatego'] ='';

$_POST['subnamecatego'] =' El gran combo';        
$_POST['tipocolection'] ='12312312-12';
$_POST['tipokit'] ='4360766';
$_POST['cantpzas'] ='3101234333434';

$_POST['tipocolectionl3'] ='contacto@gramcombo.com';//
$_POST['grupotallalist'] ='calle 5ta No. 43A-12 Barrio departamental';
$_POST['tipotalla'] ='Cali colombia';*/

$fileValida = ""; 
$fieldPost = $_POST['fieldedit'];
$response = array();


//***********
//CREA LEVELS
//***********

if(isset($fieldPost) && $fieldPost == "additem"){    
    
    $_POST_datas = array();
    $nameTagLEvel1 = "";
    $actiLevel1 = "";
    $actiLevel2 = "";
    $actiLevel3 = "";
    
    //***********
    //RECIBE DATOS 
    //***********
    $nameCatego = (empty($_POST['namecatego']))? "" : $_POST['namecatego'];
    $descriCatego = (empty($_POST['descricatego']))? "" : $_POST['descricatego'];
    $opciCatego = (empty($_POST['opcicatego']))? "" : $_POST['opcicatego'];
    
    //para level dos            
    $subNomeCatego = (empty($_POST['subnamecatego']))? "" : $_POST['subnamecatego'];
    $tipoColectionL2 = (empty($_POST['tipocolection']))? "" : $_POST['tipocolection'];
    $tipoKit = (empty($_POST['tipokit']))? "" : $_POST['tipokit'];
    $cantPzas = (empty($_POST['cantpzas']))? "" : $_POST['cantpzas'];
    
    //para level tres
    $fileCatego = (empty($_FILES['fotoprod']))? "" : $_FILES['fotoprod'];    
    $tipoColectionL3 = (empty($_POST['tipocolectionl3']))? "" : $_POST['tipocolectionl3']; // masculino | femenino
    $tipoKitL3 = (empty($_POST['tipokitl3']))? "" : $_POST['tipokitl3']; // formal | clasico | sport \ zapatos
    $tipoPrenda = (empty($_POST['grupotallalist']))? "" : $_POST['grupotallalist']; //DEFINIDAS EN GRUPOS DE TALLAS -> superior | inferior | traje ...   
    $tipoTalla = (empty($_POST['tipotalla']))? "" : $_POST['tipotalla']; //LETRAS - NUMEROS - UNICA
    
    //print_r($_POST['namecatego']);//."->nome catego<br>";
    //print_r($_POST['descricatego']);//."->descri catego<br>";
    if($opciCatego != ""){
        switch($opciCatego){
            ////
            //LEVEL DOS
            ///                     
            case "catkit":
                
                $db->where('nome_clean_depa_prod', $tipoColectionL2);                
                $idcolectQ = $db->getOne('departamento_prods', 'id_depart_prod');
                $idTipoColectL2 = $idcolectQ['id_depart_prod'];
                                                
                $_POST_datas = array(
                    'namecatego' => $nameCatego,
                    'descricatego' => $descriCatego,             
                    'subnomecatego' => $subNomeCatego,
                    'tipocoletion' => $tipoColectionL2,
                    'tipokit' => $tipoKit,
                    'cantpzas' => $cantPzas
                );		                    
                $rules = array( 
                    'namecatego'=> 'required|alpha_space',      
                    'descricatego'=> 'alpha_space',
                    'subnomecatego'=> 'required|alpha_space',
                    'tipocoletion'=> 'required|alpha_space|max_len,20',
                    'tipokit' => 'required|alpha_dash|max_len,20',
                    'cantpzas' => 'required|integer|max_len,4'
                );        
                $filters = array(
                    'namecatego'=> 'trim|htmlencode',
                    'descricatego'=> 'trim|htmlencode',
                    'subnomecatego'=> 'trim|htmlencode',
                    'tipocoletion'=> 'trim|sanitize_string',
                    'tipokit' => 'trim|sanitize_string',
                    'cantpzas' => 'trim|sanitize_numbers'
                ); 
                
                //echo "<pre>";
                //print_r($_POST_datas);
                
                $actiLevel2 = 1;
                break;
                
            ////
            //LEVEL TRES
            ///
            case "catprenda":
                
                if(isset($tipoPrenda) && $tipoPrenda != ""){                        
                    $nameTipoPrenda = explode("_", $tipoPrenda); 
                    $nameTipoPrendaF = $nameTipoPrenda[1];            
                }
                
                $_POST_datas = array(
                    'namecatego' => $nameCatego,
                    'descricatego' => $descriCatego,                    
                    'tipocoletion' => $tipoColectionL3,
                    'tipokit' => $tipoKitL3,
                    'tipoprenda' => $nameTipoPrendaF,
                    'tipotalla' => $tipoTalla
                );		                    
                $rules = array( 
                    'namecatego'=> 'required|alpha_space',      
                    'descricatego'=> 'alpha_space',                    
                    'tipocoletion'=> 'required|alpha_space|max_len,20',
                    'tipokit' => 'required|integer|max_len,2',
                    'tipoprenda' => 'required|alpha_dash|max_len,20',
                    'tipotalla' => 'required|alpha_dash|max_len,10'
                );        
                $filters = array(
                    'namecatego'=> 'trim|htmlencode',
                    'descricatego'=> 'trim|htmlencode',                    
                    'tipocoletion'=> 'trim|sanitize_string',
                    'tipokit' => 'trim|sanitize_string',
                    'tipoprenda' => 'trim|sanitize_string',
                    'tipotalla' => 'trim|sanitize_string'
                );
                
                //nombre clean - tag
                $nameTagLevel3 = format_uri($nameCatego);
                $nameLabelCatego = $nameTagLevel3."-".$tipoColectionL3.".jpg";
                $nameLabelFile = $nameTagLevel3."-".$tipoColectionL3;
                
                //info label                
                if(!empty($fileCatego)){
                    $filePost = $_FILES['fotoprod']; //empty($_POST['fotoprod'])? "" : $_POST['fotoprod'];  
                    $filePostName = $_FILES['fotoprod']['name'];
                    $filePostTmpName = $_FILES['fotoprod']['tmp_name'];
                    $filePostType = $_FILES['fotoprod']['type'];
                    $filePostSize = $_FILES['fotoprod']['size'];
                    $filePostErro = $_FILES['fotoprod']['error'];    
                    
                    
                    $fileCheck = array();
                    if(!empty($filePostName)){
                        validafile($filePost, $filePostName, $filePostTmpName, $filePostType, $filePostSize, $filePostErro);
                        if(isset($err) && $err != ""){
                            //print_r($err);
                            $fileValida = "error";
                            $fileCheck[] = $err;            
                        }
                    }
                }
                
                //print_r($fileCatego);
                                
                $actiLevel3 = 1;
                break;                                                            
        }
    }else{        
        $_POST_datas = array(
            'namecatego' => $nameCatego,
            'descricatego' => $descriCatego             
        );		                    
        $rules = array( 
            'namecatego'=> 'required|alpha_space',      
            'descricatego'=> 'alpha_space'       
        );        
        $filters = array(
            'namecatego'=> 'trim|htmlencode',
            'descricatego'=> 'trim|htmlencode'
        );        
                        
        $nameTagLEvel1 = format_uri($nameCatego);
        $actiLevel1 = 1;
    }
    $_POST_datas = $validfield->sanitize($_POST_datas);
    $validated = $validfield->validate($_POST_datas, $rules);
    $_POST_datas = $validfield->filter($_POST_datas, $filters);  
    
    
    
            
    /*echo "<pre>";
    print_r($tipoColection);    
    echo "<pre>";
    print_r($idTipoPrenda);
    echo "<pre>";
    print_r($nameTipoPrendaF);
    echo "<pre>";
    print_r($datatl);
    echo "<pre>";
    print_r($datatn);*/

    
    //echo "<pre>";
    //print_r($validated);
    // Check if validation was successful
	if($validated === TRUE){
        
        $idStore_order = "";
        //
        //level_1
        //
        if($actiLevel1==1){
            foreach($_POST_datas as $insKey){  
                $datasInsert = array(
                    'nome_depart_prod' => $_POST_datas['namecatego'],
                    'descri_depart_prod' => $_POST_datas['descricatego'],
                    'nome_clean_depa_prod' => $nameTagLEvel1
                );
                
            }//fin foreach
            $idStore_order = $db->insert('departamento_prods',$datasInsert);            
        }
        
        //
        //level_2
        //
        if($actiLevel2==1){
            foreach($_POST_datas as $insKey){  
                $datasInsert = array(
                    'id_depart_prod' => $idTipoColectL2,
                    'nome_catego_product' => $_POST_datas['namecatego'],
                    'descri_catego_prod' => $_POST_datas['subnomecatego'],
                    'tags_depatament_produsts' => $_POST_datas['tipocoletion'],
                    'tipo_kit_4user' => $_POST_datas['tipokit'],
                    'cant_pz_kit' => $_POST_datas['cantpzas']                    
                );
                
            }//fin foreach

            $idStore_order = $db->insert('categorias_productos',$datasInsert);
            
        }
        
        
        //
        //level_3
        //
        if($actiLevel3==1){
            foreach($_POST_datas as $insKey){  
                /*
                'namecatego' => $nameCatego,
                    'descricatego' => $descriCatego,                    
                    'tipocoletion' => $tipoColectionL3,
                    'tipokit' => $tipoKitL3,
                    'tipoprenda' => $nameTipoPrendaF,
                    'tipotalla' => $tipoTalla
                */
                
                //SELECT `id_subcatego_producto`, `id_catego_product`, `nome_subcatego_producto`, `descri_subcatego_prod`, `img_subcate_prod`, `nome_clean_subcatego_prod`, `tags_depatament_produsts`, `posi_sub_cate_prod`, `tipo_prenda`, `talla_tipo_prenda` FROM `sub_categorias_productos` WHERE 1
                $datasInsert = array(
                    'id_catego_product' => $_POST_datas['tipokit'],
                    'nome_subcatego_producto' => $_POST_datas['namecatego'],
                    'descri_subcatego_prod' => $_POST_datas['descricatego'],
                    'img_subcate_prod' => $nameLabelCatego,
                    'nome_clean_subcatego_prod' => $nameTagLevel3,                    
                    'tags_depatament_produsts' => $_POST_datas['tipocoletion'],
                    'tipo_prenda' => $_POST_datas['tipotalla'], 
                    'talla_tipo_prenda' => $_POST_datas['tipoprenda']               
                );
                
            }//fin foreach
            
            //echo "<pre>";
            //print_r($datasInsert);
            
            //crea label catego
            if($fileValida != "error"){

                if(upimgfile($filePostName, $filePostTmpName)){
                    
                    $patFileEnd = "tienda/img-catego/"; 
                    $squareFile = "800";  

                    if(redimensionaImgFile($filePostName, $filePostType, $nameLabelFile, $patFileEnd, $squareFile)){

                        $idStore_order = $db->insert('sub_categorias_productos',$datasInsert);
                        if(!isset($idStore_order)){ 
                            $errInsertDatas = $db->getLastErrno();

                            $errQueryTmpl_ins ="<ul class='list-group text-left'>";
                            $errQueryTmpl_ins .="<li class='list-group-item list-group-item-danger'><b>*** Algo salio mal ***</b><br>
                                <br>Wrong: <b>No se pudo crear esta categoría</b>
                                <br>Erro: ".$errInsertDatas."
                                <br>Puedes intentar de nuevo
                                <br>Si el error continua, por favor entre en contacto con soporte</li>";
                            $errQueryTmpl_ins .="</ul>";


                            $response['error']= $errQueryTmpl_ins;

                        }else{
                            $response = $idStore_order;            
                        }

                    }else{//si redimension fue positivo

                        $response = ['error'=>'No fue posible crear la portada para esta categoría'];
                    }

                    //$response = ['uploaded'=>'subio correctamente'];

                }else{//si upload fue positivo
                    $errUpLoad = 1; 
                    $response = ['error'=>'No fue posible subir la imágen al servidor, por favor intentalo de nuevo'];
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
            
            
            
            
            
        }
        
        
        //echo "<pre>";
        //print_r($datasInsert);
        
        //$response = $idStore_order;
        
        
    //echo "<pre>";
    //print_r($dataArr);
        
                
    }else{
        
        $errValidaTmpl = "";
                
        $errValidaTmpl .= "<ul class='list-group text-left box75'>";
                                           
        //ERRORES VALIDACION DATOS
        $recibeRules = array();
        $recibeRules[] = $validated;
        
        //
        //CATEGORIA -> level_1
        //
        if($actiLevel1==1){
                                
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
                        case 'namecatego' :
                            $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Nombre categoría</b>
                            <br>".$usertyped."
                            <br>Reglas:
                            <br>Escribe un nombre de categoría valido, puedes suar letras y números</li>";
                        break;
                    }
                    switch($errFiel){
                        case 'descricatego' :
                            $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Descripción categoría</b>
                            <br>".$usertyped."
                            <br>Reglas:
                            <br>Parece que estas usando caracteres prohibidos, intenta escribir de nuevo tu descripción, puedes usar letras, números y signos de puntuación.</li>";
                        break;
                    }

                }

            }
        }
        
        
        //
        //CATEGORIA -> level_2
        //
        if($actiLevel2==1){
                                
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
                        case 'namecatego' :
                            $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Nombre categoría</b>
                            <br>".$usertyped."
                            <br>Reglas:
                            <br>Escribe un nombre de categoría valido, puedes suar letras y números</li>";
                        break;
                    }
                    switch($errFiel){
                        case 'descricatego' :
                            $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Descripción categoría</b>
                            <br>".$usertyped."
                            <br>Reglas:
                            <br>Parece que estas usando caracteres prohibidos, intenta escribir de nuevo tu descripción, puedes usar letras, números y signos de puntuación.</li>";
                        break;
                    }
                    switch($errFiel){
                        case 'subnomecatego' :
                            $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Sub nombre</b>
                            <br>".$usertyped."
                            <br>Reglas:
                            <br>Escribe un sub nombre valido, puedes usar letras</li>";
                        break;
                    }
                    
                    switch($errFiel){
                        case 'tipocoletion' :
                            $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Tipo colección</b>
                            <br>".$usertyped."
                            <br>Reglas:
                            <br>Debes seleccionar una colección del menú disponible</li>";
                        break;
                    }
                    switch($errFiel){
                        case 'tipokit' :
                            $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Tipo KIT</b>
                            <br>".$usertyped."
                            <br>Reglas:
                            <br>Debes seleccionar un KIT del menú disponible</li>";
                        break;
                    }
                    switch($errFiel){
                        case 'cant_pz_kit' :
                            $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Cant. Prendas</b>
                            <br>".$usertyped."
                            <br>Reglas:
                            <br>Escribe una cantidad de prendas</li>";
                        break;
                    }

                }

            }
        }
        
        
        
        
        //
        //CATEGORIA -> level_3
        //
        if($actiLevel3==1){
                                
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
                        case 'namecatego' :
                            $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Nombre categoría</b>
                            <br>".$usertyped."
                            <br>Reglas:
                            <br>Escribe un nombre de categoría valido, puedes suar letras y números</li>";
                        break;
                    }
                    switch($errFiel){
                        case 'descricatego' :
                            $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Descripción categoría</b>
                            <br>".$usertyped."
                            <br>Reglas:
                            <br>Parece que estas usando caracteres prohibidos, intenta escribir de nuevo tu descripción, puedes usar letras, números y signos de puntuación.</li>";
                        break;
                    }
                                        
                    switch($errFiel){
                        case 'tipocoletion' :
                            $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Tipo colección</b>
                            <br>".$usertyped."
                            <br>Reglas:
                            <br>Debes seleccionar una colección del menú disponible</li>";
                        break;
                    }
                    switch($errFiel){
                        case 'tipokit' :
                            $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Tipo KIT</b>
                            <br>".$usertyped."
                            <br>Reglas:
                            <br>Debes seleccionar un KIT del menú disponible</li>";
                        break;
                    }
                    switch($errFiel){
                        case 'tipoprenda' :
                            $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Grupo de tallas</b>
                            <br>".$usertyped."
                            <br>Reglas:
                            <br>Debes seleccionar un Grupo de tallas del menú disponible</li>";
                        break;
                    }
                    switch($errFiel){
                        case 'tipotalla' :
                            $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Tipo de tallas</b>
                            <br>".$usertyped."
                            <br>Reglas:
                            <br>Debes seleccionar un tipo de tallas del menú disponible</li>";
                        break;
                    }

                }

            }
        }
        
        $errValidaTmpl .= "</ul>";
        $response['error']= $errValidaTmpl;
        
        //$response['error']= $validated;
        
    }
    
    echo json_encode($response);
    
}    


