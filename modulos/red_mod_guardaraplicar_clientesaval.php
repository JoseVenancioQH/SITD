<?php 
	include("../scripts/include/dbcon.php");
    require "../scripts/clases/class.dbsession.php";
	include("../scripts/clases/class.mysql.php");			
	
    $session = new dbsession();
	if( !isset($_SESSION["pase"]) ||  $_SESSION["pase"]!=="si")
	{
		header("Location: ../index.php");
	}    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es-es" lang="es-es" dir="ltr" id="minwidth" >

<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />  
  <meta name="description" content="RED Empresa Autorizada -" />  
  <title>RED Administración</title>
  <link href="favicon.ico" rel="shortcut icon" type="image/x-icon" /> 
  
  <script type="text/javascript" src="../js/jquery-1.6.js"></script>
  <script type="text/javascript" src="../js/mootools.js"></script>
  <script type="text/javascript" src="../js/jquery.autocomplete.1.1.js"></script>
  
  <script type="text/javascript" src="../js/caut_js_guardaraplicar_clientesaval.js"></script>
  <script type="text/javascript" src="../js/sitd_js_general.js"></script>
  <script type="text/javascript" src="../js/jquery.validationEngine-es.js"></script>
  <script type="text/javascript" src="../js/jquery.validationEngine.js"></script>
  <script type="text/javascript" src="../js/jquery.blockUI.js"></script> 
  
  
  <link rel="stylesheet" href="../css/system.css" type="text/css" />
  <link rel="stylesheet" href="../css/template.css" type="text/css" />
  <link rel="stylesheet" href="../css/validationEngine.jquery.css" type="text/css" />
  <link rel="stylesheet" href="../css/autocomplete.css" type="text/css" />
  <link rel="stylesheet" href="../css/jquery.autocomplete.1.1.css" type="text/css" /> 
  
  
 
  <!--[if IE 7]>
  <link href="../css/ie7.css" rel="stylesheet" type="text/css" />
  <![endif]-->
 
  <!--[if lte IE 6]>
  <link href="../css/ie6.css" rel="stylesheet" type="text/css" />
  <![endif]-->
 
  <link rel="stylesheet" type="text/css" href="../css/rounded.css" />
  
  <!--<script type="text/javascript" src="../js/index.js"></script> -->

</head>

