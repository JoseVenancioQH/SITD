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
	include("clases/class.sitd_cat_cat.php");	
	$catcat = new catcat();	 	
	$catcat->nombrecat = $_POST['nombrecat'];
	$catcat->eventonacional = $_POST['eventonacional'];	
	$catcat->idusuario = $_POST['idusuario'];
	$catcat->catanoinicio = $_POST['catanoinicio'];
	$catcat->catanofin = $_POST['catanofin'];
	$catcat->filter_deportes = $_POST['filter_deportes'];
	$catcat->filter_rama = $_POST['filter_rama'];
	$catcat->filter_moddep = $_POST['filter_moddep'];
	$catcat->pruebas = $_POST['pruebas'];
	$catcat->id = $_POST['id'];
	$catcatData = $catcat->grabarCatCat();
	echo $catcatData;
}
?>