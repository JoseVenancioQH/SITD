<?php
include("include/dbcon.php");
require "clases/class.dbsession.php";
$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{    
	echo "({'cancelado':'cancelado'})";	
}else{

include("clases/class.mysql.php");
include("clases/class.caut_usuarios.php");
$usuarios = new usuarios();
$usuarios->id = $_GET["id"];
$usuarios->status = $_GET["status"];
echo ($usuarios->cambiarStatus())?0:1;
}
?>