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
	include("clases/class.sitd_cat_eveint.php");	
	$cateveint = new cateveint();	 	
	$cateveint->nombreeveint = $_POST['nombreeveint'];
	$cateveint->fechainicio = $_POST['fechainicio'];	
	$cateveint->fechatermina = $_POST['fechatermina'];
	$cateveint->idusuario = $_POST['idusuario'];
	$cateveintData = $cateveint->grabarEveInt();
	echo $cateveintData;
}
?>