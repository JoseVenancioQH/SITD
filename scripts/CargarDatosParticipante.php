<?php
include("include/dbcon.php");
require "clases/class.dbsession.php";
$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{    
	echo "({'cancelado':'cancelado'})";	
}else{

include("clases/class.mysql.php");
include("clases/class.cargardatosparticipantecurp.php");
$cargardatosparticipante = new cargardatosparticipante();
$cargardatosparticipante->curp = $_POST["curp"];
$jsonData = json_encode($cargardatosparticipante->CargarDatosParticipantes());

echo "({'items':".$jsonData."})";
}
?>