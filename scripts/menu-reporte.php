        <?php
		 $raw = explode(",",$_SESSION["modulos"]);		 
		 //$modulos = array_reverse($raw);
		 $nomodulos = count($raw);
		 $a = array_reverse($raw);	
		 				 
		 for($i=0;$i<$nomodulos;$i++)
		 {		 
		 	switch($a[$i])
			{					
				case "gaffetes": $selected = ($seccion=="gaffetes")?"class=\"current\"":""; echo "<li><a $selected title=\"Gaffetes\" href=\"reportes-gaffetes.php\">Gaffetes</a></li>"; break;
				case "credencial": $selected = ($seccion=="credencial")?"class=\"current\"":""; echo "<li><a $selected title=\"Credencial\" href=\"reportes-credencial.php\">Credencial</a></li>"; break;
				case "cedulainscripcion": $selected = ($seccion=="cedulainscripcion")?"class=\"current\"":""; echo "<li><a $selected title=\"Cedula de Inscripci&oacute;n\" href=\"reportes-cedulainscripcion.php\">Cedula de Inscripci&oacute;n</a></li>"; break;
				case "reportes": $selected = ($seccion=="reportes")?"class=\"current\"":""; echo "<li><a $selected title=\"Reportes Varios\" href=\"reportes-varios.php\">Reportes Varios</a></li>"; break;												
			}
		 }
		 ?>
