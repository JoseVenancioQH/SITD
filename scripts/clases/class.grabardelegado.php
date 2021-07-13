<?php
error_reporting(E_ALL);
class grabardelegado extends MySQL
{
    var $cargo = '';
	var $deporteextra = '';
	var	$evento = '';
	var	$municipio = '';
	var	$modalidad = '';
	var	$entidad = '';
	var	$nombres = '';
	var	$appaterno = '';
	var	$apmaterno = '';
	var	$fechanacimiento = '';
	var	$sexo = '';
	var	$curp = '';
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
	var	$idusuario = '';
	var	$lista_categoria = '';
	var	$lista_pruebas = '';
	var	$lista_nom_categoria = '';
	var	$nommunicipio = '';
	var	$nomevento = '';
	var	$nommodalidad = '';
	
function utf8($string_utf8)
	{
	   $string_utf8_temp = htmlentities($string_utf8,ENT_NOQUOTES, 'UTF-8');
	   $string_utf8_res = htmlspecialchars_decode($string_utf8_temp, ENT_NOQUOTES);
	   return	$string_utf8_res;
	}	
function grabarParticipanteDelegado()
	{	
////Registro Participantes	
       $consulta = parent::consulta("SELECT id_registro FROM reg_participante WHERE reg_participante_curp = '".$this->curp."'");
	   $num_total_registros = parent::num_rows($consulta);
	   if($num_total_registros==0)
		 {		 
		  //se registrara un nuevo participante		  			    
		  
		  $consulta = parent::consulta("INSERT INTO reg_participante (id_municipio, reg_participante_nombre, reg_participante_paterno,reg_participante_materno,reg_participante_curp,reg_participante_fechanac,reg_participante_direccion,reg_participante_codigop,reg_participante_telefonos,reg_participante_correo,reg_participante_peso,reg_participante_talla,reg_participante_sexo,reg_participante_tiposanguineo,reg_participante_entidad,reg_participante_localidad,reg_participante_rfc,reg_participante_colonia,id_usuario) VALUES (".$this->municipio.",'".$this->utf8($this->nombres)."','".$this->utf8($this->appaterno)."','".$this->utf8($this->apmaterno)."','".$this->curp."','".date('Y-m-d', strtotime ($this->fechanacimiento))."','".$this->utf8($this->direccion)."','".$this->codigopostal."','".$this->telefonos."','".$this->correo."','".$this->peso."','".$this->talla."','".$this->sexo."','".$this->tiposanguineo."','".$this->entidad."','".$this->utf8($this->localidad)."','".$this->rfc."','".$this->utf8($this->colonia)."',".$this->idusuario.")");		  
		 $id_insert_participante = mysql_insert_id(); 
		 $errorparticipante = "'participante':'Registro <br />EXITOSO..'";
		 $errorparticipante .= ",'logoparticipante':'ok'";
		}
	   else
	    {
		 $participante = parent::fetch_row($consulta);
		 $id_insert_participante = $participante[0];				  		
		 $errorparticipante = "'participante':'[".$this->curp."]<br />EXISTENTE...'";
		 $errorparticipante .= ",'logoparticipante':'cancel'";
		}


////Registro Eventos		
	   $consulta = parent::consulta("SELECT id_evento FROM reg_eventoparticipante WHERE id_evento = ".$this->evento." and id_registro = ".$id_insert_participante);
	   $num_total_registros = parent::num_rows($consulta);
	   if($num_total_registros==0)
		 {
		  //se registrara un nuevo evento para el participante	  
		  $consulta = parent::consulta("INSERT INTO reg_eventoparticipante (id_evento,id_registro) VALUES (".$this->evento.",".$id_insert_participante.")");		  
		  $id_insert_evento = mysql_insert_id(); 
		  $erroreventos = "'eventos':'Registro <br />EXITOSO..'";
		  $erroreventos .= ",'logoeventos':'ok'";		  
		}
	   else
	    {
		 $evento_participante = parent::fetch_row($consulta);
		 $id_insert_evento = $evento_participante[0]; 		 
		 $erroreventos = "'eventos':'".$this->nomevento."<br />EXISTENTE<br />[".$this->curp."]...'";
		 $erroreventos .= ",'logoeventos':'cancel'";		  		  		
		}
		
////Registro Modalidad		
		$consulta = parent::consulta("SELECT id_modalidad FROM reg_modalidadparticipante WHERE id_modalidad = ".$this->modalidad." and id_registro = ".$id_insert_participante." and id_evento = ".$this->evento);
	   $num_total_registros = parent::num_rows($consulta);
	   if($num_total_registros==0)
		 {
		  //se registrara una nueva modalidad para el participante	  
		  $consulta = parent::consulta("INSERT INTO reg_modalidadparticipante (id_evento,id_registro,id_modalidad) VALUES (".$this->evento.",".$id_insert_participante.",".$this->modalidad.")");		  
		  $id_insert_modalidad = mysql_insert_id(); 
		  $errormodalidad = "'modalidad':'Registro<br />EXITOSO..'";
		  $errormodalidad .= ",'logomodalidad':'ok'";		  
		}
	   else
	    {
		 $modalidad_participante = parent::fetch_row($consulta);
		 $id_insert_modalidad = $modalidad_participante[0];		 
		 $errormodalidad = "'modalidad':'".$this->nommodalidad."<br />EXISTENTE<br />[".$this->curp."]...'";
		 $errormodalidad .= ",'logomodalidad':'cancel'";		  		  			
		}						
		$errorcategoria = "'categoria':'null','logocategoria':'null'";	
		$ids= "'id_registro':'".$id_insert_participante."','id_evento':'".$id_insert_evento."','id_modalidad':'".$id_insert_modalidad."'"; 
		 
		echo '({'.$errorparticipante.','.$erroreventos.','.$errormodalidad.','.$errorcategoria.','.$ids.'})';
	    	
	}
}	
?>