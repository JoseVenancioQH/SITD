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
	include("clases/class.sitd_cat_asocdepmd.php");	
	$catasocdepmd = new catasocdepmd();	 			
	$catasocdepmd->asocdep = $_POST['asocdep'];	
	$catasocdepmd->nombre = $_POST['nombre'];	
	$catasocdepmd->app = $_POST['app'];	
	$catasocdepmd->apm = $_POST['apm'];	
	$catasocdepmd->cargo = $_POST['cargo'];	
	$catasocdepmd->telefono = $_POST['telefono'];	
	$catasocdepmd->dom = $_POST['dom'];	
	$catasocdepmd->rfc = $_POST['rfc'];		
	$catasocdepmd->idusuario = $_POST['idusuario'];
	$catasocdepmd->id = $_POST['id'];	
	$catasocdepmdData = $catasocdepmd->aplicarCatAsocDepMD();	
	echo $catasocdepmdData;
}
?>