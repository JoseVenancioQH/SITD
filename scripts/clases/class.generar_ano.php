<?php
error_reporting(E_ALL);
class generar_ano extends MySQL
{
    function extraerAnoInicio($id)
	{
		$consulta = parent::consulta("SELECT DISTINCT cat_categoria_rangoinicio as ano FROM cat_categoria ORDER BY cat_categoria_rangoinicio");		
		$num_total_registros = parent::num_rows($consulta);				
		if($num_total_registros>0)
		{
				echo "<select name='".$id."' id='".$id."' class='span-6 cselect'>";
	            echo "<option value='' selected>Elige</option>";
				while($ano = parent::fetch_array($consulta))
				{				    
					extract($ano);					
					echo "<option value='".$ano."'>".$ano."</option>";					
				}				
				echo "</select>";
		}
		else
		{
		    echo "<select name='".$id."' id='".$id."' class='span-6 cselect' disabled='disabled'>";
			echo "<option value='' selected>Ninguno</option>";
			echo "</select>";
		}
	}
	
	function extraerAnoFinal($id)
	{
		$consulta = parent::consulta("SELECT DISTINCT cat_categoria_rangofin as ano FROM cat_categoria ORDER BY cat_categoria_rangofin");		
		$num_total_registros = parent::num_rows($consulta);				
		if($num_total_registros>0)
		{
				echo "<select name='".$id."' id='".$id."' class='span-6 cselect'>";
	            echo "<option value='' selected>Elige</option>";
				while($ano = parent::fetch_array($consulta))
				{				    
					extract($ano);					
					echo "<option value='".$ano."'>".$ano."</option>";					
				}				
				echo "</select>";
		}
		else
		{
		    echo "<select name='".$id."' id='".$id."' class='span-6 cselect' disabled='disabled'>";
			echo "<option value='' selected>Ninguno</option>";
			echo "</select>";
		}
	}
	
}	
?>