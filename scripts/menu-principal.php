        <?php
		 $raw = explode(",",$_SESSION["modulos"]);		
		 $nomodulos = count($raw);
		 $a = array_reverse($raw);		 
		 for($i=0;$i<$nomodulos;$i++)
		 {
		 	switch($a[$i])
			{		 	
				case "reportes": echo "<li><a class=\"\" title=\"Reportes\" href=\"modulos/menuprincipal-reportes.php\">Reportes</a></li>"; break;								
				case "catalogos": echo "<li><a class=\"\" title=\"Catalogos\" href=\"modulos/menuprincipal-catalogos.php\">Catalogos</a></li>"; break;
				case "valparticipantes": echo "<li><a class=\"\" title=\"Validar Participantes\" href=\"modulos/menuprincipal-valparticipantes.php\">Validar Participante</a></li>"; break;
				case "regparticipantes": echo "<li><a class=\"\" title=\"Registro de Participantes\" href=\"modulos/menuprincipal-regparticipantes.php\">Registro de Participantes</a></li>"; break;
				case "asociaciondeportiva": echo "<li><a class=\"\" title=\"Asociaci&oacute;n Deportiva\" href=\"modulos/menuprincipal-asociaciondeportiva.php\">Asociacion Deportiva</a></li>"; break;
				case "eventos": echo "<li><a class=\"\" title=\"Eventos\" href=\"modulos/menuprincipal-eventos.php\">Eventos</a></li>"; break;
				case "sistema": echo "<li><a class=\"\" title=\"Sistema\" href=\"modulos/menuprincipal-sistema.php\">Sistema</a></li>"; break;
			}
		 }
		 ?> 