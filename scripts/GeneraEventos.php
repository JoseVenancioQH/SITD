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
	include("clases/class.jsoneventos.php");
	$json = new jsoneventos();	
	if($_GET['tipo_consulta'] != 0){	 
	 $jsonData = json_encode($json->GenerarEventos());
	 echo $jsonData;
	}else{
	 $responce->page = 0;
	 $responce->total = 0; 
	 $responce->records = 0;	
	 $jsonData = json_encode($responce);	
	 echo $jsonData;	 
	}
}
?>