<?php 
	include("../scripts/include/dbcon.php");    
	include("../scripts/clases/class.mysql.php");			   	
	
	include("../scripts/clases/class.deporte_categoria.php");
	include("../scripts/clases/class.generar_eventos.php");
	include("../scripts/clases/class.generar_municipio.php");
	include("../scripts/clases/class.generar_modalidad.php");
	include("../scripts/clases/class.generar_ano.php");
	
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
	
	function generaanoinicio($id)
    {  
	  $generar_anoinicio = new generar_ano();	  
      echo($generar_anoinicio->extraerAnoInicio($id));   
    }
	
	function generaanofin($id)
    {  
	  $generar_anofin = new generar_ano();	  
      echo($generar_anofin->extraerAnoFinal($id));   
    }
	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reportes Varios | Registro Estatal de Deporte - QSERVICE - Integrate</title>
<link rel="stylesheet" href="../css/screen.css" type="text/css" media="screen, projection">
<link type="text/css" href="../css/theme/ui.all.css" rel="Stylesheet" />
<link rel="stylesheet" href="../css/validationEngine.jquery.css" type="text/css" media="screen" charset="utf-8" />
<link rel="stylesheet" href="../css/datepicker.css" type="text/css" />
<link rel="stylesheet" href="../css/jquery.jgrowl.css" type="text/css" />
<link rel="stylesheet" href="../css/jquery.autocomplete.css" type="text/css"/>


