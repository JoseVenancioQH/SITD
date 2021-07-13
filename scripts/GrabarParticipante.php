<?php
include("include/dbcon.php");
require "clases/class.dbsession.php";

$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{    
	echo "({'cancelado':'cancelado'})";	
}else{

include("clases/class.mysql.php");
include("clases/class.grabarparticipante.php");
$grabarparticipante = new grabarparticipante();

$grabarparticipante->participante_sel = $_POST["participante_sel"];
$grabarparticipante->evento = $_POST["evento"];
$grabarparticipante->municipio = $_POST["municipio"];
$grabarparticipante->modalidad = $_POST["modalidad"];
$grabarparticipante->entidad = $_POST["entidad"];
$grabarparticipante->nombres = $_POST["nombres"];
$grabarparticipante->appaterno = $_POST["appaterno"];
$grabarparticipante->apmaterno = $_POST["apmaterno"];
$grabarparticipante->fechanacimiento = $_POST["fechanacimiento"];
$grabarparticipante->sexo = $_POST["sexo"];
$grabarparticipante->curp = $_POST["curp"];
$grabarparticipante->direccion = $_POST["direccion"];
$grabarparticipante->colonia = $_POST["colonia"];
$grabarparticipante->localidad = $_POST["localidad"];
$grabarparticipante->codigopostal = $_POST["codigopostal"];
$grabarparticipante->correo = $_POST["correo"];
$grabarparticipante->peso = $_POST["peso"];
$grabarparticipante->talla = $_POST["talla"];
$grabarparticipante->rfc = $_POST["rfc"];
$grabarparticipante->telefonos = $_POST["telefonos"];
$grabarparticipante->tiposanguineo = $_POST["tiposanguineo"];
$grabarparticipante->idusuario = $_POST["idusuario"];
$grabarparticipante->lista_modalidad_categorias = $_POST["lista_modalidad_categorias"];

//echo $grabarparticipante->grabarparticipante();

$result = $grabarparticipante->grabarParticipantes(); 

echo $result;
}
?>