<?php
if (!isset($_SESSION)) {
  session_start();
}

$logoutGoTo = "../";

if(isset($_SESSION['admi_account'])){
    $_SESSION['admi_account'] = NULL;
    unset($_SESSION['admi_account']);

    header("Location: $logoutGoTo");
    exit;    
}