<!--[if IE]><link rel="stylesheet" href="../css/ie.css" type="text/css" media="screen, projection"><![endif]-->
<script type="text/javascript" src="../js/jquery-1.3.1.js"></script>
<script type="text/javascript" src="../js/jquery.checkboxes.js"></script>  
<script type="text/javascript" src="../js/controller-unBlock.js" ></script>
<script type="text/javascript" src="../js/controller-reportesvarios.js"></script>
<script type="text/javascript" src="../js/jquery.validationEngine.js"></script>
<script type="text/javascript" src="../js/jquery.blockUI.js" ></script>
<script type="text/javascript" src="../js/jquery.maskedinput-1.2.2.js" ></script>
<script type="text/javascript" src="../js/controller-generacurp.js" ></script>
<script type="text/javascript" src="../js/seekAttention.jquery.js" ></script>
<script type="text/javascript" src="../js/jquery.autocomplete.js" ></script>
<script type="text/javascript" src="../js/jquery.AjaxUpload.js" ></script>
<script type="text/javascript" src="../js/jquery.growl.js" ></script>
<script type="text/javascript" src="../js/jquery.highlightFade.js"></script>
<script type="text/javascript" src="../js/jquery-ui-personalized-1.6rc6.js"></script>
<script type="text/javascript" src="../js/controller-acentos.js" ></script>
</head>
<body onLoad="javascript:$('#accordion').css('visibility','visible'); resetvalores();">
<div class="container">		
    
   <div id="header">    
     <div id="form">
             <h2>Reportes Varios</h2>		             	
             <fieldset><legend>Datos de Busqueda<img style="cursor:pointer;" src="../img/icons/trash.png" onclick="javascript:resetvalores();"/></legend>		 
			 <div id="accordion" style="visibility:hidden;">			    
			    <h3><a><span id="span-curp">Curp ()</span><span id="span-nombres">Nombres ()</span><span id="span-appaterno"> Apellido Paterno ()</span><span id="span-apmaterno"> Apellido Materno ()</span></a></h3>
				
				<div>
				
				<div class="span-5">			
				<label for="curp">C.U.R.P.: </label>
				<p>				
				<input maxlength="18" alt="CURP" class="span-5 text mayuscula" id="curp" name="curp" type="text"/>			
				</p>
				</div>	
				
				<div class="span-5">
				<p>
				<label for="nombres">Nombres: </label>
				<input alt="Nombres" class="span-5 text mayuscula"  id="nombres" name="nombres" type="text"/>				
				</p>
				</div>
				
				<div class="span-5">
				<p>
				<label for="appaterno">Apellido Paterno: </label>
				<input  alt="Apellido Paterno" class="span-5 text mayuscula" id="appaterno" name="appaterno" type="text" value=""/>				
				</p>
				</div>
							
				<div class="span-5">
				<p>
				<label for="apmaterno">Apellido Materno: </label>
				<input alt="Apellido Materno" class="span-5 text mayuscula" id="apmaterno" name="apmaterno" type="text"/>				
				</p>
				</div>
				
				</div>
				
				<h3><a><span id="span-evento">Evento ()</span><span id="span-municipio"> Municipio ()</span><span id="span-modalidad"> Modalidad ()</span></a></h3>	
			    <div>			
			    <div class="span-7">
				<p>
				<label for="evento">Evento: </label>
				<?php generaeventos("evento",'79'); ?>				
				</p>
				</div>
				
				<div class="span-7">
				<p>
				<label for="municipio">Municipio: </label>
				<?php generamunicipio("municipio",'',' cselect');?>				
				</p>
				</div>
				
				<script type="text/javascript">
				        $("#municipio option[value="+""+"]").text('Todas');
						$("#municipio").attr('disabled',false);
				</script> 		
								
				<div class="span-7">
				<p>
				<label for="modalidad">Modalidad: </label>
				<?php generamodalidad("modalidad"); ?>				
				</p>
				</div>
				
				<script type="text/javascript">
				        $("#modalidad option[value="+""+"]").text('Todas');
				</script>
				
				</div>
				
				<h3><a><span id="span-rama">Rama ()</span><span id="span-deporte"> Deporte ()</span><span id="span-categoria"> Categoria ()</span><span id="span-pruebas"> Pruebas ()</span></a></h3>	
				<div>
				
				<div class="span-4">
				<p>
				<label for="sexo">Rama: </label>
				<select name="sexo" id= "sexo"  class="span-4 cselect" >
				 <option value="">Varonil-Femenil</option>
           		 <option value="H">Varonil    </option>
		         <option value="M">Femenil     </option>		   		 
		         </select>				
				</p>
				</div>
				
				<div class="span-5">
				<p>
				<label for="nombredeporte">Deporte: </label>
				<?php generadeporte("deportes"); ?>				
				</p>
				</div>				
				
				<script type="text/javascript">
				        $("#deportes option[value="+""+"]").text('Todos');
						$("#deportes").addClass("span-5 cselect");
				</script>
				
				<div class="span-10" id="categoria">		
				<p>
				<label for="categoria">Categoria: </label>		
				<select name='selectcategoria' id='selectcategoria' class='span-12 cselect' disabled='disabled'>
			    <option value='' selected>Ninguno</option>
			    </select>					 	 
				</p>					
				</div>
				
				<script type="text/javascript">				        
						$("#selectcategoria").addClass("span-10 cselect");
				</script>
				
				<script type="text/javascript">
				        $("#selectcategoria option[value="+""+"]").text('Todas');
				</script>		
				
				<div class="clear"></div>
				
				
				<label for="pruebas">Pruebas: </label>				
				<div id="pruebas" style="width:100%;">
				<table id = "pruebas_check"></table>
				</div>
						
				</div>			
				
				<h3><a><span id="span-anoinicio">A&ntilde;o Inicio ()</span><span id="span-anofin"> A&ntilde;o Fin ()</span><span id="span-convivencia"> A&ntilde;o Convivecia ()</span></a></h3>	
				<div>			
				<div class="span-6">
				<p>
				<label for="anoinicio">Participante A&ntilde;o Inicio: </label>
				<?php generaanoinicio("anoinicio"); ?>				
				</p>
				</div>
				
				<script type="text/javascript">
				        $("#anoinicio option[value="+""+"]").text('Todos');
				</script>
				
				<div class="span-6">
				<p>
				<label for="anofin">Participante A&ntilde;o Fin: </label>
				<?php generaanofin("anofin"); ?>				
				</p>
				</div>
				
				<script type="text/javascript">
				        $("#anofin option[value="+""+"]").text('Todos');
						$("#anofin").attr('disabled',true);
				</script>
				
				<div class="span-4">
				<p>
				<label for="convanoinicio">A&ntilde;o de Convivencia : </label>
				<?php generaanoinicio("convanoinicio"); ?>				
				</p>
				</div>
				
				<script type="text/javascript">
				        $("#convanoinicio option[value="+""+"]").text('Sin Selección');
				</script>						
				
				</div>
				
				<h3><a><span id="span-orden">Orden de desplegado ()</span></a></h3>	
				<div>				
				<table id="tabla_orden" class="orden_varios">	
				<tr>				
				   <td><a href="javascript:agregarorden('curp','CURP');">CURP</a><img id="convivencia" src="../img/icons/accept.png" style="display:none;"/></td>
				   <td><a href="javascript:agregarorden('nombres','Nombres');">Nombres</a><img id="nombres" src="../img/icons/accept.png" style="display:none;"/></td>
				   <td><a href="javascript:agregarorden('appaterno','Apellido Paterno');">Apellido Paterno</a><img id="modalidad" src="../img/icons/accept.png" style="display:none;"/></td>
				   <td><a href="javascript:agregarorden('apmaterno','Apellido Materno');">Apellido Materno</a><img id="rama" src="../img/icons/accept.png" style="display:none;"/></td>		      
				</tr>
				<tr>
				   <td><a href="javascript:agregarorden('municipio','Municipio');">Municipio</a><img id="municipio" src="../img/icons/accept.png" style="display:none;"/></td>
				   <td><a href="javascript:agregarorden('modalidad','Modalidad');">Modalidad</a><img id="modalidad" src="../img/icons/accept.png" style="display:none;"/></td>
				   <td><a href="javascript:agregarorden('rama','Rama');">Rama</a><img id="rama" src="../img/icons/accept.png" style="display:none;"/></td>
				   <td><a href="javascript:agregarorden('deporte','Deporte');">Deporte</a><img id="deporte" src="../img/icons/accept.png" style="display:none;"/></td>
				</tr>
				<tr>
				   <td><a href="javascript:agregarorden('categoria','Categoria');">Categoria</a><img id="categoria" src="../img/icons/accept.png" style="display:none;"/></td>
				   <td><a href="javascript:agregarorden('anoparticipante','A&ntilde;o Participante');">A&ntilde;o Participante</a><img id="anoparticipante" src="../img/icons/accept.png" style="display:none;"/></td>
				   <td><a href="javascript:agregarorden('convivencia','Convivencia');">Convivencia</a><img id="convivencia" src="../img/icons/accept.png" style="display:none;"/></td>
				   <td>
				   </td>
				</tr>			
				</table>
				</div>
								
			</div>				
			<div class="clear"></div>						
			<div class="span-2">
			<p>
			<input type="button" id="buscar_reporte" name="buscar_reporte" value="Buscar"/>						
			</p>
			</div>
			
			<div class="span-3">
			<p>
			<label for="convanoinicio">Mostrar Foto : </label><input type="checkbox" id="desplegar_foto" />				
			</p>
			</div>
		</fieldset>		
        <fieldset><legend id="participante_reportes">Reportes Varios</legend>	
		<label style="float:right;">Imprimir Reporte<img style="cursor:pointer;" src="../img/print_32.png" onclick="javascript: imprimirreporte();"/></label>		
		<div class="scroll">		     
		     <table>
             <thead>			   
			   <th>Foto</th>			         	   			   
               <th width="20%">Nombre-CURP</th>			   
			   <th width="40%">Modalidad-Deporte-Categoria-Pruebas</th>
			   <th width="35%">Datos Adicionales</th>
			   <th width="5%" style="text-align:center;">Descartar<br /><img id = "descartartodas" style="cursor:pointer;" onclick="javascript: cambiarestadotodas();" src="../img/icons/accept.png" /></th>			   
             </thead>		 
             <tbody id="datos_participante">			 		 		 
			 </tbody>			  		 
             </table>		       
		</div>	  	    
		</fieldset>
	</div>
    
    <div id="footer">
   		<p>&copy; <?php echo date("Y"); ?> <a title="QSERVICE - Integrate" href="#" target="_blank">QSERVICE - Integrate</a> &reg;  - Todos los Derechos Reservados - Desarrollado por <a title="Reality in a digital world" href="#" target="_blank">- Empresa Autorizada -</a></p>
	</div>    
	
	
</div>    
</body>
</html>
