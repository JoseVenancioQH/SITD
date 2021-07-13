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
  <script type="text/javascript" src="../js/mootools.js"></script>
  <script type="text/javascript" src="../js/sitd_js_general.js"></script>
  <script type="text/javascript" src="../js/sitd_js_guardaraplicar_usuarios.js"></script>
  <script type="text/javascript" src="../js/jquery.validationEngine-es.js"></script>
  <script type="text/javascript" src="../js/jquery.validationEngine.js"></script>
  
  
  <link rel="stylesheet" href="../css/system.css" type="text/css" />
  <link rel="stylesheet" href="../css/template.css" type="text/css" />
  <link rel="stylesheet" href="../css/validationEngine.jquery.css" type="text/css" />
  
 
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
                              <a href="sitd_mod_lista_usuarios.php" class="toolbar">
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
                        <div class="header icon-48-user<?php echo $_GET["tipo"]; ?>"><?php echo $_GET["texto"]; ?></div>
         
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
            	
    <form id="form_usuario">
    <div id="tabla_desplegado">	
	<div class="col width-30">
        
		<fieldset class="adminform">
		<legend>Datos de Usuario</legend>
			<table class="admintable" cellspacing="1">
                <!--<tr>
					<td width="150" class="key">
						<label for="name">Empresa</label>
					</td>
					<td>
                        
						<select name="empresa" id="empresa" class="validate[required] inputbox">-->                            
                           <?php /*?> <?php			    
							  include("../scripts/clases/class.sitd_usuarios.php");
							  $usuarios = new usuarios();							  
							  $usuarios->mostrarEmpresa();						      
						   ?>   <?php */?>                         
                        <!--</select>
					</td>
				</tr>-->
                <tr>
					<td width="150" class="key">
						<label for="name">Municipio</label>
					</td>
					<td>
                        <?php include("../scripts/clases/class.sitd_usuarios.php");$usuarios = new usuarios(); ?>     
                        <?php $usuarios->listar_catalogo('municipio',$_SESSION["id"]);?>
						<!--<input type="text" name="municipio" id="municipio" class="inputbox" size="40" value="" />-->
					</td>                   
				</tr>
				<tr>
					<td width="150" class="key">
						<label for="name">Nombres</label>
					</td>
					<td>
						<input type="text" name="nombre" id="nombre" class="validate[required] inputbox" size="40" value="" />
					</td>                   
				</tr>
                <tr>
                    <td width="150" class="key">
						<label for="name">Apellido Paterno</label>
					</td>
					<td>
						<input type="text" name="appaterno" id="appaterno" class="validate[required] inputbox" size="40" value="" />
					</td>
                </tr>    
                <tr>    
                    <td width="150" class="key">
						<label for="name">Apellido Materno</label>
					</td>
					<td>
						<input type="text" name="apmaterno" id="apmaterno" class="validate[required] inputbox" size="40" value="" />
					</td>
                </tr>    
				<tr>
					<td class="key">
						<label for="username">Nombre de Usuario</label>
					</td>
					<td>
						<input type="text" name="nomusuario" id="nomusuario" class="validate[required] inputbox" size="40" value="" autocomplete="off" />
					</td>
				</tr>				
				<tr>
					<td class="key">
						<label for="password">Contrase&ntilde;a</label>
					</td>
					<td>
						<input class="validate[required] inputbox" type="password" name="password" id="password" size="40" value=""/>
					</td>
				</tr>
				<tr>
					<td class="key">
						<label for="password2">Verificaci&oacute;n de Contrase&ntilde;a</label>
					</td>
					<td>
						<input class="validate[required] inputbox" type="password" name="password2" id="password2" size="40" value=""/>
					</td>
				</tr>				
			</table>
		</fieldset>
	</div>
    
	<div class="col width-70">
		<fieldset class="adminform">
		<legend>Status de Usuario</legend>
			<table class="admintable">
				<tr>
					<td width="150" class="key">
						<label for="perfil">Perfil</label>
					</td>
					<td>                        
						<select name="perfil" id="perfil" class="inputbox">                            
                            <option value="" selected="selected">- Selecciona Rol -</option>
                            <option value="superadmin">Super Administrador</option>
                            <option value="admin">Administrador</option>
                            <option value="asodep">Asociaci&oacute;n Deportiva</option>
                            <option value="evaseg">Evaluaci&oacute;n y Seguimiento</option>
                            <option value="evedep">Evento Deportivo</option>
                            <option value="reg">Registrador</option>
                            <option value="invitado">Invitado</option>                         
                        </select>
					</td>
                 </tr>
                 <tr >   
                    <td width="150" class="key">
						<label for="accion">Acci&oacute;n<input type="checkbox" id="accion" name="ac[]" class="validate[required] nodo"/></label>
					</td>
					<td>                        
						<table><tr>
                          <td><input type="checkbox" id="grabar" name="ac[]" class="item"/>Grabar</td>
                          <td><input type="checkbox" id="editar" name="ac[]" class="item"/>Editar</td>
                          <td><input type="checkbox" id="borrar" name="ac[]" class="item"/>Borrar</td>
                        </tr></table>
					</td>
				</tr>
                <tr>   
                    <td width="150" class="key">
						<label for="privilegios">Privilegios<input type="checkbox" id="priv" name="priv[]" class="validate[required] padre"/></label>
					</td>
					<td>                        
						<table>
                         <tr>
                          <td width="150" class="key">
                          <label for="sistema">Sistema<input type="checkbox" id="sis" name="sis[]" class="nodo"/></label>
					      </td>
                          <td><input type="checkbox" id="sisusu" name="sis[]" class="item"/>Gestor Usuario</td>
                          <td><input type="checkbox" id="sispc" name="sis[]" class="item"/>Panel Control</td>
                         </tr>
                        <tr>
                          <td width="150" class="key">
						   <label for="inventario">Cat&aacute;logos (1)<input type="checkbox" id="cat" name="cat[]" class="nodo"/></label>
					      </td>                                           
                          <td><input type="checkbox" id="catrama" name="cat[]" class="item"/>Rama</td>
                          <td><input type="checkbox" id="catmodentdep" name="cat[]" class="item"/>Mod. Ent. Dep.</td>
                          <td><input type="checkbox" id="catdep" name="cat[]" class="item"/>Deportes</td>
                          <td><input type="checkbox" id="catclub" name="cat[]" class="item"/>Club</td>                          
                        </tr>
                        <tr>
                          <td width="150" class="key">
						   <label for="cat1">Cat&aacute;logos (2)<input type="checkbox" id="cat1" name="cat1[]" class="nodo"/></label>
					      </td>                                                                    
                          <td><input type="checkbox" id="catliga" name="cat1[]" class="item"/>Liga</td>
                          <td><input type="checkbox" id="catevenac" name="cat1[]" class="item"/>Evento Nac.</td> 
                          <td><input type="checkbox" id="catmun" name="cat1[]" class="item"/>Municipio</td>
                          <td><input type="checkbox" id="catasodep" name="cat1[]" class="item"/>Asoc. Dep.</td>                          
                        </tr>
                        <tr>
                          <td width="150" class="key">
						   <label for="cat2">Cat&aacute;logos (3)<input type="checkbox" id="cat2" name="cat2[]" class="nodo"/></label>
					      </td>                                                                     
                          <td><input type="checkbox" id="catprueba" name="cat2[]" class="item"/>Pruebas</td>
                          <td><input type="checkbox" id="catmoddep" name="cat2[]" class="item"/>Mod. Dep.</td>
                          <td><input type="checkbox" id="cateveint" name="cat2[]" class="item"/>Evento Int.</td>
                          <td><input type="checkbox" id="catest" name="cat2[]" class="item"/>Estado</td>                          
                        </tr>
                        <tr>
                          <td width="150" class="key">
						   <label for="cat3">Cat&aacute;logos (4)<input type="checkbox" id="cat3" name="cat3[]" class="nodo"/></label>
					      </td>                                                                                               
                          <td><input type="checkbox" id="catcat" name="cat3[]" class="item"/>Categor&iacute;a</td>
                          <td><input type="checkbox" id="catasodepmd" name="cat3[]" class="item"/>Asoc. Dep. Mesa Dir.</td>
                        </tr>
                        <tr>
                          <td width="150"  class="key">
                           <label for="asodep">Asociaci&oacute;n Dep. (1)<input type="checkbox" id="asodep" name="asodep[]" class="nodo"/></label>
                          </td>
                          <td><input type="checkbox" id="asodepvincular" name="asodep[]" class="item"/>Vincular Ente</td>
                          <td><input type="checkbox" id="asodepimprimir" name="asodep[]" class="item"/>Imprimir Asoc. Dep.</td>
                          <td><input type="checkbox" id="asodepimpsirred" name="asodep[]" class="item"/>Imprimir SIRRED</td>
                          <td><input type="checkbox" id="asodepimpcedula" name="asodep[]" class="item"/>C&eacute;dula de Inscripci&oacute;n</td>                        </tr>
                        <tr>
                          <td width="150"  class="key">
                           <label for="asodep2">Asociaci&oacute;n Dep. (2)<input type="checkbox" id="asodep2" name="asodep2[]" class="nodo"/></label>
                          </td>                          
                          <td><input type="checkbox" id="asodepimpcredencial" name="asodep2[]" class="item"/>Credencial</td>
                          <td><input type="checkbox" id="asodepimpreportes" name="asodep2[]" class="item"/>Reportes</td>
                        </tr>
                        
                        <tr>
                          <td width="150"  class="key">
                           <label for="evaseg">Evaluaci&oacute;n y Seg.<input type="checkbox" id="evaseg" name="evaseg[]" class="nodo"/></label>
                          </td>
                          <td><input type="checkbox" id="evasegvincular" name="evaseg[]" class="item"/>Vincular Ente</td>
                          <td><input type="checkbox" id="evasegimprimir" name="evaseg[]" class="item"/>Imprimir Eva. Seg.</td>
                          <td><input type="checkbox" id="evasegimpcurriculum" name="evaseg[]" class="item"/>Imprimir Curriculum</td>
                          <td><input type="checkbox" id="evasegimpreportes" name="evaseg[]" class="item"/>Imprimir Reporte</td>                        </tr>                        
                          
                        <tr>
                          <td width="150"  class="key">
                           <label for="evedep">Evento Deportivo (1)<input type="checkbox" id="evedep" name="evedep[]" class="nodo"/></label>
                          </td>
                          <td><input type="checkbox" id="evedepvincular" name="evedep[]" class="item"/>Vincular Ente</td>
                          <td><input type="checkbox" id="evedepvalidar" name="evedep[]" class="item"/>Validar</td>
                          <td><input type="checkbox" id="evedepresultados" name="evedep[]" class="item"/>Resultados</td>
                          <td><input type="checkbox" id="evedepimprimir" name="evedep[]" class="item"/>Imprimir Evento Dep.</td>                        </tr>
                          
                        <tr>
                          <td width="150"  class="key">
                           <label for="evedep1">Evento Deportivo (2)<input type="checkbox" id="evedep1" name="evedep1[]" class="nodo"/></label>
                          </td>
                          <td><input type="checkbox" id="evedepimpcedula" name="evedep1[]" class="item"/>C&eacute;dula de Inscripci&oacute;n</td>
                          <td><input type="checkbox" id="evedepimpgaffete" name="evedep1[]" class="item"/>Gaffetes</td>
                          <td><input type="checkbox" id="evedepimpreportes" name="evedep1[]" class="item"/>Reportes</td>
                          <td><input type="checkbox" id="evedepimpresultados" name="evedep1[]" class="item"/>Resultados</td>                        </tr>    
                        
                        <tr>
                          <td width="150"  class="key">
                           <label for="regentdep">Registro Ente Dep.<input type="checkbox" id="regentdepmenu" name="regentdep[]" class="nodo"/></label>
                          </td>
                          <td><input type="checkbox" id="regentdepitem" name="regentdep[]" class="item"/>Registro Ente Dep.</td>                        
                        </tr>
                        <tr>
                          <td width="150"  class="key">
                           <label for="imprimir">Imprimir<input type="checkbox" id="imp" name="imp[]" class="nodo"/></label>
                          </td>
                          <td><input type="checkbox" id="impcredencial" name="imp[]" class="item"/>Credencial</td>
                          <td><input type="checkbox" id="impstatus" name="imp[]" class="item"/>Status</td>
                          <td><input type="checkbox" id="impreporte" name="imp[]" class="item"/>Reportes</td>                         </tr>
                        
                       </table>
					</td>
				</tr>
			</table>
		</fieldset>	
       
	</div>
    </form> 
    
    <input type="hidden" id="id" value="<?php echo $_GET["id"]; ?>"/>    
    <script type="text/javascript">edit_data();</script>

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
              <a href="#" target="_blank">Registro Estatal del Deporte - </a>
              <a href="http://www.insude.gob.mx">Instituto Sudcaliforniano del Deporte</a>.
          </p>
    </div>
</body>
</html>


