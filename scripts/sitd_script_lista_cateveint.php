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
	include("clases/class.sitd_cat_eveint.php");	
	$cateveint = new cateveint();	 	
	$cateveint->pagina = $_POST['pagina'];
	$cateveint->paginado = $_POST['paginado'];
	$cateveint->limite = $_POST['limite'];
	$cateveint->filtro = $_POST['filtro'];
	$cateveint->campo = $_POST['campo'];
	$cateveint->orden = $_POST['orden'];
	/*$catevenac->eventonacional = $_POST['eventonacional'];*/	
	$cateveint->idusuario = $_POST['idusuario'];
	$cateveintData = $cateveint->mostrarCatEveInt();
	echo $cateveintData;
}
?>