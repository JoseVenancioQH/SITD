<?php
	include("scripts/include/dbcon.php");
    require "scripts/clases/class.dbsession.php";
    $session = new dbsession();
	if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
	{
		if(isset($_SESSION["idusuario"])){
		    $consulta = "
	            UPDATE reg_usuario SET 
	        	reg_usuario_conectados = reg_usuario_conectados - 1   
	        	WHERE id_usuario = ".$_SESSION["idusuario"];	        	
            $rs = mysql_query($consulta);
        }
		include("login.php");
	}
	else	
	{ 
		header("Location: modulos/admin-sitd.php");		
		exit;
	}
?>