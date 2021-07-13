<?php
error_reporting(E_ALL);
class generar_eventos extends MySQL
{
    function extraerEventos($id,$idevento)
	{
		$consulta = parent::consulta("SELECT * FROM reg_eventos where reg_eventos_activado = 'activo'");		
		$num_total_registros = parent::num_rows($consulta);
				
		if($num_total_registros>0)
		{
		        if(empty($idevento)) $selectdisabled = ''; else $selectdisabled ="disabled='disabled'";
				echo "<select name='".$id."' id='".$id."' class='validate[required] span-7 cselect' $selectdisabled>";
	            echo "<option value=''>Elige</option>";
				while($evento = parent::fetch_array($consulta))
				{				    
					extract($evento);		
					if($idevento != $id_evento){			
					  echo "<option value='".$id_evento."'>".$reg_eventos_nombre."</option>";					
					}
					else
					{
					  echo "<option value='".$id_evento."' selected>".$reg_eventos_nombre."</option>";					
					}
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