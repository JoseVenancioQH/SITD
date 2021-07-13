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
	include("clases/class.sitd_cat_municipio.php");	
	$catmunicipio = new catmunicipio();	 	
	$catmunicipio->pagina = $_POST['pagina'];
	$catmunicipio->paginado = $_POST['paginado'];
	$catmunicipio->limite = $_POST['limite'];
	$catmunicipio->filtro = $_POST['filtro'];
	$catmunicipio->campo = $_POST['campo'];
	$catmunicipio->orden = $_POST['orden'];
	$catmunicipio->estado = $_POST['estado'];	
	$catmunicipio->idusuario = $_POST['idusuario'];
	$catmunicipioData = $catmunicipio->mostrarCatMunicipio();
	echo $catmunicipioData;
}
?>