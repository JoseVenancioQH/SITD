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
	include("clases/class.sitd_cat_moddep.php");	
	$catmoddep = new catmoddep();	 	
	$catmoddep->pagina = $_POST['pagina'];
	$catmoddep->paginado = $_POST['paginado'];
	$catmoddep->limite = $_POST['limite'];
	$catmoddep->filtro = $_POST['filtro'];
	$catmoddep->campo = $_POST['campo'];
	$catmoddep->orden = $_POST['orden'];
	$catmoddep->eventonacional = $_POST['eventonacional'];	
	$catmoddep->idusuario = $_POST['idusuario'];
	$catmoddepData = $catmoddep->mostrarCatModDep();
	echo $catmoddepData;
}
?>