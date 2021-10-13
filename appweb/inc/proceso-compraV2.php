<?php
//COLECICON
//SELECT `id_depart_prod`, `nome_depart_prod`, `descri_depart_prod`, `nome_clean_depa_prod` FROM `departamento_prods` WHERE 1

//CATEGRIA
//SELECT `id_categoria_catalogo`, `id_depart_prod`, `nombre_categoria_catalogo`, `descripcion_categoria_catalogo`, `portada_categoria_catalogo`, `tag_nombre_categoria_catalogo` FROM `categoria_catalogo` WHERE 1

//KIT
//SELECT `id_catego_product`, `id_depart_prod`, `nome_catego_product`, `descri_catego_prod`, `tags_depatament_produsts`, `tipo_kit_4user`, `cant_pz_kit` FROM `categorias_productos` WHERE 1

//TIPO PRENDA
//SELECT `id_subcatego_producto`, `id_catego_product`, `nome_subcatego_producto`, `descri_subcatego_prod`, `img_subcate_prod`, `nome_clean_subcatego_prod`, `tags_depatament_produsts`, `posi_sub_cate_prod`, `tipo_prenda`, `talla_tipo_prenda` FROM `sub_categorias_productos` WHERE 1

/*///////////////////////////////////////////////////////////////
/*
/*ARTICULOS ESCOGIDOS POR EL USUARIO EN ORDEN DE COMPRA
/*
*////////////////////////////////////////////////////////////////

//SELECT `id_espci_prod_pedido`, `id_solici_promo`, `id_catego_prod`, `id_subcatego_producto`, `id_producto`, `id_prod_filing`, `cant_pedido`, `precio_costo`, `precio_venta`, `utilidad_porcien`, `utilidad`, `subtotal_list` FROM `especifica_prod_pedido` WHERE 1

$db->where ("id_solici_promo", $otNOW);    //
$items_pedido_usuario = $db->get('especifica_prod_pedido');
$count_items_pedido_usuario = count($items_pedido_usuario);

function comparaPrendaPedido($idSubCateProd){
    global $db;
    global $otNOW;
    $dataQuery = array();
    $db->where ("id_solici_promo", $otNOW);
    $db->where ("id_subcatego_producto", $idSubCateProd);
    $query = $db->getOne('especifica_prod_pedido');
    $id_prenda_pedido = $query['id_subcatego_producto'];
    return $id_prenda_pedido;
}

function comparaKitPedido($idCateProd){
    global $db;
    global $otNOW;
    $dataQuery = array();
    $db->where ("id_solici_promo", $otNOW);
    $db->where ("id_catego_prod", $idCateProd);
    $query = $db->get('especifica_prod_pedido');
    $countQuery = count($query);
    if($countQuery>0){
        foreach($query as $key){
            $dataQuery[] = $key;
        }
        return $dataQuery;
    }
   
}

/*///////////////////////////////////////////////////////////////
/*
/*PAQUETE DOTACION USUARIO
/*
*////////////////////////////////////////////////////////////////


//CATEGORIA ASIGNADA
function categoriasUsuario($id_categoria_){
    
    global $db;
    global $typeColection;
        
    $dataQuery = array();
    
    $db->where('id_depart_prod', $typeColection);
    $db->where('id_categoria_catalogo', $id_categoria_);
    $query = $db->get('categoria_catalogo');
    $countQuery = count($query);
    
    if($countQuery>0){
        foreach($query as $key){
            $dataQuery[] = $key;
        }
        return $dataQuery;
    }
}

//KIT ASIGNADO
function kitsUsuario($id_kit_){
    
    global $db;
        
    $dataQuery = array();
    
    $db->where('id_catego_product', $id_kit_);
    //$db->orderBy("nome_catego_product","asc");	
    //$db->orderBy("tags_depatament_produsts","asc");	
    $query = $db->get('categorias_productos');
    $countQuery = count($query);
    
    if($countQuery>0){
        foreach($query as $key){
            $dataQuery[] = $key;
        }
        return $dataQuery;
    }
}

//PRENDA ASIGNADO
function prendasUsuario($id_prenda_){
    
    global $db;
        
    $dataQuery = array();
    
    $db->where('id_subcatego_producto', $id_prenda_);
    $query = $db->get('sub_categorias_productos');
    $countQuery = count($query);
    
    if($countQuery>0){
        foreach($query as $key){
            $dataQuery[] = $key;
        }
        return $dataQuery;
    }
}
    
//SI EXISTE KIT ADICIONAL PARA EL USUARIO
$db->where('id_account_user',$idSSUser);
$db->where('kit','adicional');
$paquete_adicional = $db->get('pack_dotacion_user');
$count_paquete_adicional = count($paquete_adicional);

$paquete_adicional_usuario = array();
$adicional_categorias = array();
$adicional_kits = array();
$adicional_prendas = array();

if(is_array($paquete_adicional) && count($paquete_adicional)>0){
    foreach($paquete_adicional as $pauKey){
        
        $id_categoria_add = $pauKey['id_categoria_catalogo'];
        $id_kit_add = $pauKey['id_catego_product'];
        $id_prenda_add = $pauKey['id_subcatego_producto'];
        
        
        //CONSULTA CATEGORIAS ASIGNADAS
        /*if(is_array($id_categoria_add) && count($id_categoria_add) > 0){
            foreach($id_categoria_add as $icaKey){
                $adicional_categorias = categoriasUsuario($icaKey);
            }
        }*/
        $adicional_categorias = categoriasUsuario($id_categoria_add);

        //CONSULTA KITS ASIGNADOS
        $adicional_kits = kitsUsuario($id_kit_add);

        //CONSULTA PRENDAS ASIGNADAS
        $adicional_prendas = prendasUsuario($id_prenda_add);    

        
        $paquete_adicional_usuario[] = array(
            'categoria_adicional' => $adicional_categorias,
            'kit_adicional' => $adicional_kits,
            'prenda_adicional' => $adicional_prendas
        );
    }
}

//echo "<pre>";
//print_r($paquete_adicional_usuario);

