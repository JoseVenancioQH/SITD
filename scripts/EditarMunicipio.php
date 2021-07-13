<?php
include("include/dbcon.php");
require "clases/class.dbsession.php";
$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{    
	echo "({'cancelado':'cancelado'})";	
}else{

include("clases/class.mysql.php");
include("clases/class.municipio.php");
$municipio = new municipio();
$municipio->nombre = $_POST["nombre-text"];
$municipio->id = $_POST["id"];

$result = $municipio->editarMunicipio(); 

echo $result;
}
?>