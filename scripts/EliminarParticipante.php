<?php
include("include/dbcon.php");
require "clases/class.dbsession.php";
$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{    
	echo "({'cancelado':'cancelado'})";	
}else{

include("clases/class.mysql.php");
include("clases/class.eliminarparticipante.php");

$eliminarparticipante = new eliminarparticipante();
$eliminarparticipante->evento = $_POST["evento"];
$eliminarparticipante->idregistro = $_POST["idregistro"];

$result = $eliminarparticipante->eliminaParticipante(); 

echo $result;
}
?>