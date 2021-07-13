<?php
include("include/dbcon.php");
require "clases/class.dbsession.php";
$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{    
	echo "({'cancelado':'cancelado'})";	
}else{
include("clases/class.mysql.php");
include("clases/class.actualizarcomiteprensa.php");

$actualizarcomiteprensa = new actualizarcomiteprensa();
$actualizarcomiteprensa->idregmodalidad = $_POST["idregmodalidad"];
$actualizarcomiteprensa->cargo = $_POST["cargo"];
$actualizarcomiteprensa->evento = $_SESSION["evento"];

$result = $actualizarcomiteprensa->actualizaComitePrensa(); 

echo $result;
}
?>