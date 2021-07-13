<?php
error_reporting(E_ALL);
class eliminarparticipante extends MySQL
{      
    var $evento = '';
    var $idregistro = '';	
    var $idcategoriamodalidad = '';
	

function eliminaParticipante()
	{	
	  
	  $consulta = parent::consulta("select
		reg_p.reg_participante_curp as curp,       
        GROUP_CONCAT(DISTINCT reg_c.id_categoriapar SEPARATOR ',') AS idcategoriapar,
		GROUP_CONCAT(DISTINCT reg_m.id_regmodalidad SEPARATOR ',') AS idregmodalidad,
        GROUP_CONCAT(DISTINCT reg_e.id_regevento SEPARATOR ',') AS idregevento
        from (((reg_participante as reg_p 
	    inner join reg_eventoparticipante as reg_e on reg_p.id_registro = reg_e.id_registro and reg_p.id_registro = $this->idregistro and reg_e.id_evento = $this->evento)
	    inner join reg_modalidadparticipante as reg_m on reg_e.id_regevento = reg_m.id_regevento)
	    inner join reg_categoriaparticipante as reg_c on reg_c.id_regmodalidad = reg_m.id_regmodalidad) group by reg_p.id_registro");			 
	  
	  $num_total_registros = parent::num_rows($consulta);
	  if($num_total_registros>0)
	  {
		 /*while ($actual = parent::fetch_array($consulta)) 
		 {		    
		   extract($actual);*/
		   $arrayvalores = parent::fetch_row($consulta);
		   $categoriaArr = explode (",", $arrayvalores[1]);      		
           foreach ($categoriaArr as $val) {                    
               $consulta = parent::consulta("DELETE FROM reg_categoriaparticipante where id_categoriapar = ".$val);
		   }
		   
		   $modalidadArr = explode (",", $arrayvalores[2]);      		
           foreach ($modalidadArr as $val) {                    
               $consulta = parent::consulta("DELETE FROM reg_modalidadparticipante where id_regmodalidad = ".$val);
		   }
		   
		   $eventoArr = explode (",", $arrayvalores[3]);      		
           foreach ($eventoArr as $val) {                    
               $consulta = parent::consulta("DELETE FROM reg_eventoparticipante where id_regevento = ".$val);
		   }	      
		/* }*/
		 $status_des =  "ok";			 
	  }
	  else
	  {
		 $status_des =  "cancel";			
	  }		
	  
	  $status = "'status':'".$status_des."'";		
			
	   echo '({'.$status.'})';	    	
	}
	
	
	function eliminaCategoriaModalidad()
	{		  
	  $consulta = parent::consulta("select id_regmodalidad as idregmodalidad from reg_categoriaparticipante as reg_c where reg_c.id_categoriapar = ".$this->idcategoriamodalidad);			 
	  
	  $arrayvalores = parent::fetch_row($consulta);
	  
	  $consulta = parent::consulta("select id_regmodalidad as idregmodalidad from reg_categoriaparticipante as reg_c where reg_c.id_regmodalidad = ".$arrayvalores[0]);								      
																								   
	  $num_total_registros = parent::num_rows($consulta);																																							      if($num_total_registros==1)
	  {		  
		  $consulta = parent::consulta("DELETE FROM reg_modalidadparticipante where id_regmodalidad = ".$arrayvalores[0]);
	  }
													
	  $consulta = parent::consulta("DELETE FROM reg_categoriaparticipante where id_categoriapar = ".$this->idcategoriamodalidad);
	
	  $status_des =  "ok";			 
	  
	  $status = "'status':'".$status_des."'";		
			
	  echo '({'.$status.'})';	    	
	}

}	
?>