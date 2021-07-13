<?php
set_time_limit(0);	
include("include/dbcon.php");
require "clases/class.dbsession.php";
$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{  	 	
	$responce->records = -1;	 	
	$jsonData = json_encode($responce);
	echo $jsonData;
}else{
	include("clases/class.mysql.php");
	include("clases/class.jsonsubgridreporte.php");
	$jsonsubgrid = new jsonsubgridreporte();		
	$jsonsubgrid->id = $_POST['id'];
	$jsonsubgrid->evento = $_GET['evento'];
	$jsonsubgrid->validado = $_GET['validado'];
	$jsonData = json_encode($jsonsubgrid->GenerarJsonSubgridReporte());
	echo $jsonData;	
} 
?>