<?php
include("clases/class.mysql.php");
include("clases/class.generacategoria_reportes.php");
$generacategoria = new generacategoria();
$generacategoria->iddeporte = $_POST["deporte"];

echo $generacategoria->GeneraCategorias();
?>