<?php
//require_once '../lib/MysqliDb.php';
///require_once "../../cxconfig/config.inc.php";
/*
 *==================================
 *QUERY CATEGORIA CATALOGO
 *==================================
*/
function queryCategoria($pzsLevel2, $coleccionLevel2){
    global $db;
    $dataQuery = array();    
    //SELECT `id_categoria_catalogo`, `id_depart_prod`, `nombre_categoria_catalogo`, `descripcion_categoria_catalogo`, `portada_categoria_catalogo`, `tag_nombre_categoria_catalogo`, nome_clean_coleccion_categoria_catalogo FROM `categoria_catalogo` WHERE 1
    $db->where('tag_nombre_categoria_catalogo',$pzsLevel2);
    $db->where('nome_clean_coleccion_categoria_catalogo',$coleccionLevel2);
    $queryTbl = $db->get ('categoria_catalogo', null, 'id_categoria_catalogo, tag_nombre_categoria_catalogo'); 
    
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
 *QUERY LEVEL 3
 *==================================
*/

function queryLevel3($idLevel2_){
    global $db;
    $dataQuery = array();    
    //SELECT `id_subcatego_producto`, `id_catego_product`, `nome_subcatego_producto`, `descri_subcatego_prod`, `img_subcate_prod`, `nome_clean_subcatego_prod`, `tags_depatament_produsts`, `posi_sub_cate_prod`, `tipo_prenda`, `talla_tipo_prenda` FROM `sub_categorias_productos` WHERE 1
    $db->where('id_catego_product',$idLevel2_);
    $db->orderBy('nome_subcatego_producto','asc');
    $queryTbl = $db->get ('sub_categorias_productos', null, 'id_subcatego_producto, nome_subcatego_producto, descri_subcatego_prod, nome_clean_subcatego_prod, posi_sub_cate_prod, tipo_prenda, talla_tipo_prenda, img_subcate_prod, tags_depatament_produsts'); 
    
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

function queryLevel2($idLevel1_){
    global $db;
    $dataQuery = array();    
    //SELECT `id_catego_product`, `id_depart_prod`, `nome_catego_product`, `descri_catego_prod`, `tags_depatament_produsts`, `tipo_kit_4user`, `cant_pz_kit` FROM `categorias_productos` WHERE 1
    $db->where('id_depart_prod',$idLevel1_);
    $db->where('tipo_kit_4user','adicional', '!=');
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
            $coleccionLevel2 = $qKey['tags_depatament_produsts'];
            
            $dataL3 = queryLevel3($idLevel2);
            $data_categoria = queryCategoria($kitLevel2, $coleccionLevel2);
            
            $dataQuery[] = array(
                'idlevel2' => $idLevel2,
                'namelevel2' => $nameLevel2,
                'descrilevel2' => $descriLevel2,
                'kitlevel2' => $kitLevel2,
                'cantlevel2' => $pzsLevel2,                
                'datal3' => $dataL3,  
                'datacategoria' => $data_categoria,  
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
function queryLevelsFull(){
    global $db;
            
    $dataQuery = array();
    //SELECT `id_depart_prod`, `nome_depart_prod`, `descri_depart_prod`, `nome_clean_depa_prod` FROM `departamento_prods` WHERE 1    
    //$db->orderBy('nome_depart_prod','asc');
    $queryTbl = $db->get ('departamento_prods'); 
    
    $rowQueryTbl = count($queryTbl);
    if($rowQueryTbl>0){
        foreach($queryTbl as $qKey){
            $idLevel1 = $qKey['id_depart_prod'];
            $nameLevel1 = $qKey['nome_depart_prod'];
            $descriLevel1 = $qKey['descri_depart_prod'];
            $tagLevel1 = $qKey['nome_clean_depa_prod'];
            
            $dataL2 = queryLevel2($idLevel1);
            
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


/*$asdasdas = array();
$asdasdas = queryLevelsFull();
echo"<pre>";
print_r($asdasdas);
echo"</pre>";*/