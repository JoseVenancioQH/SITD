<?php
include("include/dbcon.php");
require "clases/class.dbsession.php";
$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{    
	echo "({'cancelado':'cancelado'})";	
}else{

include("clases/class.mysql.php");
include("clases/class.buscarcedulas.php");

$cedulas = new buscarcedulas();
$cedulas->evento = $_POST["evento"];
$cedulas->municipio = $_POST["municipio"];
$cedulas->rama = $_POST["sexo"];
$cedulas->deporte = $_POST["deporte"];
$cedulas->categoria = $_POST["categoria"];

$cedulas->nombres = $_POST["nombres"];
$cedulas->appaterno = $_POST["appaterno"];
$cedulas->apmaterno = $_POST["apmaterno"];
$cedulas->modalidad = $_POST["modalidad"];
$cedulas->ano = $_POST["ano"];


$result = $cedulas->GenerarJson();

$resultmunicipio = $cedulas->SelectMunicipios();

if($result == 'no')
{
 $jsonData = json_encode($result);
 echo "({'result':'no','items':''})";
}
else
{
 $jsonData = json_encode($result);
 $jsonDataMunicipio = json_encode($resultmunicipio);
 echo "({'result':'si','items':".$jsonData.",'municipio':".$jsonDataMunicipio."})";
} 
}
?>