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
	include("clases/class.sitd_cat_deportes.php");	
	$catdeportes = new catdeportes();	 	
	$catdeportes->pagina = $_POST['pagina'];
	$catdeportes->paginado = $_POST['paginado'];
	$catdeportes->limite = $_POST['limite'];
	$catdeportes->filtro = $_POST['filtro'];
	$catdeportes->campo = $_POST['campo'];
	$catdeportes->orden = $_POST['orden'];
	$catdeportes->eventonacional = $_POST['eventonacional'];	
	$catdeportes->idusuario = $_POST['idusuario'];
	$catdeportesData = $catdeportes->mostrarCatDeportes();
	echo $catdeportesData;
}
?>