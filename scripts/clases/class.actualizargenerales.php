<?php
error_reporting(E_ALL);
class actualizargenerales extends MySQL
{  
    var $idregistro = '';
    var $nombres = '';
    var $appaterno = '';
    var $apmaterno = '';
    var $sexo = '';
	var $entidad = '';
	var $fechanacimiento = '';
	var $curp = '';		
	
function utf8($string_utf8)
	{
	   $string_utf8_temp = htmlentities($string_utf8,ENT_NOQUOTES, 'UTF-8');
	   $string_utf8_res = htmlspecialchars_decode($string_utf8_temp, ENT_NOQUOTES);
	   return	$string_utf8_res;
	}	
function actualizaGenerales()
	{	
////Actualizar Categoria       
        $consulta = parent::consulta("SELECT reg_participante_curp as curpold FROM reg_participante WHERE UCASE(reg_participante_curp) = UCASE('".$this->curp."') and id_registro != ".$this->idregistro);		
		
		$num_total_registros = parent::num_rows($consulta);		
		if($num_total_registros==0)
		 {
		     $consulta = parent::consulta("SELECT reg_participante_curp FROM reg_participante WHERE  id_registro = ".$this->idregistro);
			 
			 $curpold_fetch = parent::fetch_row($consulta);
		     $curpviejo = $curpold_fetch[0];
			 	
		     $consulta = parent::consulta("UPDATE reg_participante SET reg_participante_nombre = '".$this->nombres."', reg_participante_paterno = '".$this->appaterno."', reg_participante_materno = '".$this->apmaterno."', reg_participante_entidad = '".$this->entidad."', reg_participante_fechanac = '".$this->fechanacimiento."', reg_participante_sexo = '".$this->sexo."', reg_participante_curp = '".$this->curp."' WHERE id_registro = ".$this->idregistro);		 
			 
			 if(mysql_affected_rows() > 0)
			 {			    		      
			    $archivo_viejo = '../fotosparticipantes/'.$curpviejo.'.png';
				$archivo_nuevo = '../fotosparticipantes/'.$this->curp.'.png';
				
				if (file_exists($archivo_viejo)) {
                   rename($archivo_viejo, $archivo_nuevo);
				   $archivoupdate = 'Nombre Foto Actualizada';
                } else {
                   $archivoupdate = 'No se Actualizo, Nombre Foto';
                }								
				
				$error_participante = " Actualizada EXITOSAMENTE <br />".$archivoupdate;
			    $error_participante_logo = "ok";	   
			 }
			 else
			 {
			    $error_participante = " Ninguna, afectaci&oacute;n a los datos";
			    $error_participante_logo = "cancel";				
			 }	 
		 }
		else
		 {
		     $error_participante = " Imposible actualizar datos<br />CURP: ".$this->curp."<br />EXISTENTE";
		     $error_participante_logo = "cancel";					 			 			      
		 }
		 			
		$errorparticipante = "'participante':'".$error_participante."','logoparticipante':'".$error_participante_logo."'";	
		echo '({'.$errorparticipante.'})';	    	
	}
}	
?>