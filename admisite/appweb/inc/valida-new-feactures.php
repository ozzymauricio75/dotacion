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

$namecolor = "";
$coloritem = "";    

//***********
//NUEVA COLOR
//***********
if(isset($fieldPost) && $fieldPost == "coloradd"){    
    
    //***********
    //RECIBE DATOS 
    //***********
    $namecolor = (empty($_POST['namecolor']))? "" : $_POST['namecolor'];
    $coloritem = (empty($_POST['coloritem']))? "" : $_POST['coloritem'];
                
    $_POST = array( 
        'namecolor'=> $namecolor,
        'hexacolor'=> $coloritem        
	);		
	
	$_POST = $validfield->sanitize($_POST); 
    
    //$validfield->validation_rules(array(
	$rules = array(
        'namecolor'=> 'required|alpha_space|max_len,20',
        'hexacolor'=> 'required|alpha_space|max_len,8'        
	);
    //$validfield->filter_rules(array(  
	$filters = array(
        'namecolor'=> 'trim|sanitize_string',
        'hexacolor'=> 'trim|sanitize_string'
	);
	
    $validated = $validfield->validate($_POST, $rules);
    $_POST = $validfield->filter($_POST, $filters);
    //echo "<pre>";
    ///print_r($validated);
    // Check if validation was successful
	if($validated === TRUE){
        
        $nuevoPost = array();
        $nuevoPost = $_POST;
       
        //foreach($nuevoPost as $valInsert => $valPost){
        foreach($nuevoPost as $valInsert){
            $dataInsert = array(                 
                'nome_color' =>  $nuevoPost['namecolor'],
                'color_hexa' => $nuevoPost['hexacolor']
            );         
        }
        //echo "<pre>";
        //print_r($dataInsert);
        $idStore_order = $db->insert('tipo_color', $dataInsert);
        if($idStore_order == true){                
            $response =$idStore_order;
        }else{
            $errInsertDatas = $db->getLastErrno();
                
            $errQueryTmpl_ins ="<ul class='list-group text-left'>";
            $errQueryTmpl_ins .="<li class='list-group-item list-group-item-danger'><b>*** Algo salio mal ***</b><br>
                <br>Wrong: <b>No se pudo crear el color</b>
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
                    case 'namecolor' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Nombre Color</b>
                        <br>".$usertyped."
                        <br>Regras:
                        <br>Debes escribir el nombre del color
                        <br>Ej. Rojo - Amarillo - Azul</li>";
                    break;                        
                    case 'hexacolor' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Código color</b>
                        <br>".$usertyped."
                        <br>Regras:
                        <br>Escribe un código de color valido en formato #000000 </li>";
                    break;
                }
            }
            
        }
        
        $errValidaTmpl .= "</ul>";
        $response['error']= $errValidaTmpl;
        
    }
    
    echo json_encode($response);
    
}


//***********
//NUEVA TALLA LETRAS
//***********

if(isset($fieldPost) && $fieldPost == "tallaltadd"){    
    
    //***********
    //RECIBE DATOS 
    //***********
    $namecolor = (empty($_POST['nametalla']))? "" : $_POST['nametalla'];
                    
    $_POST = array( 
        'tallalt'=> $namecolor              
	);		
	
	$_POST = $validfield->sanitize($_POST); 
    
    //$validfield->validation_rules(array(
	$rules = array(
        'tallalt'=> 'required|alpha|max_len,5'       
	);
    //$validfield->filter_rules(array(  
	$filters = array(
        'tallalt'=> 'trim|sanitize_string'
	);
	
    $validated = $validfield->validate($_POST, $rules);
    $_POST = $validfield->filter($_POST, $filters);
    //echo "<pre>";
    ///print_r($validated);
    // Check if validation was successful
	if($validated === TRUE){
        
        $nuevoPost = array();
        $nuevoPost = $_POST;
       
        //foreach($nuevoPost as $valInsert => $valPost){
        foreach($nuevoPost as $valInsert){
            $dataInsert = array(                 
                'nome_talla_letras' =>  $nuevoPost['tallalt']
            );         
        }
        //echo "<pre>";
        //print_r($dataInsert);
        $idStore_order = $db->insert('talla_letras', $dataInsert);
        if($idStore_order == true){                
            $response =$idStore_order;
        }else{
            $errInsertDatas = $db->getLastErrno();
                
            $errQueryTmpl_ins ="<ul class='list-group text-left'>";
            $errQueryTmpl_ins .="<li class='list-group-item list-group-item-danger'><b>*** Algo salio mal ***</b><br>
                <br>Wrong: <b>No se pudo crear esta talla</b>
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
                    case 'tallalt' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Talla</b>
                        <br>".$usertyped."
                        <br>Regras:
                        <br>Escribe una talla
                        <br>Ej. S - M - L</li>";
                    break;
                }
            }
            
        }
        
        $errValidaTmpl .= "</ul>";
        $response['error']= $errValidaTmpl;
        
    }
    
    echo json_encode($response);
    
}


