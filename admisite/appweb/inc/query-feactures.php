<?php
/*
 *==================================
 *QUERY COLORES
 *==================================
*/

function queryColores() {
    global $db;
        
    $dataQuery = array();
    
    $db->orderBy("nome_color","asc");	     
    $queryTbl = $db->get ("tipo_color", null, "id_color, nome_color, color_hexa");
        
    $rowQueryTbl = count($queryTbl);
    if ($rowQueryTbl > 0){
        foreach ($queryTbl as $qKey) {
         $dataQuery[] = $qKey;
        }    
        return $dataQuery;
    }
            
}


/*
 *==================================
 *QUERY TALLAS LETRAS
 *==================================
*/

function queryTallasLetras() {
    global $db;
        
    $dataQuery = array();
    
    $db->orderBy("posi_talla","asc");	     
    $queryTbl = $db->get ("talla_letras", null, "id_talla_letras, nome_talla_letras, posi_talla");
        
    $rowQueryTbl = count($queryTbl);
    if ($rowQueryTbl > 0){
        foreach ($queryTbl as $qKey) {
         $dataQuery[] = $qKey;
        }    
        return $dataQuery;
    }
            
}


/*
 *==================================
 *QUERY TALLAS NUMEROS
 *==================================
*/

function queryTallasNume() {
    global $db;
        
    $dataQuery = array();
    
    $db->orderBy("posi_talla","asc");	     
    $queryTbl = $db->get ("talla_numerico", null, "id_talla_numer, talla_numer, posi_talla");
        
    $rowQueryTbl = count($queryTbl);
    if ($rowQueryTbl > 0){
        foreach ($queryTbl as $qKey) {
         $dataQuery[] = $qKey;
        }    
        return $dataQuery;
    }
            
}



/*
 *==================================
 *QUERY TIPO PRENDAS
 *==================================
*/

//GENERO PERSONA - TIPO COLECCION
function forGenero(){
    global $db;
            
    $dataForGenero = array();
        
    $db->orderBy('nome_depart_prod','asc');
    $queryTbl = $db->get ('departamento_prods'); 
    
    $rowQueryTbl = count($queryTbl);
    if($rowQueryTbl>0){
        foreach($queryTbl as $qKey){
            $dataForGenero[] = $qKey;    
        }
        return $dataForGenero;
    }
    
}

function queryGrupTallaXprenda() {
    global $db;
        
    $dataQuery = array();
    
    $db->orderBy("genero_ropa","asc");	     
    $queryTbl = $db->get ("grupo_tallas", null, "id_grupo_talla, genero_ropa, tipo_prenda,tipo_prenda_tag");
        
    $rowQueryTbl = count($queryTbl);
    if ($rowQueryTbl > 0){
        foreach ($queryTbl as $qKey) {
         $dataQuery[] = $qKey;
        }    
        return $dataQuery;
    }
            
}



/*
 *==================================
 *QUERY GRUPO TALLAS
 *==================================
*/

function queryEspecifiGrupoTalla(){
    global $db;
            
    $dataForGenero = array();
    //SELECT `id_talla_tipo_prenda`, `id_grupo_talla`, `name_talla_tipo_prenda`, `id_talla_tablas`, `talla_tipo_prenda`, `tipo_talla`, `genero_talla`, `posi_talla` FROM `especifica_tallas_tipo_prenda` WHERE 1
    //$db->orderBy('posi_talla','asc');
    $db->orderBy('genero_talla','desc');
    $db->orderBy('name_talla_tipo_prenda','asc');
    $db->orderBy('posi_talla','asc');
    $queryTbl = $db->get ('especifica_tallas_tipo_prenda'); 
    
    $rowQueryTbl = count($queryTbl);
    if($rowQueryTbl>0){
        foreach($queryTbl as $qKey){
            $dataForGenero[] = $qKey;    
        }
        return $dataForGenero;
    }
    
}



/*
 *==================================
 *QUERY MATERIALES
 *==================================
*/

function queryMateriales(){
    global $db;
            
    $dataForGenero = array();
    //SELECT `id_material`, `nome_material`, `valor_material` FROM `tipo_material` WHERE 1
    $db->orderBy('nome_material','asc');
    $queryTbl = $db->get ('tipo_material', null,'id_material, nome_material, valor_material' ); 
    
    $rowQueryTbl = count($queryTbl);
    if($rowQueryTbl>0){
        foreach($queryTbl as $qKey){
            $dataForGenero[] = $qKey;    
        }
        return $dataForGenero;
    }
    
}

    

/*
$dataArr = array
(
    '0' => array
        (
            'idgrupotalla' => '1',
            'nametipoprenda' => 'superior',
            'idtallatbl' => '19',
            'nametalla' => '43',
            'tipotallatag' => 'tl',
            'colection' => 'masculino',
            'positalla' => '0'
        ),

    '1' => array
        (
            'idgrupotalla' => '1',
            'nametipoprenda' => 'superior',
            'idtallatbl' => '16',
            'nametalla' => '39',
            'tipotallatag' => 'tl',
            'colection' => 'masculino',
            'positalla' => '0'
        ),

    '1' => array
        (
            'idgrupotalla' => '1',
            'nametipoprenda' => 'superior',
            'idtallatbl' => '4',
            'nametalla' => '10',
            'tipotallatag' => 'tl',
            'colection' => 'masculino',
            'positalla' => '3'
        ),

    '3' => array
        (
            'idgrupotalla' => '1',
            'nametipoprenda' => 'superior',
            'idtallatbl' => '7',
            'nametalla' => '14',
            'tipotallatag' => 'tl',
            'colection' => 'masculino',
            'positalla' =>'5'
        ),

    '4' => array
        (
            'idgrupotalla' => '1',
            'nametipoprenda' => 'superior',
            'idtallatbl' => '8',
            'nametalla' => '28',
            'tipotallatag' => 'tl',
            'colection' => 'masculino',
            'positalla' => '6'
        ),

    '5' => array
        (
            'idgrupotalla' => '1',
            'nametipoprenda' => 'superior',
            'idtallatbl' => '9',
            'nametalla' => '30',
            'tipotallatag' => 'tl',
            'colection' => 'masculino',
            'positalla' => '7'
        ),

'7' => Array
        (
            'idgrupotalla' => '1',
            'nametipoprenda' => 'superior',
            'idtallatbl' => '13',
            'nametalla' => '34',
            'tipotallatag' => 'tl',
            'colection' => 'masculino',
            'positalla' => '11'
        ),

    '8' => array
        (
            'idgrupotalla' => '1',
            'nametipoprenda' => 'superior',
            'idtallatbl' => '15',
            'nametalla' => '38',
            'tipotallatag' => 'tl',
            'colection' => 'masculino',
            'positalla' => '13'
        )

);

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


}//fin foreach*/