//DOTACION ASIGNADA AL USUARIO -> KITS DIFERENTES AL ADICIONAL
$db->where('id_account_user',$idSSUser);
$db->where('kit','adicional', '!=');
$db->orderBy("tags_depatament_produsts","asc");				
$paquete_dotacion = $db->get('pack_dotacion_user');
$count_paquete_dotacion = count($paquete_dotacion);

$paquete_usuario = array();
$mis_categorias = array();
$mis_kits = array();
$mis_prendas = array();

if(is_array($paquete_dotacion)){
    foreach($paquete_dotacion as $pduKey){
        
        $id_categoria = $pduKey['id_categoria_catalogo'];
        $id_kit = $pduKey['id_catego_product'];
        $id_prenda = $pduKey['id_subcatego_producto'];
        //$categoria_adicional = $pduKey['kit'];
        
        
        //CONSULTA CATEGORIAS ASIGNADAS
        $mis_categorias = categoriasUsuario($id_categoria);

        //CONSULTA KITS ASIGNADOS
        $mis_kits = kitsUsuario($id_kit);

        //CONSULTA PRENDAS ASIGNADAS
        $mis_prendas = prendasUsuario($id_prenda);    
       
        
        $paquete_usuario[] = array(
            'categoria_pack' => $mis_categorias,
            'kit_pack' => $mis_kits,
            'prenda_pack' => $mis_prendas
        );
        
    }
    
    //$paquete_usuario[] = $paquete_adicional_usuario;
}

//echo "<pre>";
//print_r($paquete_usuario);



/*///////////////////////////////////////////////////////////////
/*
/*NAVEGACION PAQUETE DOTACION ASIGNADO
/*
*////////////////////////////////////////////////////////////////

//PRIMER PASO -> EL USUARIO SELECCIONA UNA CIUDAD DE ENVIO
/*
/
/
*/

//SEGUNDO PASO -> EL USUARIO VISUALIZA LAS CATEGORIAS DISPONIBLES
$categorias_seccion = array();
$categorias_seccion = $paquete_usuario;

if(is_array($categorias_seccion) && count($categorias_seccion)>0){
    foreach($categorias_seccion as $cuKey){
        $categorias_usuario_array = $cuKey['categoria_pack'];
        if(is_array($categorias_usuario_array)){
            foreach($categorias_usuario_array as $cuVal){
                $grupoCategorias[] = $cuVal;
            }
        }
    }
    $grupoCategoriasUsuario = unique_multidim_array($grupoCategorias, 'id_categoria_catalogo');
    //echo "<pre>";
    //print_r($grupoCategoriasUsuario);
}
//echo "<pre>";
//print_r($categorias_seccion);
//TERCER PASO -> EL USUARIO VISUALIZAN LOS KITS CORRESPONDIENTES A CADA CATEGORIA
$kits_seccion = array();
$kits_seccion = $paquete_usuario;

if(is_array($kits_seccion) && count($kits_seccion)>0){
    foreach($kits_seccion as $kuKey){
        $kits_usuario_array = $kuKey['kit_pack'];
        if(is_array($kits_usuario_array)){
            foreach($kits_usuario_array as $kuVal){
                $grupoKits[] = $kuVal;
            }
        }
    }
    $grupoKitsUsuario = unique_multidim_array($grupoKits, 'id_catego_product');
    //echo "<pre>";
    //print_r($grupoKitsUsuario);
}

//CUARTO PASO -> EL USUARIO VISUALIZAN LOS TIPOS DE PRENDA CORRESPONDIENTES A CADA KIT
$prendas_seccion = array();
$prendas_seccion = $paquete_usuario;

if(is_array($prendas_seccion) && count($prendas_seccion)>0){
    foreach($prendas_seccion as $puKey){
        $prendas_usuario_array = $puKey['prenda_pack'];
        if(is_array($prendas_usuario_array)){
            foreach($prendas_usuario_array as $puVal){
                $grupoPrendas[] = $puVal;
            }
        }
    }
    //$grupoKitsUsuario = unique_multidim_array($grupoKits, 'id_catego_product');
    //echo "<pre>";
    //print_r($grupoPrendas);
}


/*///////////////////////////////////////////////////////////////
/*
/*IMPRIME CATALOGO DOTACION USUARIO
/*
*////////////////////////////////////////////////////////////////

$input_kit_explorar = "";

$kit_explorar = "";
if(isset($_GET['tagcat'])){
    $kit_explorar = $_GET['tagcat'];
    $kit_explorar = (string)$kit_explorar; 
    $kit_explorar = $db->escape($kit_explorar);    
    $input_kit_explorar = "<input type='hidden' name='tagcatinp' value='".$kit_explorar."' />";
}elseif(isset($_GET['tagcatinp'])){
    $kit_explorar = $_GET['tagcatinp'];
    $kit_explorar = (string)$kit_explorar; 
    $kit_explorar = $db->escape($kit_explorar);    
    $input_kit_explorar = "<input type='hidden' name='tagcatinp' value='".$kit_explorar."' />";
}

$prendas_explorar = "";
if(isset($_GET['l2'])){
    $prendas_explorar = $_GET['l2'];
    $prendas_explorar = (string)$prendas_explorar; 
    $prendas_explorar = $db->escape($prendas_explorar);    
}elseif(isset($_GET['l2inp'])){
    $prendas_explorar = $_GET['l2inp'];
    $prendas_explorar = (string)$prendas_explorar; 
    $prendas_explorar = $db->escape($prendas_explorar); 
}

$prenda_activa = "";
if(isset($_GET['catego'])){
    $prenda_activa = $_GET['catego'];
    $prenda_activa = (string)$prenda_activa; 
    $prenda_activa = $db->escape($prenda_activa);
}elseif(isset($_GET['catinp'])){
    $prenda_activa = $_GET['catinp'];
    $prenda_activa = (string)$prenda_activa; 
    $prenda_activa = $db->escape($prenda_activa);
}

$acti_migaja = "";
$acti_kit_migaja = "";
$acti_prendaexp_migaja = "";
$acti_prenda_migaja = "";
$acti_home_migaja = "";
if($prenda_activa!= ""){
    $acti_migaja = 3;
    $acti_prenda_migaja = "active";
}elseif($prendas_explorar != ""){
    $acti_migaja = 2;
    $acti_prendaexp_migaja = "active";
}elseif($kit_explorar!= ""){
    $acti_migaja = 1;
    $acti_kit_migaja = "active";
}elseif( $prenda_activa == "" && $prendas_explorar == "" && $kit_explorar == ""){
    $acti_home_migaja = "active";
}


