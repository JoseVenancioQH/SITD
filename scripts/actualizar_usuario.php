<?php
include("clases/class.mysql.php");
include("clases/class.sitd_usuarios.php");
$usuarios = new usuarios();
$usuarios->privilegios = $_POST["privilegios"];
$usuarios->rolusuario = $_POST["rolusuario"];
$usuarios->nombreusuario = $_POST["nombreusuario"];
$usuarios->nombre = $_POST["nombre"];
$usuarios->pass = $_POST["pass"];
$usuarios->id = $_POST["id"];
$usuarios->municipio = $_POST["municipio"];
echo ($usuarios->actualizarUsuarios());
?>