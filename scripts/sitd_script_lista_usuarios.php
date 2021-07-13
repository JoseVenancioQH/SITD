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
	include("clases/class.sitd_usuarios.php");	
	$usuarios = new usuarios();	 	
	$usuarios->pagina = $_POST['pagina'];
	$usuarios->paginado = $_POST['paginado'];
	$usuarios->limite = $_POST['limite'];
	$usuarios->filtro = $_POST['filtro'];
	$usuarios->campo = $_POST['campo'];
	$usuarios->orden = $_POST['orden'];
	$usuariosData = $usuarios->mostrarUsuarios();
	echo $usuariosData;
}
?>