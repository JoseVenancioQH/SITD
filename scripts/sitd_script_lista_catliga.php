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
	include("clases/class.sitd_cat_liga.php");	
	$catliga = new catliga();	 	
	$catliga->pagina = $_POST['pagina'];
	$catliga->paginado = $_POST['paginado'];
	$catliga->limite = $_POST['limite'];
	$catliga->filtro = $_POST['filtro'];
	$catliga->campo = $_POST['campo'];
	$catliga->orden = $_POST['orden'];
	$catliga->club = $_POST['club'];	
	$catliga->idusuario = $_POST['idusuario'];
	$catligaData = $catliga->mostrarCatLiga();
	echo $catligaData;
}
?>