$layout_migaja = "";

$layout_categoria_usuario = "";   
$layout_kit_usuario = "";
$tmplLayoutItem = "";

$path_img_adicional = "";

//+++++++++++++++++++++++++++
//+++++++++++++++++++++++++++
//CATALOGO > NIVEL CATEGORIAS

sksort($grupoCategoriasUsuario, "ordenar_item_categoria_catalogo", true);

if(count($grupoCategoriasUsuario) > 0){
    //muestra los kits ROPA | ZAPATOS | ADICIONAL
    
    //$layout_categoria_usuario .= "<div class='main'>";
    $layout_categoria_usuario .= "<ul class='cbp-ig-grid'>";  
    $layout_categoria_usuario .= "<li class='wrapbackbtn'>";
    $layout_categoria_usuario .= "<div class='backbtn'>";
    $layout_categoria_usuario .= "<a href='".$pathmm."order/inicio/?steps=dos' class='' type='button'>";
    $layout_categoria_usuario .= "<i class='fa fa-th-large'></i>";
    $layout_categoria_usuario .= "<span>KITs Disponibles</span>";
    $layout_categoria_usuario .= "</a>";
    $layout_categoria_usuario .= "</div>";
    $layout_categoria_usuario .= "</li>";
        
    //url item kit
    $utlKDRopa = $pathmm.$takeOrderDir."/inicio/?steps=tres";
    $utlKDZapatos = $pathmm.$takeOrderDir."/browse/?steps=cuatro&l2=";
    $utlKDAdicional = $pathmm.$takeOrderDir."/browse/?steps=cuatro&l2=";

    //PATH FOTO DEFAULT
    $pathFileDefault = $pathmm."img/nopicture.png";
    
    
    
    
    
    //CREA LAYOUT PARALA CATEGORIA ADICIONAL
    $varcontrol = "";
    if(is_array($paquete_adicional_usuario) && !empty($paquete_adicional_usuario) && $varcontrol == "suputamadre"){
        foreach($paquete_adicional_usuario as $paulKey){
            
            //CATEGORIA ADICIONAL
            
            $categorias_adicional_usuario = $paulKey['categoria_adicional'];
            if(is_array($categorias_adicional_usuario)){
                foreach($categorias_adicional_usuario as $cauVal){
                    $nombre_adicional_catalogo = $cauVal['nombre_categoria_catalogo'];
                    $portada_adicional_catalogo = $cauVal['portada_categoria_catalogo'];   
                    $tag_adicional_catalogo = $cauVal['tag_nombre_categoria_catalogo'];
                    
                    //PATHH FOTO CATEGORIA
                    $path_img_adicional = "../../files-display/tienda/categorias-catalogo/".$portada_adicional_catalogo;
                    
                    //PATH SIGUIENTE PASO NAVEGACION -> PASO TRES
                    $path_url_nav_add = $pathmm.$takeOrderDir."/inicio/?steps=tres&tagcatadd=adicional";

                    //VERIFICAR PORTADA
                    if (file_exists($path_img_adicional)) {
                        $print_img_adicional = $path_img_adicional;                                        
                    } else {
                        $print_img_adicional = $pathFileDefault;
                    }
                
                }
            }
            
            //KIT ADICIONAL
            $kit_adicional_usuario = $paulKey['kit_adicional'];
            if(is_array($kit_adicional_usuario)){
                foreach($kit_adicional_usuario as $kauVal){
                    $typeKitCateProd_add = $kauVal['tipo_kit_4user'];
                    
                    $codeCataProd_add = $kauVal['id_catego_product'];
                    $nomeCategoProd_add = $kauVal['nome_catego_product'];
                    $subNomeCategoProd_add = $kauVal['descri_catego_prod'];
                    $ropaKitCategoProd_add = $kauVal['tipo_kit_4user'];
                    $piezasKitCategoProd_add = $kauVal['cant_pz_kit'];
                    
                }
            }
            
            $attr_kit_adicional = $typeKitCateProd_add;
            
            //PRENDA ADICIONAL
            $prenda_adicional_usuario = $paulKey['prenda_adicional'];
            if(is_array($prenda_adicional_usuario)){
                foreach($prenda_adicional_usuario as $pauVal){
                    $idCateProd_add = $pauVal['id_catego_product'];
                    $idSubCateProd_add = $pauVal['id_subcatego_producto'];
                    $nomeSubCateProd_add = $pauVal['nome_subcatego_producto'];
                    $fileSubCateProd_add = $pauVal['img_subcate_prod'];
                    $typeKitCateProd_add = "";//$gpuKit['tipo_kit_4user'];

                    $pathFileSubCate = "../../files-display/tienda/img-catego/".$fileSubCateProd_add;   
                    
                    //PATH SIGUIENTE PASO NAVEGACION -> ARTICULOS
                    //$linkAdicional = $pathmm.$takeOrderDir."/browse/?catego=".$idSubCateProd_add."&l2=".$idCateProd_add."&tagcat=".$attr_kit_adicional."&addl3=".$idSubCateProd_add; 
                    
                    $linkAdicional = "<a href='".$pathmm.$takeOrderDir."/browse/?catego=".$idSubCateProd_add."&l2=".$idCateProd_add."&tagcat=".$attr_kit_adicional."&addl3=".$idSubCateProd_add."&tagcatadd=adicional' >";
                    
                    $grupo_prendas_add = $pauVal;
                       
                }    
            }
            
            
            
            //LOS KITS ADICIONALES ASIGNADOS AL USUARIO
            if(isset($_GET['tagcatadd'])){
            
                //$linkWrapPZ = "<a href='?l2=".$codeCataProd_add."&tagcat=".$ropaKitCategoProd_add."&steps=cuatro' >";        

                $layout_kit_usuario .= "<li>";
                $layout_kit_usuario .= $linkAdicional;//$linkWrapPZ; 
                $layout_kit_usuario .= "<span class='cbp-ig-icon '><i>".$nomeCategoProd_add."</i></span>";
                $layout_kit_usuario .= "<h3 class='cbp-ig-title'>".$subNomeCategoProd_add."</h3>";
                $layout_kit_usuario .= "</a>";
                $layout_kit_usuario .= "</li>";    
            }

        } 
        
        //EN CUAL KIT ME ENCUENTRO
	        if( isset($_GET['tagcatadd']) && $_GET['tagcatadd'] == "adicional"){    
	            $path_migaja_nav_add = $pathmm.$takeOrderDir."/inicio/?steps=tres&tagcatadd=adicional";        
	            $layout_migaja .= "<li role='presentation' class='".$acti_prendaexp_migaja."'><a href='".$path_migaja_nav_add."'>Unitario</a></li>";
	        }//FIN KIT ACTIVO
        
        /*//EN CUAL CATEGORIA ME ENCUENTRO -> MIGAJAS
        if($kit_explorar == $tag_adicional_catalogo){

            $migaja_nombre_categoria = $nombre_adicional_catalogo;
            $migaja_tag_categoria = $tag_adicional_catalogo;
            $migaja_url_categoria = $pathmm.$takeOrderDir."/inicio/?steps=tres&tagcat=".$migaja_tag_categoria;

            $layout_migaja .= "<li role='presentation' class=''><a href='".$migaja_url_categoria."'>".$migaja_nombre_categoria."</a></li>";
        }//FIN CATEGORIA ACTIVA
        
        //EN CUAL KIT ME ENCUENTRO
        if( $prendas_explorar == $codeCataProd){
            $migaja_nombre_kit = $nomeCategoProd;
            $migaja_url_kit = $pathmm.$takeOrderDir."/inicio/?l2=".$codeCataProd;

            $layout_migaja .= "<li role='presentation' class=''><a href='".$migaja_url_kit."'>".$migaja_nombre_kit."</a></li>";
        }//FIN KIT ACTIVO*/
        
        //CUAL PRENDA ESTOY AGREGANDO AL PEDIDO
        /*if($prenda_activa == $idSubCateProd_add){

            $migaja_nombre_prenda = $nomeSubCateProd_add;
            $migaja_url_prenda = $pathmm.$takeOrderDir."/browse/?catego=".$idSubCateProd_add."&l2=".$idCateProd_add."&tagcat=".$kit_explorar; 

            $layout_migaja .= "<li role='presentation' class=''><a href='".$migaja_url_prenda."'>".$migaja_nombre_prenda."</a></li>";

        }//FIN PRENDA ACTIVA*/
        
        //LAYOUT ITEM ADICIONAL
                                    
        $layout_categoria_usuario .= "<li class=''>";
        $layout_categoria_usuario .= "<span class='badge bg-red'> PZs</span>";
        $layout_categoria_usuario .= "<a href='".$path_url_nav_add."'>";
        $layout_categoria_usuario .= "<span class='cbp-ig-icon'>";
        $layout_categoria_usuario .= "<img src='".$print_img_adicional."' class='img-responsive printicon' style='margin:0px auto;' />";// style='margin:0px auto; height:195px;'
        $layout_categoria_usuario .= "</span>";
        $layout_categoria_usuario .= "<h3 class='cbp-ig-title'>".$nombre_adicional_catalogo."</h3>";
        $layout_categoria_usuario .= "</a>";
        $layout_categoria_usuario .= "</li>";
      
    }//FIN LAYOUT CATEGORIA ADICIONAL
    
    
    //CREA LAYAOUT PARA TODOS LAS CATEGORIAS EXCEPTO ADICIONAL
    foreach($grupoCategoriasUsuario as $gcuKey){

        $nombre_categoria_catalogo = $gcuKey['nombre_categoria_catalogo'];
        $portada_categoria_catalogo = $gcuKey['portada_categoria_catalogo'];
        $tag_categoria_catalogo = $gcuKey['tag_nombre_categoria_catalogo'];

        //PATHH FOTO CATEGORIA
        $path_img_categoria = "../../files-display/tienda/categorias-catalogo/".$portada_categoria_catalogo;

        //PATH SIGUIENTE PASO NAVEGACION -> PASO TRES
        $path_url_nav = $pathmm.$takeOrderDir."/inicio/?steps=tres&tagcat=".$tag_categoria_catalogo;
        
        
        
        
        //EN CUAL CATEGORIA ME ENCUENTRO -> MIGAJAS
        if($kit_explorar == $tag_categoria_catalogo){

            $migaja_nombre_categoria = $nombre_categoria_catalogo;
            $migaja_tag_categoria = $tag_categoria_catalogo;
            $migaja_url_categoria = $pathmm.$takeOrderDir."/inicio/?steps=tres&tagcat=".$migaja_tag_categoria;

            $layout_migaja .= "<li role='presentation' class='".$acti_kit_migaja."'><a href='".$migaja_url_categoria."'>".$migaja_nombre_categoria."</a></li>";
        }//FIN CATEGORIA ACTIVA
        

        //VERIFICAR PORTADA
        if (file_exists($path_img_categoria)) {
            $print_categoria_catalogo = $path_img_categoria;                                        
        } else {
            $print_categoria_catalogo = $pathFileDefault;
        }

        $layout_categoria_usuario .= "<li class=''>";
        $layout_categoria_usuario .= "<span class='badge bg-red'> PZs</span>";
        $layout_categoria_usuario .= "<a href='".$path_url_nav."'>";
        $layout_categoria_usuario .= "<span class='cbp-ig-icon'>";
        $layout_categoria_usuario .= "<img src='".$print_categoria_catalogo."' class='img-responsive printicon' style='margin:0px auto;' />";// style='margin:0px auto; height:195px;'
        $layout_categoria_usuario .= "</span>";
        $layout_categoria_usuario .= "<h3 class='cbp-ig-title'>".$nombre_categoria_catalogo."</h3>";
        $layout_categoria_usuario .= "</a>";
        $layout_categoria_usuario .= "</li>";
    } //LAYOUT CATEGORIAS SIN ADICIONAL
    
    
    $layout_categoria_usuario .= "</ul>";//cbp-ig-grid
    //$layout_categoria_usuario .= "</div>";//main
    
}


