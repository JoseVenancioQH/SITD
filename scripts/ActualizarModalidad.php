<?php
include("include/dbcon.php");
require "clases/class.dbsession.php";
$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{    
	echo "({'cancelado':'cancelado'})";	
}else{
include("clases/class.mysql.php");
include("clases/class.actualizarmodalidad.php");

$actualizarmodalidad = new actualizarmodalidad();
$actualizarmodalidad->idmodalidad = $_POST["idmodalidad"];
$actualizarmodalidad->evento = $_SESSION["evento"];
$actualizarmodalidad->idregmodalidad = $_POST["idregmodalidad"];

$result = $actualizarmodalidad->actualizaModalidad(); 

echo $result;
}
?>