<?php
include("include/dbcon.php");
require "clases/class.dbsession.php";
$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{    
	echo "({'cancelado':'cancelado'})";	
}else{

include("clases/class.mysql.php");
include("clases/class.eliminarregistro.php");

$eliminarregistro = new eliminarregistro();
$eliminarregistro->idregistrocat = $_POST["idregistrocat"];
$eliminarregistro->evento = $_SESSION["evento"];

$result = $eliminarregistro->eliminaRegistro(); 

echo $result;
}
?>