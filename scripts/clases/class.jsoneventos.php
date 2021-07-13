<?php
error_reporting(E_ALL);
class jsoneventos extends MySQL
{	     
	function GenerarEventos()
	  {	       
	   	
	  $consulta = parent::consulta("select			
	  reg_e.id_evento as idevento,  	     
	  reg_e.reg_eventos_fechaini as fechaini,    			 		 			 
	  reg_e.reg_eventos_fechafin as fechafin,
	  reg_e.reg_eventos_ano as ano,
	  reg_e.reg_eventos_nombre as nombre,
	  reg_e.reg_eventos_realizado as coordinador,
	  reg_e.reg_eventos_caracteristicas as caracteristicas,			
	  reg_e.reg_eventos_sede as sede,
	  reg_e.reg_eventos_activado as activado      
	  from
	  reg_eventos as reg_e");
		
	    $count = parent::num_rows($consulta);
	    $i=0;
	    if($count>0)
		{					  
			   $responce->page = 1;
			   $responce->total = 1; 
			   $responce->records = $count;
			   while ($actual = parent::fetch_assoc($consulta)) 
			   {	    
				
				
				if ($actual['activado'] == 'activo'){$icon_activado = '../img/icons/accept.png';}else
				{$icon_activado = '../img/icons/delete.png';}
				$responce->rows[$i]['id']=$actual['idevento']; 
		        $responce->rows[$i]['cell']=array(						
						"<img id='activado".$actual['idevento']."' style='vertical-align:middle; cursor:pointer;' src='".$icon_activado."' onclick='javascript:cambiarstatus(\"".$actual['idevento']."\",\"".$actual['activado']."\");'/>",
						"<img id='actualizar".$actual['idevento']."' style='vertical-align:middle; cursor:pointer;' src='../img/icons/edit.png' onclick='javascript:editarevento(\"".$actual['idevento']."\");'/>",			  
						$actual['nombre'],						  
						$actual['coordinador'],
						$actual['sede'],
						$actual['caracteristicas'],
						date('d-m-Y', strtotime ($actual['fechaini'])),
						date('d-m-Y', strtotime ($actual['fechafin'])),
				        $actual['ano']);						
		        $i++;              
			   }			   
			   return $responce;			   
		 }
		 else
		 {
		   return "no";
		 }	   		 	   
	  }  
}

?>