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
	include("clases/class.caut_clientes.php");	
	$clientes = new clientes();	 	
	$clientes->idempresa = $_POST['idempresa'];
	$clientes->nomcliente = $_POST['nomcliente'];
	$clientes->appaternocliente = $_POST['appaternocliente'];
	$clientes->apmaternocliente = $_POST['apmaternocliente'];
	$clientes->dircliente = $_POST['dircliente'];	
	$clientes->telcasa = $_POST['telcasa'];	
	$clientes->telcel = $_POST['telcel'];	
	$clientes->rfccliente = $_POST['rfccliente'];	
	$clientes->municipio = $_POST['municipio'];	
	$clientes->id = $_POST['id'];	
	$clientesData = $clientes->aplicarCliente();
	echo $clientesData;
}
?>