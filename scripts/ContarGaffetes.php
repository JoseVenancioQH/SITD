<?php
set_time_limit(0);	
include("include/dbcon.php");
require "clases/class.dbsession.php";
$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{   
  echo "({'cancelado':'cancelado'})";	
}else{
  include("clases/class.mysql.php");
  include("clases/class.desplegargaffetes.php");
  $desplegargaffetes = new desplegargaffetes();
  $desplegargaffetes->deporte = $_POST['deporte'];
  $desplegargaffetes->categoria = $_POST['categoria'];
  $desplegargaffetes->municipio = $_POST['municipio'];
  $desplegargaffetes->modalidad = $_POST['modalidad'];
  $desplegargaffetes->nombres = $_POST['nombres'];
  $desplegargaffetes->appaterno = $_POST['appaterno'];
  $desplegargaffetes->apamaterno = $_POST['apmaterno'];
  $desplegargaffetes->rama = $_POST['rama'];	 
  $desplegargaffetes->evento = $_POST['evento'];	 
  $desplegargaffetes->anoinicio = $_POST['anoinicio'];
  $desplegargaffetes->anofin = $_POST['anofin'];
  $desplegargaffetes->convanoinicio = $_POST['convanoinicio'];
  $desplegargaffetes->validado = $_POST['validado'];
  $desplegargaffetes->gaffete_sel = $_POST['gaffete_sel'];  
  
  echo "({'contador':'".$desplegargaffetes->ContarGaffetes()."','cancelado':''})";
}
?>