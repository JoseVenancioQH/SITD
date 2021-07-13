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
	include("clases/class.caut_invauto.php");	
	$invauto = new invauto();	 	
	$invauto->id = $_POST['id'];	
	$jsonData = json_encode($invauto->cargareditarInvAuto());
	echo $jsonData;
}
?>