<?php
	     $raw = explode(",",$_SESSION["modulos"]);		 
		 $nomodulos = count($raw);
		 $a = $raw;	 
		
		 $submenu_sistema = '';$submenu_catalogos ='';$submenu_asodep='';$submenu_evaseg='';$submenu_evedep='';$submenu_imprimir='';$submenu_regentdep = '';$submenusub_asodep = '';$submenusub_evaseg = '';$submenusub_evedep = '';			 
				 
		 for($i=0;$i<$nomodulos;$i++)
		 {		 
		 	switch($a[$i])
			{	
			    case "asodepimpsirred": 
				$submenusub_asodep .= "<li style=\"width:200px;\"><a class=\"icon-16-red-imprimirsirred\" href=\"reportes-credencial.php\">SIRRED</a></li>"; break;				
				case "asodepimpcredencial": 
				$submenusub_asodep .= "<li style=\"width:200px;\"><a class=\"icon-16-red-imprimircredencial\" href=\"reportes-credencial.php\">Credencial</a></li>"; break;				
				case "asodepimpcedula":
				$submenusub_asodep .= "<li style=\"width:200px;\"><a class=\"icon-16-red-cedulainscripcion\" href=\"reportes-credencial.php\">Cedula de Inscripci&oacute;n</a></li>"; break;				
				case "asodepimpreportes":
				$submenusub_asodep .= "<li style=\"width:200px;\"><a class=\"icon-16-red-reporteasociaciondep\" href=\"reportes-credencial.php\">Reportes</a></li>"; break;			
				
				case "evasegimpcurriculum": 
				$submenusub_evaseg .= "<li style=\"width:200px;\"><a class=\"icon-16-red-curriculumevaluacionseg\" href=\"reportes-credencial.php\">Curriculum</a></li>"; break;				
				case "evasegimpreportes": 
				$submenusub_evaseg .= "<li style=\"width:200px;\"><a class=\"icon-16-red-reporteevaluacionseg\" href=\"reportes-credencial.php\">Reportes</a></li>"; break;				
				
								
				case "evedepimpcedula": 
				$submenusub_evedep .= "<li style=\"width:200px;\"><a class=\"icon-16-red-impimircedulaeventodep\" href=\"reportes-credencial.php\">Cedulas de Inscipci&oacute;n</a></li>"; break;					
				case "evedepimpgaffete": 
				$submenusub_evedep .= "<li style=\"width:200px;\"><a class=\"icon-16-red-impimirgaffeteseventodep\" href=\"reportes-credencial.php\">Gaffetes</a></li>"; break;					
				case "evedepimpreportes": 
				$submenusub_evedep .= "<li style=\"width:200px;\"><a class=\"icon-16-red-reporteeventodep\" href=\"reportes-credencial.php\">Reportes</a></li>"; break;					
				case "evedepimpresultados": 
				$submenusub_evedep .= "<li style=\"width:200px;\"><a class=\"icon-16-red-resultadoeventodep\" href=\"reportes-credencial.php\">Resultados</a></li>"; break;			
				
			}
		 }
		 
		 $submenusub_asodep = ($submenusub_asodep!="")?"<ul>".$submenusub_asodep."</ul>":"";
		 $submenusub_evaseg = ($submenusub_evaseg!="")?"<ul>".$submenusub_evaseg."</ul>":"";
		 $submenusub_evedep = ($submenusub_evedep!="")?"<ul>".$submenusub_evedep."</ul>":"";
		
		 
		 for($i=0;$i<$nomodulos;$i++)
		 {		 
		 	switch($a[$i])
			{					
				case "sisusu": 
				$submenu_sistema .= "<li style=\"width:200px;\"><a class=\"icon-16-user\" href=\"sitd_mod_lista_usuarios.php\">Gestor de Usuario</a></li>"; break;
				case "sispc": 
				$submenu_sistema .= "<li style=\"width:200px;\"><a class=\"icon-16-cpanel\" href=\"../index.php\">Panel de Control</a></li>"; break;					
				case "catrama": 
				$submenu_catalogos .= "<li style=\"width:200px;\"><a class=\"icon-16-red-rama\" href=\"sitd_mod_lista_catrama.php\">Rama</a></li>"; break;
				case "catmodentdep": 
				$submenu_catalogos .= "<li style=\"width:200px;\"><a class=\"icon-16-red-modalidadentedep\" href=\"sitd_mod_lista_catmoded.php\">Modalidad Ente Deportivo</a></li>"; break;
				case "catdep": 
				$submenu_catalogos .= "<li style=\"width:200px;\"><a class=\"icon-16-red-deportes\" href=\"sitd_mod_lista_catdeportes.php\">Deportes</a></li>"; break;						
				case "catevenac": 
				$submenu_catalogos .= "<li style=\"width:200px;\"><a class=\"icon-16-red-eventonacional\" href=\"sitd_mod_lista_catevenac.php\">Evento Nacional</a></li>"; break;
				case "catmun": 
				$submenu_catalogos .= "<li style=\"width:200px;\"><a class=\"icon-16-red-municipio\" href=\"sitd_mod_lista_catmunicipio.php\">Municipio</a></li>"; break;				
				case "catasodep": 
				$submenu_catalogos .= "<li style=\"width:200px;\"><a class=\"icon-16-red-asociaciondep\" href=\"sitd_mod_lista_catasocdep.php\">Asociaci&oacute;n Deportiva</a></li>"; break;
				case "catclub": 
				$submenu_catalogos .= "<li style=\"width:200px;\"><a class=\"icon-16-red-club\" href=\"sitd_mod_lista_catclub.php\">Club</a></li>"; break;
				case "catliga": 
				$submenu_catalogos .= "<li style=\"width:200px;\"><a class=\"icon-16-red-liga\" href=\"sitd_mod_lista_catliga.php\">Liga</a></li>"; break;	
				case "catprueba": 
			    $submenu_catalogos .= "<li style=\"width:200px;\"><a class=\"icon-16-red-pruebas\" href=\"sitd_mod_lista_catprueba.php\">Pruebas</a></li>"; break;				
				case "catmoddep": 
				$submenu_catalogos .= "<li style=\"width:200px;\"><a class=\"icon-16-red-modalidaddeportiva\" href=\"sitd_mod_lista_catmoddep.php\">Modalidad Deportiva</a></li>"; break;			
				case "cateveint": 
				$submenu_catalogos .= "<li style=\"width:200px;\"><a class=\"icon-16-red-eventointernacional\" href=\"sitd_mod_lista_cateveint.php\">Evento Internacional</a></li>"; break;				
				case "catest": 
				$submenu_catalogos .= "<li style=\"width:200px;\"><a class=\"icon-16-red-estado\" href=\"sitd_mod_lista_catestado.php\">Estado</a></li>"; break;					
				case "catcat": 
				$submenu_catalogos .= "<li style=\"width:200px;\"><a class=\"icon-16-red-categoria\" href=\"sitd_mod_lista_catcat.php\">Categoria</a></li>"; break;				
				case "catasodepmd": 
				$submenu_catalogos .= "<li style=\"width:200px;\"><a class=\"icon-16-red-catasocdepmd\" href=\"sitd_mod_lista_catasocdepmd.php\">Asoc. Dep. Mesa Directiva</a></li>"; break;				
				case "asodepvincular": 
				$submenu_asodep .= "<li style=\"width:200px;\"><a class=\"icon-16-red-vincularasociaciondep\" href=\"sitd_mod_lista_catasocdepmd.php\">Vincular Ente Deportivo</a></li>"; break;
				case "asodepimprimir": 
				$submenu_asodep .= "<li style=\"width:200px;\" class=\"node\"><a class=\"icon-16-red-imprimirasociaciondep\" href=\"red_mod_lista_ventaauto.php\">Imprimir</a>$submenusub_asodep</li>"; break;				
				
				case "evasegvincular": 
				$submenu_evaseg .= "<li style=\"width:200px;\"><a class=\"icon-16-red-vincularevaluacionseg\" href=\"red_mod_lista_ventaauto.php\">Vincular Ente Deportivo</a></li>"; break;
				case "evasegimprimir": 
				$submenu_evaseg .= "<li style=\"width:200px;\" class=\"node\"><a class=\"icon-16-red-imprimirevaluacionseg\" href=\"red_mod_lista_ventaauto.php\">Imprimir</a>$submenusub_evaseg</li>"; break;	
				
				case "evedepvincular": 
				$submenu_evedep .= "<li style=\"width:200px;\"><a class=\"icon-16-red-vinculareventodep\" href=\"red_mod_lista_ventaauto.php\">Vincular Evento Deportivo</a></li>"; break;	
				case "evedepvalidar": 
				$submenu_evedep .= "<li style=\"width:200px;\"><a class=\"icon-16-red-validareventodep\" href=\"red_mod_lista_ventaauto.php\">Validar</a></li>"; break;	
				case "evedepresultados": 
				$submenu_evedep .= "<li style=\"width:200px;\"><a class=\"icon-16-red-resultadoeventodep\" href=\"red_mod_lista_ventaauto.php\">Resultados</a></li>"; break;	
				case "evedepimprimir": 
				$submenu_evedep .= "<li style=\"width:200px;\" class=\"node\"><a class=\"icon-16-red-impimireventodep\" href=\"red_mod_lista_ventaauto.php\">Imprimir</a>$submenusub_evedep</li>"; break;	
				
				case "impcredencial": 
				$submenu_imprimir .= "<li style=\"width:200px;\"><a class=\"icon-16-red-imprimirreportecredencial\" href=\"red_mod_lista_ventaauto.php\">Credencial</a></li>"; break;	
				case "impstatus": 
				$submenu_imprimir .= "<li style=\"width:200px;\"><a class=\"icon-16-red-status\" href=\"red_mod_lista_ventaauto.php\">Status</a></li>"; break;	
				case "impreporte": 		
				$submenu_imprimir .= "<li style=\"width:200px;\"><a class=\"icon-16-red-reportes\" href=\"red_mod_lista_ventaauto.php\">Reportes</a></li>"; break;	
			}
		 } 
		 
		 $submenu_sistema = ($submenu_sistema!="")?"<ul>".$submenu_sistema."</ul>":"";
		 $submenu_catalogos = ($submenu_catalogos!="")?"<ul>".$submenu_catalogos."</ul>":"";
		 $submenu_asodep = ($submenu_asodep!="")?"<ul>".$submenu_asodep."</ul>":"";
		 $submenu_evaseg = ($submenu_evaseg!="")?"<ul>".$submenu_evaseg."</ul>":"";
		 $submenu_evedep = ($submenu_evedep!="")?"<ul>".$submenu_evedep."</ul>":"";	
		 $submenu_regentdep = ($submenu_regentdep!="")?"<ul>".$submenu_regentdep."</ul>":"";
		 $submenu_imprimir = ($submenu_imprimir!="")?"<ul>".$submenu_imprimir."</ul>":"";
		 
		 //menu
		 for($i=0;$i<$nomodulos;$i++)
		 {
		 	switch($a[$i])
			{		 	
				case "sis": 
				     $menu_sistema = "<li class=\"node\"><a>Sistema</a>$submenu_sistema</li>"; break;					 
				case "cat": 
				     $menu_catalogos = "<li class=\"node\"><a>Cat&aacute;logos</a>$submenu_catalogos</li>"; break;				 
				case "asodep": 
				     $menu_asodep = "<li class=\"node\"><a>Asociaci&oacute;n Deportiva</a>$submenu_asodep</li>"; break;					 				case "evaseg": 
				     $menu_evaseg = "<li class=\"node\"><a>Evaluaci&oacute;n y Seguimiento</a>$submenu_evaseg</li>"; break;		
				case "evedep": 
				     $menu_evedep = "<li class=\"node\"><a>Eventos Deportivos</a>$submenu_evedep</li>"; break;
				case "regentdep": 
				     $menu_regentdep = "<li class=\"node\"><a href=\"sitd_mod_lista_regentdep.php\">Registro Ente Deportivo</a>$submenu_regentdep</li>"; break;	 
				case "imp": 
				     $menu_imprimir = "<li class=\"node\"><a>Imprimir</a>$submenu_imprimir</li>"; break;				
			}
		  }
		  
		  echo $menu_sistema;
		  echo $menu_catalogos;
		  echo $menu_asodep;
		  echo $menu_evaseg;
		  echo $menu_evedep;
		  echo $menu_regentdep;
		  echo $menu_imprimir;
?>