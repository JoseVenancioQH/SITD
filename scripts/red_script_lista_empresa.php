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
	include("clases/class.caut_empresa.php");	
	$empresa = new empresa();	 	
	$empresa->pagina = $_POST['pagina'];
	$empresa->paginado = $_POST['paginado'];
	$empresa->limite = $_POST['limite'];
	$empresa->filtro = $_POST['filtro'];
	$empresa->campo = $_POST['campo'];
	$empresa->orden = $_POST['orden'];
	$empresaData = $empresa->mostrarEmpresa();
	echo $empresaData;
}
?>