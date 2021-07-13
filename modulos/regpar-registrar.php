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
<title>Registro de Participantes | Registro Estatal de Deporte - QSERVICE - Integrate</title>
<link rel="stylesheet" href="../css/screen.css" type="text/css" media="screen, projection">
<link type="text/css" href="../css/theme/ui.all.css" rel="Stylesheet" />
<link rel="stylesheet" href="../css/validationEngine.jquery.css" type="text/css" media="screen" charset="utf-8" />
<link rel="stylesheet" href="../css/datepicker.css" type="text/css" />
<link rel="stylesheet" href="../css/jquery.jgrowl.css" type="text/css" />
<link rel="stylesheet" type="text/css" media="screen" href="../grid/themes/redmond/jquery-ui-1.8.2.custom.css" />
<link rel="stylesheet" type="text/css" media="screen" href="../grid/themes/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="../grid/themes/ui.multiselect.css" />
<link rel="stylesheet" type="text/css" href="../css/jquery.Jcrop.css" />

<script type="text/javascript" src="../js/jquery-1.3.1.js"></script>
<script type="text/javascript" src=s"../js/jquery.highlightFade.js"></script>
<script type="text/javascript" src="../js/jquery-ui-personalized-1.6rc6.js"></script> 
<script type="text/javascript" src="../js/jquery.checkboxes.js"></script> 
 
<script type="text/javascript" src="../js/controller-general.js"></script>
<script type="text/javascript" src="../js/controller-unBlock.js" ></script>
<script type="text/javascript" src="../js/controller-registroparticipante.js"></script>
<script type="text/javascript" src="../js/controller-generacurp.js" ></script>

