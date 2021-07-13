<?php    
	$mySQLHost = "localhost";
    $mySQLUsername = "root";
    $mySQLPassword = "";
    $mySQLDatabase = "sitdbcs";
    $link = mysql_connect($mySQLHost, $mySQLUsername, $mySQLPassword);
    if(!$link){die("Could not connect to database!");}
    $db = mysql_select_db($mySQLDatabase, $link);
    
if(!$db){die("Could not select database!");}else{if($_SESSION["pase"]=="si"){header("Location: ../admin-sitd.php");}else{validar_usuario();}}
function validar_usuario()
{
    $mySQLHost = "localhost";
    $mySQLUsername = "root";
    $mySQLPassword = "";
    $mySQLDatabase = "sitdbcs";
    $link = mysql_connect($mySQLHost, $mySQLUsername, $mySQLPassword);
    if(!$link){die("Could not connect to database!");}
    $db = mysql_select_db("sitdbcs", $link);

	$user = $_POST["username"];
	$pass = $_POST["passwd"];
	
	$query = "SELECT 
	         u.id_usuario as idusuario, 
			 reg_usuario_nomusuario as nomusuario, 
			 reg_usuario_nombre as nombre, 
			 reg_usuario_appaterno as appaterno, 
			 reg_usuario_apmaterno as apmaterno, 
			 reg_usuario_modulos as modulos, 
			 reg_usuario_acciones as acciones,
			 u.id_municipio as idmunicipio,
			 m.cat_municipio_nombre as municipio
			 FROM reg_usuario as u left join cat_municipio as m on u.id_municipio = m.id_municipio 
			 WHERE reg_usuario_nomusuario = \"".$user."\" AND  reg_usuario_pass = \"".$pass."\"";	
	
	$rs = mysql_query($query,$link);	
	if(mysql_affected_rows()>0)
	{		
		require "clases/class.dbsession.php";
		$session = new dbsession();
		$_SESSION["pase"] = "si";
		$row_usuario = mysql_fetch_assoc($rs);
		$_SESSION["id"] = $row_usuario['idusuario'];
		$_SESSION["nombre"] = $row_usuario['nombre'].' '.$row_usuario['appaterno'].' '.$row_usuario['apmaterno'];
		$_SESSION["acciones"] = $row_usuario['acciones'];	
		$_SESSION["modulos"] = $row_usuario['modulos'];						
		$_SESSION["idmunicipio"] = $row_usuario['idmunicipio'];						
		$_SESSION["municipio"] = $row_usuario['municipio'];						
		header("Location: ../modulos/admin-sitd.php");
		exit;
	}
	else
	{	
		header("Location: ../index.php?action=error");
	}
}
?>
