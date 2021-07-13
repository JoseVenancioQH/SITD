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
	if($_GET['tipo_consulta'] != 0){
	 $json->deporte = $_GET['deporte'];
	 $json->categoria = $_GET['categoria'];
	 $json->municipio = $_GET['municipio'];
	  $json->modalidad = $_GET['modalidad'];
	 $json->nombres = $_GET['nombres'];
	 $json->appaterno = $_GET['appaterno'];
	 $json->apamaterno = $_GET['apmaterno'];
	 $json->rama = $_GET['rama'];
	 $json->ano = $_GET['ano'];
	 $json->evento = $_GET['evento'];
	 $jsonData = json_encode($json->GenerarJson());
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