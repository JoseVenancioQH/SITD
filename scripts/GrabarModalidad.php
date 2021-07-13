
<?php
include("include/dbcon.php");
require "clases/class.dbsession.php";
$session = new dbsession();
if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
{    
	echo "({'cancelado':'cancelado'})";	
}else{

include("clases/class.mysql.php");
include("clases/class.modalidad.php");
$modalidad = new modalidad();
$modalidad->nombre = $_POST["nombre-text"];


$result = $modalidad->grabarModalidad(); 

echo $result;
}
?>