<?php
$sessionArr = array();
$MM_restrictGoTo = $pathmm.$admiDir;

if (!((isset($_SESSION['admi_account'])) && (is_array($_SESSION['admi_account'])))) {   
    	
    $_SESSION['admi_account'] = NULL;
    unset($_SESSION['admi_account']);
      
    $jumpLook = '<script type="text/javascript">';
    $jumpLook .='window.location.href="'.$MM_restrictGoTo.'";';
    $jumpLook .='</script>';
    $jumpLook .='<noscript>';
    $jumpLook .='<meta http-equiv="refresh" content="0;url='.$MM_restrictGoTo.'" />';
    $jumpLook .='</noscript>';
    echo $jumpLook;
    exit;            
                        
}else{
          
    $sessionArr[] = $_SESSION['admi_account'];
    foreach($sessionArr as $userKey){
        $idSSUser = $userKey['iduser'];        
        $pseudoSSUser = $userKey['spseudouser'];
        $nameSSUser = $userKey['nameuser'];
        $lnameSSUser = $userKey['lastnameuser'];    
        $companySSUser = $userKey['companyuser'];         
        $imgSSUser = $userKey['imguser'];           
    }
	$userSessionArea = "ok";
    $actisession = "ok";  
    
    //PATH FOTO DEFAULT
    $imgSSUserDefault = $pathmm."img/nopicture.png";
    //PORTADA
    $pathImgSSUser = "../../../files-display/manager/".$imgSSUser;

    if (file_exists($pathImgSSUser)) {
    $portadaImgSSUser = $pathmm."files-display/manager/".$imgSSUser;
        } else {
    $portadaImgSSUser = $imgSSUserDefault;
    }  
}