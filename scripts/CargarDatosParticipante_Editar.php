<?php
include("include/dbcon.php");
require "clases/class.dbsession.php";
$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{    
	echo "({'cancelado':'cancelado'})";	
}else{

include("clases/class.mysql.php");
include("clases/class.cargardatosparticipanteeditar.php");
$cargardatosparticipante = new cargardatosparticipante();
$cargardatosparticipante->idregistro = $_POST["idregistro"];
$cargardatosparticipante->evento = $_POST["evento"];
$jsonData = json_encode($cargardatosparticipante->CargarDatosParticipantes_Editar());

echo "({'items':".$jsonData."})";
}
?>