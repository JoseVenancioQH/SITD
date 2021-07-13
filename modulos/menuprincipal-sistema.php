<?php 
	include("../scripts/include/dbcon.php");
    require "../scripts/clases/class.dbsession.php";	
	
    $session = new dbsession();
	if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
	{
		header("Location: ../index.php");
	}
	include("../scripts/clases/class.mysql.php");
	include("../scripts/clases/class.generar_municipio.php");	
	
	function generamunicipio($id,$usuario_municipio,$clase)
    {   
	  
	  $generar_municipio = new generar_municipio();	  
      echo($generar_municipio->extraerMunicipio($id,$usuario_municipio,$clase));   
    }
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Usuarios | Registro Estatal de Deporte - QSERVICE - Integrate</title>
<link rel="stylesheet" href="../css/screen.css" type="text/css" media="screen, projection">
<link type="text/css" href="../css/theme/ui.all.css" rel="Stylesheet" />
<!--[if IE]><link rel="stylesheet" href="../css/ie.css" type="text/css" media="screen, projection"><![endif]-->
<script type="text/javascript" src="../js/jquery-1.3.1.js"></script>
<script type='text/javascript' src='../js/jquery.highlightFade.js'></script>
<script type="text/javascript" src="../js/jquery-ui-personalized-1.6rc6.js"></script> 
<script type="text/javascript" src="../js/jquery.checkboxes.js"></script> 
<script type="text/javascript" src="../js/controller-usuarios.js"></script>
<script type="text/javascript" src="../js/jquery.scrollTo.js" ></script>
<script type="text/javascript" src="../js/seekAttention.jquery.js" ></script>
<script type="text/javascript" src="../js/jquery.blockUI.js" ></script> 
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
			$seccion = "sistema";
			include("../scripts/menu.php");
        ?>       
        </ul>             
            <ul id="submenu">
                <?php
			        $seccion = "usuarios";
			        include("../scripts/menu-usuario.php");
                ?>
            </ul>            
    </div>    
    
    <div id="form">
      
        <h2>Usuarios</h2>			 
			<fieldset><legend>Lista de Usuarios Registrados</legend>
			<img style="cursor:pointer; vertical-align:middle; margin-left:10px;" id="agregar" src="../img/icons/add.png"/>Agregar Usuario
			<table width="950" border="0">
            <thead>
                  <tr>
                    <th>Nombre Usuario</th>
					<th>PassWord</th>
					<th>Nombre Completo</th>
                    <th>Permisos</th>
                    <th>Rol</th>
					<th>Municipio</th>
                    <th>Editar</th>
                    <th>Status Activo/Inactivo</th>					                    
                  </tr>
            </thead>
			<tbody id="desplegado-usuarios">
            <?php
			    
                include("../scripts/clases/class.caut_usuarios.php");
				$usuarios = new usuarios();
				$usuarios->mostrarUsuarios();
            ?> 
			</tbody>
            </table>
			</fieldset>	                         
    </div>
	
	<div id="dialog" title="Usuario">
	            <form id="form-dialog">
	            <div id="notice" class="notice" style="visibility:hidden;"></div>
	            <div class="span-7" style="text-align:left;">
				<p>
				<label for="rolusuario-text">Rol del Usuario</label>
				<select  name="rolusuario-text" id="rolusuario-text">
		        <option value="" selected>- Seleccione -</option>           
		        <option value="admin">Administrador</option>		   
		        <option value="registradorvalidador">Registrador-Validador</option>	           
		        <option value="registrador">Registrador</option>		   
		        <option value="reporteador">Reporteador</option>		   
				<option value="validador">Validador</option>		   
	            </select>						
				</p>
				</div>
				
				<div class="span-7">
				<p>
				<label for="municipio">Municipio: </label>
				<?php generamunicipio("municipio","",""); ?>				
				</p>
				</div>
				
				<div class="clear"></div>
				
	            <div class="span-7" style="text-align:left;">
				<p>
				<label for="nombreusuario-text">Nombre del Usuario (Completo)</label>
				<input alt="Nombre del Usuario (Completo)" class="span-7 text" id="nombreusuario-text" name="nombreusuario-text" type="text"/>				
				</p>
				</div>
				
				<div class="span-7" style="text-align:left;">
				<p>
				<label for="nombre-text">Nombre del Usuario (Sistema)</label>
				<input alt="Nombre del Usuario (Sistema)" class="span-7 text" id="nombre-text" name="nombre-text" type="text"/>				
				</p>
				</div>
				
				<div class="span-7" style="text-align:left;">
				<p>
				<label for="pass-text">Password</label>
				<input alt="PassWord" class="span-7 text" id="pass-text" name="pass-text" type="text"/>				
				</p>
				</div>
		<!--<form id="tabla-almacen">-->		
	    <table>
		
		<label for="permisos-text">Aplicar Permisos en Sistema</label>						
		
		<thead>
		  <tr>
		     <th COLSPAN="2">
			      <legend>
			      <input name="sistema" id="sistema" type="checkbox"> Sistema
				  </legend>
			 </th>
			 			 
		  </tr>
		</thead>
		<tbody id="tabla-sistema">
		<tr>
		<td><legend><input name="usuarios" id="usuarios" type="checkbox"> Usuarios</legend></td>
		</tr>
		</tbody>
		</table>
		<!--</form>-->
		
		<table>
		<thead>
		  <tr>
		     <th COLSPAN="2">
			      <legend>
			      <input name="eventos" id="eventos" type="checkbox"> Eventos
				  </legend>
			 </th>
			 
		  </tr>
		</thead>
		<tbody id="tabla-eventos">
		<tr>
		<td><legend><input name="eventosregistrar" id="eventosregistrar" type="checkbox"> Registrar Evento</legend></td>
		<td><legend><input name="eventosmodificar" id="eventosmodificar" type="checkbox"> Modificar Evento</legend></td>					
		</tr>
		</tbody>
		</table>
		
		
		<table>
		<thead>
		  <tr>
		     <th COLSPAN="2">
			      <legend>
			      <input name="asociaciondeportiva" id="asociaciondeportiva" type="checkbox"> Asociaci&oacute;n Deportiva
				  </legend>
			 </th>
			 
		  </tr>
		</thead>
		<tbody id="tabla-asociaciondeportiva">
		<tr>
		<td><legend><input name="asociaciondeportivaregistrar" id="asociaciondeportivaregistrar" type="checkbox"> Registro Asociaci&oacute;n Deportiva</legend>
		</td>
		<td><legend><input name="asociaciondeportivamodificar" id="asociaciondeportivamodificar" type="checkbox"> Modificar Asociaci&oacute;n Deportiva</legend></td>					
		</tr>
		</tbody>
		</table>
		
		
		<table>
		<thead>
		  <tr>
		     <th COLSPAN="2">
			      <legend>
				   <input name="regparticipantes" id="regparticipantes" type="checkbox"> Registros de Participantes
				  </legend>
			 </th>
			 
		  </tr>
		</thead>
		<tbody id="tabla-registroparticipantes"> 
		<tr>
		<td><legend><input name="regparregistrar" id="regparregistrar" type="checkbox"> Registrar Participantes</legend>
		</td>
		<td><legend><input name="regparmodificar" id="regparmodificar" type="checkbox"> Modificar Participantes</legend>
		</td>		
		</tr>
		</tbody>
		</table>
		   
		   
		<table>
		<thead>
		  <tr>
		     <th>
			      <legend>
				  <input name="valparticipantes" id="valparticipantes" type="checkbox"> Validar Participante
				  </legend>
			 </th>
			 
			 
		  </tr>
		</thead>
		<tbody id="tabla-validacionparticipante">
		<tr>
		<td><legend><input name="valparactivar" id="valparactivar" type="checkbox"> Validar Participante</legend></td>		
		</tr>	
		</tbody>
		
		</table>
		
		
		<table>
		<thead>
		  <tr>
		     <th COLSPAN="3">
			      <legend>
				  <input name="catalogos" id="catalogos" type="checkbox"> Catalogos
				  </legend>
			 </th>
			 
			 
		  </tr>
		</thead>
		<tbody id="tabla-catalogos">
		<tr>
		<td><legend><input name="liga" id="liga" type="checkbox"> Liga</legend></td>		
		<td><legend><input name="equipo" id="equipo" type="checkbox"> Equipo</legend></td>		
		</tr>	
		<tr>
		<td><legend><input name="categoria" id="categoria" type="checkbox"> Categoria</legend></td>						
		<td><legend><input name="deportes" id="deportes" type="checkbox"> Deportes</legend></td>					
		</tr>	
		</tr>
		<tr>
		<td><legend><input name="modalidad" id="modalidad" type="checkbox"> Modalidad</legend></td>
		<td><legend><input name="municipio" id="municipio" type="checkbox"> Municipio</legend></td>					
		</tr>
		</tbody>
		
		</table>
		
		
		
		<table>
		<thead>
		  <tr>
		     <th COLSPAN="3">
			      <legend>
				  <input name="reportes" id="reportes" type="checkbox"> Reportes
				  </legend>
			 </th>		 
		  </tr>
		</thead>
		<tbody id="tabla-reportes">
		<tr>
		<td><legend><input name="cedulainscripcion" id="cedulainscripcion" type="checkbox"> Cedula de Inscripcion</legend></td>
		<td><legend><input name="credencial" id="credencial" type="checkbox"> Credencial</legend></td>
		<td><legend><input name="gaffetes" id="gaffetes" type="checkbox"> Gaffetes</legend></td>
		</tr>
		
		<tr>
		<td><legend><input name="reportesvarios" id="reportesvarios" type="checkbox"> Reportes Varios</legend></td>		
		</tr>			
		</tbody>
		</table>		
		
		</form>
    </div>
    
    <div id="footer">
   		<p>&copy; <?php echo date("Y"); ?> <a title="QSERVICE - Integrate" href="#" target="_blank">QSERVICE - Integrate</a> &reg;  - Todos los Derechos Reservados - Desarrollado por <a title="Reality in a digital world" href="#" target="_blank">- Empresa Autorizada -</a></p>
	</div>        
</div>    
</body>
</html>
