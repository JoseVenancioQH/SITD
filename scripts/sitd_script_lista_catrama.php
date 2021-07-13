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
	include("clases/class.sitd_cat_rama.php");	
	$catrama = new catrama();	 	
	$catrama->pagina = $_POST['pagina'];
	$catrama->paginado = $_POST['paginado'];
	$catrama->limite = $_POST['limite'];
	$catrama->filtro = $_POST['filtro'];
	$catrama->campo = $_POST['campo'];
	$catrama->orden = $_POST['orden'];
	$catrama->eventonacional = $_POST['eventonacional'];	
	$catrama->idusuario = $_POST['idusuario'];
	$catramaData = $catrama->mostrarCatRama();
	echo $catramaData;
}
?>