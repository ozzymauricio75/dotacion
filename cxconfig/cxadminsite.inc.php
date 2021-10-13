<?php

$cxadmisite = new mysqli('localhost','dotacionesquestc_admidb','!e*(#d+Sikc.','dotacionesquestc_questdb');
$cxadmisite->query("SET NAMES 'utf8'");

if (mysqli_connect_errno()) {
    printf("La conexion fallo: %s\n", mysqli_connect_error());
    exit();
}

?>
