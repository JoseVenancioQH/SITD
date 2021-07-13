<?php
include("include/dbcon.php");
require "clases/class.dbsession.php";
$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{    
	echo "({'cancelado':'cancelado'})";	
}else{
include("clases/class.mysql.php");
include("clases/class.grabardelegado.php");
$grabardelegado = new grabardelegado();
$grabardelegado->evento = $_POST["evento"];
$grabardelegado->municipio = $_POST["municipio"];
$grabardelegado->modalidad = $_POST["modalidad"];
$grabardelegado->entidad = $_POST["entidad"];
$grabardelegado->nomevento = $_POST["nomevento"];
$grabardelegado->nommunicipio = $_POST["nommunicipio"];
$grabardelegado->nommodalidad = $_POST["nommodalidad"];
$grabardelegado->nombres = $_POST["nombres"];
$grabardelegado->appaterno = $_POST["appaterno"];
$grabardelegado->apmaterno = $_POST["apmaterno"];
$grabardelegado->fechanacimiento = $_POST["fechanacimiento"];
$grabardelegado->sexo = $_POST["sexo"];
$grabardelegado->curp = $_POST["curp"];
$grabardelegado->direccion = $_POST["direccion"];
$grabardelegado->colonia = $_POST["colonia"];
$grabardelegado->localidad = $_POST["localidad"];
$grabardelegado->codigopostal = $_POST["codigopostal"];
$grabardelegado->correo = $_POST["correo"];
$grabardelegado->peso = $_POST["peso"];
$grabardelegado->talla = $_POST["talla"];
$grabardelegado->rfc = $_POST["rfc"];
$grabardelegado->telefonos = $_POST["telefonos"];
$grabardelegado->tiposanguineo = $_POST["tiposanguineo"];
$grabardelegado->idusuario = $_POST["idusuario"];
$grabardelegado->lista_categoria = $_POST["lista_categoria"];
$grabardelegado->lista_pruebas = $_POST["lista_pruebas"];
$grabardelegado->lista_nom_categoria = $_POST["lista_nom_categoria"];
$grabardelegado->deporteextra = $_POST["deporteextra"];
$grabardelegado->cargo = $_POST["cargo"];

//echo $grabardeportista->grabarDeportista();

$result = $grabardelegado->grabarParticipanteDelegado(); 

echo $result;
}
?>