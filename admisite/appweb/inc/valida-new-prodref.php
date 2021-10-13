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
$_POST['codeitem_data'] = "312";
$_POST['nameprod_data'] = 'cualquier nombre de producto - 4 #123 34% de 42"';
$_POST['skuprod_data'] = "asdasd31232 qwee123";
$_POST['precioprod_data'] = "12312123";
$_POST['categoprod_data'] = "12";
$_POST['l2prod_data'] = "21";
$_POST['codegrupotallas_data'] = "1";
$_POST['tagl1prod_data'] = "masculino";    
$_POST['tallas_data'] = "2,3,5,1";
$_POST['colors_data'] = "3,12,4,6";    
$_POST['material_data'] = "1,6";     
$_POST['status_data'] = "2";
$_POST['descriprod_data'] = 'lo que se me ocurra para este nuevo producto de comentarios $123123 23% dcto. (dfsdf) ASDFASDFASDF ';*/

/////////////////////////////////////////////////////

//$_POST['fieldedit'] = 'additem';
$fieldPost = $_POST['fieldedit'];    
$response = array();
$lastItemDB = "";    
$validaGrupoTallas = "";
$validaTallas = "";
$validaColores = "";
$validaMateriales = "";
$fileValida = "";



/*formData.append("codeitemform_data", codeitemform);
formData.append("tallasprod_data", tallasprod); // number 123456 is immediately converted to string "123456"
formData.append("colorsprod_data", colorsprod); 
formData.append("cantprod_data", cantprod); 
formData.append("mincantprod_data", mincantprod); */


/*$idItemPOST = empty($_POST['codeitemform_data'])? "" : $_POST['codeitemform_data'];
$tallasItemPOST = empty($_POST['tallasprod_data'])? "" : $_POST['tallasprod_data'];       
$colorsItemPOST = empty($_POST['colorsprod_data'])? "" : $_POST['colorsprod_data'];    
$cantItemPOST = empty($_POST['cantprod_data'])? "" : $_POST['cantprod_data'];     
$minCantItemPOST = empty($_POST['mincantprod_data'])? "" : $_POST['mincantprod_data'];
$fotosAlbum = empty($_FILES['multifileimg'])? "" : $_FILES['multifileimg'];*/




//$response[] .= $idItemPOST;
//$response[] .= $tallasItemPOST;
//$response[] .= $colorsItemPOST;
//$response[] .= $cantItemPOST;
//$response[] .= $minCantItemPOST;
//$response[] .= $fotosAlbum;

//echo json_encode($response);
///exit(json_encode($response));    
//////////////////////////////////
//================NEW ITEM
//////////////////////////////////
    
