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
<title>Registrar Eventos | Registro Estatal de Deporte - QSERVICE - Integrate</title>
<link rel="stylesheet" href="../css/screen.css" type="text/css" media="screen, projection">
<link type="text/css" href="../css/theme/ui.all.css" rel="Stylesheet" />
<link rel="stylesheet" href="../css/jquery.jgrowl.css" type="text/css" />
<link rel="stylesheet" type="text/css" media="screen" href="../grid/themes/redmond/jquery-ui-1.8.2.custom.css" />
<link rel="stylesheet" type="text/css" media="screen" href="../grid/themes/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="../grid/themes/ui.multiselect.css" />
<link rel="stylesheet" href="../css/datepicker.css" type="text/css" />
<link rel="stylesheet" href="../css/validationEngine.jquery.css" type="text/css" media="screen" charset="utf-8" />
<!--[if IE]><link rel="stylesheet" href="../css/ie.css" type="text/css" media="screen, projection"><![endif]-->
<script type="text/javascript" src="../js/jquery-1.3.1.js"></script>
<script type="text/javascript" src="../js/datepicker.js"></script>
<script type="text/javascript" src="../js/controller-unBlock.js" ></script>
<script type="text/javascript" src="../js/controller-eventos.js"></script>
<script type="text/javascript" src="../js/controller-general.js"></script>
<script type="text/javascript" src="../js/jquery.validationEngine.js"></script>
<script type="text/javascript" src="../js/jquery.blockUI.js" ></script>
<script type="text/javascript" src="../js/jquery.maskedinput-1.2.2.js" ></script>

<script type="text/javascript" src="../js/jquery.growl.js" ></script>
<script type="text/javascript" src="../js/jquery.highlightFade.js"></script>
<script type="text/javascript" src="../js/jquery-ui-personalized-1.6rc6.js"></script>
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
             <h2>Agregar Evento</h2>
             
             <ul id="navigation">
    
            <li id="ayuda_registrar_evento_div" style="font-size:9px;">
            <!--<div id="grabar_participante_div" style="float:right; font-size:8px; margin-left:5px;">-->
            <a href="../help/Validar/ValidarParticipante.html" target="_blank" style="cursor:pointer; text-decoration:none;">
            <table class="nospace"><tr><td style="text-align:center;">
            <img style="vertical-align:middle; cursor:pointer;" alt="Ayuda Registrar Evento" src="../img/ayuda.png"/>
            </td></tr>
            <tr><td style="text-align:center;">
            <span style="vertical-align:middle; text-align:center;">Ayuda Registrar<br />Evento</span>
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
            
            <li id="cancelar_actualizar_evento_div" style="font-size:9px; display:none;">
            <!--<div id="grabar_participante_div" style="float:right; font-size:8px; margin-left:5px;">-->
            <a onclick="javascript:CancelarActualizarEvento();" style="cursor:pointer; text-decoration:none;">
            <table class="nospace"><tr><td style="text-align:center;">
            <img id="cancelaractualizarevento" style="vertical-align:middle; cursor:pointer;" alt="Cancelar Actualizar Evento" src="../img/evento_cancelar.png"/>
            </td></tr>
            <tr><td style="text-align:center;">
            <span style="vertical-align:middle; text-align:center;">Cancelar Actualizar<br />Evento</span>
            </td></tr></table>
            </a>
            <!--</div>-->
            </li>
            
            <li id="actualizar_evento_div" style="font-size:9px; display:none;">
            <!--<div id="grabar_participante_div" style="float:right; font-size:8px; margin-left:5px;">-->
            <a onclick="javascript:ActualizarEvento_submit();" style="cursor:pointer; text-decoration:none;">
            <table class="nospace"><tr><td style="text-align:center;">
            <img id="actualizarevento" style="vertical-align:middle; cursor:pointer;" alt="Registrar Evento" src="../img/evento_actualizar.png"/>
            </td></tr>
            <tr><td style="text-align:center;">
            <span style="vertical-align:middle; text-align:center;">Actualizar<br />Evento</span>
            </td></tr></table>
            </a>
            <!--</div>-->
            </li>
            
            <li id="registrar_evento_div" style="font-size:9px;">
            <!--<div id="grabar_participante_div" style="float:right; font-size:8px; margin-left:5px;">-->
            <a onclick="javascript:RegistrarEvento_submit();" style="cursor:pointer; text-decoration:none;">
            <table class="nospace"><tr><td style="text-align:center;">
            <img id="registrarevento" style="vertical-align:middle; cursor:pointer;" alt="Registrar Evento" src="../img/evento_registrar.png"/>
            </td></tr>
            <tr><td style="text-align:center;">
            <span style="vertical-align:middle; text-align:center;">Registrar<br />Evento</span>
            </td></tr></table>
            </a>
            <!--</div>-->
            </li>        
            
            </ul>		 
            <fieldset><legend>Datos del Evento</legend>		 
              <form name="grabar-evento" id="grabar-evento" method="post" action="">  
              
			    <div class="span-7">
				<p>
				<label for="nombre-text">Nombre del Evento: </label>
				<input  alt="Nombre Evento" class="validate[required,length[0,50]] span-7 text" id="nombre-text" name="nombre-text" type="text"/>				
				</p>
				</div>
				
				<div class="span-7">
				<p>
				<label for="coordina-text">Coordinador del Evento: </label>
				<input alt="Coordinador del Evento" class="validate[required,custom[onlyLetter],length[0,50]] span-7 text" id="coordina-text" name="coordina-text" type="text"/>				
				</p>
				</div>
				
				<div class="span-7">
				<p>
				<label for="sede-text">Sedes del Evento: </label>
				<input alt="Sede" class="validate[required,length[0,50]] span-7 text" id="sede-text" name="sede-text" type="text"/>				
				</p>
				</div>
				
				<div class="span-12">
				<p>
				<label for="caracteristicas-text">Caracteristicas del Evento: </label>
				<input alt="Caracteristicas del Evento" class="validate[required,length[0,250]] span-12 text" id="caracteristicas-text" name="caracteristicas-text" type="text"/>				
				</p>
				</div>			
                
				<div class="span-3">
				<p>
				<label for="fechainicio">Fecha de Inicio: </label>
				<input alt="Fecha de Inicio" class="validate[required,custom[date],length[0,10]] span-3 icon-fecha text" name="fechainicio" id="fechainicio" value="<?php echo date("d-m-Y") ?>" />				
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
              </form>  
			</fieldset>		 
      
            <div class="clear"></div>     
            <div id="listeventos_div">
             <table id="listeventos"></table>               
             <div id="listeventospager"></div>
            </div> 

         
    </div>
    <div id="footer">
   		<p>&copy; <?php echo date("Y"); ?> <a title="QSERVICE - Integrate" href="#" target="_blank">QSERVICE - Integrate</a> &reg;  - Todos los Derechos Reservados - Desarrollado por <a title="Reality in a digital world" href="#" target="_blank">- Empresa Autorizada -</a></p>
	</div>        
</div>    
</body>
</html>
