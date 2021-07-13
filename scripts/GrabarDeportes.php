<?php
include("include/dbcon.php");
require "clases/class.dbsession.php";
$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{    
	echo "({'cancelado':'cancelado'})";	
}else{

include("clases/class.mysql.php");
include("clases/class.deportes.php");
$deportes = new deportes();
$deportes->nombre = $_POST["nombre-text"];


$result = $deportes->grabarDeportes(); 

echo $result;
}
?>