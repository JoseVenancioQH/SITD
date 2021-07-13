<?php
include("include/dbcon.php");
require "clases/class.dbsession.php";
$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{    
	echo "({'cancelado':'cancelado'})";	
}else{

include("clases/class.mysql.php");
include("clases/class.jsonautocomplet.php");
$jsonautocomplet = new jsonautocomplet();

$jsonData = json_encode($jsonautocomplet->GenerarJson());

echo "({'items':".$jsonData."})";
}
?>