if(isset($fieldPost) && $fieldPost == "additem"){

    //$response = "entro alemnos";
    
    //***********
    //RECIBE DATOS A EDITAR
    //***********
    $idItemPOST = empty($_POST['codeitemform'])? "" : $_POST['codeitemform'];
    $tallasItemPOST = empty($_POST['tallaslist'])? "" : $_POST['tallaslist'];
    $tipoTalla = empty($_POST['tipotalla_data'])? "" : $_POST['tipotalla_data'];
    $colorsItemPOST = empty($_POST['tipocolor'])? "" : $_POST['tipocolor'];    
    $cantItemPOST = empty($_POST['cantprod'])? "" : $_POST['cantprod'];     
    $minCantItemPOST = empty($_POST['minprod'])? "" : $_POST['minprod'];
    $fotosAlbum = empty($_FILES['multifileimg'])? "" : $_FILES['multifileimg'];
    
    //$response[] .= $idItemPOST;
    //$response[] .= $tallasItemPOST;
    //$response[] .= $colorsItemPOST;
    //$response[] .= $cantItemPOST;
    //$response[] .= $minCantItemPOST;
    //$response[] .= $tipoTalla;
    
    
    
    //***********
    //QUERY INFO ADICIONAL
    //***********
    
    //INFO PRODUCTO     
    $db->where('id_producto', $idItemPOST);
    $queryTbl = $db->get('productos',1,'id_subcatego_producto, cod_venta_prod, nome_producto');
    
    if(is_array($queryTbl)){  
        foreach($queryTbl as $qKey){
            $subCateItemGB = $qKey['id_subcatego_producto'];
            $nameItemGB = $qKey['nome_producto'];
            $skuItemGB = $qKey['cod_venta_prod'];
        }
        
    }
    
    //COLOR
    $db->where('id_color', $colorsItemPOST);
    $queryTbl_color = $db->getOne('tipo_color', 'nome_color');        
    $nameColor = $queryTbl_color['nome_color'];
    $idColor = $colorsItemPOST;
    
    //INFO TALLAS 
    $nameTL = "";
    $nameTN = "";
    $idTL = "";
    $idTN = "";
    $skuFull = "";
    $verificaTallaRef = "";
    $tallasItemPOSTValida = "";
    
    //ESCAPAR ID DEL USUARIO
	$idprodValida = (int)$idItemPOST;
	$idprodValida = $db->escape($idprodValida);
	
    if($tipoTalla=="tl"){
        $tallasItemPOSTValida = (int)$tallasItemPOST;
        $tallasItemPOSTValida = $db->escape($tallasItemPOSTValida);
    
        $db->where('id_talla_letras', $tallasItemPOSTValida);
        $queryTbl_talla_letra = $db->getOne('talla_letras', 'nome_talla_letras');        
        $nameTL = $queryTbl_talla_letra['nome_talla_letras'];
        $verificaTallaRef = $nameTL;
        $idTL = $tallasItemPOST;
        
        $skuFull =  $nameItemGB."&nbsp;".$skuItemGB."&nbsp;".$nameTL."&nbsp;".$nameColor;
        
        //VALIDAR SI LA REFERENCIA YA FUE PUBLICADA
	$db->where('id_producto', $idItemPOST);
	$db->where('id_talla_letras', $tallasItemPOSTValida);
	//$db->orWhere('id_talla_numer', $tallasItemPOSTValida);
	$existeProd = $db->getOne('productos_filing', 'id_prod_filing');
	
	
	//if(count($existeProd)>0){
	if(!empty($existeProd)){
	
	    $response['error']= "La referencia talla <b>".$verificaTallaRef."</b> y color <b>".$nameColor."</b>  ya fue creada, por favor verificalo e intentalo de nuevo";
	    echo json_encode($response);
	    exit;
	}
	
         
    }else if($tipoTalla=="tn"){
    	$tallasItemPOSTValida = (int)$tallasItemPOST;
        $tallasItemPOSTValida = $db->escape($tallasItemPOSTValida);
        
        $db->where('id_talla_numer', $tallasItemPOSTValida);
        $queryTbl_talla_nume = $db->getOne('talla_numerico', 'talla_numer');
        $nameTN = $queryTbl_talla_nume['talla_numer'];
        $verificaTallaRef = $nameTN;
        $idTN = $tallasItemPOST;
        
        $skuFull =  $nameItemGB."&nbsp;".$skuItemGB."&nbsp;".$nameTN."&nbsp;".$nameColor;
        
        //VALIDAR SI LA REFERENCIA YA FUE PUBLICADA
	$db->where('id_producto', $idItemPOST);
	$db->where('id_talla_numer', $tallasItemPOSTValida);
	$existeProd = $db->getOne('productos_filing', 'id_prod_filing');
	
	//if(count($existeProd)>0){
	if(!empty($existeProd)){
	
	    $response['error']= "La referencia talla <b>".$verificaTallaRef."</b> y color <b>".$nameColor."</b>  ya fue creada, por favor verificalo e intentalo de nuevo";
	    echo json_encode($response);
	    exit;
	}
        
    }
     
    
    
    
    
        
    //***********
    //DATOS REF
    //***********
    
    $tablaAlbumQ = "albun_db";
    $idTablaAlbumQ = "id_albun";
    $ultimoIdAlbum = lastIDRegis($tablaAlbumQ, $idTablaAlbumQ);
    $ultimoIdAlbum = $ultimoIdAlbum + 1;
    
    //$refAlbumCode = $refAlbumEdit."-".$ultimoIdAlbum;
    
    $refAlbum_dash =  format_uri($skuFull);
    $refAlbum_dash = $refAlbum_dash."-".$ultimoIdAlbum;
    $nameFotoPortada = $refAlbum_dash;
    
    //***********
    //FILES IMG
    //***********
            
   
    if(!empty($fotosAlbum)){

        //recibe datas post file
        //$filePost = $fotosAlbum; 

        //""""""devuelve un array file organizado
        $img_desc = reArrayFiles($fotosAlbum); 
        
        $filteredArr = $img_desc;
        
                
        //"""""Elimina arrays vacios
        foreach($filteredArr as $key => $link){ 
            if($link === '' || $link === 0 || $link['error'] == 4){ 
                unset($filteredArr[$key]); 
            } 
        } 
        
        //ELMINAR FILES REPETIDOS QUE LLEGA DESDE EL AJAX
        //foreach($img_desc as $imgKey){
            $filteredArr = unique_multidim_array($filteredArr, 'name');
        //}

        //"""""guarda datas file para subir al servidor    
        $filesUpload = array_reverse($filteredArr); 
        
        
        //"""""verifica posibles errores en img upload
        $fileCheck = array();    
        foreach($filteredArr as $val){
            validafile($val['tmp_name'], $val['name'], $val['tmp_name'], $val['type'], $val['size'], $val['error']);
            if(isset($err) && $err != ""){                
                $fileValida = "error";
                $fileCheck[] = $err;  //aqui no necesite aplicar la funcion de organizar array reArrayFiles(), pq el array va mostrando la forma posicion y para cada opsicion su respectivo archivo con lista de errores                  
            }            
        }  
        
        //$response = $filesUpload;
        //print_r($filesUpload);
        
        //SI TODO SALIO BN CON LA VALIDACION           
        if($fileValida != "error"){
            
            //crea album         
            //SELECT `id_albun`, `nome_albun`, `portada_album`, `ref_album`, `ruta_publicacion` FROM `albun_db` WHERE 1
            $datasNewAlbum = array(
                'nome_albun' => $nameItemGB, 
                'portada_album' => $nameFotoPortada.".jpg",
                'ref_album' => $refAlbum_dash,
                'ruta_publicacion' => NULL
            );
            $newAlbum = $db->insert('albun_db', $datasNewAlbum);
            if(!isset($newAlbum)){
                $erroQuery_Album = $db->getLastErrno();    

                $errQueryTmpl_Album ="<ul class='list-group text-left'>";
                $errQueryTmpl_Album .="<li class='list-group-item list-group-item-danger'><b>*** Algo salio mal ***</b><br>
                    <br>Wrong: <b>No se pudo crear el album</b>
                    <br>Erro: ".$erroQuery_Album."
                    <br>Puedes intentar de nuevo
                    <br>Si el error continua, por favor entre en contacto con soporte</li>";
                $errQueryTmpl_Album .="</ul>";


                $response['error']= $errQueryTmpl_Album;

            }else{
                
                $countFotos = 0;//count($filesUpload);
                //$itemPortada = 0;
            
            
                foreach($filesUpload as $valF){
                    
                    

                    if(upimgfile($valF['name'], $valF['tmp_name'])){
                                                            
                        //img full  
                        $patFileEnd = "album/1200/"; //define el directorio final de la imagen    
                        $squareFile = "1200";  //define dimensiones de imagen

                        //img COPIAS REDIMENSIONADAS 
                        $patFileEndThumb800 = "album/800/"; //define el directorio final de la imagen   
                        $squareFileThumb800 = "800";  //define dimensiones de imagen
                        $patFileEndThumb400 = "album/400/"; //define el directorio final de la imagen   
                        $squareFileThumb400 = "400";  //define dimensiones de imagen
                        $patFileEndThumb = "album/200/"; //define el directorio final de la imagen   
                        $squareFileThumb = "200";  //define dimensiones de imagen

                    
                        $refAlbumInsert = $refAlbum_dash;  
                        //$urldb = $valF['urlinst'];
                        $nameFileSponsorF = date('YmdHis',time()).mt_rand(); 
                        $nameFileSponsorFArr[] = $nameFileSponsorF;  
                        
                        
                        if($valF['name'][0]){
                            $nameFileSponsorFLabel = $nameFotoPortada;
                            $pathLabel = "album/labels/";
                            $squareLabel = "600";
                            redimensionaImgFile($valF['name'], $valF['type'], $nameFileSponsorFLabel, $pathLabel, $squareLabel);
                        }


                        if(redimensionaImgFile($valF['name'], $valF['type'], $nameFileSponsorF, $patFileEnd, $squareFile)){ 

                            //crea thumb
                            if((redimensionaImgFile($valF['name'], $valF['type'], $nameFileSponsorF, $patFileEndThumb, $squareFileThumb)) && (redimensionaImgFile($valF['name'], $valF['type'], $nameFileSponsorF, $patFileEndThumb400, $squareFileThumb400)) && (redimensionaImgFile($valF['name'], $valF['type'], $nameFileSponsorF, $patFileEndThumb800, $squareFileThumb800))){

                                $idSponsor = $db->rawQuery("INSERT INTO fotos_albun (id_albun, img_foto) VALUES('".$newAlbum."', '".$nameFileSponsorF.".jpg')");
                                if(!isset($idSponsor)){ 
                                    $response['error'] = "Ocurrio un error, en el momento de guardar la foto en el album:\n Error:". $db->getLastError();  
                                }else{
                                    $statusEdit = "ok";       
                                }    
                            }else{
                                $errCopySponsor[] =array($valF['name']);

                                $errQueryTmpl_Foto ="<ul class='list-group text-left'>";
                                $errQueryTmpl_Foto .="<li class='list-group-item list-group-item-danger'><b>*** Algo salio mal ***</b><br>
                                    <br>Wrong: <b>No se pudo publicar la foto</b>
                                    <br>Erro: ".$errCopySponsor."
                                    <br>Puedes intentar de nuevo
                                    <br>Si el error continua, por favor entre en contacto con soporte</li>";
                                $errQueryTmpl_Foto .="</ul>";

                                $response['error']=$errQueryTmpl_Foto;

                            }                        
                        }else{
                            $errCopySponsor[] =array($valF['name']);

                            $errQueryTmpl_Foto ="<ul class='list-group text-left'>";
                            $errQueryTmpl_Foto .="<li class='list-group-item list-group-item-danger'><b>*** Algo salio mal ***</b><br>
                                <br>Wrong: <b>No se pudo publicar la foto</b>
                                <br>Erro: ".$errCopySponsor."
                                <br>Puedes intentar de nuevo
                                <br>Si el error continua, por favor entre en contacto con soporte</li>";
                            $errQueryTmpl_Foto .="</ul>";

                            $response['error']=$errQueryTmpl_Foto;
                        }
                                                                
                    //$response = "Subio correctamente";

                }else{//si upload fue positivo
                    $errUpLoad = 1; 
                    $response['error']= "Fallo subir las imágenes al servidor";
                }//si upload fue negativo
            }//fin foreach
                
        }//FIN NEW ALBUM -> INSERTA FOTOS

        //IMPRIME ERRORES DE FILES IMG
        }else{

            if(is_array($fileCheck)){            
                $erroFileULLayout = "<ul class='list-group text-left box75'>";

                foreach($fileCheck as $itemFile => $ifKey){
                    $givErr[] = $ifKey;
                    $erroFileULLayout .= printFileErr($givErr);    
                }            
                $erroFileULLayout .= "</ul>";            
            }

            $response['error']= $erroFileULLayout;            
        }
        
        
    }//fin $_FILES[]
     
    
    //$response[] = $filesUpload;
    
    //***********
    //VALIDACION DATOS RECIBIDOS
    //***********
           
    $_POST = array(      
        'iditem'=> $idItemPOST,
        'tallaref' => $tallasItemPOST,
        'tipotalla' => $tipoTalla,
        'colorref' => $colorsItemPOST,
        'cantref' =>$cantItemPOST,
        'mincantref' => $minCantItemPOST
	);		
	
	$_POST = $validfield->sanitize($_POST); 
    
    
	$rules = array(
        'iditem'=> 'required|integer',
        'tallaref' => 'required|integer',
        'tipotalla' => 'required|alpha|max_len,2',
        'colorref' => 'required|integer',
        'cantref' => 'required|float',
        'mincantref' => 'required|float'
	);
    
	$filters = array(
        'iditem'=> 'trim|sanitize_string',
        'tallaref' => 'trim|sanitize_string',
        'tipotalla' => 'trim|sanitize_string',
        'colorref' => 'trim|sanitize_string',
        'cantref' => 'trim|sanitize_string',
        'mincantref' => 'trim|sanitize_string'
	);
	
    $validated = $validfield->validate($_POST, $rules);
    $_POST = $validfield->filter($_POST, $filters);
    
    
    
    
    //"""""""""" SI LOS DATOS ESTAN LIMPIOS
    if($validated === TRUE ){

               
        //***********
        //INSERTAR DATAS NUEVO ITEN
        //***********
        $datasPOST = array();
        $datasPOST = $_POST;
        
        //SELECT `id_prod_filing`, `id_subcatego_producto`, `id_producto`, `id_estado_contrato`, `agotado_filing`, `cod_venta_prod_filing`, `cod_venta_descri_filing`, `nome_producto_filing`, `foto_producto_filing`, `txt_alt_img_prod_filing`, `ref_album_prod_filing`, `cant_exist_prod_filing`, `max_exist_prod_filing`, `min_exist_prod_filing`, `id_talla_letras`, `id_talla_numer`, `id_color` FROM `productos_filing` WHERE 1
        foreach($datasPOST as $dpKey){
            $dataNewItem = array(                                                
                'id_producto'=> $datasPOST['iditem'],
                'id_talla_letras' => $idTL,
                'id_talla_numer' => $idTN,
                'id_color' => $idColor,
                'cant_exist_prod_filing' => $datasPOST['cantref'],
                'min_exist_prod_filing' => $datasPOST['mincantref'],
                'id_subcatego_producto' => $subCateItemGB,
                'cod_venta_prod_filing'=> $skuItemGB,
                'cod_venta_descri_filing' => $skuFull,
                'nome_producto_filing' => $nameItemGB,
                'foto_producto_filing'=> $nameFotoPortada.".jpg",
                'ref_album_prod_filing' => $refAlbum_dash                                                                                                                
            );                                
        }
                                                
        $newProdIns = $db->insert ('productos_filing', $dataNewItem); 
        if (!$newProdIns){                       
            
            //$response = $newProdIns;

            
       // }else{            
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
                        case 'tallaref' :
                            $errQueryTmpl .="<li class='list-group-item list-group-item-danger'><b>Talla</b>
                            <br>Reglas:
                            <br>Selecciona una de las opciones de talla que te muestra el menú</li>";

                        break;
                        case 'tipotalla' :
                            $errQueryTmpl .="<li class='list-group-item list-group-item-danger'><b>Talla</b>
                            <br>Reglas:
                            <br>Selecciona una de las opciones de talla que te muestra el menú</li>";

                        break;
                        case 'colorref' :
                            $errQueryTmpl .="<li class='list-group-item list-group-item-danger'><b>Color</b>
                            <br>Reglas:
                            <br>Selecciona una de las opciones de color que te muestra el menú</li>";

                        break;                    
                        case 'cantref' :
                            $errQueryTmpl .="<li class='list-group-item list-group-item-danger'><b>Cant. Existencias</b>
                            <br>Reglas:
                            <br>Escribe un número entero, no uses simbolos, ni puntuaciones</li>";

                        break;
                        case 'mincantref' :
                            $errQueryTmpl .="<li class='list-group-item list-group-item-danger'><b>Min. Cant. Existencias</b>
                            <br>Reglas:
                            <br>Escribe un número entero, no uses simbolos, ni puntuaciones</li>";

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
