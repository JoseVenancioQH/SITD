<?php
error_reporting(E_ALL);
class generar_modalidad extends MySQL
{
    function extraerModalidad($id)
	{
		$consulta = parent::consulta("SELECT * FROM cat_modalidad");		
		$num_total_registros = parent::num_rows($consulta);
				
		if($num_total_registros>0)
		{
				echo "<select name='".$id."' id='".$id."' class='validate[required] span-7 cselect'>";
	            echo "<option value='' selected>Elige</option>";
				while($modalidad = parent::fetch_array($consulta))
				{				    
					extract($modalidad);					
					echo "<option value='".$id_modalidad."'>".$cat_modalidad_nombre."</option>";					
				}				
				echo "</select>";
		}
		else
		{
		    echo "<select name='".$id."' id='".$id."' class='validate[required] span-7 cselect' disabled='disabled'>";
			echo "<option value='' selected>Ninguno</option>";
			echo "</select>";
		}
	}
}	
?>