//***********
//NUEVA TALLA NUMEROS
//***********

if(isset($fieldPost) && $fieldPost == "tallanumadd"){    
    
    //***********
    //RECIBE DATOS 
    //***********
    $namecolor = (empty($_POST['nametallanum']))? "" : $_POST['nametallanum'];
                    
    $_POST = array( 
        'tallanum'=> $namecolor              
	);		
	
	$_POST = $validfield->sanitize($_POST); 
    
    //$validfield->validation_rules(array(
	$rules = array(
        'tallanum'=> 'required|numeric|max_len,5'       
	);
    //$validfield->filter_rules(array(  
	$filters = array(
        'tallanum'=> 'trim|sanitize_string'
	);
	
    $validated = $validfield->validate($_POST, $rules);
    $_POST = $validfield->filter($_POST, $filters);
    //echo "<pre>";
    ///print_r($validated);
    // Check if validation was successful
	if($validated === TRUE){
        
        $nuevoPost = array();
        $nuevoPost = $_POST;
       
        //foreach($nuevoPost as $valInsert => $valPost){
        foreach($nuevoPost as $valInsert){
            $dataInsert = array(                 
                'talla_numer' =>  $nuevoPost['tallanum']
            );         
        }
        //echo "<pre>";
        //print_r($dataInsert);
        $idStore_order = $db->insert('talla_numerico', $dataInsert);
        if($idStore_order == true){                
            $response =$idStore_order;
        }else{
            $errInsertDatas = $db->getLastErrno();
                
            $errQueryTmpl_ins ="<ul class='list-group text-left'>";
            $errQueryTmpl_ins .="<li class='list-group-item list-group-item-danger'><b>*** Algo salio mal ***</b><br>
                <br>Wrong: <b>No se pudo crear esta talla</b>
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
                    case 'tallanum' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Talla</b>
                        <br>".$usertyped."
                        <br>Regras:
                        <br>Escribe una talla
                        <br>Ej. 32 - 34 - 36</li>";
                    break;
                }
            }
            
        }
        
        $errValidaTmpl .= "</ul>";
        $response['error']= $errValidaTmpl;
        
    }
    
    echo json_encode($response);
    
}

    
//***********
//NUEVA PRENDA
//***********