//+++++++++++++++++++++++++++
//+++++++++++++++++++++++++++
//CATALOGO > NIVEL KIT




$checkColeccionKit = "";

//$total_piezas_kit = "";
if(count($grupoKitsUsuario) > 0){
    foreach($grupoKitsUsuario as $gkuKey){
        $codeCataProd = $gkuKey['id_catego_product'];
        $nomeCategoProd = $gkuKey['nome_catego_product'];
        $subNomeCategoProd = $gkuKey['descri_catego_prod'];
        $ropaKitCategoProd = $gkuKey['tipo_kit_4user'];
        $piezasKitCategoProd = $gkuKey['cant_pz_kit'];
        $tagColeccionKitCategoProd = $gkuKey['tags_depatament_produsts'];
        //$total_piezas_kit = $piezasKitCategoProd;
        //echo $total_piezas_kit;
        
        //EN CUAL KIT ME ENCUENTRO
        if( $prendas_explorar == $codeCataProd){
            $migaja_nombre_kit = $nomeCategoProd;
            $migaja_url_kit = $pathmm.$takeOrderDir."/inicio/?l2=".$codeCataProd."&tagcat=".$kit_explorar."&steps=cuatro";

            $layout_migaja .= "<li role='presentation' class='".$acti_prendaexp_migaja."'><a href='".$migaja_url_kit."'>".$migaja_nombre_kit."</a></li>";
        }//FIN KIT ACTIVO

        //IMPRIME LOS KITS DEPENDIENDO LA CATEGORIA ACTIVADA

        if($kit_explorar == $ropaKitCategoProd ){
            
            if($checkColeccionKit != $tagColeccionKitCategoProd){
                $checkColeccionKit = $tagColeccionKitCategoProd;
            }
            
            $linkWrapPZ = "<a href='?l2=".$codeCataProd."&tagcat=".$ropaKitCategoProd."&steps=cuatro' >";        

            $layout_kit_usuario .= "<li>";
            $layout_kit_usuario .= $linkWrapPZ; 
            $layout_kit_usuario .= "<span class='cbp-ig-icon '><i>".$nomeCategoProd."</i></span>";
            $layout_kit_usuario .= "<h3 class='cbp-ig-title'>".$subNomeCategoProd."</h3>";
            $layout_kit_usuario .= "</a>";
            $layout_kit_usuario .= "</li>"; 
                
        }
    }
}

