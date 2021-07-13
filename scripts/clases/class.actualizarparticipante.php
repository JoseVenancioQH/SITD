<?php
error_reporting(E_ALL);
class actualizarparticipante extends MySQL
{  	
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
	var	$idregistro = '';
	var $lista_modalidad_categorias = '';
	
function utf8($string_utf8)
	{
	   $string_utf8_temp = htmlentities($string_utf8,ENT_NOQUOTES, 'UTF-8');
	   $string_utf8_res = htmlspecialchars_decode($string_utf8_temp, ENT_NOQUOTES);
	   return	$string_utf8_res;
	}	
function actualizarParticipantes()
	{	
	  $id_insert_participante = $this->idregistro;	
	  $consulta = parent::consulta("SELECT reg_participante_curp as curpviejo FROM reg_participante WHERE  id_registro = ".$id_insert_participante);
	  
	  $curpold_fetch = parent::fetch_row($consulta);
	  $curpviejo = $curpold_fetch[0];	
	  
/////Registro Participantes           
/////Actualiza Datos del CURP en reg_participante
	  $consulta = parent::consulta("UPDATE reg_participante SET id_municipio = ".$this->municipio.", reg_participante_nombre = '".$this->utf8($this->nombres)."', reg_participante_paterno = '".$this->utf8($this->appaterno)."', reg_participante_materno = '".$this->utf8($this->apmaterno)."', reg_participante_entidad = '".$this->entidad."', reg_participante_fechanac = '".date('Y-m-d', strtotime ($this->fechanacimiento))."', reg_participante_sexo = '".$this->sexo."', reg_participante_curp = '".$this->curp."' WHERE id_registro = ".$id_insert_participante);				   
	  	
	  if($curpviejo != $this->curp){
		 $archivo_viejo = '../fotosparticipantes/'.$curpviejo.'.png';
		 $archivo_nuevo = '../fotosparticipantes/'.$this->curp.'.png';				  
		 if (file_exists($archivo_viejo)) {rename($archivo_viejo, $archivo_nuevo);}			  
	  }	  
	   
/////Actualzia reg_participante	   
	  $consulta = parent::consulta("UPDATE reg_participante SET reg_participante_direccion = '".$this->utf8($this->direccion)."', reg_participante_codigop = '".$this->utf8($this->codigopostal)."', reg_participante_telefonos = '".$this->utf8($this->telefonos)."', reg_participante_correo = '".$this->utf8($this->correo)."', reg_participante_peso = '".$this->utf8($this->peso)."', reg_participante_talla = '".$this->utf8($this->talla)."', reg_participante_tiposanguineo = '".$this->utf8($this->tiposanguineo)."', reg_participante_localidad = '".$this->utf8($this->localidad)."', reg_participante_colonia = '".$this->utf8($this->colonia)."'  WHERE id_registro = ".$id_insert_participante);			
			 		
/////Registro Eventos		
	  $consulta = parent::consulta("SELECT id_regevento FROM reg_eventoparticipante WHERE id_evento = ".$this->evento." and id_registro = ".$id_insert_participante);	   
	   
	  $evento_participante = parent::fetch_row($consulta);
	  $id_insert_evento = $evento_participante[0];
	   
	  $consulta = parent::consulta("SELECT id_regmodalidad FROM reg_modalidadparticipante WHERE id_regevento = ".$id_insert_evento);  	   	  
	  
	  $num_total_registros = parent::num_rows($consulta);	   
	  if($num_total_registros==0)
	  {	  
		while($rowmodalidad = parent::fetch_array($consulta))
		  {
			extract($rowmodalidad);
			$consulta = parent::consulta("DELETE FROM reg_categoriaparticipante where id_regmodalidad = ".$id_regmodalidad);				  
		  } 
	  }
		
	  $consulta = parent::consulta("DELETE FROM reg_modalidadparticipante where id_regevento = ".$id_insert_evento);	
		 
	  //recorriendo lista de modalidad, deporte, categoria, pruebas 
	  $lista = explode('{y}', $this->lista_modalidad_categorias);
	  foreach ($lista as $categoria){	
	  $dato = explode('{x}', $categoria);	  
////Registro Modalidad		
	     $consulta = parent::consulta("SELECT id_regmodalidad FROM reg_modalidadparticipante WHERE id_regevento = ".$id_insert_evento." and id_modalidad = ".$dato[0]);
	     $num_total_registros = parent::num_rows($consulta);	   
		   if($num_total_registros==0)
			{
			  if($dato[4]=='null'){	
			  //se registrara una nueva modalidad para el participante	  
			  $consulta = parent::consulta("INSERT INTO reg_modalidadparticipante (id_regevento,id_modalidad,id_evento,id_registro) VALUES (".$id_insert_evento.",".$dato[0].','.$this->evento.",".$id_insert_participante.")");
			  }else{
			  $consulta = parent::consulta("INSERT INTO reg_modalidadparticipante (id_regevento,id_modalidad,id_evento,id_registro,reg_modalidadparticipante_cargo) VALUES (".$id_insert_evento.",".$dato[0].','.$this->evento.",".$id_insert_participante.",'".$dato[4]."')");	  
			  }
			  $id_insert_modalidad = mysql_insert_id(); 			  			  	  
			}
		   else
			{
			 $modalidad_participante = parent::fetch_row($consulta);
			 $id_insert_modalidad = $modalidad_participante[0];			 			  		  			
			}	
		
////Registro Categoria					
		$consulta = parent::consulta("SELECT id_categoriapar FROM reg_categoriaparticipante WHERE id_categoria = ".$dato[2]." and id_regmodalidad = ".$id_insert_modalidad);
	    $num_total_registros = parent::num_rows($consulta);
		   if($num_total_registros==0)
			 {
			  //se registrara una nueva categoria para el participante	  
			  $consulta = parent::consulta("INSERT INTO reg_categoriaparticipante (id_evento,id_registro,id_regmodalidad,id_categoria,reg_categoriaparticipante_pruebas) VALUES (".$this->evento.",".$id_insert_participante.','.$id_insert_modalidad.",".$dato[2].",'".$dato[3]."')"); 
			 }		   
		}//fin loop categorias	
		$actualizacion_statu = "'actualizado':'ok'";				
		echo '({'.$actualizacion_statu.'})';					
	}//class end	
}//end	
?>