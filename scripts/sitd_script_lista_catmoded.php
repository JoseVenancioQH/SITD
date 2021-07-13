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
	include("clases/class.sitd_cat_moded.php");		
	$catmoded = new catmoded();	 	
	$catmoded->pagina = $_POST['pagina'];
	$catmoded->paginado = $_POST['paginado'];
	$catmoded->limite = $_POST['limite'];
	$catmoded->filtro = $_POST['filtro'];
	$catmoded->campo = $_POST['campo'];
	$catmoded->orden = $_POST['orden'];
	$catmoded->eventonacional = $_POST['eventonacional'];	
	$catmoded->idusuario = $_POST['idusuario'];
	$catmodedData = $catmoded->mostrarCatModed();
	echo $catmodedData;
}
?>