//+++++++++++++++++++++++++++
//+++++++++++++++++++++++++++
//CATALOGO > NIVEL PRENDAS



$catalogoBreak = 1;

$id_prenda_pedido = "";
$id_prenda_pedido_db = "";

//echo "<pre>";
//print_r($grupoPrendas);
if(count($grupoPrendas)>0){
    foreach($grupoPrendas as $gpuKit){
        
        //LAYOUT PRENDAS 

        $idCateProd = $gpuKit['id_catego_product'];
        $idSubCateProd = $gpuKit['id_subcatego_producto'];
        $nomeSubCateProd = $gpuKit['nome_subcatego_producto'];
        $fileSubCateProd = $gpuKit['img_subcate_prod'];
        $tagColectionPrenda = $gpuKit['tags_depatament_produsts'];
        $typeKitCateProd = "";//$gpuKit['tipo_kit_4user']; $kit_explorar = $_GET['tagcat'];

        $pathFileSubCate = "../../files-display/tienda/img-catego/".$fileSubCateProd;                

        //VERIFICAR PORTADA
        if (file_exists($pathFileSubCate)) {
            $portadaSubCateFile = $pathFileSubCate;                                        
        } else {
            $portadaSubCateFile = $pathFileDefault;
        }
        
        //CUAL PRENDA ESTOY AGREGANDO AL PEDIDO
        if($prenda_activa == $idSubCateProd){

            $migaja_nombre_prenda = $nomeSubCateProd;
            $migaja_url_prenda = $pathmm.$takeOrderDir."/browse/?catego=".$idSubCateProd."&l2=".$idCateProd."&tagcat=".$kit_explorar; 

            $layout_migaja .= "<li role='presentation' class='".$acti_prenda_migaja."'><a href='".$migaja_url_prenda."'>".$migaja_nombre_prenda."</a></li>";

        }//FIN PRENDA ACTIVA
        
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        //SEGUIMIENTO AL PEDIDO QUE ESTOY REALIZANDO
        
        $id_prenda_pedido = comparaPrendaPedido($idSubCateProd);

        /*if(is_array($items_pedido_usuario)){
            foreach($items_pedido_usuario as $ipuKey){
                $id_kit_pedido = $ipuKey['id_catego_prod'];
                $id_prenda_pedido = $ipuKey['id_subcatego_producto'];
            }

            $id_prenda_pedido_db = $id_prenda_pedido;
        }//SEGUIMIENTO AL PEDIDO QUE ESTOY REALIZANDO*/
        
        //IMPRIME LAS PRENDAS CORRESPONDIENTES AL KIT ACTIVADO POR EL USUARIO
        if($prendas_explorar == $idCateProd){
            
            if($id_prenda_pedido == $idSubCateProd){
                
                //echo "si entra";
                                                
                $linkWrapPZ = "<a href='#' class='pzskit' name='".$nomeSubCateProd."' title='Pieza seleccionada' data-msj='Ya seleccionaste esta pieza, para cambiarla primero debes eliminarla desde la orden del pedido'>";
                $divDisabledPZ = "show";

            }else{
            
                if(isset($_GET['addl3']) && $_GET['addl3'] != ""){
                $adicionalVar = (int)$_GET['addl3'];
                $linkWrapPZ = "<a href='".$pathmm.$takeOrderDir."/browse/?catego=".$idSubCateProd."&l2=".$idCateProd."&addl3=".$adicionalVar."&tagcat=".$kit_explorar."&gender=".$tagColectionPrenda."'>";
                }else{
                    $linkWrapPZ = "<a href='".$pathmm.$takeOrderDir."/browse/?catego=".$idSubCateProd."&l2=".$idCateProd."&tagcat=".$kit_explorar."&gender=".$tagColectionPrenda."'>";    
                }            
                $divDisabledPZ = "hidden";
            }


            $tmplLayoutItem .= "<div class='col-xs-12 col-sm-6 wrap-prod '>";// item subcate ".$wrapPZClass."
            $tmplLayoutItem .= $linkWrapPZ;//"<a href='".$pathFile."/?catego=".$idSubCateProd."&l2=".$idCategoProd."'>";
            $tmplLayoutItem .= "<div class='box box-widget widget-user-3 '>";// wrap subcate
            $tmplLayoutItem .= "<div class='desabled ".$divDisabledPZ."'><i class='fa fa-check'></i><span>Seleccionado</span></div>";
            $tmplLayoutItem .= "<div class='widget-user-header' style='background-image:url(".$portadaSubCateFile.");'></div>";
            $tmplLayoutItem .= "<h3 class='padd-verti-xs padd-hori-xs untopdowlmargin text-center'>";
            $tmplLayoutItem .= $nomeSubCateProd;
            $tmplLayoutItem .= "</h3>";                            
            $tmplLayoutItem .= "</div>";//fin wrap subcate
            $tmplLayoutItem .= "</a>";
            $tmplLayoutItem .= "</div>";// fin item subcate
            
            //DEFINE PUNTOS DE QUIEBRE
            if(fmod($catalogoBreak,2)==0){
                $tmplLayoutItem .= "<div class='clearfix hidden-xs visible-sm visible-md visible-lg'></div>";
            }
            if(fmod($catalogoBreak,1)==0){
                $tmplLayoutItem .= "<div class='clearfix visible-xs hidden-sm hidden-md hidden-lg'></div>";
            }
            $catalogoBreak++;
            
        }
                                                                                                              
    }
}