if(isset($fieldPost) && $fieldPost == "prendaadd"){    
    
    //***********
    //RECIBE DATOS 
    //***********
    $nameprenda = (empty($_POST['nameprenda']))? "" : $_POST['nameprenda'];
    $tipotalla = (empty($_POST['tipotalla']))? "" : $_POST['tipotalla'];
    $tipocolection = (empty($_POST['tipocolection']))? "" : $_POST['tipocolection'];
                    
    $_POST = array( 
        'tipoprenda'=> $nameprenda,        
        'generoropa'=> $tipocolection,
        'tipoprendatag'=> $tipotalla              
	);		
	
	$_POST = $validfield->sanitize($_POST); 
    
    //$validfield->validation_rules(array(
	$rules = array(
        'tipoprenda'=> 'required|alpha|max_len,20',      
        'generoropa'=> 'required|alpha|max_len,20',      
        'tipoprendatag'=> 'required|alpha|max_len,10'       
	);
    //$validfield->filter_rules(array(  
	$filters = array(
        'tipoprenda'=> 'trim|sanitize_string',
        'generoropa'=> 'trim|sanitize_string',
        'tipoprendatag'=> 'trim|sanitize_string'
	);
	
    $validated = $validfield->validate($_POST, $rules);
    $_POST = $validfield->filter($_POST, $filters);
    //echo "<pre>";
    ///print_r($validated);
    // Check if validation was successful
	if($validated === TRUE){
        
        $nuevoPost = array();
        $nuevoPost = $_POST;
       
        //foreach($nuevoPost as $valInsert => $valPost){
        foreach($nuevoPost as $valInsert){
            $dataInsert = array(                 
                'tipo_prenda' =>  $nuevoPost['tipoprenda'],
                'genero_ropa' =>  $nuevoPost['generoropa'],
                'tipo_prenda_tag' =>  $nuevoPost['tipoprendatag']
            );         
        }
        //echo "<pre>";
        //print_r($dataInsert);
        $idStore_order = $db->insert('grupo_tallas', $dataInsert);
        if($idStore_order == true){                
            $response =$idStore_order;
        }else{
            $errInsertDatas = $db->getLastErrno();
                
            $errQueryTmpl_ins ="<ul class='list-group text-left'>";
            $errQueryTmpl_ins .="<li class='list-group-item list-group-item-danger'><b>*** Algo salio mal ***</b><br>
                <br>Wrong: <b>No se pudo crear esta prenda</b>
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
                    case 'tipoprenda' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Nombre prenda</b>
                        <br>".$usertyped."
                        <br>Regras:
                        <br>Escribe un nombre de prenda valido
                        <br>Superior, inferior, Ropa intima, Traje</li>";
                    break;
                }
                switch($errFiel){
                    case 'generoropa' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Tipo colección</b>
                        <br>".$usertyped."
                        <br>Regras:
                        <br>Selecciona una de las opciones disponibles</li>";
                    break;
                }
                switch($errFiel){
                    case 'tipoprendatag' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Tipo talla</b>
                        <br>".$usertyped."
                        <br>Regras:
                        <br>Selecciona una de las opciones disponibles</li>";
                    break;
                }
            }
            
        }
        
        $errValidaTmpl .= "</ul>";
        $response['error']= $errValidaTmpl;
        
    }
    
    echo json_encode($response);
    
}


//formData.append("tallaslt", tallaslt); 
//        formData.append("tallasnume", tallasnum); 
//grutallaadd
    
    
    
//***********
//GRUPO DE TALLAS
//***********

