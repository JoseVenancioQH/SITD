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
	include("clases/class.caut_invcosto.php");	
	$invcosto = new invcosto();	 	
	$invcosto->pagina = $_POST['pagina'];
	$invcosto->paginado = $_POST['paginado'];
	$invcosto->limite = $_POST['limite'];
	$invcosto->filtro = $_POST['filtro'];
	$invcosto->campo = $_POST['campo'];
	$invcosto->orden = $_POST['orden'];
	$invcosto->modelo = $_POST['modelo'];
	$invcosto->marca = $_POST['marca'];
	$invcosto->tipo = $_POST['tipo'];
	$invcosto->linea = $_POST['linea'];
	$invcosto->color = $_POST['color'];
	$invcosto->idempresa = $_POST['idempresa'];
	$invcostoData = $invcosto->mostrarInvAutoCosto();
	echo $invcostoData;
}
?>