<?php 

class Conexion{

function get_conexion()
{

try {
	
$conexion = new PDO("mysql:host=localhost;dbname=db_bcg","root","",
	array(
		PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
		PDO::ATTR_PERSISTENT => true

	   ));
$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
return $conexion;
//$conexion = ($conexion) ? "ok" : "error" ;
//echo $conexion;

} catch (Exception $e) {
	
  echo "Error: ".$e->getMessage();
}


}












}




 ?>