/*///////////////////////////////////////////////////////////////
/*
/*ACCESOS DIRECTOS PRODUCTOS
/*
*////////////////////////////////////////////////////////////////

function totalDotacionUsuario($idSubcatePF){
    global $db;
    $datasQuery = array();
    
    $rawSQL = "SELECT cat.id_catego_product, cat.nome_catego_product, cat.tipo_kit_4user, sub.id_catego_product, sub.nome_subcatego_producto, sub.id_subcatego_producto, sub.img_subcate_prod, sub.talla_tipo_prenda, sub.tags_depatament_produsts, sub.posi_sub_cate_prod";
    $rawSQL .= " FROM categorias_productos as cat, sub_categorias_productos as sub ";
    $rawSQL .= "WHERE sub.id_subcatego_producto = ".$idSubcatePF." AND sub.id_catego_product = cat.id_catego_product ORDER BY sub.posi_sub_cate_prod ASC";
    
    $queryDB = $db->rawQuery ($rawSQL);
        
    $resuQueryDB = count($queryDB);
    if ($resuQueryDB > 0){
        foreach ($queryDB as $qkey) { 
            $datasQuery[] = $qkey;    
        }
        return $datasQuery;
    }
}
function consultaPrendasDotacion(){
    
    global $db;
    global $idSSUser;
    
    $asignadosUsu = array();
    
    $db->where('id_account_user',$idSSUser);
    $paquete_full = $db->get('pack_dotacion_user');
    
    if(!empty($paquete_full)){
        foreach($paquete_full as $pfKey){
            $id_prenda_full = $pfKey['id_subcatego_producto'];

            $totalUserGet = totalDotacionUsuario($id_prenda_full);

            $asignadosUsu[] = $totalUserGet;
        }   
    }
    
    return $asignadosUsu;
}

$print_articulos_user = consultaPrendasDotacion();
//echo "<pre>";
//print_r($print_articulos_user);

function printAccesoRapido(){
    global $pathmm;
    global $id_prenda_pedido;
    $print_articulos_user = array();
    $print_articulos_user = consultaPrendasDotacion();
    $layout_articulos_user = "";
    global $takeOrderDir;
    
    if(is_array($print_articulos_user)){
        foreach($print_articulos_user as $potKey){
            if(is_array($potKey)){
                foreach($potKey as $potVal){   
                    /*
                    [id_catego_product] => 7
                    [nome_catego_product] => Formal
                    [tipo_kit_4user] => frio
                    [nome_subcatego_producto] => Blazer - Chaqueta
                    [id_subcatego_producto] => 24
                    [img_subcate_prod] => blazer-formal-clima-frio-femenino.jpg
                    [talla_tipo_prenda] => superior
                    [tags_depatament_produsts] => femenino
                    [posi_sub_cate_prod] => 3
                    */

                    $id_prenda = $potVal['id_subcatego_producto'];
                    $id_kit = $potVal['id_catego_product'];
                    $tag_categoria = $potVal['tipo_kit_4user'];
                    $name_prenda = $potVal['nome_subcatego_producto'];
                    $portada_prenda = $potVal['img_subcate_prod'];

                    $pathFileSubCate = $pathmm."/files-display/tienda/img-catego/".$portada_prenda;                

                    //VERIFICAR PORTADA
                    /*if (file_exists($pathFileSubCate)) {
                        $portadaSubCateFile = $pathFileSubCate;                                        
                    } else {
                        $portadaSubCateFile = $pathFileDefault;
                    }*/

                    if($id_prenda_pedido == $id_prenda){

                        //echo "si entra";

                        $linkWrapPZ = "<a href='#' class='pzskit' name='".$nomeSubCateProd."' title='Pieza seleccionada' data-msj='Ya seleccionaste esta pieza, para cambiarla primero debes eliminarla desde la orden del pedido'>";
                        $divDisabledPZ = "show";

                    }else{

                        if(isset($_GET['addl3']) && $_GET['addl3'] != ""){
                        $adicionalVar = (int)$_GET['addl3'];
                        $linkWrapPZ = "<a href='".$pathmm.$takeOrderDir."/browse/?catego=".$id_prenda."&l2=".$id_kit."&addl3=".$adicionalVar."&tagcat=".$tag_categoria."'>";
                        }else{
                            $linkWrapPZ = "<a href='".$pathmm.$takeOrderDir."/browse/?catego=".$id_prenda."&l2=".$id_kit."&tagcat=".$tag_categoria."'>";    
                        }            
                        $divDisabledPZ = "hidden";
                    }

                    $layout_articulos_user .= "<li>";    

                    $layout_articulos_user .= $linkWrapPZ;
                    $layout_articulos_user .= "<img src='".$pathFileSubCate."' style='height:40px; float:left; margin-right:10px;'>";
                    $layout_articulos_user .= $name_prenda;
                    $layout_articulos_user .= "</a>";
                    $layout_articulos_user .= "</li>";
                }
            }

        }
        return $layout_articulos_user;
    }
    

}// fin function printOrderListTmp()


