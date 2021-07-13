        <?php
		 $raw = explode(",",$_SESSION["modulos"]);		 
		 //$modulos = array_reverse($raw);
		 $nomodulos = count($raw);
		 $a = array_reverse($raw);		 
		 for($i=0;$i<$nomodulos;$i++)
		 {
		 	switch($a[$i])
			{				
				case "regparmodificar": $selected = ($seccion=="modificar")?"class=\"current\"":""; echo "<li><a $selected title=\"Modificar Registro de Participantes\" href=\"regpar-modificar.php\">Modificar</a></li>"; break;
				case "regparregistrar": $selected = ($seccion=="registrar")?"class=\"current\"":""; echo "<li><a $selected title=\"Registrar Registro de Participantes\" href=\"regpar-registrar.php\">Registrar</a></li>"; break;							
			}
		 }
		 ?>