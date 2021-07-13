        <?php
		 $raw = explode(",",$_SESSION["modulos"]);		 
		 //$modulos = array_reverse($raw);
		 $nomodulos = count($raw);
		 $a = array_reverse($raw);		 
		 for($i=0;$i<$nomodulos;$i++)
		 {
		 	switch($a[$i])
			{				
				case "eventosmodificar": $selected = ($seccion=="modificar")?"class=\"current\"":""; echo "<li><a $selected title=\"Modificar Eventos\" href=\"eventos-modificar.php\">Modificar</a></li>"; break;
				case "eventosregistrar": $selected = ($seccion=="registrar")?"class=\"current\"":""; echo "<li><a $selected title=\"Registrar Eventos\" href=\"eventos-registrar.php\">Registrar</a></li>"; break;			
			}
		 }
		 ?>