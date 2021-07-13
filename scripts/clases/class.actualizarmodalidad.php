<?php
error_reporting(E_ALL);
class actualizarmodalidad extends MySQL
{  
    var $idregmodalidad = '';
    var $evento = '';
	var $idmodalidad = '';    
	
function utf8($string_utf8)
	{
	   $string_utf8_temp = htmlentities($string_utf8,ENT_NOQUOTES, 'UTF-8');
	   $string_utf8_res = htmlspecialchars_decode($string_utf8_temp, ENT_NOQUOTES);
	   return	$string_utf8_res;
	}	
function actualizaModalidad()
	{	
////Actualizar Categoria       
             
		     $consulta = parent::consulta("UPDATE reg_modalidadparticipante SET id_modalidad = ".$this->idmodalidad."  WHERE id_regmodalidad = ".$this->idregmodalidad);		 			 
			 if(mysql_affected_rows() > 0)
			 {
			   $error_modalidad = " Actualizada EXITOSAMENTE";
			   $error_modalidad_logo = "ok";  			   			   			   
			 }
			 else
			 {
			   $error_modalidad = " Error, no se pudo actualizar...<br />Verifique con ADMINISTRADOR...";
			   $error_modalidad_logo = "cancel";			   
			 }	     
		
		 			
		$errormodalidad = "'modalidad':'".$error_modalidad."','logomodalidad':'".$error_modalidad_logo."'";	
		echo '({'.$errormodalidad.'})';	    	
	}
}	
?>