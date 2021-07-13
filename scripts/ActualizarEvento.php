<?php
include("include/dbcon.php");
require "clases/class.dbsession.php";
$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{    
	echo "({'cancelado':'cancelado'})";	
}else{

include("clases/class.mysql.php");
include("clases/class.eventos.php");
$eventos = new eventos();
$eventos->nombre = $_POST["nombre-text"];
$eventos->coordina = $_POST["coordina-text"];
$eventos->sede = $_POST["sede-text"];
$eventos->caracteristicas = $_POST["caracteristicas-text"];
$eventos->fechainicio = $_POST["fechainicio"];
$eventos->fechafin = $_POST["fechafin"];
$eventos->ano = $_POST["ano-text"];
$eventos->idevento = $_POST["idevento"];

$result = $eventos->actualizarEventos(); 

if($result != 'no'){
	echo "true";
}else{
	echo $result;
}
}
?>