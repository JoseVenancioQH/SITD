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
	include("clases/class.sitd_cat_estado.php");	
	$catestado = new catestado();	 	
	$catestado->nombreestado = $_POST['nombreestado'];	
	$catestado->idusuario = $_POST['idusuario'];	
	$catestadoData = $catestado->grabarCatEstado();
	echo $catestadoData;
}
?>