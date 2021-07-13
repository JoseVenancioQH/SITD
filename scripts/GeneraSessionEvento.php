<?php	
include("include/dbcon.php");
require "clases/class.dbsession.php";
$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{    
	echo "({'cancelado':'cancelado'})";	
}else{	
$_SESSION["evento"] = $_POST["evento"];
$_SESSION["nombreevento"] = $_POST["nombreevento"];	
exit;
}
?>