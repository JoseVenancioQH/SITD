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
<link rel="stylesheet" href="../css/jquery.jgrowl.css" type="text/css" />
<link rel="stylesheet" type="text/css" media="screen" href="../grid/themes/redmond/jquery-ui-1.8.2.custom.css" />
<link rel="stylesheet" type="text/css" media="screen" href="../grid/themes/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="../grid/themes/ui.multiselect.css" />
<link rel="stylesheet" type="text/css" href="../css/jquery.Jcrop.css" />


<!--[if IE]><link rel="stylesheet" href="../css/ie.css" type="text/css" media="screen, projection"><![endif]-->
<script type="text/javascript" src="../js/jquery-1.3.1.js"></script>
<script type="text/javascript" src="../js/jquery.checkboxes.js"></script>  
<script type="text/javascript" src="../js/controller-unBlock.js" ></script>
<script type="text/javascript" src="../js/controller-reportesvarios.js"></script>
<script type="text/javascript" src="../js/controller-general.js"></script>
<script type="text/javascript" src="../js/jquery.blockUI.js" ></script>
<script type="text/javascript" src="../js/seekAttention.jquery.js" ></script>
<script type="text/javascript" src="../js/jquery.AjaxUpload.js" ></script>
<script type="text/javascript" src="../js/jquery.growl.js" ></script>
<script type="text/javascript" src="../js/jquery.highlightFade.js"></script>
<script type="text/javascript" src="../js/jquery-ui-personalized-1.6rc6.js"></script>
<script type="text/javascript" src="../grid/src/i18n/grid.locale-es.js" ></script>
<script type="text/javascript" src="../js/jquery.Jcrop.js"></script>

