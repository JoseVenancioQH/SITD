<?php
include("include/dbcon.php");
require "clases/class.dbsession.php";
$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{    
	echo "({'cancelado':'cancelado'})";	
}else{

include("clases/class.mysql.php");
include("clases/class.generacategoria.php");
$generacategoria = new generacategoria();
$generacategoria->iddeporte = $_POST["deporte"];
$generacategoria->evento = $_POST["evento"];

echo $generacategoria->GeneraCategorias();
}
?>