/*///////////////////////////////////////////////////////////////
/*
/*ESTADOS PROGRESO COMPRA GLOBAL - KIT
/*
*////////////////////////////////////////////////////////////////

//MAPA COMPLETO PAQUETE DOTACION USUARIO
$paquete_dotacion_noadd = $paquete_usuario;
//$paquete_dotacion_add[] = $paquete_adicional_usuario; 
if(!empty($paquete_adicional_usuario)){
    $paquete_dotacion_noadd[] = $paquete_adicional_usuario;   
}


//$grupoPrendas[] = $grupo_prendas_add;
//$total_prendas = $grupoPrendas;

//$paquete_usuario[] = $paquete_adicional_usuario;
//$total_mapa = $paquete_usuario;

//$grupoPrendas[] = $grupo_prendas_add;
//$total_prendas = $grupoPrendas;
//$total_prendas[] = $grupo_prendas_add;
//CANTIDAD PIEZAS EN EL KIT ACTUALMENTE VISITADO
//$piezasKitCategoProd
/*echo "<pre>";
print_r($total_mapa);

foreach($total_mapa as $tmKey){
    foreach($tmKey as $tmVal => $tmvla){
        foreach( $tmvla as $fvf){
        $nome_prenda[] = $fvf;//['nome_clean_subcatego_prod'];
        //echo  $nome_prenda."<br>";
        }
    }
}
print_r($nome_prenda);*/

//++++++++++++++++++++++++++++++++++++++++++++++++
//CALCULA TOTAL PRENDAS ASIGNADAS A USUARIO 
//TOTAL COMPRA GLOBAL


//TOTAL ITEMS O PIEZAS PARA ESTE USUARIO
$total_articulos_dotacion = count($paquete_dotacion_noadd);// + count($paquete_dotacion_add);

//echo $total_articulos_dotacion;

//TOTAL ITEMS O PIEZAS EN SOLICITUD DE PEDIDO
$total_articulos_pedido = $count_items_pedido_usuario;


//DEFINE PROGRESO COMPRA GLOBAL
$valueGlobalProgess = ($total_articulos_pedido/$total_articulos_dotacion)*100;//$totalPZasOrder
$valueGlobalProgessFormat = round($valueGlobalProgess, 2, PHP_ROUND_HALF_DOWN);



//DEFINE PROGRESO COMPRA PARA EL KIT ACTUALMENTE VISITADO

$maxPZAS = 0;
$totalItemsOTNOW = 0;
$totalPZasOrder = 0;

if((isset($_GET['addl3']) && $_GET['addl3'] != "") || (isset($_GET['addl3inp']) && $_GET['addl3inp'] != "") ){
//if(isset($count_paquete_adicional) && $count_paquete_adicional > 0 && isset($_GET['addl3'])){
    $maxPZAS = 1;

    //VERIFICA SI YA REALIZO EL PEDIDO DEL KIT ADICIONAL
    $db->where ("id_solici_promo", $otNOW); 
    $db->where ("id_subcatego_producto", $id_prenda_add); 
    $adicional_pedido = $db->getOne('especifica_prod_pedido');
    $count_adicional_pedido = count($adicional_pedido);
    
    if($count_adicional_pedido > 0){
        $totalItemsOTNOW = 1;
        $totalPZasOrder = 1;    
    }    
}else{
    //echo $piezasKitCategoProd;
    
    $maxPZAS = $piezasKitCategoProd;
    //TOTAL ITEMS REGISTRADOS EN EL PEDIDO PARA EL KIT ACTUALMENTE VISITADO
    $totalItemsOTNOW = comparaKitPedido($prendas_explorar); //queryOrderTmpItem($otNOW, $prendas_explorar);
    $totalPZasOrder = count($totalItemsOTNOW);
}


$valueProgresGlobal = ($totalPZasOrder/$maxPZAS)*100;
$valueProgresGlobalFormat = round($valueProgresGlobal, 2, PHP_ROUND_HALF_DOWN);


//IMPRIME PRODS
$printProds = array();
$printProds = queryProds();

//URL ACTUAL

$actual_url_browse = obtenerURL();

//$totalItemsProd = count($printProds);

/*///////////////////////////////////////////////////////////////
/*
/*ESTADOS PROGRESO COMPRA GLOBAL - KIT
/*
*////////////////////////////////////////////////////////////////

