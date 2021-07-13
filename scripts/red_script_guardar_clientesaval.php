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
	$clientesaval->idempresa = $_POST['idempresa'];
	$clientesaval->nomaval = $_POST['nomaval'];
	$clientesaval->appaternoaval = $_POST['appaternoaval'];
	$clientesaval->apmaternoaval = $_POST['apmaternoaval'];
	$clientesaval->diraval = $_POST['diraval'];	
	$clientesaval->telcasaval = $_POST['telcasaval'];	
	$clientesaval->telcelaval = $_POST['telcelaval'];	
	$clientesaval->municipio = $_POST['municipio'];
	$clientesaval->idcliente = $_POST['cliente'];
	$clientesavalData = $clientesaval->grabarClienteAval();
	echo $clientesavalData;
}
?>