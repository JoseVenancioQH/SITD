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
  <meta name="description" content="RED - Empresa Autorizada -" />  
  <title>RED Administración</title>
  <link href="favicon.ico" rel="shortcut icon" type="image/x-icon" /> 
  
  <script type="text/javascript" src="../js/jquery-1.6.js"></script>
  <!--<script type="text/javascript" src="../js/jquery.autocomplete.pack.js"></script>
  <script type="text/javascript" src="../js/jquery.select-autocomplete.js"></script>  -->
  <script type="text/javascript" src="../js/jquery.autocomplete.1.1.js"></script>
  <script type="text/javascript" src="../js/mootools.js"></script>
  <script type="text/javascript" src="../js/caut_js_guardaraplicar_invauto.js"></script>
  <script type="text/javascript" src="../js/jquery.validationEngine-es.js"></script>
  <script type="text/javascript" src="../js/jquery.validationEngine.js"></script>  
  <script type="text/javascript" src="../js/sitd_js_general.js"></script> 
  <script type="text/javascript" src="../js/jquery.AjaxUpload.js"></script> 
  <script type="text/javascript" src="../js/jquery.colorbox.js"></script>
  <script type="text/javascript" src="../js/jquery.blockUI.js"></script> 
  
  <link rel="stylesheet" href="../css/system.css" type="text/css" />
  <link rel="stylesheet" href="../css/template.css" type="text/css" />
  <link rel="stylesheet" href="../css/validationEngine.jquery.css" type="text/css" />
  <link rel="stylesheet" href="../css/autocomplete.css" type="text/css" />
  <link rel="stylesheet" href="../css/jquery.autocomplete.1.1.css" type="text/css" /> 
  <link rel="stylesheet" href="../css/colorbox.css" type="text/css" /> 
 
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
                              
                              <td class="button">
                              <a href="#" onclick="javascript:jQuery.blockUI({ message: jQuery('#question'), css: { width: '275px' } });" class="toolbar">
                              <span class="icon-32-galerydelete" title="Borrar Galeria de Imagenes">
                              </span>
                              Eliminar
                              </a>
                              </td>                                                  
                              
                              <td id="button_img" class="button">
                              <a id="upload_button" href="#" class="toolbar">
                              <span class="icon-32-galery" title="Guardar">
                              </span>
                              Agregar
                              </a>
                              </td>                       
                              
                               
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
                              <a href="red_mod_lista_invauto.php" class="toolbar">
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
                        <div class="header icon-48-invauto<?php echo $_GET["tipo"]; ?>"><?php echo $_GET["texto"]; ?></div>
         
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
            	
    <form id="form_invauto">
    <div id="tabla_desplegado">	
	<div class="col width-30">        
		<fieldset class="adminform">
		<legend>Datos del Auto</legend>
			<table class="admintable" cellspacing="1">
                <tr>
					<td width="150" class="key">
						<label for="noserie">N&uacute;mero de Serie</label>
					</td>
					<td>                       
						<input size="100" name="noserie" id="noserie" class="validate[required] inputbox mayuscula" type="text" value="" />
					</td>
				</tr>
				<tr>
					<td width="150" class="key">
						<label for="nopedimento">N&uacute;mero de Pedimento</label>
					</td>
					<td>
						<input type="text" name="nopedimento" id="nopedimento" class="validate[required] inputbox" value="" />
					</td>
				</tr>
                <tr>
					<td width="150" class="key">
						<label for="millas">Millas</label>
					</td>
					<td>
						<input type="text" name="millas" id="millas" class="validate[required] inputbox" value="" />
					</td>
				</tr>
                <tr>
					<td width="150" class="key">
						<label for="noplacas">N&uacute;mero de Placas</label>
					</td>
					<td>
						<input type="text" name="noplacas" id="noplacas" class="validate[required] inputbox" value="" />
					</td>
				</tr>
                <tr>
					<td width="150" class="key">
						<label for="nomotor">N&uacute;mero de Motor</label>
					</td>
					<td>
						<input type="text" name="nomotor" id="nomotor" class="validate[required] inputbox" value="" />
					</td>
				</tr>
                <tr>
					<td width="150" class="key">
						<label for="norfa">N&uacute;mero de R.F.A.</label>
					</td>
					<td>
						<input type="text" name="norfa" id="norfa" class="validate[required] inputbox" value="" />
					</td>
				</tr>								
			</table>
		</fieldset>
	</div>
    <div class="col width-30">        
		<fieldset class="adminform">
		<legend>Datos Auto Nacional</legend>
			<table class="admintable" cellspacing="1">
                <tr>
					<td width="150" class="key">
						<label for="nofactura">N&uacute;mero de Factura</label>
					</td>
					<td>                       
						<input size="100" name="nofactura" id="nofactura" class="validate[required] inputbox" size="30" type="text" value="" />
					</td>
				</tr>
				<tr>
					<td width="150" class="key">
						<label for="notenencia">N&uacute;mero de Tenencia</label>
					</td>
					<td>
						<input type="text" name="notenencia" id="notenencia" class="validate[required] inputbox" size="30" value="" />
					</td>
				</tr>
                <tr>
					<td width="150" class="key">
						<label for="tcirculacion">Tarjeta de Circulaci&oacute;n</label>
					</td>
					<td>
						<input type="text" name="tcirculacion" id="tcirculacion" class="validate[required] inputbox" size="30" value="" />
					</td>
				</tr>
                <tr>
					<td width="150" class="key">
						<label for="kmrecorridos">N&uacute;mero de KM Recorridos</label>
					</td>
					<td>
						<input type="text" name="kmrecorridos" id="kmrecorridos" class="validate[required] inputbox" size="30" value="" />
					</td>
				</tr>                								
			</table>
		</fieldset>
	</div>
    <div class="col width-25">        
		<fieldset class="adminform">
		<legend>Datos Particulares del Auto</legend>
			<table class="admintable" cellspacing="1">
                <tr>
					<td width="150" class="key">
						<label for="marca">Marca</label>
					</td>
					<td>            
                        <input type="text"  id="marca" class="validate[required] autocomplete"/>           
						<?php /*?><select name="marca" id="marca" class="validate[required] selectbox">                            
                            <?php			    
							  include("../scripts/clases/class.red_invauto.php");
							  $invauto = new invauto();							  
							  $invauto->mostrarCatalogo('marca',$_SESSION["idempresa"]);						      
						   ?>                            
                        </select><?php */?>
					</td>
				</tr>
				<tr>
					<td width="150" class="key">
						<label for="modelo">Modelo</label>
					</td>
					<td>                        
                        <input type="text"  id="modelo" class="validate[required] autocomplete"/>
						<?php /*?><select name="modelo" id="modelo" class="validate[required] selectbox">                            
                            <?php			    							  
							  $invauto->mostrarCatalogo('modelo',$_SESSION["idempresa"]);						      
						   ?>                            
                        </select><?php */?>
					</td>
				</tr>
                <tr>
					<td width="150" class="key">
						<label for="linea">Linea</label>
					</td>
					<td>                        
                        <input type="text"  id="linea" class="validate[required] autocomplete"/>
						<?php /*?><select name="linea" id="linea" class="validate[required] selectbox">                            
                            <?php			    							  
							  $invauto->mostrarCatalogo('linea',$_SESSION["idempresa"]);						      
						   ?>                            
                        </select><?php */?>
					</td>
				</tr>
                <tr>
					<td width="150" class="key">
						<label for="tipo">Tipo</label>
					</td>
					<td>                        
                        <input type="text"  id="tipo" class="validate[required] autocomplete"/> 
						<?php /*?><select name="tipo" id="tipo" class="validate[required] selectbox">                            
                            <?php			    							  
							  $invauto->mostrarCatalogo('tipo',$_SESSION["idempresa"]);						      
						   ?>                            
                        </select><?php */?>
					</td>
				</tr>
                <tr>
					<td width="150" class="key">
						<label for="cilindros">Cilindros</label>
					</td>
					<td>                        
                        <input type="text"  id="cilindros" class="validate[required] autocomplete"/>
						<?php /*?><select name="cilindros" id="cilindros" class="validate[required] selectbox">                            
                            <?php			    							  
							  $invauto->mostrarCatalogo('cilindros',$_SESSION["idempresa"]);						      
						   ?>                            
                        </select><?php */?>
					</td>
				</tr>
                <tr>
					<td width="150" class="key">
						<label for="color">Color</label>
					</td>
					<td width="500px">                        
                        <input type="text"  id="color" class="validate[required] autocomplete"/>
						<?php /*?><select style="width:300px;" name="color" id="color" class="validate[required] selectbox">                            
                            <?php			    							  
							  $invauto->mostrarCatalogo('color',$_SESSION["idempresa"]);						      
						   ?>                            
                        </select><?php */?>
					</td>
				</tr>                								
			</table>
		</fieldset>
	</div>
    
    <div class="col width-15">        
		<fieldset class="adminform">
		<legend>Imagenes</legend>
            <div style="overflow:auto; height:145px">
			<table><tbody id="imgautos"></tbody></table>
            </div>
		</fieldset>
	</div>
    	
    <div class="col width-30">        
		<fieldset class="adminform">
		<legend>Componente Exteriores<input type="checkbox" id="comext" name="ex[]" class="nodo"/></legend>
			<table class="admintable">				
             <tr >                       
                <td>                                        
                    <table>
                    <tr><td><input type="checkbox" id="extunidadluces" name="ex[]" class="item"/>Unidad de Luces</td></tr>
                    <tr><td><input type="checkbox" id="ext14luces" name="ex[]" class="item"/>1/4 de Luces</td></tr>
                    <tr><td><input type="checkbox" id="extantena" name="ex[]" class="item"/>Antena</td></tr>
                    <tr><td><input type="checkbox" id="extespejolateral" name="ex[]" class="item"/>Espejo Lateral</td></tr>
                    <tr><td><input type="checkbox" id="extcristales" name="ex[]" class="item"/>Cristales</td></tr>
                    <tr><td><input type="checkbox" id="extemblemas" name="ex[]" class="item"/>Emblemas</td></tr>
                    </table>
                </td>                    
                 <td>                        
                    <table>
                    <tr><td><input type="checkbox" id="extllantas" name="ex[]" class="item"/>Llantas</td></tr>
                    <tr><td><input type="checkbox" id="exttaponruedas" name="ex[]" class="item"/>Tap&oacute;n de Ruedas</td></tr>
                    <tr><td><input type="checkbox" id="extmoldurascompletas" name="ex[]" class="item"/>Molduras Completas</td></tr> 
                    <tr><td><input type="checkbox" id="exttapongasolina" name="ex[]" class="item"/>Tap&oacute;n de Gasolina</td></tr> 
                    <tr><td><input type="checkbox" id="extcarsingolpes" name="ex[]" class="item"/>Carroceria Sin Golpes</td></tr>                    <tr><td><input type="checkbox" id="extbocinaclaxon" name="ex[]" class="item"/>Bocina Clax&oacute;n</td></tr>
                    </table>
                </td>
            </tr>                
			</table>
		</fieldset>
	</div>
    <div class="col width-30">        
		<fieldset class="adminform">        
		<legend>Componente Interiores<input type="checkbox" id="comint" name="in[]" class="nodo"/></legend>
			<table class="admintable">				
             <tr >                       
                <td>                                        
                    <table>
                    <tr><td><input type="checkbox" id="intvestiduras" name="in[]" class="item"/>Vestiduras</td></tr>
                    <tr><td><input type="checkbox" id="inttapete" name="in[]" class="item"/>Tapete</td></tr>
                    <tr><td><input type="checkbox" id="intinstrumentotab" name="in[]" class="item"/>Instrumento Tablero</td></tr>
                    <tr><td><input type="checkbox" id="intcalefaccion" name="in[]" class="item"/>Calefacci&oacute;n</td></tr>
                    <tr><td><input type="checkbox" id="intradioestereo" name="in[]" class="item"/>Radio Estereo</td></tr>
                    <tr><td><input type="checkbox" id="intbocinas" name="in[]" class="item"/>Bocinas</td></tr>
                    </table>
                </td>                    
                 <td>                        
                    <table>
                    <tr><td><input type="checkbox" id="intencendedor" name="in[]" class="item"/>Encendedor</td></tr>
                    <tr><td><input type="checkbox" id="intespejoretrovisor" name="in[]" class="item"/>Espejo Retrovisor</td></tr>
                    <tr><td><input type="checkbox" id="intcenicero" name="in[]" class="item"/>Cenicero</td></tr> 
                    <tr><td><input type="checkbox" id="intcinturon" name="in[]" class="item"/>Cintur&oacute;n</td></tr> 
                    <tr><td><input type="checkbox" id="intbotones" name="in[]" class="item"/>Botones</td></tr>
                    <tr><td></td></tr>
                    </table>
                </td>
            </tr>                
			</table>
		</fieldset>
	</div>
    <div class="col width-20">        
		<fieldset class="adminform">        
		<legend>Accesorios<input type="checkbox" id="acc" name="ac[]" class="nodo"/></legend>
			<table class="admintable">				
             <tr >                       
                <td>                                        
                    <table>
                    <tr><td><input type="checkbox" id="accgato" name="ac[]" class="item"/>Gato</td></tr>
                    <tr><td><input type="checkbox" id="accllaveruedas" name="ac[]" class="item"/>Llave Ruedas</td></tr>
                    <tr><td><input type="checkbox" id="accestucheherr" name="ac[]" class="item"/>Estuche Herramientas</td></tr>
                    <tr><td><input type="checkbox" id="acctrianguloseg" name="ac[]" class="item"/>Triangulo de Seguridad</td></tr>
                    <tr><td><input type="checkbox" id="accllantarefaccion" name="ac[]" class="item"/>Llanta Refacci&oacute;n</td></tr>
                    <tr><td><input type="checkbox" id="accextinguidor" name="ac[]" class="item"/>Extinguidor</td></tr>
                    </table>
                </td>                                     
            </tr>                
			</table>
		</fieldset>
	</div>	
    <div class="col width-20">        
		<fieldset class="adminform">        
		<legend>Componente Mecanicos<input type="checkbox" id="commec" name="cm[]" class="nodo"/></legend>        
			<table class="admintable">				
             <tr >                       
                <td>                                        
                    <table>
                    <tr><td><input type="checkbox" id="compmecclaxon" name="cm[]" class="item"/>Clax&oacute;n</td></tr>
                    <tr><td><input type="checkbox" id="compmectaponradiador" name="cm[]" class="item"/>Tap&oacute;n Radiador</td></tr>
                    <tr><td><input type="checkbox" id="compmectaponaceite" name="cm[]" class="item"/>Tap&oacute;n Aceite</td></tr>
                    <tr><td><input type="checkbox" id="compmecfiltroaceite" name="cm[]" class="item"/>Filtro Aceite</td></tr>
                    <tr><td><input type="checkbox" id="compmecfiltroaire" name="cm[]" class="item"/>Filtro Aire</td></tr>
                    <tr><td><input type="checkbox" id="compmecbateria" name="cm[]" class="item"/>Bateria</td></tr>
                    </table>
                </td>                                    
            </tr>                
			</table>
		</fieldset>
	</div>      
    </form> 
    
    <input type="hidden" id="id" value="<?php echo $_GET["id"]; ?>"/>
    <input type="hidden" id="idempresa" value="<?php echo $_SESSION["idempresa"]; ?>"/>    
    <script type="text/javascript">
	                    loaddata_autocomplet();					
						edit_data();
    </script>
    
    <div id="question" style="display:none; cursor: default"> 
        <img src="../images/info.png"><h5 id="confirmacion"><br />Esta a punto de borrar, todas las imagenes del Auto<br /><br />Desea Continuar?.<br /><br /></h5>
        <input type="button" id="si" value="Si" /> 
        <input type="button" id="no" value="No" />
        <br />
        <br /> 
    </div> 

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


