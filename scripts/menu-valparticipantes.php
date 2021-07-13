        <?php
		 $raw = explode(",",$_SESSION["modulos"]);		 
		 //$modulos = array_reverse($raw);
		 $nomodulos = count($raw);
		 $a = array_reverse($raw);		 
		 for($i=0;$i<$nomodulos;$i++)
		 {
		 	switch($a[$i])
			{				
				case "valparticipantes": $selected = ($seccion=="valparticipantes")?"class=\"current\"":""; echo "<li><a $selected title=\"Validaci&oacute;n de Participantes\" href=\"validar-participante.php\">Validaci&oacute;n de Participantes</a></li>"; break;							
			}
		 }
		 ?>