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
	include("clases/class.sitd_cat_rama.php");	
	$catrama = new catrama();	 	
	$catrama->nombrerama = $_POST['nombrerama'];
	$catrama->eventonacional = $_POST['eventonacional'];	
	$catrama->idusuario = $_POST['idusuario'];	
	$catramaData = $catrama->grabartodoCatRama();
	echo $catramaData;
}
?>