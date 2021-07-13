<?php
include("include/dbcon.php");
require "clases/class.dbsession.php";
$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{    
	echo "({'cancelado':'cancelado'})";	
}else{

include("clases/class.mysql.php");
include("clases/class.grabarcomiteorganizador.php");
$grabarcomiteorganizador = new grabarcomiteorganizador();
$grabarcomiteorganizador->evento = $_POST["evento"];
$grabarcomiteorganizador->municipio = $_POST["municipio"];
$grabarcomiteorganizador->modalidad = $_POST["modalidad"];
$grabarcomiteorganizador->entidad = $_POST["entidad"];
$grabarcomiteorganizador->nomevento = $_POST["nomevento"];
$grabarcomiteorganizador->nommunicipio = $_POST["nommunicipio"];
$grabarcomiteorganizador->nommodalidad = $_POST["nommodalidad"];
$grabarcomiteorganizador->nombres = $_POST["nombres"];
$grabarcomiteorganizador->appaterno = $_POST["appaterno"];
$grabarcomiteorganizador->apmaterno = $_POST["apmaterno"];
$grabarcomiteorganizador->fechanacimiento = $_POST["fechanacimiento"];
$grabarcomiteorganizador->sexo = $_POST["sexo"];
$grabarcomiteorganizador->curp = $_POST["curp"];
$grabarcomiteorganizador->direccion = $_POST["direccion"];
$grabarcomiteorganizador->colonia = $_POST["colonia"];
$grabarcomiteorganizador->localidad = $_POST["localidad"];
$grabarcomiteorganizador->codigopostal = $_POST["codigopostal"];
$grabarcomiteorganizador->correo = $_POST["correo"];
$grabarcomiteorganizador->peso = $_POST["peso"];
$grabarcomiteorganizador->talla = $_POST["talla"];
$grabarcomiteorganizador->rfc = $_POST["rfc"];
$grabarcomiteorganizador->telefonos = $_POST["telefonos"];
$grabarcomiteorganizador->tiposanguineo = $_POST["tiposanguineo"];
$grabarcomiteorganizador->idusuario = $_POST["idusuario"];
$grabarcomiteorganizador->lista_categoria = $_POST["lista_categoria"];
$grabarcomiteorganizador->lista_pruebas = $_POST["lista_pruebas"];
$grabarcomiteorganizador->lista_nom_categoria = $_POST["lista_nom_categoria"];
$grabarcomiteorganizador->deporteextra = $_POST["deporteextra"];
$grabarcomiteorganizador->cargo = $_POST["cargo"];
$grabarcomiteorganizador->prensa = $_POST["prensa"];

//echo $grabardeportista->grabarDeportista();

$result = $grabarcomiteorganizador->grabarParticipanteComiteOrganizador(); 

echo $result;
}
?>