<?php
error_reporting(E_ALL);
class actualizardatosadicionales extends MySQL
{  
    var	$direccion = '';
	var	$colonia = '';
	var	$localidad = '';
	var	$codigopostal = '';
	var	$correo = '';
	var	$peso = '';
	var	$talla = '';
	var	$rfc = '';
	var $telefonos = '';
	var	$tiposanguineo = '';
	var $idparticipante = '';	    
	
function utf8($string_utf8)
	{
	   $string_utf8_temp = htmlentities($string_utf8,ENT_NOQUOTES, 'UTF-8');
	   $string_utf8_res = htmlspecialchars_decode($string_utf8_temp, ENT_NOQUOTES);
	   return	$string_utf8_res;
	}	
function actualizaDatosAdicionales()
	{	
////Actualizar Categoria                               
		     $consulta = parent::consulta("UPDATE reg_participante SET reg_participante_direccion = '".$this->utf8($this->direccion)."', reg_participante_codigop = '".$this->utf8($this->codigopostal)."', reg_participante_telefonos = '".$this->utf8($this->telefonos)."', reg_participante_correo = '".$this->utf8($this->correo)."', reg_participante_peso = '".$this->utf8($this->peso)."', reg_participante_talla = '".$this->utf8($this->talla)."', reg_participante_tiposanguineo = '".$this->utf8($this->tiposanguineo)."', reg_participante_localidad = '".$this->utf8($this->localidad)."', reg_participante_colonia = '".$this->utf8($this->colonia)."'  WHERE id_registro = ".$this->idparticipante);		 			 
			 if(mysql_affected_rows() > 0)
			 {
			   $error_adicionales = " Actualizada EXITOSAMENTE";
			   $error_adicionales_logo = "ok";  			   			   			   
			 }
			 else
			 {
			   $error_adicionales = " Ninguna, modificaci&oacute;n a los datos...";
			   $error_adicionales_logo = "cancel";	   
			 }	     
		
		 			
		$erroradicionales = "'adicionales':'".$error_adicionales."','logoadicionales':'".$error_adicionales_logo."'";	
		echo '({'.$erroradicionales.'})';	    	
	}
}	
?>