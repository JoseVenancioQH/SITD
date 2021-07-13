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
  <script type="text/javascript" src="../js/sitd_js_general.js"></script>
   <script type="text/javascript" src="../js/sitd_js_guardaraplicar_catcat.js"></script>
  <script type="text/javascript" src="../js/jquery.validationEngine-es.js"></script>
  <script type="text/javascript" src="../js/jquery.validationEngine.js"></script>
  <script type="text/javascript" src="../js/jquery-ui-1.10.2.custom.js"></script> 
  <!--<script type="text/javascript" src="../js/jquery.tablescroll.js"></script> -->
  
  
  <link rel="stylesheet" href="../css/system.css" type="text/css" />
  <link rel="stylesheet" href="../css/template.css" type="text/css" />
  <link rel="stylesheet" href="../css/validationEngine.jquery.css" type="text/css" />
  <link rel="stylesheet" href="../css/jquery-ui-1.10.2.custom.css" type="text/css" />
 
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
                               
                              <td class="button" id="toolbar-apply" style="display:<?php if($_GET["tipo"]=='edit') echo 'inline;'; else echo 'none;';?>">
                              <a href="#" onclick="javascript:validar('aplicar');" class="toolbar">
                              <span class="icon-32-apply" title="Aplicar">
                              </span>
                              Aplicar
                              </a>
                              </td>
                               
                              <td class="button" id="toolbar-cancel">
                              <a href="sitd_mod_lista_catcat.php" class="toolbar">
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
                        <div class="header icon-48-red-catcat-<?php echo $_GET["tipo"]; ?>"><?php echo $_GET["texto"]; ?></div>
         
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
            	
    <form id="form_catcat">
    <div id="tabla_desplegado">	
	<div class="col width-100">       
		<fieldset class="adminform">
		<legend>Datos de Categoria</legend>
			<table class="admintable" cellspacing="1">
                <tr>
					<td width="150" class="key">
						<label for="rama">Nombre Categoria</label>
					</td>
					<td>                       
						<input name="cat" id="cat" class="validate[required] inputbox" size="60" type="text" value="" />
					</td>
				</tr>
                <tr>
					<td width="150" class="key">
						<label for="catanoinicio">Año Inicio Categoria</label>
					</td>
					<td>                       
						<!--<input name="catanoinicio" id="catanoinicio" class="validate[required] inputbox" size="60" type="text" value="" />-->
                        <select name='catanoinicio' id='catanoinicio' class='validate[required] inputbox'>
                        <option value='' selected>- Selecciona A&ntilde;o Inicio -</option>
                        </select>
					</td>
				</tr>
                <tr>
					<td width="150" class="key">
						<label for="catanofin">Año Final Categoria</label>
					</td>
					<td>                       
						<!--<input name="catanofin" id="catanofin" class="validate[required] inputbox" size="60" type="text" value="" />-->
                        <select name='catanofin' id='catanofin' class='validate[required] inputbox'>
                        <option value='' selected>- Selecciona A&ntilde;o Fin -</option>
                        </select>
					</td>
				</tr>                             			
				<tr>
					<td class="key">
						<label for="eventonacional">Evento Nacional</label>
					</td>
					<td>
                         <?php include("../scripts/clases/class.sitd_cat_cat.php");$catcat = new catcat(); ?>                 
				         <?php $catcat->listar_catalogo('eventonacional',$_SESSION["id"]);?>						
					</td>
				</tr>
                <tr>
					<td class="key">
						<label for="deportes">Deportes</label>
					</td>
					<td>                                          
				        <select name='filter_deportes' id='filter_deportes' class='validate[required] inputbox' disabled='disabled'>
                        <option value='' selected>- Selecciona Deporte -</option>
                        </select> 						
					</td>
				</tr>
                <tr>
					<td class="key">
						<label for="rama">Rama</label>
					</td>
					<td>
				        <select name='filter_rama' id='filter_rama' class='validate[required] inputbox' disabled='disabled'>
                        <option value='' selected>- Selecciona Rama -</option>
                        </select>						
					</td>
				</tr>
                <tr>
					<td class="key">
						<label for="moddep">Modalidad Deportiva</label>
					</td>
					<td>
				        <select name='filter_moddep' id='filter_moddep' class='inputbox' disabled='disabled'>
                        <option value='' selected>- Selecciona Modalidad Deportiva -</option>
                        </select> 						
					</td>
				</tr>												
			</table>
		</fieldset>
	</div>	
    <div id="scrolltb" class="col width-100" style="height:200px; overflow:scroll">         
		<fieldset class="adminform">
		<legend>Pruebas de la Categoria</legend>
			<table class="admintable" cellspacing="1">
                <tr>
					<td width="150" class="key">
						<label for="prueba">Nombre Prueba</label>
					</td>
					<td>                       
						<input name="prueba" id="prueba" class="inputbox" size="60" type="text" value="" />
					</td>
                    <td><input name="add" id="add" class="inputbox" size="60" type="button" value="Agregar" /></td>
				</tr>
                <tr> 
                <div>              
				<table id="tbprueba" class="adminlist" cellpadding="1">
                 <thead>
                  <tr>
                    <th width="2%" class="title">#</th>                    				    	
                    <th width="3%" class="title">
					   Eliminar
					</th>			
				    <th width="15%" class="title">
                       Nombre Prueba
                    </th>					
                  </tr>
                 </thead>                       
				 <tbody>                 
                 </tbody>                                 
				</table>                
                </div>
               <tr>				                           																			
			</table>
		</fieldset>
     
	</div>
    </form> 
    
    <input type="hidden" id="idusuario" value="<?php echo $_SESSION["id"];?>"/>
    <input type="hidden" id="id" value="<?php echo $_GET["id"];?>"/>    
    <script type="text/javascript">edit_data();</script>
    <script type="text/javascript">var d = new Date(); d=d.getFullYear(); for (var i = d; i >= 1940; i--){jQuery('#catanoinicio, #catanofin').append('<option value="'+i+'">'+i+'</option>');}</script>
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
		<a href="#" target="_blank">INSUDE - Instituto Sudcaliforniano del Deporte</a>
		<?php echo $_SESSION["nombre"]; ?> <a href="#">Sistema T&eacute;cnico Deportivo de BCS</a>.	</p>
    </div>
</body>
</html>


