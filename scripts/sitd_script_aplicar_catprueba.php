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
	include("clases/class.sitd_cat_prueba.php");	
	$catprueba = new catprueba();	 	
	$catprueba->prueba = $_POST['prueba'];
	$catprueba->idcategoria = $_POST['idcategoria'];	
	$catprueba->idusuario = $_POST['idusuario'];	
	$catprueba->id = $_POST['id'];
	$catpruebaData = $catprueba->aplicarCatPrueba();
	echo $catpruebaData;
}
?>