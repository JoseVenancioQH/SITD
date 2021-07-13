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
	include("clases/class.sitd_cat_club.php");	
	$catclub = new catclub();	 	
	$catclub->nombreclub = $_POST['nombreclub'];
	$catclub->asocdep = $_POST['asocdep'];	
	$catclub->idusuario = $_POST['idusuario'];
	$catclub->id = $_POST['id'];
	$catclubData = $catclub->aplicarCatClub();
	echo $catclubData;
}
?>