<script type="text/javascript" src="../js/jquery.validationEngine.js"></script>
<script type="text/javascript" src="../js/jquery.blockUI.js" ></script>
<script type="text/javascript" src="../js/jquery.maskedinput-1.2.2.js" ></script>
<script type="text/javascript" src="../js/seekAttention.jquery.js" ></script>
<script type="text/javascript" src="../js/jquery.AjaxUpload.js" ></script>
<script type="text/javascript" src="../js/jquery.growl.js" ></script>
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
			        $seccion = "registrar";
			        include("../scripts/menu-regparticipantes.php");
                ?>
            </ul>            
    </div>        
    
    <div id="dialog_editar_imagen" title="Editar Imagen" style="display:none;">
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
    
    
    <div id="dialog_renovar_participante" title="Renovar Participante">    
      <div class="span-4" style="text-align:left;">
      <p>
      <label for="modalidad">Modalidad: </label>
      <?php generamodalidad("modalidad_buscar"); ?>				
      </p>
      </div>
         
      <div class="span-5" style="text-align:left;">
      <p>
      <label for="nombredeporte_buscar">Deporte: </label>
      <?php generadeporte("deportes_buscar"); ?>				
      </p>
      </div>
      
      <div class="span-3" style="text-align:left;">
      <p>
      <label for="ano">A&ntilde;o: </label>
      <select name="ano_buscar" id= "ano_buscar"  class="span-3 cselect" >
       <option value="">Ninguno       </option>
       <option value="2005">2005      </option>
       <option value="2004">2004      </option>
       <option value="2003">2003      </option>
       <option value="2002">2002      </option>
       <option value="2001">2001      </option>
       <option value="2000">2000      </option>
       <option value="1999">1999      </option>
       <option value="1998">1998      </option>
       <option value="1997">1997      </option>
       <option value="1996">1996      </option>
       <option value="1995">1995      </option>
       <option value="1994">1994      </option>
       <option value="1993">1993      </option>
       <option value="1992">1992      </option>
       <option value="1991">1991      </option>
       <option value="1990">1990      </option>
       <option value="1989">1989      </option>
       <option value="1988">1988      </option>
       <option value="1987">1987      </option>
       <option value="1986">1986      </option>
       <option value="1985">1985      </option>
       <option value="1984">1984      </option>
       <option value="1983">1983      </option>
       <option value="1982">1982      </option>
       <option value="1981">1981      </option>
       <option value="1980">1980      </option>		   		 
       </select>				
      </p>
      </div>
      
      
      <div class="span-3" style="text-align:left;">
      <p>
      <label for="sexo">Sexo: </label>
      <select name="sexo_buscar" id= "sexo_buscar"  class="validate[required] span-3 cselect" >
       <option value="">Ninguno       </option>
       <option value="H">Hombre    </option>
       <option value="M">Mujer     </option>		   		 
       </select>				
      </p>
      </div>
      
      <div class="span-3">
      <p>
      <label for="nombres">Nombres: </label>
      <input alt="Nombres" class="validate[required] span-3 text mayuscula"  id="nombres_buscar" name="nombres_buscar" type="text"/>				
      </p>
      </div>
      
      <div class="span-3">
      <p>
      <label for="appaterno">Ap. Paterno: </label>
      <input  alt="Apellido Paterno" class="validate[required] span-3 text mayuscula" id="appaterno_buscar" name="appaterno_buscar" type="text" value=""/>				
      </p>
      </div>
                  
      <div class="span-3">
      <p>
      <label for="apmaterno">Ap. Materno: </label>
      <input alt="Apellido Materno" class="validate[required] span-3 text mayuscula" id="apmaterno_buscar" name="apmaterno_buscar" type="text"/>				
      </p>
      </div>
      
      <div class="span-2" style="margin-top:30px;">          
      <input id="buscar_renovar" name="buscar_renovar" type="button" value="Bucar"/>				
      </div>
      
      <div class="clear"></div>     
      
      <table id="list4"></table> 
      <div id="list4pager"></div> 
      
       <div class="clear"></div>
       
       <div id="insertBefore_categoria"></div>
      
    </div>
	   
    
    <ul id="navigation">
    
    <li id="limpiar_form_div" style="font-size:9px;">
    <!--<div  style="float:right; font-size:8px; margin-left:5px;">-->
    <a onclick="javascript:LimpiarCamposForm();" style="cursor:pointer; text-decoration:none;">
    <table class="nospace"><tr><td style="text-align:center;">
    <img id="limpiarcamposform" style="vertical-align:middle; cursor:pointer;" alt="Inicializar Captura" src="../img/limpiar_total.png"/>
    </td></tr>
    <tr><td style="text-align:center;">
    <span style="vertical-align:middle; text-align:center;">Inicializar<br />Captura</span>
    </td></tr></table>
    </a>
    <!--</div>--> 
    </li>
    
    <li id="cancelar_actualizar_div" style="font-size:9px; display:none;">
    <!--<div id="cancelar_actualizar_div" style="float:right; font-size:8px; margin-left:5px; display:none;">-->
    <a onclick="javascript:CancelarActualizacion();" style="cursor:pointer; text-decoration:none;">
    <table class="nospace"><tr><td style="text-align:center;">
    <img id="cancelaractualizacion" style="vertical-align:middle; cursor:pointer;" alt="Cancelar Actualizaci&oacute;n" src="../img/cancelar_actualizacion.png"/>
    </td></tr>
    <tr><td style="text-align:center;">
    <span style="vertical-align:middle; text-align:center;">Cancelar<br />Actualizaci&oacute;n</span>
    </td></tr></table>
    </a>
    <!--</div>-->
    </li>
    
    <li id="actualizar_participante_div" style="font-size:9px; display:none;">
    <!--<div id="actualizar_participante_div" style="float:right; font-size:8px; margin-left:5px; display:none;">-->
    <a onclick="javascript:ActualizarParticipante_Submit();" style="cursor:pointer; text-decoration:none;">
    <table class="nospace"><tr><td style="text-align:center;">
    <img id="actualizarparticipante" style="vertical-align:middle; cursor:pointer;" alt="Actualizar Participante" src="../img/actualizar_participante.png"/>
    </td></tr>
    <tr><td style="text-align:center;">
    <span style="vertical-align:middle; text-align:center;">Actualizar<br />Participantes</span>
    </td></tr></table>
    </a>
    <!--</div>-->
    </li>
    
    <li id="grabar_participante_div" style="font-size:9px;">
    <!--<div id="grabar_participante_div" style="float:right; font-size:8px; margin-left:5px;">-->
    <a onclick="javascript:GrabarParticipante_submit();" style="cursor:pointer; text-decoration:none;">
    <table class="nospace"><tr><td style="text-align:center;">
    <img id="grabarparticipante_submit" style="vertical-align:middle; cursor:pointer;" alt="Grabar Participante" src="../img/grabar_participante.png"/>
    </td></tr>
    <tr><td style="text-align:center;">
    <span style="vertical-align:middle; text-align:center;">Grabar<br />Participantes</span>
    </td></tr></table>
    </a>
    <!--</div>-->
    </li>    
    </ul>

    
    
    
    <div id="form">      
            <!-- <div id="limpiar_form_div" style="float:right; font-size:8px; margin-left:5px;">
             <a onclick="javascript:LimpiarCamposForm();" style="cursor:pointer; text-decoration:none;">
             <table class="nospace"><tr><td style="text-align:center;">
             <img id="limpiarcamposform" style="vertical-align:middle; cursor:pointer;" alt="Inicializar Captura" src="../img/limpiar_total.png"/>
             </td></tr>
             <tr><td style="text-align:center;">
             <span style="vertical-align:middle; text-align:center;">Inicializar<br />Captura</span>
             </td></tr></table>
             </a>
             </div> 
    
             <div id="cancelar_actualizar_div" style="float:right; font-size:8px; margin-left:5px; display:none;">
             <a onclick="javascript:CancelarActualizacion();" style="cursor:pointer; text-decoration:none;">
             <table class="nospace"><tr><td>
             <img id="cancelaractualizacion" style="vertical-align:middle; cursor:pointer;" alt="Cancelar Actualizaci&oacute;n" src="../img/cancelar_actualizacion.png"/>
             </td></tr>
             <tr><td style="text-align:center;">
             <span style="vertical-align:middle; text-align:center;">Cancelar<br />Actualizaci&oacute;n</span>
             </td></tr></table>
             </a>
             </div>
             
             <div id="actualizar_participante_div" style="float:right; font-size:8px; margin-left:5px; display:none;">
             <a onclick="javascript:ActualizarParticipante_Submit();" style="cursor:pointer; text-decoration:none;">
             <table class="nospace"><tr><td>
             <img id="actualizarparticipante" style="vertical-align:middle; cursor:pointer;" alt="Actualizar Participante" src="../img/actualizar_participante.png"/>
             </td></tr>
             <tr><td style="text-align:center;">
             <span style="vertical-align:middle; text-align:center;">Actualizar<br />Participantes</span>
             </td></tr></table>
             </a>
             </div>
             
             <div id="grabar_participante_div" style="float:right; font-size:8px; margin-left:5px;">
             <a onclick="javascript:GrabarParticipante_submit();" style="cursor:pointer; text-decoration:none;">
             <table class="nospace"><tr><td>
             <img id="grabarparticipante_submit" style="vertical-align:middle; cursor:pointer;" alt="Grabar Participante" src="../img/grabar_participante.png"/>
             </td></tr>
             <tr><td style="text-align:center;">
             <span style="vertical-align:middle; text-align:center;">Grabar<br />Participantes</span>
             </td></tr></table>
             </a>
             </div>-->
             
             
             
             <h2>Agregar Participante</h2>
             <!-- <div style="width:60px; font-size:8px; text-align:center; height:auto; float:right;">
                <img id="buscarparticipante" style="vertical-align:middle; cursor:pointer; text-align:center;" alt="Busca Participante" src="../img/buscar.png" /><p>Buscar <br />Participante</p>
              </div>-->              
             
             
             <br />
			 <form name="grabar-participante" id="grabar-participante" method="post" action="">             	
             <!--<div style="width:100%; height:auto; float:left; margin-bottom:20px;">
              <div style="width:60px; font-size:8px; text-align:center; height:auto; float:right;">
                <img style="text-align:center;" src="../img/buscar.png" /><p>Buscar <br />Participante</p>
              </div>                
             </div>-->             
             <fieldset><legend>Datos del Registro <img alt="Limpia Datos de Registro" style="vertical-align:middle; cursor:pointer;" src="../img/icons/trash.png" onclick="javascript:limpiarregistro();"/></legend>	 
			
			    <div class="span-7">
				<p>
				<label for="evento">Evento: </label>
				<?php generaeventos("evento",$_SESSION['evento']); ?>				
				</p>
				</div>
				
				<div class="span-7">
				<p>
				<label for="municipio">Municipio: </label>
				<?php generamunicipio("municipio",$_SESSION["municipio"],' cselect validate[required]');?>				
				</p>
				</div>
				
				<div class="span-7">
				<p>
				<label for="modalidad">Modalidad: </label>
				<?php generamodalidad("modalidad"); ?>				
				</p>
				</div>
				
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
				</fieldset>			
               
				<fieldset id="fieldsetcategoria" style="display:none;"><legend>Datos de Categoria <img alt="Limpia Datos de Categoria" style="vertical-align:middle; cursor:pointer;" src="../img/icons/trash.png" onclick="javascript:limpiarcategoria();"/></legend><div  style="float:right; font-size:9px; margin-top:-40px; margin-right:-10px;"><a onclick="javascript:AgregarCategoria();" style="cursor:pointer; text-decoration:none;"><span style="vertical-align:bottom;">Agregar Categoria</span></a><img id="agregarcategoria" style="vertical-align:middle; cursor:pointer;" alt="Agregar Categoria" src="../img/add.png" onclick="javascript:AgregarCategoria();" /><img id="limpiarcategorias" style="vertical-align:middle; cursor:pointer; display:none;" alt="Limpiar Categorias" src="../img/trash.png" onclick="javascript:LimpiarCategorias();" /></div>		
				
			    <div class="span-7">
				<p>
				<label for="nombredeporte">Deporte: </label>
				<?php generadeporte("deportes"); ?>				
				</p>
				</div>				
				
				<div class="span-12" id="categoria">		
				<p>
				<label for="categoria">Categoria: </label>		
				<select name='selectcategoria' id='selectcategoria' class='span-12 cselect' disabled='disabled'>
			    <option value='' selected>Ninguno</option>
			    </select>					 	 
				</p>					
				</div>          
                
				<div class="clear"></div>
				
				<label for="pruebas" id="titulo_prueba">Pruebas: <input type="checkbox" id="sinpruebas"/> Sin Pruebas</label>				
				<div id="pruebas" style="width:100%; margin-bottom:30px;"></div>
                		
				
				<!--<div class="span-4" id="categoria">					
				<p>
				<input class="span-4" id="agregar-categoria" name="agregar-categoria" type="button" value="Agregar Categoria"/>	 	 
				</p>					
				</div>-->
				
				<!--<input id="pruebas-text" name="pruebas-text" type="hidden"/>-->
				
				<!--<div class="scroll2">
				 <table>
				 <thead>
				   <th style="display:none;">idcategoria</th>				   
				   <th>Deporte</th>
				   <th>Categoria</th>
				   <th>Pruebas</th>				   			   
				   <th>Eliminar</th>				   
				 </thead>		 
				 <tbody id = "lista_categorias">		 		 
				 </tbody>			  		 
				 </table>	    
			    </div>-->               
                
                <div class="clear"></div>     
                <div id="listacategoria_div" style="display:none;">
                <table id="listcategoria"></table> 
                              
                </div>
                
                <div class="clear"></div>              
                
				</fieldset>              
				
				<fieldset id="datos_generales"><legend>Datos Generales del Participante <img alt="Limpia Datos de Participante" style="vertical-align:middle; cursor:pointer;" src="../img/icons/trash.png" onclick="javascript:LimpiarDatosParticipante();"/></legend>
                <div id="selparticipante_div" style="float:right; font-size:9px; margin-top:-40px; margin-right:-10px;"><a onclick="javascript:RenovarParticipante();" style="cursor:pointer; text-decoration:none;"><span id ="selpart" style="vertical-align:bottom;">Seleccionar Participantes</span></a><img id="renovarparticipante" style="vertical-align:middle; cursor:pointer;" alt="Registro por Lote" src="../img/grabar_20.png" onclick="javascript:RenovarParticipante();" /><img id="limpiarparticipante" style="vertical-align:middle; cursor:pointer; display:none;" alt="Registro por Lote" src="../img/trash.png" onclick="javascript:LimpiarParticipante();" /></div>				
				<!--<div style="width:60px; font-size:8px; text-align:center; height:auto; float:right;">
                <img id="renovarparticipante" style="vertical-align:middle; cursor:pointer; text-align:center;" alt="Registro por Lote" src="../img/grabar_20.png" onclick="javascript:RenovarParticipante();" />--><!--<p>Renovar Registros Por <br />Lotes</p>-->
              <!--</div>-->
			    <div class="divocultar span-4">
				<p>
				<label for="nombres">Nombres: </label>
				<input alt="Nombres" class="validate[required] span-4 text mayuscula"  id="nombres" name="nombres" type="text"/>				
				</p>
				</div>
				
				<div class="divocultar span-3">
				<p>
				<label for="appaterno">Apellido Paterno: </label>
				<input  alt="Apellido Paterno" class="validate[required] span-3 text mayuscula" id="appaterno" name="appaterno" type="text" value=""/>				
				</p>
				</div>
							
				<div class="divocultar span-3">
				<p>
				<label for="apmaterno">Apellido Materno: </label>
				<input alt="Apellido Materno" class="validate[required] span-3 text mayuscula" id="apmaterno" name="apmaterno" type="text"/>				
				</p>
				</div>
				
				<div class="divocultar span-3">
				<p>
				<label for="fechanacimiento">Fecha Nac.: </label>
				<input alt="Fecha de Nacimiento" class="validate[required,custom[date],length[0,10]] span-3 icon-fecha text" name="fechanacimiento" id="fechanacimiento" />				
				</p>
				</div>
				
				<div class="divocultar span-6">
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
				
				<div class="divocultar span-3">
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
				
				<div class="divocultar span-6">			
				<label for="curp">C.U.R.P.: <input id="curpautomatico" name="curpautomatico" type="checkbox" checked="checked">Automatico</label>
				<p>				
				<input maxlength="18" alt="CURP" class="validate[required,length[18,18]] span-6 text mayuscula" id="curp" name="curp" type="text"/>			
				</p>
				</div>
                
                <div id="cargardatosadicionales" class="span-6 divocultar" style="margin-top:20px;">			
				<img id="agregarcategoria" style="vertical-align:middle; cursor:pointer;" alt="Cargar Datos Adicionales" src="../img/flecha_abajo.png" onclick="javascript:CargarDatosAdicionales();" /><a onclick="javascript:CargarDatosAdicionales();" style="cursor:pointer; text-decoration:none;"><span style=" font-size:9px; vertical-align:middle;">Cargar Datos (Verifica Existencia C.U.R.P.)</span></a>
				</div>
                
                					
				
				<div id="div_upload_button" class="span-2" style="display:none; width:71px; height:100px; float:right;">			
				     <img id="upload_button" src="../img/foto.png" style="cursor:pointer;"/>				
				</div>				
				
				<!--dimensiones fotografia infantil ancho de 71px * alto de 85px-->
				
				</fieldset>		
				
				<fieldset><legend>Datos Adicionales del Participante <img alt="Limpia Datos de Participante" style="vertical-align:middle; cursor:pointer;" src="../img/icons/trash.png" onclick="javascript:limpiargenerales();"/></legend>
				
				<div class="divocultar span-4">			
				<label for="direccion">Direcci&oacute;n: </label>
				<p>				
				<input alt="Direcci&oacute;n" class="validate[required] span-4 text" id="direccion" name="direccion" type="text"/>			
				</p>
				</div>
				
				<div class="divocultar span-4">			
				<label for="colonia">Colonia: </label>
				<p>				
				<input alt="Colonia" class="validate[required] span-4 text" id="colonia" name="colonia" type="text"/>			
				</p>
				</div>
				
				<div class="divocultar span-4">			
				<label for="localidad">Localidad: </label>
				<p>				
				<input alt="Localidad" class="validate[required] span-4 text" id="localidad" name="localidad" type="text"/>			
				</p>
				</div>
				
				<div class="divocultar span-4">			
				<label for="codigopostal">Codigo Postal: </label>
				<p>				
				<input alt="Codigo Postal" class="span-4 text" id="codigopostal" name="codigopostal" type="text"/>			
				</p>
				</div>
				
				
				<div class="divocultar span-4">			
				<label for="telefonos">Telefonos: </label>
				<p>				
				<input alt="Telefonos" class="validate[required] span-4 text" id="telefonos" name="telefonos" type="text"/>			
				</p>
				</div>
				
				<div class="divocultar span-4">			
				<label for="correo">Correo Electronico: </label>
				<p>				
				<input alt="Correo Electronico" class="span-4 text" id="correo" name="correo" type="text"/>			
				</p>
				</div>
				
				<div class="divocultar span-4">			
				<label for="peso">Peso (KG): </label>
				<p>				
				<input alt="Peso" class="validate[required] span-4 text" id="peso" name="peso" type="text"/>			
				</p>
				</div>
				
				<div class="divocultar span-4">			
				<label for="talla">Talla (Mts): </label>
				<p>				
				<input alt="Talla" class="validate[required] span-4 text" id="talla" name="talla" type="text"/>			
				</p>
				</div>
				
				<div class="divocultar span-4">			
				<label for="talla">R.F.C.: </label>
				<p>				
				<input alt="R.F.C." class="validate[required] span-4 text" id="rfc" name="rfc" type="text"/>			
				</p>
				</div>
				
				<div class="divocultar span-4">			
				<label for="tiposanguineo">Tipo Sanguineo: </label>
				<p>				
				<input alt="Tipo Sanguineo" class="span-4 text" id="tiposanguineo" name="tiposanguineo" type="text"/>			
				</p>
				</div>
								
				</fieldset>
			 
			 <input id="idusuario" name="idusuario" type="hidden" value="<?php echo $_SESSION["id"]; ?>"/>				
			 		 
			 <input id="grabar-participante" type="submit" value="Grabar Participante" style="display:none;"/> 
             			 			 
             </form>		 	 					   			 
        </div>
		
        <fieldset><legend>Lista de Participantes Registrados</legend>
		<!--<label style="float:right;">Ultimos Registrados <img alt="Refrescar Lista" style="vertical-align:middle; cursor:pointer;" src="../img/icons/refresh.png" onclick="javascript:statususuario='activado'; $('#deportes_lista').val(''); $('#evento_lista').val(''); GenerarLista_Categoria();"/></label>
		<div id="clone_busca" style="width:100%;">
		<div class="span-7" id="clone_eventos">
		<p>
		<label for="evento">Evento: </label>
		<?php /*?><?php generaeventos("evento_lista"); ?>	<?php */?>			
		</p>
		</div>				
				
	    <div class="span-7" id="clone_deportes">
		<p>
		<label for="nombredeporte">Deporte: </label>
