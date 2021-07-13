<?php
include("include/dbcon.php");
require "clases/class.dbsession.php";

$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{    
	echo "({'cancelado':'cancelado'})";	
}else{

include("clases/class.mysql.php");
include("clases/class.grabardeportista.php");
$grabardeportista = new grabardeportista();

$grabardeportista->participante_sel = $_POST["participante_sel"];
$grabardeportista->evento = $_POST["evento"];
$grabardeportista->municipio = $_POST["municipio"];
$grabardeportista->modalidad = $_POST["modalidad"];
$grabardeportista->entidad = $_POST["entidad"];
$grabardeportista->nombres = $_POST["nombres"];
$grabardeportista->appaterno = $_POST["appaterno"];
$grabardeportista->apmaterno = $_POST["apmaterno"];
$grabardeportista->fechanacimiento = $_POST["fechanacimiento"];
$grabardeportista->sexo = $_POST["sexo"];
$grabardeportista->curp = $_POST["curp"];
$grabardeportista->direccion = $_POST["direccion"];
$grabardeportista->colonia = $_POST["colonia"];
$grabardeportista->localidad = $_POST["localidad"];
$grabardeportista->codigopostal = $_POST["codigopostal"];
$grabardeportista->correo = $_POST["correo"];
$grabardeportista->peso = $_POST["peso"];
$grabardeportista->talla = $_POST["talla"];
$grabardeportista->rfc = $_POST["rfc"];
$grabardeportista->telefonos = $_POST["telefonos"];
$grabardeportista->tiposanguineo = $_POST["tiposanguineo"];
$grabardeportista->idusuario = $_POST["idusuario"];
$grabardeportista->lista_modalidad_categorias = $_POST["lista_modalidad_categorias"];

//echo $grabardeportista->grabarDeportista();

$result = $grabardeportista->grabarDeportistas(); 

echo $result;
}
?>