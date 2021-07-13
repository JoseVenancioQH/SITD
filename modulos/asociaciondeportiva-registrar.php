<?php 
	include("../scripts/include/dbcon.php");
    require "../scripts/clases/class.dbsession.php";
    $session = new dbsession();
	if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
	{
		header("Location: ../index.php");
	}
	
function generadeporte($ano)
{   
  include("PHPClass/const.conn.class.inc");
  $conector = new MySQL();
  $link = $conector->conectar($_s, $_u, $_c, $_b);
  $consulta = "SELECT deporte+0, deporte, count(deporte) FROM categoria$ano group by deporte HAVING Count(deporte) > 1";
  $rs = $conector->consultar($consulta, $link);
  $conector->cerrar($link);
	
	echo "<select name='deportes' id='deportes' class='deporte' onChange='cargaContenido(this.id,0)'>";
	echo "<option value='0' selected>Elige</option><option value='1'>Ninguna</option>";
	while($registro=mysql_fetch_row($rs))
	{
		echo "<option value='".$registro[0]."'>".$registro[1]."</option>";
	}
	echo "</select><span id=\"error_deporte\"><img alt=\"Precaucion\" src=\"Imagenes/precaucion.gif\"/></span>";	
}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registrar Eventos | Registro Estatal de Deporte - QSERVICE - Integrate</title>
<link rel="stylesheet" href="../css/screen.css" type="text/css" media="screen, projection">
<link type="text/css" href="../css/theme/ui.all.css" rel="Stylesheet" />
<link rel="stylesheet" href="../css/datepicker.css" type="text/css" />
<link rel="stylesheet" href="../css/jquery.jgrowl.css" type="text/css" />
<link rel="stylesheet" href="../css/validationEngine.jquery.css" type="text/css" media="screen" charset="utf-8" />
<!--[if IE]><link rel="stylesheet" href="../css/ie.css" type="text/css" media="screen, projection"><![endif]-->



<script type="text/javascript" src="../js/jquery-1.3.1.js"></script>
<script type="text/javascript" src="../js/datepicker.js"></script>
<script type="text/javascript" src="../js/controller-eventos.js"></script>
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
			$seccion = "eventos";
			include("../scripts/menu.php");
        ?>       
        </ul>             
            <ul id="submenu">
                <?php
			        $seccion = "registrar";
			        include("../scripts/menu-eventos.php");
                ?>
            </ul>            
    </div>
    
    <div id="form">
             <h2>Agregar Asociaci&oacute;n Deportivaa</h2>
			 
			 <form name="grabar-asocdep" id="grabar-asocdep" method="post" action="">             	
             <fieldset><legend>Datos Generales</legend>		 
			
			 
			    <div class="span-7">
				<p>
				<label for="nombre-text">Nombre: </label>
				<input  alt="Nombre Asociaci&oacute;n Deportiva" class="validate[required,custom[onlyLetter]] span-7 text" id="nombre-text" name="nombre-text" type="text"/>				
				</p>
				</div>
				
				<div class="span-7">
				<p>
				<label for="coordina-text">Direcci&oacute;n: </label>
				<input alt="Coordinador del Evento" class="validate[required,custom[onlyLetter]] span-7 text" id="coordina-text" name="coordina-text" type="text"/>				
				</p>
				</div>
				
				<div class="span-7">
				<p>
				<label for="telefono-text">Telefono: </label>
				<input alt="Telefono" class="validate[required,custom[onlyLetter],length[0,50]] span-7 text" id="telefono-text" name="telefono-text" type="text"/>				
				</p>
				</div>
				
				<div class="span-12">
				<p>
				<label for="estado-text">Estado: </label>
				<input alt="Estado" class="validate[required,custom[onlyLetter],length[0,250]] span-12 text" id="estado-text" name="estado-text" value="Baja California Sur" type="text"/>				
				</p>
				</div>
				
				
                
				<div class="span-3">
				<p>
				<label for="municipio-text">Municipio: </label>
				<select  name="municipio-text" id="municipio-text">
		        <option value="">- Seleccione -</option>           
		        <option value="1" selected>LA PAZ   </option>		   
		        <option value="2">LOS CABOS</option>		   
		        <option value="3">MULEG&Eacute;   </option>		   
		        <option value="4">COMOND&Uacute;  </option>		   
		        <option value="5">LORETO   </option>		   
	            </select>								
				</p>
				</div>
				
				<div class="span-3">
				<p>
				<label for="municipio-text">Municipio: </label>
				<select  name="municipio-text" id="municipio-text">
		        <option value="">- Seleccione -</option>           
		        <option value="1" selected>LA PAZ   </option>		   
		        <option value="2">LOS CABOS</option>		   
		        <option value="3">MULEG&Eacute;   </option>		   
		        <option value="4">COMOND&Uacute;  </option>		   
		        <option value="5">LORETO   </option>		   
	            </select>								
				</p>
				</div>				
				
				<div class="span-3">
				<p>
				<label for="fechafin">Fecha de Fin: </label>
				<input alt="Fecha de Inicio" class="validate[required,custom[date],length[0,10]] span-3 icon-fecha text" name="fechafin" id="fechafin" value="<?php echo date("d-m-Y") ?>" />				
				</p>
				</div>	
				
				<div class="span-3">
				<p>
				<label for="ano-text">A&ntilde;o del Evento: </label>
				<input alt="A&ntilde;o del Evento" class="span-3 text" id="ano-text" name="ano-text" value="<?php echo date("Y") ?>"/>				
				</p>
				</div>			
			 </fieldset>		 
			 <input type="submit" value="Grabar Evento"/>			 
             </form>			 
			 		
						   
        </div>  
    
    <div id="footer">
   		<p>&copy; <?php echo date("Y"); ?> <a title="QSERVICE - Integrate" href="#" target="_blank">QSERVICE - Integrate</a> &reg;  - Todos los Derechos Reservados - Desarrollado por <a title="Reality in a digital world" href="#" target="_blank">- Empresa Autorizada -</a></p>
	</div>        
</div>    
</body>
</html>