<body id="minwidth-body">
	<div id="border-top" class="h_blue">
		<div>
			<div>
				<span class="version">Bienvenido <?php echo $_SESSION["nombre"]; ?></span>
				<span class="title"></span>
			</div>
		</div>
	</div>
    
	<div id="header-box">
		<div id="module-status">
			<span class="logout"><a href="../scripts/close-session.php"> Cerrar sesión</a></span>
		</div>
	
        <div id="module-menu">
         <ul id="menu" >         
             <?php include("../scripts/menu_disabled.php"); ?>
         </ul>
        </div>
         
		<div class="clr"></div>
	</div>   
    
	<div id="content-box">
		<div class="border">
			<div class="padding">
            
				<div id="toolbar-box">
                    <div class="t">
                        <div class="t">
                            <div class="t"></div>
                        </div>
                    </div>
                    <div class="m">
                        <div class="toolbar" id="toolbar">
                              <table class="toolbar"><tr>
                              <!--<td class="button" id="toolbar-cancel">
                              <a href="#" onclick="javascript:if(document.adminForm.boxchecked.value==0){alert('Por favor, seleccionar un usuario de la lista para cerrar sesión');}else{  submitbutton('logout')}" class="toolbar">
                              <span class="icon-32-cancel" title="Cerrar sesión">
                              </span>
                              Cerrar sesión
                              </a>
                              </td>-->
                               
                              <td class="button" id="toolbar-save" style="display:<?php if($_GET["tipo"]=='add') echo 'inline;'; else echo 'none;';?>">
                              <a href="#" onclick="javascript:validar('guardar');" class="toolbar">
                              <span class="icon-32-save" title="Guardar">
                              </span>
                              Guardar
                              </a>
                              </td>
                               
                              <td class="button" id="toolbar-apply" style="display:<?php if($_GET["tipo"]=='edit') echo 'inline'; else echo 'none';?>">
                              <a href="#" onclick="javascript:validar('aplicar');" class="toolbar">
                              <span class="icon-32-apply" title="Aplicar">
                              </span>
                              Aplicar
                              </a>
                              </td>
                               
                              <td class="button" id="toolbar-cancel">
                              <a href="red_mod_lista_clientesaval.php" class="toolbar">
                              <span class="icon-32-cancel" title="Cancelar">
                              </span>
                              Cancelar
                              </a>
                              </td>
                               
                              <!--<td class="button" id="toolbar-help">
                              <a href="#" onclick="popupWindow('http://help.joomla.org/index2.php?option=com_content&amp;task=findkey&amp;tmpl=component;1&amp;keyref=screen.users.15', 'Ayuda', 640, 480, 1)" class="toolbar">
                              <span class="icon-32-help" title="Ayuda">
                              </span>
                              Ayuda
                              </a>
                              </td>-->
                               
                              </tr></table>
                        </div>
                        <div class="header icon-48-clienteaval<?php echo $_GET["tipo"]; ?>"><?php echo $_GET["texto"]; ?></div>
         
                        <div class="clr"></div>
                        
                    </div>
                    <div class="b">
                        <div class="b">
                            <div class="b"></div>
                        </div>
                    </div>
                </div>                
                
   		    <div class="clr"></div>		
            		
			<div id="mensaje"></div>	
            
		    <div id="element-box">
            
			<div class="t">
		 		<div class="t">
					<div class="t"></div>
		 		</div>
			</div>
            
			<div class="m">
            	
    <form id="form_clienteaval">
    <div id="tabla_desplegado">	
	<div class="col width-100">       
		<fieldset class="adminform">
		<legend>Datos del Aval</legend>
			<table class="admintable" cellspacing="1">
                <tr>
					<td width="150" class="key">
						<label for="cliente">Cliente</label>
					</td>
                    
                    
                    
					<td>    
                    
                        <table class="nospace">
                         <tr>
                             <td><input name="cliente" id="cliente" class="validate[required] inputbox autocomplete_nombre mayuscula icon-autocomplet" size="80" type="text" value="" /></td><td class="icon-trash" style="cursor:pointer;" onclick="javascript:borrarcliente();"></td>
                         </tr>
                         </table>
                                        
						
					</td>
				</tr>
                <tr>
					<td width="150" class="key">
						<label for="nomaval">Nombre Aval</label>
					</td>
					<td>                       
						<input name="nomaval" id="nomaval" class="validate[required] inputbox autocomplete_nombre mayuscula icon-autocomplet" size="80" type="text" value="" />
					</td>
				</tr>
                <tr>
					<td width="150" class="key">
						<label for="appaternoaval">Apellido Paterno Aval</label>
					</td>
					<td>                       
						<input name="appaternoaval" id="appaternoaval" class="validate[required] inputbox autocomplete_nombre mayuscula icon-autocomplet" size="80" type="text" value="" />
					</td>
				</tr>
				<tr>
					<td width="150" class="key">
						<label for="apmaternoaval">Apellido Materno Aval</label>
					</td>
					<td>
						<input type="text" name="apmaternoaval" id="apmaternoaval" class="inputbox autocomplete_nombre mayuscula icon-autocomplet" size="80" value="" />
					</td>
				</tr>
                <tr>
					<td width="150" class="key">
						<label for="municipio">Municipio del Aval</label>
					</td>
					<td>            
                        <input type="text"  id="municipio" class="validate[required] autocomplete icon-autocomplet"/>           
						<?php /*?><select name="marca" id="marca" class="validate[required] selectbox">                            
                            <?php			    
							  include("../scripts/clases/class.sitd_cat_rama.php");
							  $invauto = new invauto();							  
							  $invauto->mostrarCatalogo('marca',$_SESSION["idempresa"]);						      
						   ?>                            
                        </select><?php */?>
					</td>
				</tr>
                <tr>
					<td width="150" class="key">
						<label for="diraval">Direcci&oacute;n Aval</label>
					</td>
					<td>
						<input type="text" name="diraval" id="diraval" class="inputbox" size="80" value="" />
					</td>
				</tr>
                <tr>
					<td width="150" class="key">
						<label for="telcel">Telefono Celular del Aval</label>
					</td>
					<td>
						<input type="text" name="telcel" id="telcel" class="inputbox" size="80" value="" />
					</td>
				</tr>
                <tr>
					<td width="150" class="key">
						<label for="telcasa">Telefono Casa del Aval</label>
					</td>
					<td>
						<input type="text" name="telcasa" id="telcasa" class="inputbox" size="80" value="" />
					</td>
				</tr>                
			</table>            
		</fieldset>        
	</div>	
    <!--<div class="col width-100">       
		<fieldset class="adminform">
		<legend>Aval del Cliente</legend>
			<table class="admintable" cellspacing="1">
                <tr>
					<td width="150" class="key">
						<label for="avalnomcliente">Nombre Cliente</label>
					</td>
					<td>                       
						<input name="avalnomcliente" id="avalnomcliente" class="validate[required] inputbox autocomplete_nombre mayuscula" size="80" type="text" value="" />
					</td>
				</tr>
                <tr>
					<td width="150" class="key">
						<label for="avalappaternocliente">Apellido Paterno</label>
					</td>
					<td>                       
						<input name="avalappaternocliente" id="avalappaternocliente" class="validate[required] inputbox autocomplete_nombre mayuscula" size="80" type="text" value="" />
					</td>
				</tr>
				<tr>
					<td width="150" class="key">
						<label for="avalapmaternocliente">Apellido Materno</label>
					</td>
					<td>
						<input type="text" name="avalapmaternocliente" id="avalapmaternocliente" class="validate[required] inputbox autocomplete_nombre mayuscula" size="80" value="" />
					</td>
				</tr>
                <tr>
					<td width="150" class="key">
						<label for="avalmunicipio">Municipio</label>
					</td>
					<td>            
                        <input type="text"  id="avalmunicipio" class="validate[required] autocomplete"/>           
						<?php /*?><select name="marca" id="marca" class="validate[required] selectbox">                            
                            <?php			    
							  include("../scripts/clases/class.caut_invauto.php");
							  $invauto = new invauto();							  
							  $invauto->mostrarCatalogo('marca',$_SESSION["idempresa"]);						      
						   ?>                            
                        </select><?php */?>
					</td>
				</tr>
                <tr>
					<td width="150" class="key">
						<label for="avaldircliente">Direcci&oacute;n</label>
					</td>
					<td>
						<input type="text" name="avaldircliente" id="avaldircliente" class="validate[required] inputbox" size="80" value="" />
					</td>
				</tr>
                <tr>
					<td width="150" class="key">
						<label for="avaltelcel">Telefono Celular</label>
					</td>
					<td>
						<input type="text" name="avaltelcel" id="avaltelcel" class="validate[required] inputbox" size="80" value="" />
					</td>
				</tr>
                <tr>
					<td width="150" class="key">
						<label for="avaltelcasa">Telefono Casa</label>
					</td>
					<td>
						<input type="text" name="avaltelcasa" id="avaltelcasa" class="validate[required] inputbox" size="80" value="" />
					</td>
				</tr>                
			</table>            
		</fieldset>        
	</div>-->
    </form> 
    
    <input type="hidden" id="id" value="<?php echo $_GET["id"]; ?>"/>
    <input type="hidden" id="idempresa" value="<?php echo $_SESSION["idempresa"]; ?>"/>    
    <script type="text/javascript">
	                    loaddata_autocomplet();
						loaddata_autocomplet_nombre();
						edit_data();
    </script>

	<div class="clr"></div>
        <div class="clr"></div>
    </div>    
	   <div class="clr"></div>
	  </div>
	     <div class="b">
				<div class="b">
					<div class="b"></div>
				</div>
		</div>
   	 </div>
	<noscript>¡Advertencia! JavaScript debe estar habilitado para un correcto funcionamiento de la Administración</noscript>
    
	<div class="clr"></div>
	</div>
	<div class="clr"></div>
</div>
</div>

	<div id="border-bottom"><div><div></div></div></div>
	<div id="footer">
	<p class="copyright">
		<a href="#" target="_blank">QSERVICE - Integrate</a>
		<?php echo $_SESSION["empresa"]; ?> <a href="#">Control Automotriz</a>.	</p>
    </div>
</body>
</html>


