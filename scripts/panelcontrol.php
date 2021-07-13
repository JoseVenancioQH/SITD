<?php
	     $raw = explode(",",$_SESSION["modulos"]);		 
		 $nomodulos = count($raw);
		 $a = $raw;		 
		 /*$a = array_reverse($raw);*/		 
		 $panel_control = '';
		 		 
		 for($i=0;$i<$nomodulos;$i++)
		 {		 
		 	switch($a[$i])
			{	 
			   case "asodepvincular":
			   $panel_control .="<div style=\"float:left;\">
				  <div class=\"icon\">
					<a href=\"caut_mod_lista_invauto.php\"><img src=\"../images/header/icon-48-red-vincularasociaciondeportiva.png\" alt=\"Inventario de Autos\"/><span>Vincular Asociaci&oacute;n Deportiva</span></a>
				  </div>
			   </div>";break;
			  
			  case "evasegvincular": 
			  $panel_control .="<div style=\"float:left;\">
				<div class=\"icon\">
					<a href=\"caut_mod_lista_clientes.php\"><img src=\"../images/header/icon-48-red-vincularevaluacionseguimiento.png\" alt=\"Inventario de Clientes\"  /><span>Vincular Evaluaci&oacute;n y Seguimiento</span></a>
				</div>
			  </div>";break;
			  
			  case "evedepvincular": 
			  $panel_control .="<div style=\"float:left;\">
				<div class=\"icon\">
					<a href=\"caut_mod_lista_clientesaval.php\"><img src=\"../images/header/icon-48-red-vinculareventodeportivo.png\" alt=\"Inventario de Aval Clientes\"  /><span>Vincular Evento Deportivo</span></a>
				</div>
			  </div>";break;
			  
			  case "regentdep": 
			  $panel_control .="<div style=\"float:left;\">
				<div class=\"icon\">
					<a href=\"caut_mod_lista_invcosto.php\"><img src=\"../images/header/icon-48-red-registroentedeportivo.png\" alt=\"Inventario Costo Auto\"  /><span>Registro Ente Deportivo</span></a>
				</div>
			  </div>";break;
			  
			 case "sisusu":							   
			 $panel_control .="<div style=\"float:left;\">
			   <div class=\"icon\">
				   <a href=\"index.php?option=com_frontpage\"><img src=\"../images/header/icon-48-red-usuario.png\" alt=\"Venta de Auto\"/><span>Gestor de Usuarios</span></a>
			   </div>
			 </div>";break;
			 
			 case "catrama":
			 $panel_control .="<div style=\"float:left;\">
			   <div class=\"icon\">
				   <a href=\"index.php?option=com_frontpage\"><img src=\"../images/header/icon-48-red-catrama.png\" alt=\"Abonos\"/><span>Cat&aacute;logo Rama</span></a>
			   </div>
			 </div>";break;
			 
			 case "catmodentdep":
			$panel_control .="<div style=\"float:left;\">
			   <div class=\"icon\">
				  <a href=\"index.php?option=com_sections&amp;scope=content\"><img src=\"../images/header/icon-48-red-catmodentdep.png\" alt=\"Pagares\"  /><span>Cat&aacute;logo Modalidad Ente Dep.</span></a>
			   </div>
			</div>";break;
			
			case "catdep":
			$panel_control .="<div style=\"float:left;\">
			  <div class=\"icon\">
				 <a href=\"index.php?option=com_categories&amp;section=com_content\"><img src=\"../images/header/icon-48-red-catdeportes.png\" alt=\"Imprimir Cotizaci&oacute;n\"/><span>Cat&aacute;logo Deportes</span></a>
			  </div>
			</div>";break;
	        
			case "catclub":
			$panel_control .="<div style=\"float:left;\">
			 <div class=\"icon\">
				<a href=\"index.php?option=com_media\"><img src=\"../images/header/icon-48-red-catclub.png\" alt=\"Imprimir Inventario Cliente\"/><span>Cat&aacute;logo Club</span></a>
			 </div>
			</div>";break;
			
			case "catliga": 
			$panel_control .="<div style=\"float:left;\">
			 <div class=\"icon\">
				<a href=\"index.php?option=com_menus\"><img src=\"../images/header/icon-48-red-catliga.png\" alt=\"Imprimir Inventario Auto\"/><span>Cat&aacute;logo Liga</span></a>
			 </div>
			</div>";break;
			
			case "catevenac": 
			$panel_control .="<div style=\"float:left;\">
			 <div class=\"icon\">
				<a href=\"index.php?option=com_languages&amp;client=0\"><img src=\"../images/header/icon-48-red-cateventonacional.png\" alt=\"Imprimir Contrato\"/><span>Cat&aacute;logo Evento Nacional</span></a>
			 </div>
			</div>";break;                               
			
			case "catmun":
			$panel_control .="<div style=\"float:left;\">
			 <div class=\"icon\">
				<a href=\"index.php?option=com_config\"><img src=\"../images/header/icon-48-red-catmunicipio.png\" alt=\"Imprimir Pagares\"/><span>Cat&aacute;logo Municipio</span></a>
			 </div>
			</div>";break;
			
			case "catasodep":
			$panel_control .="<div style=\"float:left;\">
			 <div class=\"icon\">
				<a href=\"index.php?option=com_config\"><img src=\"../images/header/icon-48-red-catasocdep.png\" alt=\"Imprimir Resumen de Pago\"/><span>Cat&aacute;logo Asociaci&oacute;n Dep.</span></a>
			 </div>
			</div>";break;
			
			case "catprueba": 
			$panel_control .="<div style=\"float:left;\">
			 <div class=\"icon\">
				<a href=\"index.php?option=com_config\"><img src=\"../images/header/icon-48-red-catpruebas.png\" alt=\"Imprimir Deslinde de Responsabilidades\"/><span>Cat&aacute;logo Pruebas</span></a>
			 </div>
			</div>";break;
			
			case "catmoddep":
			$panel_control .="<div style=\"float:left;\">
			 <div class=\"icon\">
				<a href=\"index.php?option=com_config\"><img src=\"../images/header/icon-48-red-catmodalidaddep.png\" alt=\"Imprimir Resumen de Pagos\"/><span>Cat&aacute;logo Modalidad Dep.</span></a>
			 </div>
			</div>";break;
			
			case "cateveint":
			$panel_control .="<div style=\"float:left;\">
			 <div class=\"icon\">
				<a href=\"index.php?option=com_config\"><img src=\"../images/header/icon-48-red-cateventoint.png\" alt=\"Imprimir Resumen de Adeudo\"/><span>Cat&aacute;logo Evento Internacional</span></a>
			 </div>
			</div>";break;
			
			case "catest":
			$panel_control .="<div style=\"float:left;\">
			 <div class=\"icon\">
				<a href=\"index.php?option=com_config\"><img src=\"../images/header/icon-48-red-catestado.png\" alt=\"Imprimir Resumen de Vencimientos\"/><span>Cat&aacute;logo Estado</span></a>
			 </div>
			</div>";break;
			
			case "catcat": 
			$panel_control .="<div style=\"float:left;\">
			 <div class=\"icon\">
				<a href=\"index.php?option=com_config\"><img src=\"../images/header/icon-48-red-catcategoria.png\" alt=\"Cat&aacute;logo Categoria\"/><span>Cat&aacute;logo Categoria</span></a>
			 </div>
			</div>";break;
			
			case "asodepimpsirred": 
			$panel_control .="<div style=\"float:left;\">
			 <div class=\"icon\">
				<a href=\"index.php?option=com_config\"><img src=\"../images/header/icon-48-red-imprimirsirred.png\" alt=\"Imprimir Asoc. Dep. Sirred\"/><span>Imprimir Asoc. Dep. SIRRED</span></a>
			 </div>
			</div>";break;
			
			case "asodepimpcedula": 
			$panel_control .="<div style=\"float:left;\">
			 <div class=\"icon\">
				<a href=\"index.php?option=com_config\"><img src=\"../images/header/icon-48-red-imprimircedula.png\" alt=\"Imprimir Asoc. Dep. C&eacute;dula\"/><span>Imprimir Asoc. Dep. C&eacute;dula</span></a>
			 </div>
			</div>";break;
			
			case "asodepimpcredencial": 
			$panel_control .="<div style=\"float:left;\">
			 <div class=\"icon\">
				<a href=\"index.php?option=com_config\"><img src=\"../images/header/icon-48-red-imprimircredencial.png\" alt=\"Imprimir Asoc. Dep. Credencial\"/><span>Imprimir Asoc. Dep. Credencial</span></a>
			 </div>
			</div>";break;
			
			case "asodepimpreportes": 
			$panel_control .="<div style=\"float:left;\">
			 <div class=\"icon\">
				<a href=\"index.php?option=com_config\"><img src=\"../images/header/icon-48-red-imprimirreporte.png\" alt=\"Imprimir Asoc. Dep. Reportes\"/><span>Imprimir Asoc. Dep. Reportes</span></a>
			 </div>
			</div>";break;
			
			case "evasegimpcurriculum": 
			$panel_control .="<div style=\"float:left;\">
			 <div class=\"icon\">
				<a href=\"index.php?option=com_config\"><img src=\"../images/header/icon-48-red-imprimirevasegcurriculum.png\" alt=\"Imprimir Evaluaci&oacute;n y Seg. Curriculum\"/><span>Imprimir Evaluaci&oacute;n y Seg. Curriculum</span></a>
			 </div>
			</div>";break;
			
			case "evasegimpreportes": 
			$panel_control .="<div style=\"float:left;\">
			 <div class=\"icon\">
				<a href=\"index.php?option=com_config\"><img src=\"../images/header/icon-48-red-imprimirevasegreportes.png\" alt=\"Imprimir Evaluaci&oacute;n y Seg. Reportes\"/><span>Imprimir Evaluaci&oacute;n y Seg. Reportes</span></a>
			 </div>
			</div>";break;

            case "evedepvalidar": 
			$panel_control .="<div style=\"float:left;\">
			 <div class=\"icon\">
				<a href=\"index.php?option=com_config\"><img src=\"../images/header/icon-48-red-validarevedep.png\" alt=\"Validar Evento Deportivo\"/><span>Validar Evento Deportivo</span></a>
			 </div>
			</div>";break;
			
			case "evedepvalidar": 
			$panel_control .="<div style=\"float:left;\">
			 <div class=\"icon\">
				<a href=\"index.php?option=com_config\"><img src=\"../images/header/icon-48-red-validarevedep.png\" alt=\"Validar Evento Deportivo\"/><span>Validar Evento Deportivo</span></a>
			 </div>
			</div>";break;
			
			case "evedepresultados": 
			$panel_control .="<div style=\"float:left;\">
			 <div class=\"icon\">
				<a href=\"index.php?option=com_config\"><img src=\"../images/header/icon-48-red-resultadoseventodep.png\" alt=\"Validar Evento Deportivo\"/><span>Resultados Evento Deportivo</span></a>
			 </div>
			</div>";break;
			
			
			case "evedepimpcedula": 
			$panel_control .="<div style=\"float:left;\">
			 <div class=\"icon\">
				<a href=\"index.php?option=com_config\"><img src=\"../images/header/icon-48-red-cedulaeventodep.png\" alt=\"Imprimir C&eacute;dula Evento Deportivo\"/><span>Imprimir C&eacute;dula Evento Deportivo</span></a>
			 </div>
			</div>";break;
			
			case "evedepimpgaffete": 
			$panel_control .="<div style=\"float:left;\">
			 <div class=\"icon\">
				<a href=\"index.php?option=com_config\"><img src=\"../images/header/icon-48-red-gaffeteeventodep.png\" alt=\"Imprimir Gaffete Evento Deportivo\"/><span>Imprimir Gaffete Evento Deportivo</span></a>
			 </div>
			</div>";break;
			
			case "evedepimpreportes": 
			$panel_control .="<div style=\"float:left;\">
			 <div class=\"icon\">
				<a href=\"index.php?option=com_config\"><img src=\"../images/header/icon-48-red-reporteseventodep.png\" alt=\"Imprimir Reporte Evento Deportivo\"/><span>Imprimir Reporte Evento Deportivo</span></a>
			 </div>
			</div>";break;
			
			
			case "evedepimpresultados": 
			$panel_control .="<div style=\"float:left;\">
			 <div class=\"icon\">
				<a href=\"index.php?option=com_config\"><img src=\"../images/header/icon-48-red-imprimiresultadoseventodep.png\" alt=\"Imprimir Resultados Evento Deportivo\"/><span>Imprimir Resultados Evento Deportivo</span></a>
			 </div>
			</div>";break;
			
			case "impcredencial": 
			$panel_control .="<div style=\"float:left;\">
			 <div class=\"icon\">
				<a href=\"index.php?option=com_config\"><img src=\"../images/header/icon-48-red-imprimicredencial.png\" alt=\"Imprimir Credencial\"/><span>Imprimir Credencial</span></a>
			 </div>
			</div>";break;
			
			case "impstatus": 
			$panel_control .="<div style=\"float:left;\">
			 <div class=\"icon\">
				<a href=\"index.php?option=com_config\"><img src=\"../images/header/icon-48-red-imprimirstatus.png\" alt=\"Imprimir Status\"/><span>Imprimir Status</span></a>
			 </div>
			</div>";break;
			
			case "impreporte": 
			$panel_control .="<div style=\"float:left;\">
			 <div class=\"icon\">
				<a href=\"index.php?option=com_config\"><img src=\"../images/header/icon-48-red-imprimirreportes.png\" alt=\"Imprimir Reportes\"/><span>Imprimir Reportes</span></a>
			 </div>
			</div>";break;
			
		   }
		 }
		 
		 echo $panel_control;		 
?>
