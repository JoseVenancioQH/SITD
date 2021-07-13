        <?php
		 $raw = explode(",",$_SESSION["modulos"]);		 
		 //$modulos = array_reverse($raw);
		 $nomodulos = count($raw);
		 $a = array_reverse($raw);		 
		 for($i=0;$i<$nomodulos;$i++)
		 {
		 	switch($a[$i])
			{				
				case "usuarios": $selected = ($seccion=="usuarios")?"class=\"current\"":""; echo "<li><a $selected title=\"Usuarios\" href=\"sistema-usuarios.php\">Usuarios</a></li>"; break;			
			}
		 }
		 ?>