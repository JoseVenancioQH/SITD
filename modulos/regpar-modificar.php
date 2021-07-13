<?php 
	include("../scripts/include/dbcon.php");
    require "../scripts/clases/class.dbsession.php";
	include("../scripts/clases/class.mysql.php");			
	
    $session = new dbsession();
	if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
	{
		header("Location: ../index.php");
	}	
	
	include("../scripts/clases/class.deporte_categoria.php");
	include("../scripts/clases/class.generar_eventos.php");
	include("../scripts/clases/class.generar_municipio.php");
	include("../scripts/clases/class.generar_modalidad.php");
	
	function generadeporte($id)
    {  
	  
	  $deporte_categoria = new deporte_categoria();	  
      echo($deporte_categoria->extraerDeportes($id));   
    }
	
	function generaeventos($id,$idevento)
    {   
	  
	  $generar_eventos = new generar_eventos();	  
      echo($generar_eventos->extraerEventos($id,$idevento));   
    }
	
	function generamunicipio($id,$usuario_municipio,$clase)
    {  
	  $generar_municipio = new generar_municipio();	  
      echo($generar_municipio->extraerMunicipio($id,$usuario_municipio,$clase));   
    }
	
	function generamodalidad($id)
    {   
	  
	  $generar_modalidad = new generar_modalidad();	  
      echo($generar_modalidad->extraerModalidad($id));   
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Modificar Registro de Participante | Registro Estatal de Deporte - QSERVICE - Integrate</title>
<link rel="stylesheet" href="../css/screen.css" type="text/css" media="screen, projection">
<link type="text/css" href="../css/theme/ui.all.css" rel="Stylesheet" />
<link rel="stylesheet" href="../css/validationEngine.jquery.css" type="text/css" media="screen" charset="utf-8" />
<link rel="stylesheet" href="../css/datepicker.css" type="text/css" />
<link rel="stylesheet" href="../css/jquery.jgrowl.css" type="text/css" />
<link rel="stylesheet" href="../css/jquery.jgrowl.css" type="text/css" />
<link rel="stylesheet" href="../css/jquery.autocomplete.css" type="text/css"/>

<!--[if IE]><link rel="stylesheet" href="../css/ie.css" type="text/css" media="screen, projection"><![endif]-->
<script type="text/javascript" src="../js/jquery-1.3.1.js"></script>
<script type="text/javascript" src="../js/jquery.checkboxes.js"></script>  
<script type="text/javascript" src="../js/controller-unBlock.js" ></script>
<script type="text/javascript" src="../js/jquery.highlightFade.js"></script>
<script type="text/javascript" src="../js/jquery-ui-personalized-1.6rc6.js"></script> 
<script type="text/javascript" src="../js/controller-modificarparticipante.js"></script>
<script type="text/javascript" src="../js/controller-generacurp.js" ></script>
<script type="text/javascript" src="../js/jquery.blockUI.js" ></script>
<script type="text/javascript" src="../js/seekAttention.jquery.js" ></script>
<script type="text/javascript" src="../js/jquery.autocomplete.js" ></script>
<script type="text/javascript" src="../js/jquery.AjaxUpload.js" ></script>
<script type="text/javascript" src="../js/jquery.growl.js" ></script>
<script type="text/javascript" src="../js/controller-acentos.js" ></script>
<script type="text/javascript" src="../js/jquery.maskedinput-1.2.2.js" ></script>
<script type="text/javascript" src="../js/jquery.validationEngine.js"></script>
<script type="text/javascript" src="../js/jquery.json.js" ></script>
<script type="text/javascript" src="../js/jquery.taffy.js" ></script>

</head>
<body>
<div class="container">		
    
    <div id="header">
   	  <div id="user_id">Bienvenido <?php echo $_SESSION["nombre"]; ?> | <a title="salir del sistema" href="../scripts/close-session.php">Salir</a></div><br /><div style="float:right; margin-right:20px;"><?php echo $_SESSION["nombreevento"]; ?></div>
	  <h1><img alt="QSERVICE - Integrate" src="../img/logo.png" /> RED - - Empresa Autorizada -</h1>
    </div>
    
    <div id="navegacion"> 
       <ul id="menu">
        <?php
			$seccion = "regparticipantes";
			include("../scripts/menu.php");
        ?>       
        </ul>             
            <ul id="submenu">
                <?php
			        $seccion = "modificar";
			        include("../scripts/menu-regparticipantes.php");
                ?>
            </ul>          
    </div>
    
    <div id="form">
             <h2>Modificar Registro de Participante</h2>		             	
             <fieldset><legend>Datos de Busqueda</legend>		 
			
			   <?php /*?> <div class="span-7">
				<p>
				<label for="evento">Evento: </label>
				<?php generaeventos("evento"); ?>				
				</p>
				</div>
				
				<div class="span-7">
				<p>
				<label for="municipio">Municipio: </label>
				<?php generamunicipio("municipio",$_SESSION["municipio"],"validate[required] cselect"); ?>				
				</p>
				</div>			
				
				<div class="span-7">
				<p>
				<label for="modalidad">Modalidad: </label>
				<?php generamodalidad("modalidad"); ?>				
				</p>
				</div>			
				
				<div class="clear"></div>		
												
			    <div class="span-7">
				<p>
				<label for="nombredeporte">Deporte: </label>
				<?php generadeporte("deportes"); ?>				
				</p>
				</div>
				
				<script type="text/javascript">
				$("#deportes").addClass("validate[required] span-7 cselect");
				</script>		
				
				
				<div class="span-12" id="categoria">		
				<p>
				<label for="categoria">Categoria: </label>		
				<select name='selectcategoria' id='selectcategoria' class='span-12 cselect' disabled='disabled'>
			    <option value='' selected>Ninguno</option>
			    </select>					 	 
				</p>					
				</div>				
				
				<div class="span-3">
				<p>
				<label for="sexo">Rama: </label>
				<select name="sexo" id= "sexo"  class="span-3 cselect" >
				 <option value="">Varonil-Femenil</option>
           		 <option value="H">Varonil    </option>
		         <option value="M">Femenil     </option>		   		 
		         </select>				
				</p>
				</div>
				
				<div class="clear"></div>
				
				<?php */?>
				<div class="span-19">
				<p>
				<label for="textobusqueda">Texto busqueda: </label>
				<input alt="Texto busqueda" class="span-19 text mayuscula"  id="textobusqueda" name="textobusqueda" type="text"/>				
				</p>
				</div>			
                
				<?php /*?><input type="hidden" id="municipio" name="municipio" value="<?php echo $_SESSION['municipio'];?>"/>
				<?php */?>
				<?php /*?><input type="hidden" id="evento" name="evento" value="<?php echo $_SESSION['evento'];?>"/><?php */?>				
				
				<!--<div class="clear"></div>			
				<input type="submit" id="buscar" value="Buscar"/>-->				
			    </fieldset>			
				
        <fieldset>
		
		<legend id="participante_edit">Datos del Participante a Modificar</legend>
		<table>
		<tr>
		<td style="vertical-align:top;">				
		<div id = "operaciones_participantes" style="width:100%; display:none;">
		<img id="eliminarparticipante" style="cursor:pointer; vertical-align:middle; margin-left:10px;"  src="../img/icons/delete.png" onclick="javascript:EliminarParticipante();"/>Eliminar Participante
		<img id="actualizargenerales" style="cursor:pointer; vertical-align:middle; margin-left:10px;"  src="../img/icons/edit.png" onclick="javascript:ModificarGenerales();"/>Actualizar Generales
		<img id="actualizaradicionales" style="cursor:pointer; vertical-align:middle; margin-left:10px;"  src="../img/icons/edit.png" onclick="javascript:ModificarAdicionales();"/>Actualizar Adicionales				
		<span id="upload_button" style="cursor:pointer;"><img  src="../img/foto_16.png" style=" margin-left:10px; cursor:pointer;" />Actualizar Foto</span>						
		</div>		
		</td>
		<td>
		<div id="div_foto" class="span-2" style="display:none; width:71px; height:100px; float:right;">			
		<img id="foto" src="../img/foto.png" onError="../img/foto.png" style="cursor:pointer;"/>				
		</div>
		</td>
		</tr>
		</table>
		
		<div class="scroll">		     
		     <table>
             <thead>			         	   		   			                  
			   <th>Deporte</th>
			   <th>Modalidad</th>			   
			   <th>Categoria</th>
			   <th>Pruebas</th>		       			   
			   <th style="text-align:center;">Modificar Categoria-Pruebas-Cargo-Prensa</th>
			   <th style="text-align:center;">Eliminar Registro</th>
			 </thead>	  
             <tbody id = "datos_participante">		 		 
			 </tbody>			  		 
             </table>	    
		</div>	  	    
		</fieldset>
	</div>
	<div id="dialog_datos_generales" title="Modificar Datos Generales">
			
	<fieldset id="fieldsetcategoria"><legend>Datos Generales <img alt="Limpia Datos Generales" style="vertical-align:middle; cursor:pointer;" src="../img/icons/trash.png" onclick="javascript:limpiargenerales();"/></legend>	
			<form name="actualizar-generales" id="actualizar-generales" method="post" action="">
			    <div class="span-4">
				<p>
				<label for="nombres">Nombres: </label>
				<input alt="Nombres" class="validate[required] span-4 text mayuscula"  id="nombres" name="nombres" type="text"/>				
				</p>
				</div>
				
				<div class="span-3">
				<p>
				<label for="appaterno">Paterno: </label>
				<input  alt="Apellido Paterno" class="validate[required] span-3 text mayuscula" id="appaterno" name="appaterno" type="text" value=""/>				
				</p>
				</div>
							
				<div class="span-3">
				<p>
				<label for="apmaterno">Materno: </label>
				<input alt="Apellido Materno" class="validate[required] span-3 text mayuscula" id="apmaterno" name="apmaterno" type="text"/>				
				</p>
				</div>
				
				<div class="span-3">
				<p>
				<label for="fechanacimiento">Fecha Nac.: </label>
				<input alt="Fecha de Nacimiento" class="validate[required,custom[date],length[0,10]] span-3 icon-fecha text" name="fechanacimiento" id="fechanacimiento" />				
				</p>
				</div>
				
				<div class="span-6">
				<p>
				<label for="estado">Estado de la Rep.: </label>
				<select name="entidad" id= "entidad"  class="validate[required] span-6 cselect" >
				 <option value="">Ninguno           </option>
           		 <option value="AS">AGUASCALIENTES           </option>
		         <option value="BC">BAJA CALIFORNIA NTE.     </option>
		   		 <option value="BS" selected>BAJA CALIFORNIA SUR      </option>
		  		 <option value="CC">CAMPECHE                 </option>
		   		 <option value="CL">COAHUILA                 </option>
		   		 <option value="CM">COLIMA                   </option>
		   		 <option value="CS">CHIAPAS                  </option>
		   	     <option value="CH">CHIHUAHUA                </option>
		    	 <option value="DF">DISTRITO FEDERAL         </option>
		     	 <option value="DG">DURANGO                  </option>
		  		 <option value="GT">GUANAJUATO               </option>
		   	     <option value="GR">GUERRERO                 </option>
		    	 <option value="HG">HIDALGO                  </option>
		    	 <option value="JC">JALISCO                  </option>
		   		 <option value="MC">MEXICO                   </option>
		   		 <option value="MN">MICHOACAN                </option>
		   	     <option value="MS">MORELOS                  </option>
		   	     <option value="NT">NAYARIT                  </option>
		   		 <option value="NL">NUEVO LEON               </option>
		   		 <option value="OC">OAXACA                   </option>
		   		 <option value="PL">PUEBLA                   </option>
		   		 <option value="QT">QUERETARO                </option>
		   		 <option value="QR">QUINTANA ROO             </option>
		   		 <option value="SP">SAN LUIS POTOSI          </option>
		   		 <option value="SL">SINALOA                  </option>
		   		 <option value="SR">SONORA                   </option>
		   		 <option value="TC">TABASCO                  </option>
		   	     <option value="TS">TAMAULIPAS               </option>
		   		 <option value="TL">TLAXCALA                 </option>
	    		 <option value="VZ">VERACRUZ                 </option>
		   		 <option value="YN">YUCATAN                  </option>
		   		 <option value="ZS">ZACATECAS                </option>	   
		         </select>				
				</p>
				</div>
				
				<div class="span-3">
				<p>
				<label for="sexo">Sexo: </label>
				<select name="sexo" id= "sexo"  class="validate[required] span-3 cselect" >
				 <option value="">Ninguno       </option>
           		 <option value="H">Hombre    </option>
		         <option value="M">Mujer     </option>		   		 
		         </select>				
				</p>
				</div>
				
				<div class="clear"></div> 
				
				<div class="span-6">			
				<label for="curp">C.U.R.P.: </label>
				<p>				
				<input maxlength="18" alt="CURP" class="validate[required,length[18,18]] span-6 text mayuscula" id="curp" name="curp" type="text"/>			
				</p>
				</div>		
			</form>	
	</fieldset>	
			
	</div>
    <div id="dialog_categoria_pruebas" title="Modificar Categoria-Pruebas">			
			    <fieldset id="fieldsetcategoria"><legend>Datos de Categoria <img alt="Limpia Datos de Categoria" style="vertical-align:middle; cursor:pointer;" src="../img/icons/trash.png" onclick="javascript:limpiarcategoria();"/></legend>	
			<form name="actualizar-categoria" id="actualizar-categoria" method="post" action="">
			    <div class="span-7">
				<p>
				<label for="nombredeporte">Deporte: </label>
				<?php generadeporte("deportes"); ?>				
				</p>
				</div>								
				
				<script type="text/javascript">
				$("#deportes").addClass("validate[required] span-7 cselect");
				</script>	
				
				<div class="span-12" id="categoria">		
				<p>
				<label for="categoria">Categoria: </label>		
				<select name='selectcategoria' id='selectcategoria' class='span-12 cselect' disabled='disabled'>
			    <option value='' selected>Ninguno</option>
			    </select>					 	 
				</p>					
				</div>
				
				<div class="clear"></div>
				
				<label for="pruebas">Pruebas: </label>				
				<div id="pruebas" style="width:100%;">
				</div>							
	
				</fieldset>
				
				<div class="span-7" id="div_deportes_extras" style="display:none;">
				<p>
				<label for="nombredeporte">Deporte: </label>
				<?php generadeporte("deportes_extras"); ?>				
				</p>
				</div>	
				
				<div id="div_cargo" class="span-7" style="display:none;">
				<p>
				<label for="cargo">Cargo: </label>
				<input  alt="Cargo" class="" id="cargo" name="cargo" type="text" value=""/>				
				</p>
				</div>	
				
				<div id="div_prensa" class="span-7" style="display:none;">
				<p>
				<label for="prensa">Prensa: </label>
				<input  alt="Prensa" class="" id="prensa" name="prensa" type="text" value=""/>				
				</p>
				</div>		
			</form>
	</div>
	<div id="dialog_datos_adicionales" title="Modificar Datos Adicionales">
 	            <fieldset><legend>Datos Adicionales del Participante <img alt="Limpia Datos de Participante" style="vertical-align:middle; cursor:pointer;" src="../img/icons/trash.png" onclick="javascript:limpiargenerales();"/></legend>
			<form name="actualizar-adicionales" id="actualizar-adicionales" method="post" action="">	
				<div class="span-4">			
				<label for="direccion">Direcci&oacute;n: </label>
				<p>				
				<input alt="Direcci&oacute;n" class="validate[required] span-4 text" id="direccion" name="direccion" type="text"/>			
				</p>
				</div>
				
				<div class="span-4">			
				<label for="colonia">Colonia: </label>
				<p>				
				<input alt="Colonia" class="validate[required] span-4 text" id="colonia" name="colonia" type="text"/>			
				</p>
				</div>
				
				<div class="span-4">			
				<label for="localidad">Localidad: </label>
				<p>				
				<input alt="Localidad" class="validate[required] span-4 text" id="localidad" name="localidad" type="text"/>			
				</p>
				</div>
				
				<div class="span-4">			
				<label for="codigopostal">Codigo Postal: </label>
				<p>				
				<input alt="Codigo Postal" class="span-4 text" id="codigopostal" name="codigopostal" type="text"/>			
				</p>
				</div>
				
				
				<div class="span-4">			
				<label for="telefonos">Telefonos: </label>
				<p>				
				<input alt="Telefonos" class="validate[required] span-4 text" id="telefonos" name="telefonos" type="text"/>			
				</p>
				</div>
				
				<div class="span-4">			
				<label for="correo">Correo Electronico: </label>
				<p>				
				<input alt="Correo Electronico" class="span-4 text" id="correo" name="correo" type="text"/>			
				</p>
				</div>
				
				<div class="span-4">			
				<label for="peso">Peso (KG): </label>
				<p>				
				<input alt="Peso" class="validate[required] span-4 text" id="peso" name="peso" type="text"/>			
				</p>
				</div>
				
				<div class="span-4">			
				<label for="talla">Talla (Mts): </label>
				<p>				
				<input alt="Talla" class="validate[required] span-4 text" id="talla" name="talla" type="text"/>			
				</p>
				</div>
				
				<div class="span-4">			
				<label for="talla">R.F.C.: </label>
				<p>				
				<input alt="R.F.C." class="validate[required] span-4 text" id="rfc" name="rfc" type="text"/>			
				</p>
				</div>
				
				<div class="span-4">			
				<label for="tiposanguineo">Tipo Sanguineo: </label>
				<p>				
				<input alt="Tipo Sanguineo" class="span-4 text" id="tiposanguineo" name="tiposanguineo" type="text"/>			
				</p>
				</div>
			</form>					
				</fieldset>
	</div>			
	<div id="cambiar_modalidad" title="Cambiar Modalidad" style="display:none;">
	            <div class="span-7">
				<p>
				<label for="modalidad">Modalidad: </label>
				<?php generamodalidad("modalidad");?>				
				</p>
				</div>
	</div>
    <div id="footer">
   		<p>&copy; <?php echo date("Y"); ?> <a title="QSERVICE - Integrate" href="#" target="_blank">QSERVICE - Integrate</a> &reg;  - Todos los Derechos Reservados - Desarrollado por <a title="Reality in a digital world" href="#" target="_blank">- Empresa Autorizada -</a></p>
	</div>      
	
	
	  
</div>    
</body>
</html>
