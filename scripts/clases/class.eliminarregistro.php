<?php
error_reporting(E_ALL);
class eliminarregistro extends MySQL
{  
    var $idregistrocat = '';
    var $evento = '';   			
function eliminaRegistro()
	{	
////Actualizar Categoria				
        $consulta = parent::consulta("DELETE FROM reg_categoriaparticipante where id_categoriapar = ".$this->idregistrocat." and id_evento = ".$this->evento);				 
		if(mysql_affected_rows() > 0)
		 {
			   $error_registro = " Eliminado EXITOSAMENTE";
			   $error_registro_logo = "ok";  			   
		 }
		else
		 {
			   $error_registro = " Ninguna, afectaci&oacute;n de borradono se pudo actualizar...";
			   $error_registro_logo = "cancel";				
		 }
		 			
		$errorregistro = "'registro':'".$error_registro."','logoregistro':'".$error_registro_logo."'";	
		echo '({'.$errorregistro.'})';	    	
	}
}	
?>