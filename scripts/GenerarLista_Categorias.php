<?php
include("include/dbcon.php");
require "clases/class.dbsession.php";
$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{    
	echo "({'cancelado':'cancelado'})";	
}else{
include("clases/class.mysql.php");
include("clases/class.categoria.php");
$categoria = new categoria();
$categoria->deportes_lista = $_POST["deportes_lista"];
$categoria->evento_lista = $_POST["evento_lista"];
$categoria->statususuario = $_POST["statususuario"];
$categoria->idusuario = $_POST["idusuario"];

echo $categoria->GenerarLista_Categorias();
}
?>