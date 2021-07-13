<?php
error_reporting(E_ALL);
class generar_municipio extends MySQL
{
    function extraerMunicipio($id,$usuario_municipio,$clase)
	{
		$consulta = parent::consulta("SELECT * FROM cat_municipio");		
		$num_total_registros = parent::num_rows($consulta);
				
		if($num_total_registros>0)
		{		        
		        if(is_null($usuario_municipio) || empty($usuario_municipio)){				
				 echo "<select name='".$id."' id='".$id."' class='$clase span-7'>";
	             echo "<option value='' selected>Elige</option>";}	
				else{
				 echo "<select name='".$id."' id='".$id."' class='span-7$clase' disabled='disabled'>";
				 echo "<option value='' selected>Elige</option>";
				}
				
				$selecciona = '';				
				while($municipio = parent::fetch_array($consulta))
				{				    
					extract($municipio);					
					if(!is_null($usuario_municipio) && !empty($usuario_municipio)){if($id_municipio == $usuario_municipio){$selecciona = 'selected';}}
					echo "<option value='".$id_municipio."' $selecciona>".$cat_municipio_nombre."</option>";					
					$selecciona = '';
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