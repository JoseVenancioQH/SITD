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
	include("clases/class.sitd_cat_moded.php");	
	$catmoded = new catmoded();	 	
	$catmoded->nombrecatmoded = $_POST['nombrecatmoded'];
	$catmoded->eventonacional = $_POST['eventonacional'];	
	$catmoded->idusuario = $_POST['idusuario'];	
	$catmodedData = $catmoded->grabartodoCatModed();
	echo $catmodedData;
}
?>