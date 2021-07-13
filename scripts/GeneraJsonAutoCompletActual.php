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
$jsonautocomplet->municipio = $_SESSION['municipio'];
$jsonautocomplet->evento = $_SESSION['evento'];

$jsonData = json_encode($jsonautocomplet->GenerarJsonActual());

echo "({'items':".$jsonData."})";
}
?>