/*//MAPA COMPLETO PAQUETE DOTACION USUARIO
$paquete_dotacion_noadd = $paquete_usuario;
$paquete_dotacion_add[] = $paquete_adicional_usuario;

//EXPLORAR LOS ITEMS ADICIONADOS AL PEDIDO

$pzs_kit_pedido_x_prenda = 0;
$pzs_kit_pack = "";

//DEFINIR DONDE SE ENCUENTRA EL USUARIO Y QUE ESTA PIDIENDO
if(is_array($paquete_dotacion_noadd) && count($paquete_dotacion_noadd)>0){

    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //RECORRIENDO EL ESQUEMA DOTACION ASIGNADO AL USUARIO
    foreach($paquete_dotacion_noadd as $ptdKey){

        //LA CATEGORIA QUE EL USUARIO ESTA EXPLORANDO
        $categorias_total_dotacion = $ptdKey['categoria_pack'];
        if(is_array($categorias_total_dotacion)){
            foreach($categorias_total_dotacion as $ctdVal){
                $nombre_categoria_catalogo = $ctdVal['nombre_categoria_catalogo'];
                $portada_categoria_catalogo = $ctdVal['portada_categoria_catalogo'];
                $tag_categoria_catalogo = $ctdVal['tag_nombre_categoria_catalogo'];

            }
        }
        

        //EL KIT QUE EL USUARIO ESTA EXPLORANDO
        $kits_total_dotacion = $ptdKey['kit_pack'];
        if(is_array($kits_total_dotacion)){
            foreach($kits_total_dotacion as $ktdVal){
                $id_kit_pack = $ktdVal['id_catego_product'];
                $nombre_kit_pack = $ktdVal['nome_catego_product'];
                $ropaKitCategoProd = $ktdVal['tipo_kit_4user'];
                $pzs_kit_pack = $ktdVal['cant_pz_kit'];
                
                
                

            }
        }
        
       
        //LA PRENDA QUE EL USUARIO ESTA EXPLORANDO
        $prendas_total_dotacion = $ptdKey['prenda_pack'];
        if(is_array($prendas_total_dotacion)){
            foreach($prendas_total_dotacion as $itdVal){
                $kit_pack = $itdVal['id_catego_product'];
                $prenda_pack = $itdVal['id_subcatego_producto'];
                $nombre_premda_pack = $itdVal['nome_subcatego_producto'];
                
                
            }
        }
           
        
    }//FIN ESQUEMA DOTACION ASIGNADO
    
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //SEGUIMIENTO AL PEDIDO QUE ESTOY REALIZANDO
    if(is_array($items_pedido_usuario)){
        foreach($items_pedido_usuario as $ipuKey){

            $id_kit_pedido = $ipuKey['id_catego_prod'];
            $id_prenda_pedido = $ipuKey['id_subcatego_producto'];

            //+++++++++++++++++++++++++++++++++++++++++
            //EN CUAL CATEGORIA ME ENCUENTRO -> MIGAJAS
            if($kit_explorar == $ropaKitCategoProd){

                //CUANTAS PRENDAS AGREGUE DE ESTE KIT
                if( $prendas_explorar == $id_kit_pedido){

                    //CUAL PRENDA ESTOY AGREGANDO AL PEDIDO
                    if($prenda_activa == $id_prenda_pedido){

                    }

                }
            }


            //+++++++++++++++++++++++++++++++++++++++++
            //CANTIDAD ARTICULOS PARA ESTA CATEGORIA

            //CONTROL ARTIUCLOS POR TIPO PRENDA SELECCIONADO
            if($prendas_explorar = $id_kit_pedido){
                $pzs_kit_pedido_x_prenda = $pzs_kit_pedido_x_prenda + 1;
            }

        }
    }//SEGUIMIENTO AL PEDIDO QUE ESTOY REALIZANDO
 
} */



/*//MIGAJAS -> EL USUARIO VISUALIZA EN CUAL CATEGORIA SE ENCUENTRA
$migaja_pedido = array();
$migaja_pedido = $paquete_usuario;

if(is_array($migaja_pedido) && count($migaja_pedido)>0){
    foreach($migaja_pedido as $migKey){
        $categorias_migajas_array = $migKey['categoria_pack'];
        $kit_migajas_array = $migKey['kit_pack'];
        $prenda_migajas_array = $migKey['prenda_pack'];
        
        //MIGAJAS CATEGORIAS
        if(is_array($prendas_usuario_array)){
            foreach($prendas_usuario_array as $puVal){
                $grupoPrendas[] = $puVal;
            }
        }
    }
    //$grupoKitsUsuario = unique_multidim_array($grupoKits, 'id_catego_product');
    echo "<pre>";
    print_r($categorias_migajas_array);
}*/





    

/*///////////////////////////////////////////////////////////////
/*
/*ARTICULOS ESCOGIDOS POR EL USUARIO EN ORDEN DE COMPRA
/*
*////////////////////////////////////////////////////////////////

/*//MAPA COMPLETO PAQUETE DOTACION USUARIO
//$paquete_usuario[] = $paquete_adicional_usuario;
$paquete_dotacion_noadd = $paquete_usuario;
$paquete_dotacion_add = $paquete_adicional_usuario;

//SELECT `id_espci_prod_pedido`, `id_solici_promo`, `id_catego_prod`, `id_subcatego_producto`, `id_producto`, `id_prod_filing`, `cant_pedido`, `precio_costo`, `precio_venta`, `utilidad_porcien`, `utilidad`, `subtotal_list` FROM `especifica_prod_pedido` WHERE 1

$db->where ("id_solici_promo", $otNOW);    //
$items_pedido_usuario = $db->get('especifica_prod_pedido');
$count_items_pedido_usuario = count($items_pedido_usuario);

//echo "<pre>";
//print_r($paquete_dotacion_noadd);

$mis_items_pedidos = array();

$total_articulos_pedidos = 0;

if(is_array($items_pedido_usuario)){
    foreach($items_pedido_usuario as $ipuKey){
        
        //$id_kit_pedido = $ipuKey['id_catego_prod'];
        $id_prenda_pedido = $ipuKey['id_subcatego_producto'];
        
        
        
        if(is_array($paquete_dotacion_noadd) && count($paquete_dotacion_noadd)>0){
            foreach($paquete_dotacion_noadd as $ptdKey){
                $kits_total_dotacion = $ptdKey['kit_pack'];
                if(is_array($kits_total_dotacion)){
                    foreach($kits_total_dotacion as $ktdVal){
                        $id_kit_pack = $ktdVal['id_catego_product'];
                        $pzs_kit_pack = $ktdVal['cant_pz_kit'];
                    }
                }
            }


            $prendas_total_dotacion = $ptdKey['prenda_pack'];
            if(is_array($prendas_total_dotacion)){
                foreach($prendas_total_dotacion as $itdVal){
                    $kit_pack = $itdVal['id_catego_product'];
                    $prenda_pack = $itdVal['id_subcatego_producto'];
                }
            }
        }           
    
    
    //DEFINIR CUANTAS PIEZAS DEL KIT FUERON ADUIRIDAS
    //COMPARAR CUALES PRENDAS FUERON PEDIDAS
    
        
        
        
        
        
        //CONSULTA KITS EN PEDIDO
        //$mis_kits = kitsUsuario($id_kit);
        
        //CONSULTA PRENDAS EN PEDIDO
        $mis_items_pedidos = prendasUsuario($id_prenda_pedido);
        
        $total_articulos_pedidos = count($mis_items_pedidos);
        
        //COMPRUEBO CUANTAS PIEZAS POR CATEGORIA YA HE PEDIDO
        if(is_array($mis_prendas)){
            //foreach($mis_prendas)
        }
        
                
        $total_articulos_pedidos = $total_articulos_pedidos + 1;
    }
}



*/