<script type="text/javascript">
$.jgrid.no_legacy_api = true;
$.jgrid.useJSON = true;
</script>
<script src="../grid/js/jquery.jqGrid.min.js" type="text/javascript"></script>
<script src="../grid/js/jquery-ui-1.8.2.custom.min.js" type="text/javascript"></script>
</head>
<body>
<!--<body onLoad="javascript:$('#accordion').css('visibility','visible'); resetvalores();">-->
<div class="container">    
    <div id="header">
   	  <div id="user_id">Bienvenido <?php echo $_SESSION["nombre"]; ?> | <a title="salir del sistema" href="../scripts/close-session.php">Salir</a></div><br /><div style="float:right; margin-right:20px;"><?php echo $_SESSION["nombreevento"]; ?></div>
	  <h1><img alt="QSERVICE - Integrate" src="../img/logo.png" /> RED - - Empresa Autorizada -</h1>
     </div>
    
    <div id="navegacion"> 
       <ul id="menu">
        <?php
			$seccion = "reportes";
			include("../scripts/menu.php");
        ?>       
        </ul>             
            <ul id="submenu">
                <?php
			        $seccion = "reportes";
			        include("../scripts/menu-reporte.php");
                ?>
            </ul>            
    </div>
    
    <div id="dialog_editar_imagen" title="Editar Imagen">
    <!-- This is the image we're attaching Jcrop to -->
    <table class="nospace" style=" font-size:8px;">
    <tr><td><input name="foto" type="radio"  id="foto_original"/>Original</td><td></td></tr>
    <tr><td><input name="foto" type="radio"  id="foto_comprimida" checked="checked"/>Comprimida</td><td></td></tr>
    <tr class="space"><td></td><td></td></tr>
    <tr><td>Editar</td><td>Resultado Editada</td></tr>
    <tr>
     <td class="nospace">
       <table  class="nospace">
          <tr>
          <td id="cropbox_td">
          <div style="width:auto;height:auto;overflow:hidden;">    
           <img id="cropbox_cargando" src="../img/cargando.gif"/>
           <img id="cropbox" src="../img/foto.png"/>
          </div> 
          </td>
          <td>
              <table class="nospace">
                <tr>
                  <td>
                  Ancho Original:<br />
                  <input id="ancho_original" type="text" value="70" size="6" disabled="disabled"/>
                  </td>
                </tr>  
                <tr>
                  <td>
                  Alto original:<br />
                  <input id="alto_original" type="text" value="90" size="6" disabled="disabled"/>
                  </td>
                </tr>
              </table>
          </td>
          </tr>
       </table>  
     </td>    
     <td class="nospace"> 
       <table class="nospace">      
        <tr>        
          <td id="preview_td">
             <div style="width:70px;height:90px;overflow:hidden;">             
                <img id="preview" src="../img/foto.png"/>
             </div>                   
          </td>   
           
          <td>
              <table class="nospace">
              <tr>
                <td>
               <!-- Ancho Nuevo:<br />
                <input id="ancho_nuevo" type="text" value="71" size="6"/>-->
                </td>
                
                
                <td>
                 <table class="nospace">
                   <tr>
                    <td style="text-align:left; vertical-align:middle;"><!--<img class="menos" src="../img/flecha_izquierda.png" onclick="javascript:w_menos();"/>--></td>                    
                   </tr>
                 </table>
                </td>
      
                <td>
                 <table class="nospace">
                   <tr>                    
                    <td style="text-align:right; vertical-align:middle;"><!--<img class="mas" src="../img/flecha_derecha.png" onclick="javascript:w_mas();"/>--></td>
                   </tr>
                 </table>
                </td>
                
                
              </tr>  
              <tr>
                <td>
                <!--Alto Nuevo:<br />
                <input id="alto_nuevo" type="text" value="100" size="6"/>-->
                </td>
                
                <td>
                 <table class="nospace">
                   <tr>
                    <td style="text-align:left; vertical-align:middle;"><!--<img class="menos" src="../img/flecha_izquierda.png" onclick="javascript:h_menos();"/>--></td>                   
                   </tr>
                 </table>
                </td>
      
                <td>
                 <table class="nospace">
                   <tr>                    
                    <td style="text-align:right; vertical-align:middle;"><!--<img class="mas" src="../img/flecha_derecha.png" onclick="javascript:h_mas();"/>--></td>
                   </tr>
                 </table>
                </td>                
               
              </tr>
              </table>
          </td>                                        
        </tr> 
        
       </table>    
      </td>
    </tr>
    
    <tr><td colspan="2">Coordenada y Medida Original</td><td></td></tr>
    
    <tr>
     <td colspan="2">
      <table><tr>
      <td style="text-align:center;">XSup:<br />
          <input id="x1" type="text" size="4" disabled="disabled"/></td>
      <td style="text-align:center;">YSup:<br />
          <input id="y1" type="text" size="4" disabled="disabled"/></td>
      <td style="text-align:center;">XInf:<br />
          <input id="x2" type="text" size="4" disabled="disabled"/></td>
      <td style="text-align:center;">yInf:<br />
          <input id="y2" type="text" size="4" disabled="disabled"/></td>
      <td style="text-align:center;">Ancho:<br />
          <input id="w" type="text" size="4" disabled="disabled"/></td>
      <td style="text-align:center;">Alto:<br />
          <input id="h" type="text" size="4" disabled="disabled"/></td>        
      </tr></table>    
     </td>
     <td></td>     
    </tr>
    
    <tr>
     <td colspan="2">
     
      <table class="nospace"><tr>        
      
      
      </tr></table>    
     </td>
     <td></td>     
     
    </tr>
    </table>
    </div>   
    
     <div id="form">
            <h2>Reportes Varios</h2>	
            
            <ul id="navigation">
    
            <li id="ayuda_imprimir_validar_div" style="font-size:9px;">
            <!--<div id="grabar_participante_div" style="float:right; font-size:8px; margin-left:5px;">-->
            <a href="../help/Validar/ValidarParticipante.html" target="_blank" style="cursor:pointer; text-decoration:none;">
            <table class="nospace"><tr><td style="text-align:center;">
            <img style="vertical-align:middle; cursor:pointer;" alt="Ayuda Validar Participante" src="../img/ayuda.png"/>
            </td></tr>
            <tr><td style="text-align:center;">
            <span style="vertical-align:middle; text-align:center;">Ayuda Validar<br />Participante</span>
            </td></tr></table>
            </a>
            <!--</div>-->
            </li>                
            
            <li id="imprimir_resumen_div" style="font-size:9px;">
            <!--<div id="grabar_participante_div" style="float:right; font-size:8px; margin-left:5px;">-->
            <a onclick="javascript:ImprimirReporte('resumen');" style="cursor:pointer; text-decoration:none;">
            <table class="nospace"><tr><td style="text-align:center;">
            <img id="imprimirresumen" style="vertical-align:middle; cursor:pointer;" alt="Imprimir Resumen" src="../img/imprimir_cedula.png"/>
            </td></tr>
            <tr><td style="text-align:center;">
            <span style="vertical-align:middle; text-align:center;">Imprimir<br />Resumen</span>
            </td></tr></table>
            </a>
            <!--</div>-->
            </li>            
            
            <li id="imprimir_sincategoria_div" style="font-size:9px;">
            <!--<div id="grabar_participante_div" style="float:right; font-size:8px; margin-left:5px;">-->
            <a onclick="javascript:ImprimirReporte('sincategoria');" style="cursor:pointer; text-decoration:none;">
            <table class="nospace"><tr><td style="text-align:center;">
            <img id="imprimirsincategoria" style="vertical-align:middle; cursor:pointer;" alt="Imprimir Sin Categoria" src="../img/imprimir_cedula.png"/>
            </td></tr>
            <tr><td style="text-align:center;">
            <span style="vertical-align:middle; text-align:center;">Imprimir<br />Sin Categoria</span>
            </td></tr></table>
            </a>
            <!--</div>-->
            </li>
            
            <li id="imprimir_singenerales_div" style="font-size:9px;">
            <!--<div id="grabar_participante_div" style="float:right; font-size:8px; margin-left:5px;">-->
            <a onclick="javascript:ImprimirReporte('singenerales');" style="cursor:pointer; text-decoration:none;">
            <table class="nospace"><tr><td style="text-align:center;">
            <img id="imprimirsingenerales" style="vertical-align:middle; cursor:pointer;" alt="Imprimir Sin Generales" src="../img/imprimir_cedula.png"/>
            </td></tr>
            <tr><td style="text-align:center;">
            <span style="vertical-align:middle; text-align:center;">Imprimir<br />Sin Generales</span>
            </td></tr></table>
            </a>
            <!--</div>-->
            </li>
            
            <li id="imprimir_fotos_div" style="font-size:9px;">
            <!--<div id="grabar_participante_div" style="float:right; font-size:8px; margin-left:5px;">-->
            <a onclick="javascript:ImprimirReporte('fotos');" style="cursor:pointer; text-decoration:none;">
            <table class="nospace"><tr><td style="text-align:center;">
            <img id="imprimirfotos" style="vertical-align:middle; cursor:pointer;" alt="Imprimir Fotos" src="../img/imprimir_cedula.png"/>
            </td></tr>
            <tr><td style="text-align:center;">
            <span style="vertical-align:middle; text-align:center;">Imprimir<br />Fotos</span>
            </td></tr></table>
            </a>
            <!--</div>-->
            </li>
            
            <li id="imprimir_completo_div" style="font-size:9px;">
            <!--<div id="grabar_participante_div" style="float:right; font-size:8px; margin-left:5px;">-->
            <a onclick="javascript:ImprimirReporte('completo');" style="cursor:pointer; text-decoration:none;">
            <table class="nospace"><tr><td style="text-align:center;">
            <img id="imprimircompleto" style="vertical-align:middle; cursor:pointer;" alt="Imprimir Completo" src="../img/imprimir_cedula.png"/>
            </td></tr>
            <tr><td style="text-align:center;">
            <span style="vertical-align:middle; text-align:center;">Imprimir<br />Reporte Completo</span>
            </td></tr></table>
            </a>
            <!--</div>-->
            </li> 
                        
            <li id="descargar_fotos_div" style="font-size:9px;">
            <!--<div id="grabar_participante_div" style="float:right; font-size:8px; margin-left:5px;">-->
            <a onclick="javascript:ImprimirReporte('DescargarFotos');" style="cursor:pointer; text-decoration:none;">
            <table class="nospace"><tr><td style="text-align:center;">
            <img id="descargarfoto" style="vertical-align:middle; cursor:pointer;" alt="Descargar Foto" src="../img/descargar_archivo.png"/>
            </td></tr>
            <tr><td style="text-align:center;">
            <span style="vertical-align:middle; text-align:center;">Descargar<br />Fotos</span>
            </td></tr></table>
            </a>
            <!--</div>-->
            </li>     
            
            </ul>
            
            
            <div id="accordion">
            <h3><a><span id="span-titulo">Filtro Y Orden ( ) de Busqueda</span></a></h3>            
            <div>      
            
            <div class="span-7">
            <p>
            <label for="evento">Evento: <input type="checkbox" id="solovalidados" checked="checked"/>Solo Validados</label>
            <?php generaeventos("evento",$_SESSION['evento']); ?>				
            </p>
            </div>
            
            <div class="span-7">
            <p>
            <label for="municipio"><a style="cursor:pointer; text-decoration:none;" class="ordenar_rep" id="municipio_ordenar">Municipio</a>: </label>
            <?php generamunicipio("municipio",$_SESSION["municipio"],' cselect validate[required]');?>				
            </p>
            </div>
                       
            <div class="span-5" style="text-align:left;">
            <p>
            <label for="modalidad"><a style="cursor:pointer; text-decoration:none;" class="ordenar_rep" id="modalidad_ordenar">Modalidad</a>: </label>
            <?php generamodalidad("modalidad_registro"); ?>				
            </p>
            </div>           
            
            <div class="clear"></div>
               
            <div class="span-5" style="text-align:left;">
            <p>
            <label for="nombredeporte_buscar"><a style="cursor:pointer; text-decoration:none;" class="ordenar_rep" id="deporte_ordenar">Deporte</a>: </label>
            <?php generadeporte("deportes_registro"); ?>				
            </p>
            </div>
            
            <div class="span-10" id="categoria_registro">		
            <p>
            <label for="categoria"><a style="cursor:pointer; text-decoration:none;" class="ordenar_rep" id="categoria_ordenar">Categoria</a>: </label>		
            <select name='selectcategoria_registro' id='selectcategoria_registro' class='span-10 cselect' disabled='disabled'>
            <option value='' selected>Ninguno</option>
            </select>					 	 
            </p>					
            </div>
            
                       
            
            <div class="clear"></div>
            
            
            
            <div class="span-6">
            <p>
            <label for="anoinicio"><a style="cursor:pointer; text-decoration:none;" class="ordenar_rep" id="anonacimiento_ordenar_1">Participante A&ntilde;o Inicio</a>: </label>
            <?php generaanoinicio("anoinicio"); ?>				
            </p>
            </div>
            
            <script type="text/javascript">
                    $("#anoinicio option[value="+""+"]").text('Todos');
            </script>
            
            <div class="span-6">
            <p>
            <label for="anofin"><a style="cursor:pointer; text-decoration:none;" class="ordenar_rep" id="anonacimiento_ordenar_2">Participante A&ntilde;o Fin</a>: </label>
            <?php generaanofin("anofin"); ?>				
            </p>
            </div>
            
            <script type="text/javascript">
                    $("#anofin option[value="+""+"]").text('Todos');
                    $("#anofin").attr('disabled',true);
            </script>
            
            <div class="span-6">
            <p>
            <label for="convanoinicio"><a style="cursor:pointer; text-decoration:none;" class="ordenar_rep" id="anonacimiento_ordenar">A&ntilde;o Convivencia</a>: </label>
            <?php generaanofin("convanoinicio"); ?>				
            </p>
            </div>
            
            <div class="clear"></div>          
            
            <div class="span-3" style="text-align:left;">
            <p>
            <label for="sexo"><a style="cursor:pointer; text-decoration:none;" class="ordenar_rep" id="sexo_ordenar">Sexo</a>: </label>
            <select name="sexo_registro" id= "sexo_registro"  class="validate[required] span-3 cselect" >
             <option value="">Ninguno       </option>
             <option value="H">Hombre    </option>
             <option value="M">Mujer     </option>		   		 
             </select>				
            </p>
            </div>
            
            <div class="span-4">
            <p>
            <label for="nombres"><a style="cursor:pointer; text-decoration:none;" class="ordenar_rep" id="nombres_ordenar">Nombres</a>: </label>
            <input alt="Nombres" class="validate[required] span-4 text mayuscula"  id="nombres_registro" name="nombres_registro" type="text"/>				
            </p>
            </div>
            
            <div class="span-4">
            <p>
            <label for="appaterno"><a style="cursor:pointer; text-decoration:none;" class="ordenar_rep" id="appaterno_ordenar">Ap. Paterno</a>: </label>
            <input  alt="Apellido Paterno" class="validate[required] span-4 text mayuscula" id="appaterno_registro" name="appaterno_registro" type="text" value=""/>				
            </p>
            </div>
                        
            <div class="span-4">
            <p>
            <label for="apmaterno"><a style="cursor:pointer; text-decoration:none;" class="ordenar_rep" id="apmaterno_ordenar">Ap. Materno</a>: </label>
            <input alt="Apellido Materno" class="validate[required] span-4 text mayuscula" id="apmaterno_registro" name="apmaterno_registro" type="text"/>				
            </p>
            </div>
            
            <div class="span-2" style="margin-top:30px;">          
            <input id="buscar_registro" name="buscar_registro" type="button" value="Bucar"/>				
            </div>      
           
            </div>                   
           
            <div class="clear"></div>     
            <div id="listreportes_div">
            <table id="listreportes"></table>               
            <div id="listreportespager"></div>
            </div>
            
            <div class="clear"></div>            
                        	
             <!--<fieldset><legend>Datos de Busqueda<img style="cursor:pointer;" src="../img/icons/trash.png" onclick="javascript:resetvalores();"/></legend>		 
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
				<?php /*?><?php generaeventos("evento",$_SESSION['evento']); ?>	<?php */?>			
				</p>
				</div>
				
				<div class="span-7">
				<p>
				<label for="municipio">Municipio: </label>
				<?php /*?><?php generamunicipio("municipio",$_SESSION["municipio"],' cselect');?>	<?php */?>			
				</p>
				</div>
				
				<script type="text/javascript">
				        $("#municipio option[value="+""+"]").text('Todas');
						$("#municipio").attr('disabled',false);
				</script> 		
								
				<div class="span-7">
				<p>
				<label for="modalidad">Modalidad: </label>
				<?php /*?><?php generamodalidad("modalidad"); ?><?php */?>				
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
				<?php /*?><?php generadeporte("deportes"); ?>	<?php */?>			
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
				<?php /*?><?php generaanoinicio("anoinicio"); ?><?php */?>				
				</p>
				</div>
				
				<script type="text/javascript">
				        $("#anoinicio option[value="+""+"]").text('Todos');
				</script>
				
				<div class="span-6">
				<p>
				<label for="anofin">Participante A&ntilde;o Fin: </label>
				<?php /*?><?php generaanofin("anofin"); ?><?php */?>				
				</p>
				</div>
				
				<script type="text/javascript">
				        $("#anofin option[value="+""+"]").text('Todos');
						$("#anofin").attr('disabled',true);
				</script>
				
				<div class="span-4">
				<p>
				<label for="convanoinicio">A&ntilde;o de Convivencia : </label>
				<?php /*?><?php generaanoinicio("convanoinicio"); ?><?php */?>				
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
        <fieldset><legend id="participante_validados">Validar Participante</legend>	
		<label style="float:right;"><a href="javascript: actualizarcambios();" >Actualizar Cambios</a><img style="cursor:pointer;" src="../img/refresh.png" onclick="javascript: actualizarcambios();"/></label>		
		<div class="scroll_largo">		     
		     <table>
             <thead>			   
			   <th width="5%">Foto</th>			         	   			   
               <th width="25%">Nombre-CURP</th>			   
			   <th width="35%">Modalidad-Deporte-Categoria-Pruebas <img id="validar_todos" onclick="javascript:validartodos();" style="cursor:pointer;" src="../img/no.png"/><a href="javascript:validartodos();" >Val. Todos</a></th>
			   <th width="35%">Documentaci&oacute;n <img id="documentos_todos" onclick="javascript:documentostodos();" style="cursor:pointer;" src="../img/no.png"/><a href="javascript:documentostodos();" >Doc. Todos</a></th>			      
             </thead>		 
             <tbody id="datos_participante">			 		 		 
			 </tbody>			  		 
             </table>		       
		</div>	  	    
		</fieldset>-->
	</div>
    
    <div id="footer">
   		<p>&copy; <?php echo date("Y"); ?> <a title="QSERVICE - Integrate" href="#" target="_blank">QSERVICE - Integrate</a> &reg;  - Todos los Derechos Reservados - Desarrollado por <a title="Reality in a digital world" href="#" target="_blank">- Empresa Autorizada -</a></p>
	</div>    
	
	
</div>    
</body>
</html>

