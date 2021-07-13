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
	include("clases/class.sitd_cat_evenac.php");	
	$catevenac = new catevenac();	 	
	$catevenac->nombreevenac = $_POST['nombreevenac'];
	$catevenac->fechainicio = $_POST['fechainicio'];	
	$catevenac->fechatermina = $_POST['fechatermina'];	
	$catevenac->idusuario = $_POST['idusuario'];
	$catevenac->id = $_POST['id'];
	$catevenacData = $catevenac->aplicarEveNac();
	echo $catevenacData;
}
?>