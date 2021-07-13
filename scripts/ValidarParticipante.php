<?php
include("include/dbcon.php");
require "clases/class.dbsession.php";

$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{    
	echo "({'cancelado':'cancelado'})";	
}else{

include("clases/class.mysql.php");
include("clases/class.validarparticipantes.php");
$validarparticipante = new validarparticipantes();

$validarparticipante->participante_sel = $_POST["participante_sel"];
$validarparticipante->tipo_validar = $_POST["tipo_validar"];
$result = $validarparticipante->validarParticipante(); 

echo $result;
}
?>