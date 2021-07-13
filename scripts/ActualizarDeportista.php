<?php
include("include/dbcon.php");
require "clases/class.dbsession.php";
$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{    
	echo "({'cancelado':'cancelado'})";	
}else{

include("clases/class.mysql.php");
include("clases/class.actualizardeportista.php");


	
$actualizardeportista = new actualizardeportista();
$actualizardeportista->idregistrocat = $_POST["idregistrocat"];
$actualizardeportista->evento = $_SESSION["evento"];
$actualizardeportista->categoria = $_POST["categoria"];
$actualizardeportista->pruebas = $_POST["pruebas"];
$actualizardeportista->idregistro = $_POST["idregistro"];

$result = $actualizardeportista->actualizarDeportistas(); 

echo $result;
}
?>