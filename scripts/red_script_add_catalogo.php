<?php
set_time_limit(0);	
include("include/dbcon.php");
require "clases/class.dbsession.php";
$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{    
	 echo "cancel";
}else{
	include("clases/class.mysql.php");
	include("clases/class.caut_catalogo.php");	
	$catalogo = new catalogo();	 	
	$catalogo->nombre = $_POST['nombre'];
	$catalogo->catalogo = $_POST['catalogo'];
	$catalogo->idempresa = $_POST['idempresa'];	
	echo $catalogo->addCatalogo();
}
?>