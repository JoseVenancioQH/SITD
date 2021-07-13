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
	include("clases/class.sitd_cat_liga.php");	
	$catliga = new catliga();	 	
	$catliga->id = $_POST['id'];	
	$jsonData = json_encode($catliga->cargareditarCatLiga());
	echo $jsonData;
}
?>