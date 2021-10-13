
<?php
class MySQL
{
  var $conexion;
  function MySQL()
  {
  	if(!isset($this->conexion))
	{
  		$this->conexion = (mysql_connect("localhost","root","")) or die(mysql_error());
  		mysql_select_db("admimybo_db",$this->conexion) or die(mysql_error());
  	}
  }
  
  
/*  class MySQL
{
  var $conexion;
	global $cxadmimybo;
	//include_once('cxadmimybo.php');
  
  function MySQL()
  {

	  if(!isset($this->conexion))
	{
		
		$cxadmimybo = mysql_pconnect($hostname_cxadmimybo, $username_cxadmimybo, $password_cxadmimybo) or trigger_error(mysql_error(),E_USER_ERROR);
		$this->conexion = $cxadmimybo;
		mysql_select_db("admimybo_db",$this->conexion) or die(mysql_error());
	
  	}
		
  }*/

 function consulta($consulta)
 {
	$resultado = mysql_query($consulta,$this->conexion);
  	if(!$resultado)
	{
  		echo 'MySQL Error: ' . mysql_error();
	    exit;
	}
  	return $resultado; 
  }
  
  
 function fetch_array($consulta)
 { 
  	return mysql_fetch_array($consulta);
 }
 
 function num_rows($consulta)
 { 
 	 return mysql_num_rows($consulta);
 }
 
 function fetch_row($consulta)
 { 
 	 return mysql_fetch_row($consulta);
 }
 function fetch_assoc($consulta)
 { 
 	 return mysql_fetch_assoc($consulta);
 } 
 
}

?>