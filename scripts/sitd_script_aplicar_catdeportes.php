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
	include("clases/class.sitd_cat_deportes.php");	
	$catdeportes = new catdeportes();	 	
	$catdeportes->nombredeportes = $_POST['nombredeportes'];
	$catdeportes->eventonacional = $_POST['eventonacional'];	
	$catdeportes->idusuario = $_POST['idusuario'];
	$catdeportes->id = $_POST['id'];
	$catdeportesData = $catdeportes->aplicarCatDeportes();
	echo $catdeportesData;
}
?>