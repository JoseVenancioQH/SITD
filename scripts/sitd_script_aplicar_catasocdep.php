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
	include("clases/class.sitd_cat_asocdep.php");	
	$catasocdep = new catasocdep();	 		
	$catasocdep->nombreasocdep = $_POST['nombreasocdep'];
	$catasocdep->municipio = $_POST['municipio'];	
	$catasocdep->deportes = $_POST['deportes'];	
	$catasocdep->dircalle = $_POST['dircalle'];	
	$catasocdep->dirnum = $_POST['dirnum'];	
	$catasocdep->dircolonia = $_POST['dircolonia'];	
	$catasocdep->acronimo = $_POST['acronimo'];		
	$catasocdep->telconv = $_POST['telconv'];	
	$catasocdep->telcel = $_POST['telcel'];	
	$catasocdep->dircorreo = $_POST['dircorreo'];			
	$catasocdep->idusuario = $_POST['idusuario'];
	$catasocdep->id = $_POST['id'];
	$catasocdepData = $catasocdep->aplicarCatAsocDep();
	echo $catasocdepData;
}
?>