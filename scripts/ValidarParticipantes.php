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
$validarparticipantes = new validarparticipantes();
$validarparticipantes->lista_validados = $_POST["lista_validados"];
$validarparticipantes->lista_documentos = $_POST["lista_documentos"];

$result = $validarparticipantes->validaParticipantes(); 

echo $result;

}
?>