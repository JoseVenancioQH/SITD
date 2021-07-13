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
$categoria->evento = $_POST["evento"];
$categoria->iddeporte = $_POST["iddeporte"];
$categoria->nombrecat = $_POST["nombrecat"];
$categoria->anoinicio = $_POST["anoinicio"];
$categoria->anofin = $_POST["anofin"];
$categoria->listapruebas = $_POST["listapruebas"];
$categoria->rama = $_POST["rama"];
$categoria->evento_text = $_POST["evento_text"];
$categoria->deporte_text = $_POST["deporte_text"];
$categoria->idusuario = $_POST["idusuario"];
$categoria->id = $_POST["id"];

echo $categoria->editarCategoria(); 
}
?>