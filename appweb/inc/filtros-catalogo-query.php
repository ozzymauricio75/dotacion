<?php
require_once '../lib/MysqliDb.php';
require_once "../../cxconfig/config.inc.php";
//$_POST['id'] = 2;
if($_POST['levII']){
    $idEspecie=$_POST['levII'];
//function loadRaza($idEspecie){
    //$db global;
    //`id_catego_product`, `id_depart_prod`, `nome_catego_product`, `descri_catego_prod`, `tags_depatament_produsts` FROM `categorias_productos`
    
    $db->where ('id_depart_prod', $idEspecie);
    $db->orderBy("nome_catego_product","Asc");									
    $razaQuery = $db->get('categorias_productos');

    if ($db->count > 0){
        echo "<option value='' selected>Seleccionar una</option>";	
        foreach ($razaQuery as $razaKey) { 
            $idRaza = $razaKey['id_catego_product'];
            $nomeRaza = $razaKey['nome_catego_product'];
            $decriRaza = $razaKey['descri_catego_prod'];
            echo "<option value='".$idRaza."'>".$nomeRaza."&nbsp;".$decriRaza."</option>";	
        }
    }	
//}
}