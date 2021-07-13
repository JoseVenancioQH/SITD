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
	include("clases/class.sitd_cat_cat.php");	
	$catcat = new catcat();	 	
	$catcat->pagina = $_POST['pagina'];
	$catcat->paginado = $_POST['paginado'];
	$catcat->limite = $_POST['limite'];
	$catcat->filtro = $_POST['filtro'];
	$catcat->campo = $_POST['campo'];
	$catcat->orden = $_POST['orden'];
	$catcat->eventonacional = $_POST['eventonacional'];	
	$catcat->filter_deportes = $_POST['deportes'];	
	$catcat->filter_rama = $_POST['rama'];	
	$catcat->filter_moddep = $_POST['moddep'];	
	$catcat->catanoinicio = $_POST['anoinicio'];	
	$catcat->catanofin = $_POST['anofin'];	
	$catcat->idusuario = $_POST['idusuario'];
	$catcatData = $catcat->mostrarCatCat();
	echo $catcatData;
}
?>