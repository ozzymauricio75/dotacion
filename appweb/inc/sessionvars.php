<?php
$sessionArr = array();
$MM_restrictGoTo = $pathmm;

if(!isset($_SESSION['carin'])){ $_SESSION['carin'] = NULL; }
if (!((isset($_SESSION['pseudouser_account'])) && (is_array($_SESSION['pseudouser_account'])))) {   
    	
    $_SESSION['pseudouser_account'] = NULL;
    unset($_SESSION['pseudouser_account']);
      
    $jumpLook = '<script type="text/javascript">';
    $jumpLook .='window.location.href="'.$MM_restrictGoTo.'";';
    $jumpLook .='</script>';
    $jumpLook .='<noscript>';
    $jumpLook .='<meta http-equiv="refresh" content="0;url='.$MM_restrictGoTo.'" />';
    $jumpLook .='</noscript>';
    echo $jumpLook;
    exit;            
    
}else{
    
    if(isset($_GET['defcity']) && $_GET['defcity'] == "ok"){
        $_SESSION['pseudouser_account']['cityuserget'] = (int)$_GET['cityuser'];
    }
    
    
    $sessionArr[] = $_SESSION['pseudouser_account'];
    foreach($sessionArr as $userKey){
        $idSSUser = $userKey['iduser'];
        //$codSSUser = $userKey['coduser'];
        $pseudoSSUser = $userKey['spseudouser'];
        $nameSSUser = $userKey['nameuser'];
        $emailSSUser = $userKey['mailuser'];   
        $genderSSUser = $userKey['genderuser'];   
        $kitSSUser = $userKey['kituser']; 
        $cedulaSSUser = $userKey['cedulauser']; 
        $companySSUser = $userKey['companyuser']; 
        $cityCompanySSUser = $userKey['citycompanyuser'];                
        $cityGETSSUser = empty($userKey['cityuserget']) ? "" : $userKey['cityuserget']; 
    }
	$userSessionArea = "ok";
    $actisession = "ok";
    $typeColection = $genderSSUser;//define masculino<->femenino 
    $typeKit = $kitSSUser;    
    
    //define tag de coleccion
    $db->where('id_depart_prod',$typeColection);
    $tagColection = $db->getOne('departamento_prods', 'nome_clean_depa_prod');
    $typeColectionTag = $tagColection['nome_clean_depa_prod'];
}
//echo $idSSUser;

$otmp = "";
//CONSULTA ID PEDIDO ACTIVADO
if(isset($_GET['otmp'])){    
    $_SESSION['carin'] = $_GET['otmp'];
    $otNOW = $_SESSION['carin'];
}

if(isset($_SESSION['carin'])){
    $otNOW = $_SESSION['carin'];
}else{
    $otNOW = "";
}