if(isset($fieldPost) && $fieldPost == "grutallaadd"){    
    
    //***********
    //RECIBE DATOS 
    //***********
    $tipoColection = (empty($_POST['tipocolection']))? "" : $_POST['tipocolection'];
    $tipoPrenda = (empty($_POST['grupotallalist']))? "" : $_POST['grupotallalist'];
    $tallaltra = (empty($_POST['tallaslistlt']))? "" : $_POST['tallaslistlt'];
    $tallanume = (empty($_POST['tallaslistnume']))? "" : $_POST['tallaslistnume'];
    //$nameGrupoTalla = (empty($_POST['nameprenda']))? "" : $_POST['nameprenda'];
    
    
    if(isset($tipoPrenda) && $tipoPrenda != ""){    
        //name file
        $nameTipoPrenda = explode("_", $tipoPrenda); 
        $nameTipoPrendaF = $nameTipoPrenda[1];            
    }
    
    $db->where('tipo_prenda', $nameTipoPrendaF);
    $db->where('genero_ropa', $tipoColection);
    $idtp = $db->getOne('grupo_tallas', 'id_grupo_talla');
    $idTipoPrenda = $idtp['id_grupo_talla'];
    //TALLAS LETRAS
    $dataArr = array();
    if(is_array($tallaltra) && count($tallaltra)>0){
       foreach($tallaltra as $tlKey){           
           //SELECT `id_talla_letras`, `nome_talla_letras`, `posi_talla` FROM `talla_letras` WHERE 1
           $idTallaNLetraGet = $tlKey;
           $db->where('id_talla_letras', $idTallaNLetraGet);
           $qtl = $db->get('talla_letras', null, 'id_talla_letras, nome_talla_letras, posi_talla');
           if(count($qtl)>0){
                foreach($qtl as $qtlKey){
                    $idTallaArr = $qtlKey['id_talla_letras'];
                    $nameTallaArr = $qtlKey['nome_talla_letras'];
                    $posiTallaArr = $qtlKey['posi_talla'];
                    
                    $dataArr[] = array(
                        'idgrupotalla' => $idTipoPrenda,
                        'nametipoprenda' => $nameTipoPrendaF,
                        'idtallatbl' => $idTallaArr,
                        'nametalla' => $nameTallaArr,
                        'tipotallatag' => 'tl',
                        'colection' => $tipoColection,
                        'positalla' => $posiTallaArr
                    );
                    
                    //$datatl[] = $qtlKey;
                }    
           }
           
       }
    }
    //TALLAS NUMEROS
    //$datatn = array();
    if(is_array($tallanume) && count($tallanume)>0){
       foreach($tallanume as $tnKey){           
           //SELECT `id_talla_numer`, `talla_numer`, `posi_talla` FROM `talla_numerico` WHERE 1
           $idTallaNumeGet = $tnKey;
           $db->where('id_talla_numer', $idTallaNumeGet);
           $qtn = $db->get('talla_numerico', null, 'id_talla_numer, talla_numer, posi_talla');
           if(count($qtn)>0){
                foreach($qtn as $qtnKey){
                    $idTallaArr = $qtnKey['id_talla_numer'];
                    $nameTallaArr = $qtnKey['talla_numer'];
                    $posiTallaArr = $qtnKey['posi_talla'];
                    
                    $dataArr[] = array(
                        'idgrupotalla' => $idTipoPrenda,
                        'nametipoprenda' => $nameTipoPrendaF,
                        'idtallatbl' => $idTallaArr,
                        'nametalla' => $nameTallaArr,
                        'tipotallatag' => 'tn',
                        'colection' => $tipoColection,
                        'positalla' => $posiTallaArr
                    );
                    //$datatn[] = $qtnKey;
                }    
           }           
       }
    }
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

    $_POST = array( 
        'tipocoletion'=> $tipoColection,        
        'tipoprenda'=> $idTipoPrenda              
	);		
	
	$_POST = $validfield->sanitize($_POST); 
    
    //$validfield->validation_rules(array(
	$rules = array( 
        'tipocoletion'=> 'required|alpha|max_len,20',      
        'tipoprenda'=> 'required|integer|max_len,4'       
	);
    //$validfield->filter_rules(array(  
	$filters = array(
        'tipocoletion'=> 'trim|sanitize_string',
        'tipoprenda'=> 'trim|sanitize_string'
	);
	
    $validated = $validfield->validate($_POST, $rules);
    $_POST = $validfield->filter($_POST, $filters);
    //echo "<pre>";
    ///print_r($validated);
    // Check if validation was successful
	if($validated === TRUE){
        
        //$nuevoPost = array();
        //$nuevoPost = $dataArr;
       
        
/*    'idgrupotalla' => $idTipoPrenda,
    'nametipoprenda' => $nameTipoPrendaF,
    'idtallatbl' => $idTallaArr,
    'nametalla' => $nameTallaArr,
    'tipotallatag' => 'tl',
    'colection' => $tipoColection,
    'positalla' => $posiTallaArr*/
        
        //foreach($nuevoPost as $valInsert => $valPost){
        foreach($dataArr as $insKey){
                        
            $idgrupotalla = $insKey['idgrupotalla'];
            $nametipoprenda = $insKey['nametipoprenda'];
            $idtallatbl = $insKey['idtallatbl'];
            $nametalla = $insKey['nametalla'];
            $tipotallatag = $insKey['tipotallatag'];
            $colection = $insKey['colection'];
            $positalla = $insKey['positalla'];
            
            
            //SELECT `id_talla_tipo_prenda`, `id_grupo_talla`, `name_talla_tipo_prenda`, `id_talla_tablas`, `talla_tipo_prenda`, `tipo_talla`, `genero_talla`, `posi_talla` FROM `especifica_tallas_tipo_prenda` WHERE 1

            $idStore_order = $db->rawQuery("INSERT INTO especifica_tallas_tipo_prenda (id_grupo_talla, name_talla_tipo_prenda, id_talla_tablas, talla_tipo_prenda, tipo_talla, genero_talla, posi_talla) VALUES('".$idgrupotalla."', '".$nametipoprenda."', '".$idtallatbl."', '".$nametalla."', '".$tipotallatag."', '".$colection."', '".$positalla."')");
            
            
        }//fin foreach
        
        $response = $idStore_order;
        
        /*if(!$idStore_order){ 
            $errInsertDatas = $db->getLastErrno();

            $errQueryTmpl_ins ="<ul class='list-group text-left'>";
            $errQueryTmpl_ins .="<li class='list-group-item list-group-item-danger'><b>*** Algo salio mal ***</b><br>
                <br>Wrong: <b>No se pudo crear este grupo de tallas</b>
                <br>Erro: ".$errInsertDatas."
                <br>Puedes intentar de nuevo
                <br>Si el error continua, por favor entre en contacto con soporte</li>";
            $errQueryTmpl_ins .="</ul>";


            $response['error']= $errQueryTmpl_ins;
            
        }else{
            $response = $idStore_order;
            

        }*/
    //echo "<pre>";
    //print_r($dataArr);
        
                
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
                    case 'tipocoletion' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Tipo colección</b>
                        <br>".$usertyped."
                        <br>Regras:
                        <br>Escribe un nombre de prenda valido
                        <br>Selecciona una de las opciones disponibles</li>";
                    break;
                }
                switch($errFiel){
                    case 'tipoprenda' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Tipo prenda</b>
                        <br>".$usertyped."
                        <br>Regras:
                        <br>Selecciona una de las opciones disponibles</li>";
                    break;
                }
                
            }
           
        }
        
        $errValidaTmpl .= "</ul>";
        $response['error']= $errValidaTmpl;
        
    }
    
    echo json_encode($response);
    
}    




    
//***********
//NUEVO MATERIAL
//***********
if(isset($fieldPost) && $fieldPost == "materadd"){    
    
    //***********
    //RECIBE DATOS 
    //***********
    $namemater = (empty($_POST['namematerial']))? "" : $_POST['namematerial'];
    $valormater = (empty($_POST['valormaterial']))? "" : $_POST['valormaterial'];
                
    $_POST = array( 
        'namemater'=> $namemater,
        'valormater'=> $valormater        
	);		
	
	$_POST = $validfield->sanitize($_POST); 
    
    //$validfield->validation_rules(array(
	$rules = array(
        'namemater'=> 'required|alpha_space|max_len,20',
        'valormater'=> 'alpha_space|max_len,8'        
	);
    //$validfield->filter_rules(array(  
	$filters = array(
        'namemater'=> 'trim|sanitize_string',
        'valormater'=> 'trim|sanitize_string'
	);
	
    $validated = $validfield->validate($_POST, $rules);
    $_POST = $validfield->filter($_POST, $filters);
    //echo "<pre>";
    ///print_r($validated);
    // Check if validation was successful
	if($validated === TRUE){
        
        $nuevoPost = array();
        $nuevoPost = $_POST;
       
        //foreach($nuevoPost as $valInsert => $valPost){
        foreach($nuevoPost as $valInsert){
            $dataInsert = array(                 
                'nome_material' =>  $nuevoPost['namemater'],
                'valor_material' => $nuevoPost['valormater']
            );         
        }
        //echo "<pre>";
        //print_r($dataInsert);
        $idStore_order = $db->insert('tipo_material', $dataInsert);
        if($idStore_order == true){                
            $response =$idStore_order;
        }else{
            $errInsertDatas = $db->getLastErrno();
                
            $errQueryTmpl_ins ="<ul class='list-group text-left'>";
            $errQueryTmpl_ins .="<li class='list-group-item list-group-item-danger'><b>*** Algo salio mal ***</b><br>
                <br>Wrong: <b>No se pudo crear el color</b>
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
                    case 'namemater' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Nombre material</b>
                        <br>".$usertyped."
                        <br>Regras:
                        <br>Debes escribir el nombre del material, puedes usar letras y números
                        <br>Ej. Algodos |  poliester | Nylon</li>";
                    break;                        
                    case 'valormater' :
                        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Código color</b>
                        <br>".$usertyped."
                        <br>Regras:
                        <br>Escribe un valor valido, puedes usar letras y números</li>";
                    break;
                }
            }
            
        }
        
        $errValidaTmpl .= "</ul>";
        $response['error']= $errValidaTmpl;
        
    }
    
    echo json_encode($response);
    
}