<?php require_once '../../appweb/lib/MysqliDb.php'; ?>
<?php require_once '../../cxconfig/config.inc.php'; ?>
<?php require_once '../../cxconfig/global-settings.php'; ?>
<?php require_once '../../appweb/inc/sessionvars-boss.php'; ?>
<?php require_once '../../appweb/lib/gump.class.php'; ?>
<?php require_once '../../appweb/inc/site-tools.php'; ?>
<?php
/*if (!isset($_SESSION)) {
  session_start();
}*/

$logoutGoTo = "../";

if(isset($_GET['uss']) && $_GET['uss'] == "out"){
    //edita estatus orden temporal
    $orderTmpFinish = Array (
        'estado_solicitud' => 1
    );

    $db->where ('id_solici_promo', $otNOW);
    if ($db->update ('solicitud_pedido_temp', $orderTmpFinish)){

        //suspende acceso de usuario
        //$userSuspend = Array ('estado_cuenta' => 2);

        //$db->where ('id_account_user', $idSSUser);
        //if ($db->update ('account_user', $userSuspend)){

            unset($_SESSION['carin']);

            if(isset($_SESSION['boss_account'])){

                $_SESSION['boss_account'] = NULL;
                unset($_SESSION['boss_account']);

                header("Location: $logoutGoTo");
                exit;    
            }
        //}                                    
    }   
}else{
    if(isset($_SESSION['boss_account'])){
        $_SESSION['boss_account'] = NULL;
        unset($_SESSION['boss_account']);

        header("Location: $logoutGoTo");
        exit;    
    }
}

/*$_SESSION = array(); 
// Borra la cookie que almacena la sesión 
if(isset($_COOKIE[session_name('')])) { 
    setcookie(session_name(), '', time() - 42000, '/'); 
} 
// Finalmente, destruye la sesión 
session_destroy();

if(isset($_SESSION['boss_account'])){
    
    $_SESSION['boss_account'] = NULL;
    unset($_SESSION['boss_account']);
        
    header("Location: $logoutGoTo");
    exit;    
}
*/





/*
$logoutGoTo = "../../";
if (!isset($_SESSION)) {
  session_start();
}
$_SESSION['nome_user'] = NULL;
$_SESSION['sobrenome_user'] = NULL;
$_SESSION['pseudouser_criatorio'] = NULL;
unset($_SESSION['nome_user']);
unset($_SESSION['sobrenome_user']);
unset($_SESSION['pseudouser_criatorio']);

if ($logoutGoTo != "") {header("Location: $logoutGoTo");
	exit;
}*/