<?php
include("include/dbcon.php");
require "clases/class.dbsession.php";
$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{    
	echo "({'cancelado':'cancelado'})";	
}else{

include("clases/class.mysql.php");
include("clases/class.desplegarreportesvarios.php");

$desplegarreportesvarios = new desplegarreportesvarios();
$desplegarreportesvarios->municipio = $_POST['municipio_global'];
$desplegarreportesvarios->evento = $_POST['evento_global'];
$desplegarreportesvarios->orden = $_POST['lista_orden'];
$desplegarreportesvarios->pruebas = $_POST['lista_prueba'];
$desplegarreportesvarios->modalidad = $_POST['modalidad_global'];
$desplegarreportesvarios->rama = $_POST['rama_global'];
$desplegarreportesvarios->deporte = $_POST['deporte_global'];
$desplegarreportesvarios->categoria = $_POST['categoria_global'];
$desplegarreportesvarios->anoinicio = $_POST['anoinicio_global'];
$desplegarreportesvarios->anofin = $_POST['anofin_global'];
$desplegarreportesvarios->convivencia = $_POST['convivencia_global'];
$desplegarreportesvarios->nombres = $_POST['nombres_global'];
$desplegarreportesvarios->appaterno = $_POST['appaterno_global'];
$desplegarreportesvarios->apmaterno = $_POST['apmaterno_global'];
$desplegarreportesvarios->curp = $_POST['curp_global'];



$jsonData = json_encode($desplegarreportesvarios->GeneraReportesVarios());

echo "({'items':".$jsonData."})";
}
?>