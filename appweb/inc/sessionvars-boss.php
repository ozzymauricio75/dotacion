<?php
$sessionArr = array();
$MM_restrictGoTo = $pathmm."boss/";

if(!isset($_SESSION['carin'])){ $_SESSION['carin'] = NULL; }
if (!((isset($_SESSION['boss_account'])) && (is_array($_SESSION['boss_account'])))) {   
    	
    $_SESSION['boss_account'] = NULL;
    unset($_SESSION['boss_account']);
      
    $jumpLook = '<script type="text/javascript">';
    $jumpLook .='window.location.href="'.$MM_restrictGoTo.'";';
    $jumpLook .='</script>';
    $jumpLook .='<noscript>';
    $jumpLook .='<meta http-equiv="refresh" content="0;url='.$MM_restrictGoTo.'" />';
    $jumpLook .='</noscript>';
    echo $jumpLook;
    exit;            
    
}else{
    $sessionArr[] = $_SESSION['boss_account'];
    foreach($sessionArr as $userKey){
        $idSSUser = $userKey['iduser'];        
        $pseudoSSUser = $userKey['spseudouser'];
        $nameSSUser = $userKey['nameuser'];
        $emailSSUser = $userKey['mailuser'];            
        $companySSUser = $userKey['companyuser']; 
        $cityCompanySSUser = $userKey['citycompanyuser'];                             
    }
	$userSessionArea = "ok";
    $actisession = "ok";
    //$typeColection = $genderSSUser;//define masculino<->femenino 
    //$typeKit = $kitSSUser;    
}



//CREAR NUEVO ORDEN DE PEDIDO USUARIO JEFE
$MM_restrictNewOrder = $pathmm."boss/inicio/";
if(isset($_GET['orderboss']) && $_GET['orderboss'] == "new"){ 
    
    $lastOrderTemp = actiOrder($idSSUser, $idSSUser, $nameSSUser);
                
    if($lastOrderTemp !== false){
        $fileDestiny = $bossDir."/browse/?otmp=".$lastOrderTemp;
        gotoRedirect($fileDestiny);   
    }else{
        $errValidaTmpl .= "<section class='box50 padd-verti-xs'>";
        $errValidaTmpl .= "<ul class='list-group text-left'>";
        $errValidaTmpl .= "<li class='list-group-item list-group-item-danger'><b>Algo salio mal</b>
            <br>Opciones:
            <br>Erro: ".$lastOrderTemp."
            <br>Puedes intentar nuevamente
            <br>Si este error continua, por favor comunicate con soporte</li>";
        $errValidaTmpl .= "</ul>";
        $errValidaTmpl .= "</section>";    
    }
    
    
}else if(isset($_GET['orderboss']) && $_GET['orderboss'] != "new"){
    
    $jumpLook = '<script type="text/javascript">';
    $jumpLook .='window.location.href="'.$MM_restrictNewOrder.'";';
    $jumpLook .='</script>';
    $jumpLook .='<noscript>';
    $jumpLook .='<meta http-equiv="refresh" content="0;url='.$MM_restrictNewOrder.'" />';
    $jumpLook .='</noscript>';
    echo $jumpLook;
    exit; 
    
}


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