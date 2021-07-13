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
	include("clases/class.caut_clientesaval.php");	
	$clientesaval = new clientesaval();	 	
	$clientesaval->pagina = $_POST['pagina'];
	$clientesaval->paginado = $_POST['paginado'];
	$clientesaval->limite = $_POST['limite'];
	$clientesaval->filtro = $_POST['filtro'];
	$clientesaval->campo = $_POST['campo'];
	$clientesaval->orden = $_POST['orden'];
	$clientesavalData = $clientesaval->mostrarClientesAval();
	echo $clientesavalData;
}
?>