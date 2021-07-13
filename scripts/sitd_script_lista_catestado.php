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
	include("clases/class.sitd_cat_estado.php");	
	$catestado = new catestado();	 	
	$catestado->pagina = $_POST['pagina'];
	$catestado->paginado = $_POST['paginado'];
	$catestado->limite = $_POST['limite'];
	$catestado->filtro = $_POST['filtro'];
	$catestado->campo = $_POST['campo'];
	$catestado->orden = $_POST['orden'];	
	$catestado->idusuario = $_POST['idusuario'];
	$catestadoData = $catestado->mostrarCatEstado();
	echo $catestadoData;
}
?>