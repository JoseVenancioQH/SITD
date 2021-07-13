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
	include("clases/class.caut_invauto.php");	
	$invauto = new invauto();	 	
	$invauto->pagina = $_POST['pagina'];
	$invauto->paginado = $_POST['paginado'];
	$invauto->limite = $_POST['limite'];
	$invauto->filtro = $_POST['filtro'];
	$invauto->campo = $_POST['campo'];
	$invauto->orden = $_POST['orden'];
	$invauto->modelo = $_POST['modelo'];
	$invauto->marca = $_POST['marca'];
	$invauto->tipo = $_POST['tipo'];
	$invauto->linea = $_POST['linea'];
	$invauto->color = $_POST['color'];
	$invauto->idempresa = $_POST['idempresa'];
	$invautoData = $invauto->mostrarInvAuto();
	echo $invautoData;
}
?>