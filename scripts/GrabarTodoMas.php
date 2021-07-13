<?php
include("include/dbcon.php");
require "clases/class.dbsession.php";
$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{    
	echo "({'cancelado':'cancelado'})";	
}else{

include("clases/class.mysql.php");
include("clases/class.grabartodomas.php");
$grabartodomas = new grabartodomas();
$grabartodomas->evento = $_POST["evento"];
$grabartodomas->municipio = $_POST["municipio"];
$grabartodomas->modalidad = $_POST["modalidad"];
$grabartodomas->entidad = $_POST["entidad"];
$grabartodomas->nomevento = $_POST["nomevento"];
$grabartodomas->nommunicipio = $_POST["nommunicipio"];
$grabartodomas->nommodalidad = $_POST["nommodalidad"];
$grabartodomas->nombres = $_POST["nombres"];
$grabartodomas->appaterno = $_POST["appaterno"];
$grabartodomas->apmaterno = $_POST["apmaterno"];
$grabartodomas->fechanacimiento = $_POST["fechanacimiento"];
$grabartodomas->sexo = $_POST["sexo"];
$grabartodomas->curp = $_POST["curp"];
$grabartodomas->direccion = $_POST["direccion"];
$grabartodomas->colonia = $_POST["colonia"];
$grabartodomas->localidad = $_POST["localidad"];
$grabartodomas->codigopostal = $_POST["codigopostal"];
$grabartodomas->correo = $_POST["correo"];
$grabartodomas->peso = $_POST["peso"];
$grabartodomas->talla = $_POST["talla"];
$grabartodomas->rfc = $_POST["rfc"];
$grabartodomas->telefonos = $_POST["telefonos"];
$grabartodomas->tiposanguineo = $_POST["tiposanguineo"];
$grabartodomas->idusuario = $_POST["idusuario"];
$grabartodomas->lista_categoria = $_POST["lista_categoria"];
$grabartodomas->lista_pruebas = $_POST["lista_pruebas"];
$grabartodomas->lista_nom_categoria = $_POST["lista_nom_categoria"];
$grabartodomas->deporteextra = $_POST["deporteextra"];
$grabartodomas->cargo = $_POST["cargo"];


//echo $grabartodomas->grabarDeportista();

$result = $grabartodomas->grabarParticipanteTodoMas(); 

echo $result;
}
?>