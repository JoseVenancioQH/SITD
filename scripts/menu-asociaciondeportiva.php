        <?php
		 $raw = explode(",",$_SESSION["modulos"]);		 
		 //$modulos = array_reverse($raw);
		 $nomodulos = count($raw);
		 $a = array_reverse($raw);		 
		 for($i=0;$i<$nomodulos;$i++)
		 {
		 	switch($a[$i])
			{				
				case "asociaciondeportivamodificar": $selected = ($seccion=="modificar")?"class=\"current\"":""; echo "<li><a $selected title=\"Modificar Asociaci&oacute;n Deportiva\" href=\"asociaciondeportiva-modificar.php\">Modificar</a></li>"; break;
				case "asociaciondeportivaregistrar": $selected = ($seccion=="registrar")?"class=\"current\"":""; echo "<li><a $selected title=\"Registrar Asociaci&oacute;n Deportiva\" href=\"asociaciondeportiva-registrar.php\">Registrar</a></li>"; break;			
			}
		 }
		 ?>