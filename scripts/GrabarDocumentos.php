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
$grabardocumentos = new validarparticipantes();

$grabardocumentos->idregcat = $_POST["idregcat"];
$grabardocumentos->documentos = $_POST["documentos"];
$grabardocumentos->evento = $_POST["evento"];
$result = $grabardocumentos->grabarDocumentos(); 

echo $result;
}
?>