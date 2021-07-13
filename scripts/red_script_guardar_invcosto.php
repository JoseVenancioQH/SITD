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
	include("clases/class.caut_invcosto.php");	
	$invcosto = new invcosto();	 	
	$invcosto->idempresa = $_POST['idempresa'];
	$invcosto->idauto = $_POST['idauto'];
	$invcosto->id = $_POST['id'];	
	$invcosto->tipocosto = $_POST['tipocosto'];
	$invcosto->psiniva = $_POST['psiniva'];
	$invcosto->anticipo = $_POST['anticipo'];
	$invcosto->pcontado = $_POST['pcontado'];	
	echo $invcosto->grabarInvCosto();	
}
?>