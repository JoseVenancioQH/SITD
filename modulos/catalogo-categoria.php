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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Catalogo Prueba | Registro Estatal de Deporte - QSERVICE - Integrate</title>
<link rel="stylesheet" href="../css/screen.css" type="text/css" media="screen, projection">
<link type="text/css" href="../css/theme/ui.all.css" rel="Stylesheet" />
<link rel="stylesheet" href="../css/validationEngine.jquery.css" type="text/css" media="screen" charset="utf-8" />
<!--[if IE]><link rel="stylesheet" href="../css/ie.css" type="text/css" media="screen, projection"><![endif]-->
<script type="text/javascript" src="../js/jquery-1.3.1.js"></script>
<!--<script type='text/javascript' src='../js/jquery.highlightFade.js'></script>
<script type="text/javascript" src="../js/jquery-ui-personalized-1.6rc6.js"></script>--> 
<script type="text/javascript" src="../js/controller-unBlock.js" ></script>
<script type="text/javascript" src="../js/controller-categoria.js"></script>
<script type="text/javascript" src="../js/jquery.validationEngine.js"></script>
<script type="text/javascript" src="../js/jquery.blockUI.js" ></script>
<script type="text/javascript" src="../js/jquery.maskedinput-1.2.2.js" ></script>

</head>
<body>
<div class="container">		
    
    <div id="header">
   	  <div id="user_id">Bienvenido <?php echo $_SESSION["nombre"]; ?> | <a title="salir del sistema" href="../scripts/close-session.php">Salir</a></div>
	  <h1><img alt="QSERVICE - Integrate" src="../img/logo.png" /> RED - - Empresa Autorizada -</h1>
    </div>
    
    <div id="navegacion"> 
       <ul id="menu">
        <?php
			$seccion = "catalogo";
			include("../scripts/menu.php");
        ?>       
        </ul>             
            <ul id="submenu">
                <?php
			        $seccion = "categoria";
			        include("../scripts/menu-catalogo.php");
                ?>
            </ul>            
    </div>
    
    <div id="form">
             <h2>Agregar Categoria</h2>
			 
			 <form name="grabar-categoria" id="grabar-categoria" method="post" action="">             	
             <fieldset><legend>Datos de Categoria <img alt="Limpia Datos de Categoria" style="vertical-align:middle; cursor:pointer;" src="../img/icons/trash.png" onclick="javascript:limpiarform();"/></legend>		 
			
			    <div class="span-7" id="clone_eventos">
				<p>
				<label for="evento">Evento: </label>
				<?php generaeventos("evento",$_SESSION["evento"]); ?>				
				</p>
				</div>				
				
			    <div class="span-7" id="clone_deportes">
				<p>
				<label for="nombredeporte">Deporte: </label>
				<?php generadeporte("deportes"); ?>				
				</p>
				</div>
				
				<script type="text/javascript">
				$("#deportes").addClass("validate[required] span-7 cselect");
				</script>		
				
				<div class="span-7">
				<p>
				<label for="nombredeporte">Rama: </label>
				  <select name="rama" id="rama" size="1" class='validate[required] span-7 cselect'>
				  <option value="" selected>Elige</option>
				  <option value="Femenil">Femenil</option>
				  <option value="Varonil">Varonil</option>
				  <option value="Mixto">Mixto</option>				  
				  </select>				
				</p>
				</div>				
				
				<div class="clear"></div>
				
			    <div class="span-6">
				<p>
				<label for="nombrecategoria">Nombre de Categoria: </label>
				<input  alt="Nombre Categoria" class="validate[required,length[0,150]] span-6 text" id="nombrecategoria" name="nombrecategoria" type="text"/>				
				</p>
				</div>
							
				<div class="span-2">
				<p>
				<label for="anoinicio">Inicio: </label>
				<input alt="A&ntilde;o de Inicio de Categoria" class="validate[required,custom[onlyNumber],length[0,4]] span-2 text" id="anoinicio" name="anoinicio" type="text"/>				
				</p>
				</div>
				
				<div class="span-2">
				<p>
				<label for="anofin">Final: </label>
				<input alt="A&ntilde;o Final de Categoria" class="validate[required,custom[onlyNumber],length[0,4]] span-2 text" id="anofin" name="anofin" type="text"/>				
				</p>
				</div>
				
				<div class="span-12">
				
				<label for="anofin">Pruebas: </label>
				<p>				
				<input alt="Pruebas" class="span-8 text" id="pruebas" name="pruebas" type="text"/>				
				<input id="agregar-prueba" name="agregar-prueba" type="button" value="Agregar Prueba"/>
				</p>
				</div>
				
				<div class="span-20">
				<p>
				<label for="pruebas-text">Pruebas: </label><img alt="Limpia Datos de Prueba" style="vertical-align:middle; cursor:pointer;" src="../img/icons/trash.png" onclick="javascript:borradototal();"/>
				</p>
				</div>
				
				
				<div id="contenedor_pruebas" class="span-23">					
				<ul id = "lista_pruebas" style="float:left; list-style:none; width:100%; height:auto;">										
				</ul>				
				</div>				
			 <input id="listapruebas" name="listapruebas" type="hidden"/>
			 <input id="idusuario" name="idusuario" type="hidden" value="<?php echo $_SESSION["id"]; ?>"/>				
			 </fieldset>		 
			 <input id="grabar_categoris_buttom" type="submit" value="Grabar Categoria"/>			 			 
             </form>		 	 					   			 
        </div>
		
        <fieldset><legend>Lista de Categorias Registradas</legend>
		<label style="float:right;">Ultimos Registrados <img alt="Refrescar Lista" style="vertical-align:middle; cursor:pointer;" src="../img/icons/refresh.png" onclick="javascript:statususuario='activado'; $('#deportes_lista').val(''); $('#evento_lista').val(''); GenerarLista_Categoria();"/></label>
		<div id="clone_busca" style="width:100%;">
		<div class="span-7" id="clone_eventos">
		<p>
		<label for="evento">Evento: </label>
		<?php generaeventos("evento_lista",$_SESSION["evento"]); ?>				
		</p>
		</div>				
				
	    <div class="span-7" id="clone_deportes">
		<p>
		<label for="nombredeporte">Deporte: </label>
		<?php generadeporte("deportes_lista"); ?>				
		</p>
		</div>
		
		<script type="text/javascript">
				$("#deportes_lista").addClass("validate[required] span-7 cselect");
				</script>		
		<input id="buscar_categoria" onclick="javascript:GenerarLista_Categoria();" type="button" value="Buscar" style="margin-top:30px;"/>
		   	
		</div>
		
		<!--<div id="buscar_ultimos" style="width:20%; float:left;">
		<label for="pruebas-text">Ultimos Registrados <img alt="Refrescar Lista" style="vertical-align:middle; cursor:pointer;" src="../img/icons/refresh.png" onclick="javascript:GenerarLista_Categoria();"/></label>
		</div>-->
	 
		<div class="scroll">
		     <table>
             <thead>        	   
               <th>Evento</th>
			   <th>Deporte</th>
			   <th>Rama</th>
			   <th>Nombre</th>
			   <th>A&ntilde;o Inicio</th>
			   <th>A&ntilde;o Fin</th>
			   <th>Pruebas</th>			   
			   <th>Eliminar</th>
			   <th>Editar</th>
             </thead>		 
             <tbody id = "lista_categorias">		 		 
			 </tbody>			  		 
             </table>	    
		</div>	  	    
		</fieldset>	
		<div id="footer">
   		<p>&copy; <?php echo date("Y"); ?> <a title="QSERVICE - Integrate" href="#" target="_blank">QSERVICE - Integrate</a> &reg;  - Todos los Derechos Reservados - Desarrollado por <a title="Reality in a digital world" href="#" target="_blank">- Empresa Autorizada -</a></p>
	</div>        
</div>    
</body>
</html>
