<?php
include("include/dbcon.php");
require "clases/class.dbsession.php";
$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{    
	echo "({'cancelado':'cancelado'})";	
}else{

include("clases/class.mysql.php");
include("clases/class.deporte_categoria.php");
$deporte_categoria = new deporte_categoria();	  
echo($deporte_categoria->extraerDeportes('deportes_extras'));
}
?>