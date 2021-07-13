<?php
error_reporting(E_ALL);
class deporte_categoria extends MySQL
{
    function extraerDeportes($id)
	{
		$consulta = parent::consulta("SELECT * FROM cat_deportes");		
		$num_total_registros = parent::num_rows($consulta);
				
		$clase_valida = '';		
		if($num_total_registros>0)
		{
		       	echo "<select name='".$id."' id='".$id."' class=''>";
	                echo "<option value='' selected>Elige</option>";
				while($deportes = parent::fetch_array($consulta))
				{
				    
					extract($deportes);					
					echo "<option value='".$id_deporte."'>".$cat_deporte_nombre."</option>";					
				}				
				echo "</select>";
		}
		else
		{
		    echo "<select name='".$id."' id='".$id."' class='".$clase_valida."span-7 cselect' disabled='disabled'>";
			echo "<option value='' selected>Ninguno</option>";
			echo "</select>";
		}
	}
}	
?>