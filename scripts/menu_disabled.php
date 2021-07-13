<?php
	     $raw = explode(",",$_SESSION["modulos"]);		 
		 $nomodulos = count($raw);
		 $a = $raw;		 
		 /*$a = array_reverse($raw);*/
		 
		 $submenu_sistema = '';$submenu_catalogos ='';$submenu_asodep='';$submenu_evaseg='';$submenu_evedep='';$submenu_imprimir='';$submenu_regentdep = '';$submenusub_asodep = '';$submenusub_evaseg = '';$submenusub_evedep = '';		 
				 
		 //menu
		 for($i=0;$i<$nomodulos;$i++)
		 {
		 	switch($a[$i])
			{		 	
				case "sis": 
				     $menu_sistema = "<li class=\"disabled\"><a>Sistema</a>$submenu_sistema</li>"; break;					 
				case "cat": 
				     $menu_catalogos = "<li class=\"disabled\"><a>Cat&aacute;logos</a>$submenu_catalogos</li>"; break;							 
				case "asodep": 
				     $menu_asodep = "<li class=\"disabled\"><a>Asociaci&oacute;n Deportiva</a>$submenu_asodep</li>"; break;					 
				case "evaseg": 
				     $menu_evaseg = "<li class=\"disabled\"><a>Evaluaci&oacute;n y Seguimiento</a>$submenu_evaseg</li>"; break;		
				case "evedep": 
				     $menu_evedep = "<li class=\"disabled\"><a>Eventos Deportivos</a>$submenu_evedep</li>"; break;
				case "regentdep": 
				     $menu_regentdep = "<li class=\"disabled\"><a>Registro Ente Deportivo</a>$submenu_regentdep</li>"; break;	 
				case "imp": 
				     $menu_imprimir = "<li class=\"disabled\"><a>Imprimir</a>$submenu_imprimir</li>"; break;				
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
