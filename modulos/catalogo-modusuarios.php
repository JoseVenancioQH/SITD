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
<title>Usuarios | DEMARC - Control de Obra</title>
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
<a href="#top" id="top-link"></a>
<div class="container">   
    <div id="header">
   	  <div id="user_id">Bienvenido <?php echo $_SESSION["nombre"]; ?> | <a title="salir del sistema" href="../scripts/close-session.php">Salir</a></div>
	  <h1><img alt="DEMARC" src="../img/logo.jpg" /> DEMARC - Control de Obra</h1>
    </div>
    
    <div id="navegacion"> 
       <ul id="menu">
        <?php
			$seccion = "Catalogo";
			include("../scripts/menu.php");
        ?>       
        </ul> 
            
            <ul id="submenu">
               <?php
			        $seccion = "Usuarios";
			        include("../scripts/menu-catalogo.php");
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
                    <th>Editar</th>
                    <th>Status Activo/Inactivo</th>					                    
                  </tr>
            </thead>
			<tbody id="desplegado-usuarios">
            <?php
			    include("../scripts/clases/class.mysql.php");
                include("../scripts/clases/class.sitd_usuarios.php");
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
		        <option value="admin">Admin</option>		   
		        <option value="super">Super</option>		   
		        <option value="almacen">Almacen</option>		   
		        <option value="destajos">Destajos</option>		   
		        <option value="altaconjuntohabitacional">Alta Conjunto Habitacional</option>		   
				<option value="cotizacionprototipocasa">Cotizaci&oacute;n Prototipo de Casa</option>		   
	            </select>						
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
		     <th COLSPAN="3">
			      <legend>
			      <input name="Almacen" id="Almacen" type="checkbox"> Almacen
				  </legend>
			 </th>
			 			 
		  </tr>
		</thead>
		<tbody id="tabla-Almacen">
		<tr>
		<td><legend><input name="ActualizacionHerramienta" id="ActualizacionHerramienta" type="checkbox"> Actualizaci&oacute;n de Herramienta</legend></td>
		<td><legend><input name="ActualizacionMaterial" id="ActualizacionMaterial" type="checkbox"> Actualizaci&oacute;n de Material</legend></td>
		<td><legend><input name="SalidaHerramienta" id="SalidaHerramienta" type="checkbox"> Salida de Herramienta</legend></td>			
		</tr>
		<tr>
		<td><legend><input name="SalidaMaterial" id="SalidaMaterial" type="checkbox"> Salida de Material</legend></td>
		<td><legend><input name="EntradaMaterial" id="EntradaMaterial" type="checkbox"> Entrada de Material</legend></td>
		<td><legend><input name="EntradaHerramienta" id="EntradaHerramienta" type="checkbox"> Entrada de Herramienta</legend></td>
		</tr>
		</table>
		<!--</form>-->
		
		<table>
		<thead>
		  <tr>
		     <th>
			      <legend>
			      <input name="AltaConHab" id="AltaConHab" type="checkbox"> Alta Conjunto Habitacional
				  </legend>
			 </th>
			 
		  </tr>
		</thead>
		<tbody id="tabla-AltaConHab">
		<tr>
		<td><legend><input name="ActivacionCasa" id="ActivacionCasa" type="checkbox"> Activaci&oacute;n de Casa</legend></td>					
		</tr>
		</tbody>
		</table>
		
		
		<table>
		<thead>
		  <tr>
		     <th COLSPAN="2">
			      <legend>
			      <input name="Destajos" id="Destajos" type="checkbox"> Destajos
				  </legend>
			 </th>
			 
		  </tr>
		</thead>
		<tbody id="tabla-Destajos">
		<tr>
		<td><legend><input name="AsignacionTarea" id="AsignacionTarea" type="checkbox"> Asignaci&oacute;n de Tarea</legend>
		</td>
		<td><legend><input name="AvanceConsObra" id="AvanceConsObra" type="checkbox"> Avance Construcci&oacute;n de Obra</legend></td>					
		</tr>
		</tbody>
		</table>
		
		
		<table>
		<thead>
		  <tr>
		     <th>
			      <legend>
				   <input name="CotProtCasa" id="CotProtCasa" type="checkbox"> Cotizaci&oacute;n Prototipo de Casa
				  </legend>
			 </th>
			 
		  </tr>
		</thead>
		<tbody id="tabla-CotProtCasa"> 
		<tr>
		<td><legend><input name="CrearEstructuraObra" id="CrearEstructuraObra" type="checkbox"> Crear Estructura de Obra</legend>
		</td>		
		</tr>
		</tbody>
		</table>
		   
		   
		<table>
		<thead>
		  <tr>
		     <th COLSPAN="3">
			      <legend>
				  <input name="Catalogo" id="Catalogo" type="checkbox"> Catalogo
				  </legend>
			 </th>
			 
			 
		  </tr>
		</thead>
		<tbody id="tabla-Catalogo">
		<tr>
		<td><legend><input name="Usuarios" id="Usuarios" type="checkbox"> Usuarios</legend></td>
		<td><legend><input name="Herramientas" id="Herramientas" type="checkbox"> Herramientas</legend></td>
		<td><legend><input name="Medidads" id="Medidas" type="checkbox"> Medidas</legend></td>				
		</tr>
		
		<tr>
		<td><legend><input name="CategoriaEmpleados" id="CategoriaEmpleados" type="checkbox"> Categoria de Empleados</legend></td>
		<td><legend><input name="Empleados" id="Empleados" type="checkbox"> Empleados</legend></td>
		<td><legend><input name="ConjuntoHabitacional" id="ConjuntoHabitacional" type="checkbox"> Conjunto Habitacional</legend></td>		
		</tr>
		
		<tr>
		<td><legend><input name="Prototipo" id="Prototipo" type="checkbox"> Prototipo</legend></td>
		
		<td><legend><input name="Paquetes" id="Paquetes" type="checkbox"> Paquetes</legend></td>
		
		<td><legend><input name="Material" id="Material" type="checkbox"> Material</legend>	</td>
		
		</tr>
		<tr>
		<td><legend><input name="FamiliaMaterial" id="FamiliaMaterial" type="checkbox"> Familia de Material</legend></td>
		<td><legend><input name="FamiliaPaquetes" id="FamiliaPaquetes" type="checkbox"> Familia de Paquetes</legend></td>
		</tr>
		</tbody>
		
		</table>
		
		<table>
		<thead>
		  <tr>
		     <th COLSPAN="3">
			      <legend>
				  <input name="Reportes" id="Reportes" type="checkbox"> Reportes
				  </legend>
			 </th>		 
		  </tr>
		</thead>
		<tbody id="tabla-Reportes">
		<tr>
		<th><legend><input name="ReportesAlmacen" id="ReportesAlmacen" type="checkbox"> Reportes de Almacen</legend></th>
		<th><legend><input name="ReportesDestajos" id="ReportesDestajos" type="checkbox"> Reportes de Destajos</legend></th>
		<th><legend><input name="ReportesCostoInversion" id="ReportesCostoInversion" type="checkbox"> Reportes de Costo de Inversi&oacute;n</legend></th>
		</tr>
		
		<tr>
		<td><legend><input class="repalmacen" name="ReportesEntradaMaterial" id="ReportesEntradaMaterial" type="checkbox"> Reportes de Entrada de Material</legend></td>
		<td><legend><input class="repdestajos" name="ReportesEstimaciones" id="ReportesEstimaciones" type="checkbox"> Reportes de Estimaciones</legend></td>
		<td><legend><input class="repcostoinversion" name="ReportesInversionVivienda" id="ReportesInversionVivienda" type="checkbox"> Reportes de Inversi&oacute;n en Vivienda</legend></td>
		</tr>
		
		<tr>
		<td><legend><input class="repalmacen" name="ReportesSalidaMaterial" id="ReportesSalidaMaterial" type="checkbox"> Reportes de Salida de Material</legend></td>
		<td><legend><input class="repdestajos" name="ReportesAvanceObraMatCons" id="ReportesAvanceObraMatCons" type="checkbox"> Reportes de Avance de Obra Mat. de Cons.</legend></td>
		<td><legend><input class="repcostoinversion" name="ReportesMaterialVivienda" id="ReportesMaterialVivienda" type="checkbox"> Reportes de Material de Vivienda</legend></td>
		</tr>
		
		<tr>
		<td><legend><input class="repalmacen" name="ReportesMaterialFaltante" id="ReportesMaterialFaltante" type="checkbox"> Reportes de Material de Faltante</legend></td>
		<td><legend><input class="repdestajos" name="ReportesManoObraCasa" id="ReportesManoObraCasa" type="checkbox"> Reportes de Mano de Obra por Casa</legend></td>
		</tr>
		
		<tr>
		<td><legend><input class="repalmacen" name="ReportesInventario" id="ReportesInventario" type="checkbox"> Reportes de Inventario</legend></td>
		</tr>
		
		<tr>
		<td><legend><input class="repalmacen" name="ReportesHerramienta" id="ReportesHerramienta" type="checkbox"> Reportes de Herramienta</legend></td>
		</tr>
		
		<tr>
		<td><legend><input class="repalmacen" name="ReportesMaterialHerramienta" id="ReportesMaterialHerramienta" type="checkbox"> Reportes de Material de Herramienta</legend></td>
		</tr>		
		</tbody>
		</table>
		   
        
		
		
		
		
		
		
		
		
		
		
		
		</form>
    </div>
    
    <div id="footer">
   		<p>&copy; <?php echo date("Y"); ?> <a title="DEMARC" href="#" target="_blank">DEMARC</a> &reg;  - Todos los Derechos Reservados - Desarrollado por <a title="Reality in a digital world" href="#" target="_blank">Baja-Integral</a></p>
	</div>        
</div>    
</body>
</html>
