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
  <title>SITD BCS Administración</title>
  <link href="favicon.ico" rel="shortcut icon" type="image/x-icon" /> 
  
  <script type="text/javascript" src="../js/jquery-1.6.js"></script>
  <script type="text/javascript" src="../js/mootools.js"></script>
  <script type="text/javascript" src="../js/sitd_js_lista_catcat.js"></script>
  <script type="text/javascript" src="../js/jquery.blockUI.js"></script> 
  <script type="text/javascript" src="../js/jquery.colorbox.js"></script>
  
  <link rel="stylesheet" href="../css/system.css" type="text/css" />
  <link rel="stylesheet" href="../css/template.css" type="text/css" />
  <link rel="stylesheet" href="../css/colorbox.css" type="text/css" /> 
 
  <!--[if IE 7]>
  <link href="../css/ie7.css" rel="stylesheet" type="text/css" />
  <![endif]-->
 
  <!--[if lte IE 6]>
  <link href="../css/ie6.css" rel="stylesheet" type="text/css" />
  <![endif]-->
 
  <link rel="stylesheet" type="text/css" href="../css/rounded.css" />
 
  <script type="text/javascript" src="../js/menu.js"></script>
  <script type="text/javascript" src="../js/index.js"></script> 

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
             <?php include("../scripts/menu.php"); ?>
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
                              
                              <!--<td class="button" id="toolbar-publish">
                              <a href="#" onclick="javascript:status('habilitar')" class="toolbar">
                              <span class="icon-32-publish" title="Habilitar">
                              </span>
                              Habilitar
                              </a>
                              </td>
                              
                              <td class="button" id="toolbar-unpublish">
                              <a href="#" onclick="javascript:status('deshabilitar')" class="toolbar">
                              <span class="icon-32-unpublish" title="Deshabilitar">
                              </span>
                              Deshabilitar
                              </a>
                              </td>-->

                              <td class="button" id="toolbar-editargrupo">
                              <a href="#" onclick="javascript:operacion('addall','Editar Grupo Categoria')" class="toolbar">
                              <span class="icon-32-editall" title="Borrar">
                              </span>
                              Editar Nuevo Grupo
                              </a>
                              </td>
                               
                              <td class="button" id="toolbar-delete">
                              <a href="#" onclick="javascript:borrar()" class="toolbar">
                              <span class="icon-32-delete" title="Borrar">
                              </span>
                              Borrar
                              </a>
                              </td>
                               
                              <td class="button" id="toolbar-edit">
                              <a href="#" onclick="javascript:operacion('edit','Editar Categoria')" class="toolbar">
                              <span class="icon-32-edit" title="Editar">
                              </span>
                              Editar
                              </a>
                              </td>
                               
                              <td class="button" id="toolbar-new">
                              <a href="#" onclick="javascript:operacion('add','Nueva Categoria');" class="toolbar">
                              <span class="icon-32-new" title="Nuevo">
                              </span>
                              Nuevo
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
                        <div class="header icon-48-red-catcat">Cat&aacute;logo Categoria</div>
         
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
 

	<table>
		<tr>
			<td width="100%">				
                Filtro:
				<input type="text" id="search" value="" class="text_area"/>
				<button id="ir">Ir</button>
				<button id="restablecer">Restablecer</button>
			</td>	
            <td nowrap="nowrap">
                 <select name='catanoinicio' id='catanoinicio' class='validate[required] inputbox'>
                 <option value='' selected>- Selecciona A&ntilde;o Inicio -</option>
                 </select>
                 <select name='catanofin' id='catanofin' class='validate[required] inputbox'>
                 <option value='' selected>- Selecciona A&ntilde;o Fin -</option>
                 </select>
                 <?php include("../scripts/clases/class.sitd_cat_cat.php");$catcat = new catcat(); ?>     
                 <?php $catcat->listar_catalogo('eventonacional',$_SESSION["id"]);?>                                      
                 <select name='filter_deportes' id='filter_deportes' class='inputbox' disabled='disabled'>
                 <option value='' selected>- Selecciona Deporte -</option>
                 </select>                              
                 <select name='filter_rama' id='filter_rama' class='inputbox' disabled='disabled'>
                 <option value='' selected>- Selecciona Rama -</option>
                 </select>
                 <select name='filter_moddep' id='filter_moddep' class='inputbox' disabled='disabled'>
                 <option value='' selected>- Selecciona Modalidad Deportiva -</option>
                 </select>                     				 
            </td>		
        </tr>    
	</table>
    <div id="tabla_desplegado">
	           <?php			                    
				$catcat->limite=10;
				$catcat->filtro='';
				$catcat->campo='ca.id_categoria';
				$catcat->orden='desc';
				$catcat->pagina=1;
				$catcat->paginado=0;
				$catcat->idusuario=$_SESSION["id"];
				$catcat->mostrarCatCat();
              ?>
    </div> 
    <script type="text/javascript">
     jQuery('#tabla_desplegado tbody tr').each(function(){
		if(this.id!='')jQuery("a[rel='"+this.id+"']").colorbox({slideshow:true});		
	 });
	 jQuery('#catanoinicio').change(function(){
		   /*var d = new Date(); 
		   d=d.getFullYear(); */		   
		   jQuery('#catanofin').empty().append('<option value="" selected>- Selecciona A&ntilde;o Fin -</option>')
		   for (var i = this.value; i >= 1940; i--){
			   jQuery('#catanofin').append('<option value="'+i+'">'+i+'</option>');
		   }			
	 });
    </script>       
    <script type="text/javascript">var d = new Date(); d=d.getFullYear(); for (var i = d; i >= 1940; i--){jQuery('#catanoinicio, #catanofin').append('<option value="'+i+'">'+i+'</option>');}</script>
    <input type="hidden" id="idusuario" value="<?php echo $_SESSION["id"]; ?>"/>
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

