<?php
error_reporting(E_ALL);
class curp extends MySQL
{
    var $curp = "";
    
	function GeneraDatos_CURP()
	{		    
	    $consulta = parent::consulta("SELECT * FROM reg_participante where upper(reg_participante_curp) like '%".strtoupper($this->curp)."%'");
		$num_total_registros = parent::num_rows($consulta);
		if($num_total_registros>0)
		 {			
			while($curp = parent::fetch_array($consulta))
			{
			      nombre,appaterno,apmaterno,fechanac,curp,sexo+0
				  extract($curp);
				  echo "$reg_participante_nombre-$reg_participante_paterno-$reg_participante_materno-$reg_participante_fechanac-$reg_participante_curp-$reg_participante_sexo-$reg_participante_entidad";	
			}			
		 }
		else
		 {
		    echo "no";
		 }  		
	}	    
	  
}

?>