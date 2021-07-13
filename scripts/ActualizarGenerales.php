<?php
include("include/dbcon.php");
require "clases/class.dbsession.php";
$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{    
	echo "({'cancelado':'cancelado'})";	
}else{

include("clases/class.mysql.php");
include("clases/class.actualizargenerales.php");
$actualizargenerales = new actualizargenerales();
$actualizargenerales->idregistro = $_POST["idregistro"];
$actualizargenerales->nombres = $_POST["nombres"];
$actualizargenerales->appaterno = $_POST["appaterno"];
$actualizargenerales->apmaterno = $_POST["apmaterno"];
$actualizargenerales->entidad = $_POST["entidad"];
$actualizargenerales->sexo = $_POST["sexo"];
$actualizargenerales->fechanacimiento = $_POST["fechanacimiento"];
$actualizargenerales->curp = $_POST["curp"];

//echo $grabardeportista->grabarDeportista();

$result = $actualizargenerales->actualizaGenerales(); 

echo $result;
}
?>