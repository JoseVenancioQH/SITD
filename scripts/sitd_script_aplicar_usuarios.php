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
	$usuarios->accion = $_POST['accion'];
	$usuarios->privilegio = $_POST['privilegio'];	
	$usuarios->nombre = $_POST['nombre'];
	$usuarios->appaterno = $_POST['appaterno'];
	$usuarios->apmaterno = $_POST['apmaterno'];
	$usuarios->nombreusuario = $_POST['nombreusuario'];
	$usuarios->pass = $_POST['pass'];
	$usuarios->municipio = $_POST['municipio'];
	$usuarios->id = $_POST['id'];
	$usuariosData = $usuarios->aplicarUsuarios();
	echo $usuariosData;
}
?>