<?php /*?>		<?php generadeporte("deportes_lista"); ?>	<?php */?>			
		</p>
		</div>
		<input id="buscar_categoria" onclick="javascript:GenerarLista_Categoria();" type="button" value="Buscar" style="margin-top:30px;"/>
		   	
		</div>-->
		
		<!--<div id="buscar_ultimos" style="width:20%; float:left;">
		<label for="pruebas-text">Ultimos Registrados <img alt="Refrescar Lista" style="vertical-align:middle; cursor:pointer;" src="../img/icons/refresh.png" onclick="javascript:GenerarLista_Categoria();"/></label>
		</div>-->	 
		<!--<div class="scroll">
		     <table>
             <thead>			         	   
			   <th style="display:none;"></th>
			   <th style="display:none;"></th>
			   <th style="display:none;"></th>
			   <th style="display:none;"></th>
			   <th style="display:none;"></th>
			   <th style="display:none;"></th>
			   <th style="display:none;"></th>
			   <th style="display:none;"></th>
			   <th style="display:none;"></th>
			   <th style="display:none;"></th>
			   <th style="display:none;"></th>
			   <th style="display:none;"></th>
			   <th style="display:none;"></th>
			   <th style="display:none;"></th>
               <th>Evento</th>
			   <th>Municipio</th>
			   <th>Deporte</th>
			   <th>CURP</th>
			   <th>Nombre Completo</th>
			   <th>Modalidad</th>
			   <th></th>		   			   			   			   			   
             </thead>		 
             <tbody id = "lista_registro">		 		 
			 </tbody>			  		 
             </table>	    
		</div>-->	
      
       <div style="float:right; font-size:9px; margin-top:-40px; margin-right:-10px;"><a onclick="javascript:UltimosRegistrados();" style="cursor:pointer; text-decoration:none;"><span id ="selpart" style="vertical-align:bottom;">Ultimos Registrados</span></a><img id="ultimosregistrados" style="vertical-align:middle; cursor:pointer;" alt="Registro por Lote" src="../img/actualizar.png" onclick="javascript:UltimosRegistrados();" /></div>
      
      <div id="accordion">
      <h3><a><span id="span-titulo">Filtro de Busqueda</span></a></h3> 
      
      <div>
                 
      <div class="span-5" style="text-align:left;">
      <p>
      <label for="modalidad">Modalidad: </label>
      <?php generamodalidad("modalidad_registro"); ?>				
      </p>
      </div>
         
      <div class="span-5" style="text-align:left;">
      <p>
      <label for="nombredeporte_buscar">Deporte: </label>
      <?php generadeporte("deportes_registro"); ?>				
      </p>
      </div>
      
      <div class="span-10" id="categoria_registro">		
      <p>
      <label for="categoria">Categoria: </label>		
      <select name='selectcategoria_registro' id='selectcategoria_registro' class='span-10 cselect' disabled='disabled'>
      <option value='' selected>Ninguno</option>
      </select>					 	 
      </p>					
      </div>     
      <div class="clear"></div>
      
      <div class="span-3" style="text-align:left;">
      <p>
      <label for="ano">A&ntilde;o: </label>
      <select name="ano_registro" id= "ano_registro"  class="span-3 cselect" >
       <option value="">Ninguno       </option>
       <option value="2005">2005      </option>
       <option value="2004">2004      </option>
       <option value="2003">2003      </option>
       <option value="2002">2002      </option>
       <option value="2001">2001      </option>
       <option value="2000">2000      </option>
       <option value="1999">1999      </option>
       <option value="1998">1998      </option>
       <option value="1997">1997      </option>
       <option value="1996">1996      </option>
       <option value="1995">1995      </option>
       <option value="1994">1994      </option>
       <option value="1993">1993      </option>
       <option value="1992">1992      </option>
       <option value="1991">1991      </option>
       <option value="1990">1990      </option>
       <option value="1989">1989      </option>
       <option value="1988">1988      </option>
       <option value="1987">1987      </option>
       <option value="1986">1986      </option>
       <option value="1985">1985      </option>
       <option value="1984">1984      </option>
       <option value="1983">1983      </option>
       <option value="1982">1982      </option>
       <option value="1981">1981      </option>
       <option value="1980">1980      </option>		   		 
       </select>				
      </p>
      </div>
      
      
      <div class="span-3" style="text-align:left;">
      <p>
      <label for="sexo">Sexo: </label>
      <select name="sexo_registro" id= "sexo_registro"  class="validate[required] span-3 cselect" >
       <option value="">Ninguno       </option>
       <option value="H">Hombre    </option>
       <option value="M">Mujer     </option>		   		 
       </select>				
      </p>
      </div>
      
      <div class="span-4">
      <p>
      <label for="nombres">Nombres: </label>
      <input alt="Nombres" class="validate[required] span-4 text mayuscula"  id="nombres_registro" name="nombres_registro" type="text"/>				
      </p>
      </div>
      
      <div class="span-4">
      <p>
      <label for="appaterno">Ap. Paterno: </label>
      <input  alt="Apellido Paterno" class="validate[required] span-4 text mayuscula" id="appaterno_registro" name="appaterno_registro" type="text" value=""/>				
      </p>
      </div>
                  
      <div class="span-4">
      <p>
      <label for="apmaterno">Ap. Materno: </label>
      <input alt="Apellido Materno" class="validate[required] span-4 text mayuscula" id="apmaterno_registro" name="apmaterno_registro" type="text"/>				
      </p>
      </div>
      
      <div class="span-2" style="margin-top:30px;">          
      <input id="buscar_registro" name="buscar_registro" type="button" value="Bucar"/>				
      </div>     
     
      </div>     
     
      <div class="clear"></div>     
      
      <div id="listaregistrados_div">     
           <table id="listregistro"></table> 
           <div id="listregistropager"></div>                         
      </div>
      
      <div class="clear"></div>     	    
      </fieldset>	
      <div id="footer">
   		<p>&copy; <?php echo date("Y"); ?> <a title="QSERVICE - Integrate" href="#" target="_blank">QSERVICE - Integrate</a> &reg;  - Todos los Derechos Reservados - Desarrollado por <a title="Reality in a digital world" href="#" target="_blank">- Empresa Autorizada -</a></p>
	</div>        
</div>    
</body>
</html>
