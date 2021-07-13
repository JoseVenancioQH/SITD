<?php
include("include/dbcon.php");
require "clases/class.dbsession.php";
$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{    
	echo "({'cancelado':'cancelado'})";	
}else{


include("clases/class.mysql.php");
include("clases/class.actualizardatosadicionales.php");

$actualizardatosadicionales = new actualizardatosadicionales();
$actualizardatosadicionales->idparticipante = $_POST["idregparticipante"];
$actualizardatosadicionales->direccion = $_POST["direccion"];
$actualizardatosadicionales->colonia = $_POST["colonia"];
$actualizardatosadicionales->localidad = $_POST["localidad"];
$actualizardatosadicionales->codigopostal = $_POST["codigopostal"];
$actualizardatosadicionales->correo = $_POST["correo"];
$actualizardatosadicionales->peso = $_POST["peso"];
$actualizardatosadicionales->talla = $_POST["talla"];
$actualizardatosadicionales->rfc = $_POST["rfc"];
$actualizardatosadicionales->telefonos = $_POST["telefonos"];
$actualizardatosadicionales->tiposanguineo = $_POST["tiposanguineo"];

//echo $grabardeportista->grabarDeportista();

$result = $actualizardatosadicionales->actualizaDatosAdicionales(); 

echo $result;
}
?>