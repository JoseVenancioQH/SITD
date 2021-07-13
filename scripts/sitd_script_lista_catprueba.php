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
	include("clases/class.sitd_cat_prueba.php");	
	$catprueba = new catprueba();	 	
	$catprueba->pagina = $_POST['pagina'];
	$catprueba->paginado = $_POST['paginado'];
	$catprueba->limite = $_POST['limite'];
	$catprueba->filtro = $_POST['filtro'];
	$catprueba->campo = $_POST['campo'];
	$catprueba->orden = $_POST['orden'];
	$catprueba->eventonacional = $_POST['eventonacional'];	
	$catprueba->filter_deportes = $_POST['deportes'];	
	$catprueba->filter_rama = $_POST['rama'];	
	$catprueba->filter_moddep = $_POST['moddep'];	
	$catprueba->catanoinicio = $_POST['anoinicio'];	
	$catprueba->catanofin = $_POST['anofin'];	
	$catprueba->idusuario = $_POST['idusuario'];
	$catpruebaData = $catprueba->mostrarCatPrueba();
	echo $catpruebaData;
}
?>