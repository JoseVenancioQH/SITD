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
	echo json_encode($clientes->mostrarNombresClientes());	
}
?>