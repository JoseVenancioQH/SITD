<?php
error_reporting(E_ALL);
class generacategoria extends MySQL
{
    
	var $iddeporte = 0;					
	
	function remove_duplicate_word($text)
    {
	    $array_pruebas = explode(",", $text);
		$result = array_unique($array_pruebas);
        return implode (',', $result);
    }	
		
	function GeneraCategorias()
	{	
	    if($this->iddeporte!='')	    
		{
	    $consulta = parent::consulta("SELECT group_concat(id_categoria SEPARATOR '_' ) AS idscategorias, group_concat(cat_categoria_prueba SEPARATOR ',' ) AS pruebas, cat_categoria_nombre, cat_categoria_rangoinicio, cat_categoria_rangofin FROM cat_categoria as c inner join cat_deportes as d on c.id_deporte = d.id_deporte and d.id_deporte = ".$this->iddeporte." GROUP BY cat_categoria_nombre ORDER BY cat_categoria_rangoinicio");
		$num_total_registros = parent::num_rows($consulta);
		$div_pruebas = '';
		if($num_total_registros>0)
		 {			
		    echo "<p><label for='categoria'>Categoria: </label>
				<select name='selectcategoria' id='selectcategoria' class='validate[required] span-12 cselect'>";
	        echo "<option value='' selected>Elige</option>";
			while($categoria = parent::fetch_array($consulta))
			{
				  extract($categoria);
				  $pruebas_sin_repetidos = $this->remove_duplicate_word($pruebas);
				  echo "<option value='$idscategorias'>($cat_categoria_nombre) $cat_categoria_rangoinicio - $cat_categoria_rangofin</option>";	
				  $div_pruebas .= "<div id='pruebas$idscategorias' style='display:none;'>$pruebas_sin_repetidos</div>";				 	
			}			
			echo "</select></p>";
			echo $div_pruebas;
		 }
	  else
	     {
		    echo "<p><label for='categoria'>Categoria: </label>";
		    echo "<select name='selectcategoria' id='selectcategoria' class='span-12 cselect' disabled='disabled'>";
			echo "<option value='' selected>Ninguno</option>";
			echo "</select><p>";
		 }
	  }
	  else
	  {
	        echo "<p><label for='categoria'>Categoria: </label>";
	        echo "<select name='selectcategoria' id='selectcategoria' class='span-12 cselect' disabled='disabled'>";
			echo "<option value='' selected>Ninguno</option>";
			echo "</select></p>";
	  } 	 		
	}	  
	  
}

?>