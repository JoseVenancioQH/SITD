<?php
error_reporting(E_ALL);
class generacategoria extends MySQL
{
    
	var $iddeporte = 0;
	var $evento = 0;
		
	function GeneraCategorias()
	{	
	    if($this->iddeporte!='')	    
		{
	    $consulta = parent::consulta("SELECT * FROM cat_categoria as c inner join cat_deportes as d on c.id_deporte = d.id_deporte and d.id_deporte = ".$this->iddeporte." and c.id_evento = ".$this->evento." ORDER BY cat_categoria_rangoinicio");
		$num_total_registros = parent::num_rows($consulta);
		if($num_total_registros>0)
		 {			
		    echo "<p><label for='categoria'>Categoria: </label>
				<select name='selectcategoria' id='selectcategoria' class='validate[required] span-12 cselect'>";
	            echo "<option value='' selected>Elige</option>";
			while($categoria = parent::fetch_array($consulta))
			{
				  extract($categoria);
				  echo "<option value='$id_categoria'>$cat_categoria_nombre $cat_categoria_rangoinicio - $cat_categoria_rangofin ($cat_categoria_rama)</option>";
				  $div_pruebas .= 	"<div id='pruebas$id_categoria' style='display:none;'>$cat_categoria_prueba</div>";				
				 	
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