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
	include("clases/class.jsonregistro.php");
	$json = new jsonregistro();		
	$json->evento = $_GET['evento'];
	$json->municipio = $_GET['municipio'];
	$jsonData = json_encode($json->GenerarJsonUltimosRegistrados());
	echo $jsonData;
	/*}else{
	 $responce->page = 0;
	 $responce->total = 0; 
	 $responce->records = 0;	
	 $jsonData = json_encode($responce);	
	 echo $jsonData;	 
	}*/
}
?>