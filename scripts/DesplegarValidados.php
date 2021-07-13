<?php
include("include/dbcon.php");
require "clases/class.dbsession.php";
$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{    
	echo "({'cancelado':'cancelado'})";	
}else{

include("clases/class.mysql.php");
include("clases/class.desplegarvalidados.php");

$desplegarvalidados = new desplegarvalidados();
$desplegarvalidados->municipio = $_POST['municipio_global'];
$desplegarvalidados->evento = $_POST['evento_global'];
$desplegarvalidados->orden = $_POST['lista_orden'];
$desplegarvalidados->pruebas = $_POST['lista_prueba'];
$desplegarvalidados->modalidad = $_POST['modalidad_global'];
$desplegarvalidados->rama = $_POST['rama_global'];
$desplegarvalidados->deporte = $_POST['deporte_global'];
$desplegarvalidados->categoria = $_POST['categoria_global'];
$desplegarvalidados->anoinicio = $_POST['anoinicio_global'];
$desplegarvalidados->anofin = $_POST['anofin_global'];
$desplegarvalidados->convivencia = $_POST['convivencia_global'];
$desplegarvalidados->nombres = $_POST['nombres_global'];
$desplegarvalidados->appaterno = $_POST['appaterno_global'];
$desplegarvalidados->apmaterno = $_POST['apmaterno_global'];
$desplegarvalidados->curp = $_POST['curp_global'];

$jsonData = json_encode($desplegarvalidados->GeneraValidados());

echo "({'items':".$jsonData."})";
}
?>