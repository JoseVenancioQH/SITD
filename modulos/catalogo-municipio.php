<?php 
	include("../scripts/include/dbcon.php");
    require "../scripts/clases/class.dbsession.php";
    $session = new dbsession();
	if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
	{
		header("Location: ../index.php");
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Catalogo Prueba | Registro Estatal de Deporte - QSERVICE - Integrate</title>
<link rel="stylesheet" href="../css/screen.css" type="text/css" media="screen, projection">
<link type="text/css" href="../css/theme/ui.all.css" rel="Stylesheet" />
<link rel="stylesheet" href="../css/validationEngine.jquery.css" type="text/css" media="screen" charset="utf-8" />
<!--[if IE]><link rel="stylesheet" href="../css/ie.css" type="text/css" media="screen, projection"><![endif]-->
<script type="text/javascript" src="../js/jquery-1.3.1.js"></script>
<!--<script type='text/javascript' src='../js/jquery.highlightFade.js'></script>
<script type="text/javascript" src="../js/jquery-ui-personalized-1.6rc6.js"></script>--> 
<script type="text/javascript" src="../js/controller-unBlock.js" ></script>
<script type="text/javascript" src="../js/controller-municipio.js"></script>
<script type="text/javascript" src="../js/jquery.validationEngine.js"></script>
<script type="text/javascript" src="../js/jquery.blockUI.js" ></script>
<script type="text/javascript" src="../js/jquery.maskedinput-1.2.2.js" ></script>

</head>
<body>
<div class="container">		
    
    <div id="header">
   	  <div id="user_id">Bienvenido <?php echo $_SESSION["nombre"]; ?> | <a title="salir del sistema" href="../scripts/close-session.php">Salir</a></div>
	  <h1><img alt="QSERVICE - Integrate" src="../img/logo.png" /> RED - - Empresa Autorizada -</h1>
    </div>
    
    <div id="navegacion"> 
       <ul id="menu">
        <?php
			$seccion = "catalogo";
			include("../scripts/menu.php");
        ?>       
        </ul>             
            <ul id="submenu">
                <?php
			        $seccion = "municipio";
			        include("../scripts/menu-catalogo.php");
                ?>
            </ul>            
    </div>
    
    <div id="form">
             <h2>Agregar Municipio</h2>
			 
			 <form name="grabar-municipio" id="grabar-municipio" method="post" action="">             	
             <fieldset><legend>Datos del Municipio</legend>		 
			
			    <div class="span-7">
				<p>
				<label for="nombre-text">Nombre de la Municipio: </label>
				<input  alt="Nombre del Municipio" class="validate[required,length[0,150]] span-7 text" id="nombre-text" name="nombre-text" type="text"/>				
				</p>
				</div>
									
			 </fieldset>		 
			 <input id = "grabar_municipio_buttom" name = "grabar_municipio_buttom" type="submit" value="Grabar Municipio"/>			 
             </form>			 					   
        </div>
        <fieldset><legend>Lista de Municipios Registradas</legend>		 
		     <table>
             <thead>        	   
               <th>Nombre del Municipio</th>
			   <th>Eliminar</th>
			   <th>Modificar</th>			   
             </thead>			 
             <tbody id = "lista_municipio" class="scroll1"> 	
             </tbody>			 
             </table>	
			    
		</fieldset>	
    <div id="footer">
   		<p>&copy; <?php echo date("Y"); ?> <a title="QSERVICE - Integrate" href="#" target="_blank">QSERVICE - Integrate</a> &reg;  - Todos los Derechos Reservados - Desarrollado por <a title="Reality in a digital world" href="#" target="_blank">- Empresa Autorizada -</a></p>
	</div>        
</div>    
</body>
</html>
