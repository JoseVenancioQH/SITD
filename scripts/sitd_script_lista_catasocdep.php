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
	include("clases/class.sitd_cat_asocdep.php");	
	$catasocdep = new catasocdep();	 	
	$catasocdep->pagina = $_POST['pagina'];
	$catasocdep->paginado = $_POST['paginado'];
	$catasocdep->limite = $_POST['limite'];
	$catasocdep->filtro = $_POST['filtro'];
	$catasocdep->campo = $_POST['campo'];
	$catasocdep->orden = $_POST['orden'];
	$catasocdep->municipio = $_POST['municipio'];	
	$catasocdep->deportes = $_POST['deportes'];	
	$catasocdep->idusuario = $_POST['idusuario'];
	$catasocdepData = $catasocdep->mostrarCatAsocDep();
	echo $catasocdepData;
}
?>