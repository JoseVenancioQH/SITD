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
	include("clases/class.sitd_cat_evenac.php");	
	$catevenac = new catevenac();	 	
	$catevenac->pagina = $_POST['pagina'];
	$catevenac->paginado = $_POST['paginado'];
	$catevenac->limite = $_POST['limite'];
	$catevenac->filtro = $_POST['filtro'];
	$catevenac->campo = $_POST['campo'];
	$catevenac->orden = $_POST['orden'];
	/*$catevenac->eventonacional = $_POST['eventonacional'];*/	
	$catevenac->idusuario = $_POST['idusuario'];
	$catevenacData = $catevenac->mostrarCatEveNac();
	echo $catevenacData;
}
?>