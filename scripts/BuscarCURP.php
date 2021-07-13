<?php
include("include/dbcon.php");
require "clases/class.dbsession.php";
$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{    
	echo "({'cancelado':'cancelado'})";	
}else{
include("clases/class.mysql.php");
include("clases/class.curp.php");
$curp = new curp();
$curp->curp = $_POST["curp"];

echo $curp->GeneraDatos_CURP();
}
?>