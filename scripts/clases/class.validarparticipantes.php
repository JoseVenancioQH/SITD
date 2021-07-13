<?php
error_reporting(E_ALL);
class validarparticipantes extends MySQL
{  
    var $lista_validar = '';
    var $documentos = '';
	var $idregcat = '';
	var $evento = '';
	var $participante_sel = '';
	var $tipo_validar = '';
	
function utf8($string_utf8)
	{
	   $string_utf8_temp = htmlentities($string_utf8,ENT_NOQUOTES, 'UTF-8');
	   $string_utf8_res = htmlspecialchars_decode($string_utf8_temp, ENT_NOQUOTES);
	   return	$string_utf8_res;
	}	

function grabarDocumentos()
{	
	             $id = explode('-', $this->idregcat);
		         $consulta = parent::consulta("UPDATE reg_eventoparticipante SET reg_eventoparticipante_documentos = '".$this->documentos."'  WHERE id_registro = ".$id[0]." and id_evento = ".$this->evento);    
				 $documentoactualizado = "'documento':'Actualizac&oacute;n Realizada'";	
		         echo '({'.$documentoactualizado.'})';	    	
}

function validarParticipante()
	{			  
		if(!empty($this->participante_sel)){	 
////Actualizar Validar Participantes     
		   $validadostotalArr = explode(',', $this->participante_sel);
		   foreach ($validadostotalArr as $val) {			     
			   $consulta = parent::consulta("UPDATE reg_categoriaparticipante SET reg_categoriaparticipante_validado = '".$this->tipo_validar."'  WHERE id_categoriapar = ".$val);    
		   }		 			
		}	 	 			
		$validado = "'validado':'Actualizac&oacute;n Realizada'";	
		echo '({'.$validado.'})';	    	
	}
}	
?>