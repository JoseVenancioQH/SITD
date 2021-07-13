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
  <script type="text/javascript" src="../js/caut_js_lista_empresa.js"></script>
  
  <link rel="stylesheet" href="../css/system.css" type="text/css" />
  <link rel="stylesheet" href="../css/template.css" type="text/css" />
 
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
                              
                              <td class="button" id="toolbar-publish">
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
                              </td>

                               
                              <td class="button" id="toolbar-delete">
                              <a href="#" onclick="javascript:borrar()" class="toolbar">
                              <span class="icon-32-delete" title="Borrar">
                              </span>
                              Borrar
                              </a>
                              </td>
                               
                              <td class="button" id="toolbar-edit">
                              <a href="#" onclick="javascript:operacion('edit','Editar Empresa')" class="toolbar">
                              <span class="icon-32-edit" title="Editar">
                              </span>
                              Editar
                              </a>
                              </td>
                               
                              <td class="button" id="toolbar-new">
                              <a href="#" onclick="javascript:operacion('add','Nueva Empresa');" class="toolbar">
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
                        <div class="header icon-48-empresa">Registro de Empresa</div>
         
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
        </tr>    
	</table>
    <div id="tabla_desplegado">
	           <?php			    
                include("../scripts/clases/class.sitd_catrama.php");
				$empresa = new empresa();
				$empresa->limite=10;
				$empresa->filtro='';
				$empresa->campo='id_empresa';
				$empresa->orden='desc';
				$empresa->pagina=1;
				$empresa->paginado=0;
				$empresa->mostrarEmpresa();
              ?>
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

