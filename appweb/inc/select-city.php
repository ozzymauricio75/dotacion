<?php
require_once '../lib/MysqliDb.php';
require_once "../../cxconfig/config.inc.php";
//$_POST['id'] = 2;
if($_POST['depto']){
    $idEspecie=$_POST['depto'];
//function loadRaza($idEspecie){
    //$db global;
    //SELECT `id_ciudad_user`, `name_ciudad_user`, `name_estado_user`, `id_estado_rel` FROM `ciudades_user` WHERE 1
    
    $db->where ('id_estado_rel', $idEspecie);
    $db->orderBy("name_ciudad_user","Asc");									
    $razaQuery = $db->get('ciudades_user');

    if ($db->count > 0){
        echo "<option value='' selected>Selecciona una Ciudad</option>";	
        foreach ($razaQuery as $razaKey) { 
            $idRaza = $razaKey['id_ciudad_user'];
            $nomeRaza = $razaKey['name_ciudad_user'];            
            echo "<option value='".$idRaza."'>".$nomeRaza."</option>";	
        }
    }	
//}
}