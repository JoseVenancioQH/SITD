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
	include("clases/class.sitd_cat_club.php");	
	$catclub = new catclub();	 	
	$catclub->pagina = $_POST['pagina'];
	$catclub->paginado = $_POST['paginado'];
	$catclub->limite = $_POST['limite'];
	$catclub->filtro = $_POST['filtro'];
	$catclub->campo = $_POST['campo'];
	$catclub->orden = $_POST['orden'];
	$catclub->asocdep = $_POST['asocdep'];	
	$catclub->idusuario = $_POST['idusuario'];
	$catclubData = $catclub->mostrarCatClub();
	echo $catclubData;
}
?>