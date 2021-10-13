<?php
//require_once '../lib/MysqliDb.php';
///require_once "../../cxconfig/config.inc.php";
/*
 *==================================
 *QUERY LEVEL 3
 *==================================
*/

function queryLevel3($idLevel2_, $id_prenda){
    global $db;
    $dataQuery = array();    
    //SELECT `id_subcatego_producto`, `id_catego_product`, `nome_subcatego_producto`, `descri_subcatego_prod`, `img_subcate_prod`, `nome_clean_subcatego_prod`, `tags_depatament_produsts`, `posi_sub_cate_prod`, `tipo_prenda`, `talla_tipo_prenda` FROM `sub_categorias_productos` WHERE 1
    $db->where('id_catego_product',$idLevel2_);
    $db->where('id_subcatego_producto',$id_prenda);
    //$db->orderBy('tags_depatament_produsts','asc');
    //$db->orderBy('nome_subcatego_producto','asc');
    
    $queryTbl = $db->get ('sub_categorias_productos', null, 'id_subcatego_producto, nome_subcatego_producto, descri_subcatego_prod, nome_clean_subcatego_prod, posi_sub_cate_prod, tipo_prenda, talla_tipo_prenda, img_subcate_prod'); 
    
    $rowQueryTbl = count($queryTbl);
    if($rowQueryTbl>0){
        foreach($queryTbl as $qKey){                        
            $dataQuery[] = $qKey;    
        }
        return $dataQuery;
    }
}

/*
 *==================================
 *QUERY LEVEL 2
 *==================================
*/

function queryLevel2($idLevel1_, $id_kit, $id_prenda){
    global $db;
    $dataQuery = array();    
    //SELECT `id_catego_product`, `id_depart_prod`, `nome_catego_product`, `descri_catego_prod`, `tags_depatament_produsts`, `tipo_kit_4user`, `cant_pz_kit` FROM `categorias_productos` WHERE 1
    $db->where('id_depart_prod',$idLevel1_);
    $db->where('id_catego_product',$id_kit);
    $db->where('tipo_kit_4user','adicional', '!=');
    $db->orderBy('tags_depatament_produsts','asc');
    $db->orderBy('tipo_kit_4user','asc');
    $queryTbl = $db->get ('categorias_productos'); 
    
    $rowQueryTbl = count($queryTbl);
    if($rowQueryTbl>0){
        foreach($queryTbl as $qKey){
            $idLevel2 = $qKey['id_catego_product'];
            $nameLevel2 = $qKey['nome_catego_product'];
            $descriLevel2 = $qKey['descri_catego_prod'];
            $kitLevel2 = $qKey['tipo_kit_4user'];
            $pzsLevel2 = $qKey['cant_pz_kit'];
            
            $dataL3 = queryLevel3($idLevel2, $id_prenda);
            
            $dataQuery[] = array(
                'idlevel2' => $idLevel2,
                'namelevel2' => $nameLevel2,
                'descrilevel2' => $descriLevel2,
                'kitlevel2' => $kitLevel2,
                'cantlevel2' => $pzsLevel2,                
                'datal3' => $dataL3,                
            );    
        }
        return $dataQuery;
    }
}

/*
 *==================================
 *QUERY LEVELS FULL
 *==================================
*/

//GENERO PERSONA
function queryLevelsFull($id_kit, $id_prenda){
    global $db;
            
    $dataQuery = array();
    //SELECT `id_depart_prod`, `nome_depart_prod`, `descri_depart_prod`, `nome_clean_depa_prod` FROM `departamento_prods` WHERE 1    
    //$db->orderBy('nome_clean_depa_prod','asc');
    $queryTbl = $db->get ('departamento_prods'); 
    
    $rowQueryTbl = count($queryTbl);
    if($rowQueryTbl>0){
        foreach($queryTbl as $qKey){
            $idLevel1 = $qKey['id_depart_prod'];
            $nameLevel1 = $qKey['nome_depart_prod'];
            $descriLevel1 = $qKey['descri_depart_prod'];
            $tagLevel1 = $qKey['nome_clean_depa_prod'];
            
            $dataL2 = queryLevel2($idLevel1, $id_kit, $id_prenda);
            
            $dataQuery[] = array(
                'idlevel1' => $idLevel1,
                'namelevel1' => $nameLevel1,
                'descrilevel1' => $descriLevel1,
                'taglevel1' => $tagLevel1,
                'datal2' => $dataL2,                
            );    
        }
        return $dataQuery;
    }
    
}




/*///////////////////////////////////////////////////////////////
/*
/*PAQUETE DOTACION USUARIO
/*
*////////////////////////////////////////////////////////////////


/*//CATEGORIA ASIGNADA
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
        $adicional_categorias = categoriasUsuario($id_categoria_add);

        //CONSULTA KITS ASIGNADOS
        $adicional_kits = kitsUsuario($id_kit_add);

        //CONSULTA PRENDAS ASIGNADAS
        $adicional_prendas = prendasUsuario($id_prenda_add);    

        
        $paquete_adicional_usuario = array(
            'categoria_adicional' => $adicional_categorias,
            'kit_adicional' => $adicional_kits,
            'prenda_adicional' => $adicional_prendas
        );
    }
}
*/

//DOTACION ASIGNADA AL USUARIO -> KITS DIFERENTES AL ADICIONAL
function mapaDotacionUsuario(){
    global $db;
    global $idSSUser;
    $db->where('id_account_user',$idSSUser);
    $db->where('kit','adicional', '!=');
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
            $paquete_usuario[] = queryLevelsFull($id_kit, $id_prenda);

        }

        return $paquete_usuario;
    }
}
