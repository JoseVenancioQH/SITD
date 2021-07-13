        <?php
		 $raw = explode(",",$_SESSION["modulos"]);		 
		 //$modulos = array_reverse($raw);
		 $nomodulos = count($raw);
		 $a = array_reverse($raw);				 
		 for($i=0;$i<$nomodulos;$i++)
		 {		 
		 	switch($a[$i])
			{				
				case "liga": $selected = ($seccion=="liga")?"class=\"current\"":""; echo "<li><a $selected title=\"Liga\" href=\"catalogo-liga.php\">Liga</a></li>"; break;
				case "equipo": $selected = ($seccion=="equipo")?"class=\"current\"":""; echo "<li><a $selected title=\"Equipo\" href=\"catalogo-equipo.php\">Equipo</a></li>"; break;
				case "prueba": $selected = ($seccion=="prueba")?"class=\"current\"":""; echo "<li><a $selected title=\"Prueba\" href=\"catalogo-prueba.php\">Prueba</a></li>"; break;
				case "categoria": $selected = ($seccion=="categoria")?"class=\"current\"":""; echo "<li><a $selected title=\"Categoria\" href=\"catalogo-categoria.php\">Categoria</a></li>"; break;
				case "municipio": $selected = ($seccion=="municipio")?"class=\"current\"":""; echo "<li><a $selected title=\"Municipio\" href=\"catalogo-municipio.php\">Municipio</a></li>"; break;
				case "modalidad": $selected = ($seccion=="modalidad")?"class=\"current\"":""; echo "<li><a $selected title=\"Modalidad\" href=\"catalogo-modalidad.php\">Modalidad</a></li>"; break;
				case "deportes": $selected = ($seccion=="deportes")?"class=\"current\"":""; echo "<li><a $selected title=\"Deportes\" href=\"catalogo-deportes.php\">Deportes</a></li>"; break;														
			}
		 }
		 ?>
