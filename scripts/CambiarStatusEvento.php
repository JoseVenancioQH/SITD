<?php
include("include/dbcon.php");
require "clases/class.dbsession.php";
$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{    
	echo "({'cancelado':'cancelado'})";	
}else{
include("clases/class.mysql.php");
include("clases/class.eventos.php");
$eventos = new eventos();
$eventos->idevento = $_POST["idevento"];
$eventos->status = $_POST["status"];
echo $eventos->cambiarStatusEvento();
}
?>