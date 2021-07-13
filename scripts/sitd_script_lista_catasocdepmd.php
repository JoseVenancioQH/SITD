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
	include("clases/class.sitd_cat_asocdepmd.php");	
	$catasocdepmd = new catasocdepmd();	 	
	$catasocdepmd->pagina = $_POST['pagina'];
	$catasocdepmd->paginado = $_POST['paginado'];
	$catasocdepmd->limite = $_POST['limite'];
	$catasocdepmd->filtro = $_POST['filtro'];
	$catasocdepmd->campo = $_POST['campo'];
	$catasocdepmd->orden = $_POST['orden'];
	$catasocdepmd->asocdep = $_POST['asocdep'];	
	$catasocdepmd->idusuario = $_POST['idusuario'];
	$catasocdepmdData = $catasocdepmd->mostrarCatAsocDepMD();
	echo $catasocdepmdData;
}
?>