<?php
include("include/dbcon.php");
require "clases/class.dbsession.php";

$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{    
	echo "({'cancelado':'cancelado'})";	
}else{

include("clases/class.mysql.php");
include("clases/class.actualizarparticipante.php");
$actualizarparticipante = new actualizarparticipante();

$actualizarparticipante->idregistro = $_POST["idregistro"];
$actualizarparticipante->evento = $_POST["evento"];
$actualizarparticipante->municipio = $_POST["municipio"];
$actualizarparticipante->modalidad = $_POST["modalidad"];
$actualizarparticipante->entidad = $_POST["entidad"];
$actualizarparticipante->nombres = $_POST["nombres"];
$actualizarparticipante->appaterno = $_POST["appaterno"];
$actualizarparticipante->apmaterno = $_POST["apmaterno"];
$actualizarparticipante->fechanacimiento = $_POST["fechanacimiento"];
$actualizarparticipante->sexo = $_POST["sexo"];
$actualizarparticipante->curp = $_POST["curp"];
$actualizarparticipante->direccion = $_POST["direccion"];
$actualizarparticipante->colonia = $_POST["colonia"];
$actualizarparticipante->localidad = $_POST["localidad"];
$actualizarparticipante->codigopostal = $_POST["codigopostal"];
$actualizarparticipante->correo = $_POST["correo"];
$actualizarparticipante->peso = $_POST["peso"];
$actualizarparticipante->talla = $_POST["talla"];
$actualizarparticipante->rfc = $_POST["rfc"];
$actualizarparticipante->telefonos = $_POST["telefonos"];
$actualizarparticipante->tiposanguineo = $_POST["tiposanguineo"];
$actualizarparticipante->idusuario = $_POST["idusuario"];
$actualizarparticipante->lista_modalidad_categorias = $_POST["lista_modalidad_categorias"];

$result = $actualizarparticipante->actualizarParticipantes(); 

echo $result;
}
?>