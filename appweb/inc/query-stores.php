<?php 
$dataStores = array();
$dataStoresDB = array();
$dataStoresOne = array();

$idstore_ = "";
if(isset($_POST['qstore']) && $_POST['qstore'] != ""){
    //$idstore_ = $_POST['qstore'];
    $searchBox_filtro = "{$_POST['qstore']}";//"%%%%{$_GET['search']}%%%%";
    $searchBox_filtro = (string)$searchBox_filtro;  
    $searchBox_filtro = $db->escape($searchBox_filtro);
    $idstore_ = $searchBox_filtro;
}

/*
 *==================================
 *QUERY STORES
 *==================================
*/

function storesQueryDB() {
    global $db;
    global $idstore_;
    
    
    $buskString = $idstore_;
    
    //$buskString = format_NomeEmpresa($buskString);
    //$buskString = trim($buskString);
    //$buskString = str_replace('+', ' ', $buskString);
    
    //define string query cantidad palabras
    $trozos=explode(" ",$buskString);
    $numero=count($trozos);
    	
	if ($buskString != ""){
		
		if ($numero==1) {
            
		  //$sqlStore ="SELECT id_account_empre, id_mb_account_empre, nombre_account_empre, nome_representante, nit_empresa, tel_account_empre1, tel_account_empre2, dir_account_empre, mail_account_empre, comentarios_empresa FROM account_empresa WHERE nome_representante LIKE '%%%%$buskString%%%%%' OR nombre_account_empre LIKE '%%%%$buskString%' OR comentarios_empresa LIKE '%%%%$buskString%' ORDER BY nome_representante ASC";
            $sqlStore ="SELECT id_account_empre, id_mb_account_empre, nombre_account_empre, nome_representante, nit_empresa, tel_account_empre1, tel_account_empre2, dir_account_empre, mail_account_empre, comentarios_empresa FROM account_empresa WHERE nome_representante LIKE '%%%%$buskString%%%%%' ORDER BY nome_representante ASC";
            
		} elseif ($numero>1) {	
            
			$sqlStore ="SELECT id_account_empre, id_mb_account_empre, nombre_account_empre, nome_representante, nit_empresa, tel_account_empre1, tel_account_empre2, dir_account_empre, mail_account_empre, comentarios_empresa, MATCH (nome_representante, comentarios_empresa, nombre_account_empre) AGAINST ( '$buskString' ) AS Score FROM account_empresa WHERE MATCH (nome_representante, comentarios_empresa, nombre_account_empre) AGAINST ( '$buskString' ) ORDER BY Score ASC";
            //$sqlStore ="SELECT id_account_empre, id_mb_account_empre, nombre_account_empre, nome_representante, nit_empresa, tel_account_empre1, tel_account_empre2, dir_account_empre, mail_account_empre, comentarios_empresa, MATCH (nome_representante, nombre_account_empre) AGAINST ( '$buskString' ) AS Score FROM account_empresa WHERE MATCH (nome_representante, nombre_account_empre) AGAINST ( '$buskString' ) ORDER BY Score ASC";
		}
        
        $storeTBL = $db->rawQuery($sqlStore);
        
        $resuStoresDB = count($storeTBL);
        if ($resuStoresDB > 0){
            foreach ($storeTBL as $skey) { 
                $dataStoresDB[] = $skey;
            }                
            return $dataStoresDB;
        }        
	}
    
    
        
    /*$db->orderBy("nombre_account_empre","asc");	
    //$storesDB->where ("id_account_empre", $idstore_);
    $storesDB = $db->get('account_empresa', null, 'id_account_empre, id_mb_account_empre, nombre_account_empre, nit_empresa, nome_representante, dir_account_empre, comentarios_empresa');    
    $resuStoresDB = count($storesDB);
    if ($resuStoresDB > 0){
        foreach ($storesDB as $storekey) { 
            $dataStoresDB[] = $storekey;
        }    
        return $dataStoresDB;
    }*/
}