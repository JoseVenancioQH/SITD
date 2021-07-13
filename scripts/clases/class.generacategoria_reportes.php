<?php
error_reporting(E_ALL);
class generacategoria extends MySQL
{
    
	var $iddeporte = 0;					
		
	function utf8($string_utf8)
	{
	   $string_utf8_temp = htmlentities($string_utf8,ENT_NOQUOTES, 'UTF-8');
	   $string_utf8_res = htmlspecialchars_decode($string_utf8_temp, ENT_NOQUOTES);
	   return	$string_utf8_res;
	}	
		
	function GeneraCategorias()
	{	
	    if($this->iddeporte!='')	    
		{

	    $consulta = parent::consulta("SELECT group_concat(id_categoria SEPARATOR ', ' ) AS idscategorias, cat_categoria_nombre, cat_categoria_rangoinicio, cat_categoria_rangofin FROM cat_categoria as c inner join cat_deportes as d on c.id_deporte = d.id_deporte and d.id_deporte = ".$this->iddeporte." GROUP BY cat_categoria_nombre ORDER BY cat_categoria_rangoinicio");

		$num_total_registros = parent::num_rows($consulta);
		if($num_total_registros>0)
		 {			
		    echo "<p><label for='categoria'>Categoria: </label>
				<select name='selectcategoria' id='selectcategoria' class='validate[required] span-12 cselect'>";
	        echo "<option value='' selected>Elige</option>";
			while($categoria = parent::fetch_array($consulta))
			{
				  extract($categoria);
				  echo "<option value='$idscategorias'>($cat_categoria_nombre) $cat_categoria_rangoinicio - $cat_categoria_rangofin</option>";			  				
				 	
			}			
			echo "</select></p>";			
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