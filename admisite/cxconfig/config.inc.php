<?php
//////////////////////////////////////
//CONEXION BASE DE DATOS
//////////////////////////////////////

/*$db = new MysqliDb (Array (
                'host' => 'localhost',
                'username' => 'root', 
                'password' => '',
                'db'=> 'quest_sodb',
                'port' => NULL,
                'prefix' => NULL,
                'charset' => 'utf8'));*/

$db = new MysqliDb (Array (
                'host' => 'localhost',
                'username' => 'dotacionesquestc_admidb', 
                'password' => '!e*(#d+Sikc.',
                'db'=> 'dotacionesquestc_questdb',
                'port' => NULL,
                'prefix' => NULL,
                'charset' => 'utf8'));    
if(!$db) die("Database error");
$db->setTrace(true);

//OTROS DATOS
define("DEBUG","true");


if(DEBUG == "true"){
    ini_set('display_errors', 1);
	error_reporting (E_ALL|E_STRICT);
}else{
    ini_set('display_errors', 0);
}








//////////////////////////////////////
//DETECTAR VISITANTE IP
//////////////////////////////////////

function getRealIP()
{

    if (isset($_SERVER["HTTP_CLIENT_IP"]))
    {
        return $_SERVER["HTTP_CLIENT_IP"];
    }
    elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
    {
        return $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
    {
        return $_SERVER["HTTP_X_FORWARDED"];
    }
    elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
    {
        return $_SERVER["HTTP_FORWARDED_FOR"];
    }
    elseif (isset($_SERVER["HTTP_FORWARDED"]))
    {
        return $_SERVER["HTTP_FORWARDED"];
    }
    else
    {
        return $_SERVER["REMOTE_ADDR"];
    }

}

$whoIs = getRealIP();


