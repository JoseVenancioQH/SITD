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
<title>Cedula de Inscripci&oacute;n | Registro Estatal de Deporte - QSERVICE - Integrate</title>
<link rel="stylesheet" href="../css/screen.css" type="text/css" media="screen, projection">
<link type="text/css" href="../css/theme/ui.all.css" rel="Stylesheet" />
<link rel="stylesheet" href="../css/jquery.jgrowl.css" type="text/css" />
<link rel="stylesheet" type="text/css" media="screen" href="../grid/themes/redmond/jquery-ui-1.8.2.custom.css" />
<link rel="stylesheet" type="text/css" media="screen" href="../grid/themes/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="../grid/themes/ui.multiselect.css" />

<link rel="stylesheet" type="text/css" media="screen" href="../grid/themes/redmond/jquery-ui-1.8.2.custom.css" />
<link rel="stylesheet" type="text/css" media="screen" href="../grid/themes/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="../grid/themes/ui.multiselect.css" />
<link rel="stylesheet" type="text/css" href="../css/jquery.Jcrop.css" />


<script type="text/javascript" src="../js/jquery-1.3.1.js"></script>
<script type="text/javascript" src="../js/controller-unBlock.js" ></script>
<script type="text/javascript" src="../js/jquery.AjaxUpload.js" ></script>

<script type="text/javascript" src="../js/controller-general.js" ></script>
<script type="text/javascript" src="../js/controller-cedulainscripcion.js"></script>
<script type="text/javascript" src="../js/jquery.blockUI.js" ></script>
<script type="text/javascript" src="../js/jquery.Jcrop.js"></script>
<script type="text/javascript" src="../js/seekAttention.jquery.js" ></script>

<script type="text/javascript" src="../js/jquery.growl.js" ></script>
<script type="text/javascript" src="../grid/src/i18n/grid.locale-es.js" ></script>


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
			$seccion = "reportes";
			include("../scripts/menu.php");
        ?>       
        </ul>             
            <ul id="submenu">
                <?php
			        $seccion = "cedulainscripcion";
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
    
    <ul id="navigation">    
    <li id="ayuda_imprimir_cedulas_div" style="font-size:9px;">
    <!--<div id="grabar_participante_div" style="float:right; font-size:8px; margin-left:5px;">-->
    <a href="../help/ImprimirCedulas/ImprimirCedulas.html" target="_blank" style="cursor:pointer; text-decoration:none;">
    <table class="nospace"><tr><td style="text-align:center;">
    <img style="vertical-align:middle; cursor:pointer;" alt="Imprimir Cedulas" src="../img/ayuda.png"/>
    </td></tr>
    <tr><td style="text-align:center;">
    <span style="vertical-align:middle; text-align:center;">Ayuda Imprimir<br />Cedulas</span>
    </td></tr></table>
    </a>
    <!--</div>-->
    </li>   
    
    <li id="limpiar_filtros_div" style="font-size:9px;">
    <!--<div  style="float:right; font-size:8px; margin-left:5px;">-->
    <a onclick="javascript:LimpiarFiltro();" style="cursor:pointer; text-decoration:none;">
    <table class="nospace"><tr><td style="text-align:center;">
    <img id="limpiarfiltro" style="vertical-align:middle; cursor:pointer;" alt="Limpiar Filtros" src="../img/limpiar_total.png"/>
    </td></tr>
    <tr><td style="text-align:center;">
    <span style="vertical-align:middle; text-align:center;">Limpiar<br />Filtro</span>
    </td></tr></table>
    </a>
    <!--</div>--> 
    </li>
    
    <li id="imprimir_cedulas_div" style="font-size:9px;">
    <!--<div id="grabar_participante_div" style="float:right; font-size:8px; margin-left:5px;">-->
    <a onclick="javascript:ImprimirCedulas();" style="cursor:pointer; text-decoration:none;">
    <table class="nospace"><tr><td style="text-align:center;">
    <img id="imprimircedula" style="vertical-align:middle; cursor:pointer;" alt="Imprimir Cedulas" src="../img/imprimir_cedula.png"/>
    </td></tr>
    <tr><td style="text-align:center;">
    <span style="vertical-align:middle; text-align:center;">Imprimir<br />Cedulas</span>
    </td></tr></table>
    </a>
    <!--</div>-->
    </li>    
    </ul>

    
    <div id="form">
      <h2>Generador de Cedulas de Inscripci&oacute;n</h2>			 
      <div id="accordion">
      <h3><a><span id="span-titulo">Filtro de Busqueda</span></a></h3>     
      <div>
      
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
                 
      <div class="span-5" style="text-align:left;">
      <p>
      <label for="modalidad">Modalidad: </label>
      <?php generamodalidad("modalidad_registro"); ?>				
      </p>
      </div>
         
      <div class="span-7" style="text-align:left;">
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
       
  <div id="listaregistrados_div">
      <table id="listcedula"></table> 
      <div id="listcedulapager"></div>              
  </div>    
    
  <div id="footer">
   		<p>&copy; <?php echo date("Y"); ?> <a title="QSERVICE - Integrate" href="#" target="_blank">QSERVICE - Integrate</a> &reg;  - Todos los Derechos Reservados - Desarrollado por <a title="Reality in a digital world" href="#" target="_blank">- Empresa Autorizada -</a></p>
  </div>        
</div>  
</body>
</html>
