<?php
error_reporting(E_ALL);
class grabardeportista extends MySQL
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
	var	$participante_sel = '';
	var $lista_modalidad_categorias = '';
	
function utf8($string_utf8)
	{
	   $string_utf8_temp = htmlentities($string_utf8,ENT_NOQUOTES, 'UTF-8');
	   $string_utf8_res = htmlspecialchars_decode($string_utf8_temp, ENT_NOQUOTES);
	   return	$string_utf8_res;
	}	
function grabarDeportistas()
	{		
	if(empty($this->participante_sel)){		
////Registro Participantes       
       $consulta = parent::consulta("SELECT id_registro FROM reg_participante WHERE reg_participante_curp = '".$this->curp."'");
	   $num_total_registros = parent::num_rows($consulta);
	   if($num_total_registros==0)
			   {		 
				//se registrara un nuevo participante	  
				$consulta = parent::consulta("INSERT INTO reg_participante (id_municipio, reg_participante_nombre, reg_participante_paterno,reg_participante_materno,reg_participante_curp,reg_participante_fechanac,reg_participante_direccion,reg_participante_codigop,reg_participante_telefonos,reg_participante_correo,reg_participante_peso,reg_participante_talla,reg_participante_sexo,reg_participante_tiposanguineo,reg_participante_entidad,reg_participante_localidad,reg_participante_rfc,reg_participante_colonia,id_usuario) VALUES (".$this->municipio.",'".$this->utf8($this->nombres)."','".$this->utf8($this->appaterno)."','".$this->utf8($this->apmaterno)."','".$this->curp."','".date('Y-m-d', strtotime ($this->fechanacimiento))."','".$this->utf8($this->direccion)."','".$this->codigopostal."','".$this->telefonos."','".$this->correo."','".$this->peso."','".$this->talla."','".$this->sexo."','".$this->tiposanguineo."','".$this->entidad."','".$this->utf8($this->localidad)."','".$this->rfc."','".$this->utf8($this->colonia)."',".$this->idusuario.")");		  
			   $id_insert_participante = mysql_insert_id(); 
			   $array_participante_status[] = $id_insert_participante."<d>".$this->curp."<d>ok";
			  }
			 else
			  {
			   $participante = parent::fetch_row($consulta);
			   $id_insert_participante = $participante[0];				  		
			   $array_participante_status[] = $id_insert_participante."<d>".$this->curp."<d>cancel";
			  }
		
////Registro Eventos		
	   $consulta = parent::consulta("SELECT id_regevento FROM reg_eventoparticipante WHERE id_evento = ".$this->evento." and id_registro = ".$id_insert_participante);
	   $num_total_registros = parent::num_rows($consulta);
	   if($num_total_registros==0)
			 {
			  //se registrara un nuevo evento para el participante	  
			  $consulta = parent::consulta("INSERT INTO reg_eventoparticipante (id_evento,id_registro) VALUES (".$this->evento.",".$id_insert_participante.")");		  
			  $id_insert_evento = mysql_insert_id(); 
			  $array_eventos_status[] = $id_insert_participante."<d>".$id_insert_evento."<d>ok";		  
			 }
		   else
			 {
			 $evento_participante = parent::fetch_row($consulta);
			 $id_insert_evento = $evento_participante[0]; 		 
			 $array_eventos_status[] = $id_insert_participante."<d>".$id_insert_evento."<d>cancel";		  		  		
			 }	
		 
	  //recorriendo lista de modalidad, deporte, categoria, pruebas 
	  $lista = explode('<r>', $this->lista_modalidad_categorias);
	  foreach ($lista as $categoria){	
	  $dato = explode('<d>', $categoria);	 
	  
////Registro Modalidad		
	     $consulta = parent::consulta("SELECT id_regmodalidad FROM reg_modalidadparticipante WHERE id_regevento = ".$id_insert_evento." and id_modalidad = ".$dato[0]);
	     $num_total_registros = parent::num_rows($consulta);	   
		   if($num_total_registros==0)
			{
			  //se registrara una nueva modalidad para el participante	  
			  $consulta = parent::consulta("INSERT INTO reg_modalidadparticipante (id_regevento,id_modalidad,id_evento,id_registro) VALUES (".$id_insert_evento.",".$dato[0].','.$this->evento.",".$id_insert_participant.")");
			  $id_insert_modalidad = mysql_insert_id(); 
			  $array_modalidad_status[] = $id_insert_participante."<d>".$id_insert_modalidad."<d>".$id_insert_evento."<d>".$dato[0]."<d>ok";		  
			}
		   else
			{
			 $modalidad_participante = parent::fetch_row($consulta);
			 $id_insert_modalidad = $modalidad_participante[0];		 
			 $array_modalidad_status[] = $id_insert_participante."<d>".$id_insert_modalidad."<d>".$id_insert_evento."<d>".$dato[0]."<d>cancel";		  		  			
			}	
		
////Registro Categoria					
		$consulta = parent::consulta("SELECT id_categoriapar FROM reg_categoriaparticipante WHERE id_categoria = ".$dato[2]." and id_regmodalidad = ".$id_insert_modalidad);
	    $num_total_registros = parent::num_rows($consulta);
		   if($num_total_registros==0)
			 {
			  //se registrara una nueva categoria para el participante	  			  
			  $consulta = parent::consulta("INSERT INTO reg_categoriaparticipante (id_evento,id_registro,id_regmodalidad,id_categoria,reg_categoriaparticipante_pruebas) VALUES (".$this->evento.",".$id_insert_participant.','.$id_insert_modalidad.",".$dato[2].",'".$dato[3]."')");		  			  
			 $array_categoria_status[] = $id_insert_participante."<d>".$id_insert_evento."<d>".$dato[2]."<d>ok";
			 }
		   else 
			 {		 
			 $array_categoria_status[] = $id_insert_participante."<d>".$id_insert_evento."<d>".$dato[2]."<d>cancel";						
			 }			
		}//fin loop categorias	
		
		$participante_statu = "'participante':'".implode("<r>", $array_participante_status)."'";
		$eventos_statu = "'eventos':'".implode("<r>", $array_eventos_status)."'";
		$modalidad_statu = "'modalidad':'".implode("<r>", $array_modalidad_status)."'";
		$categoria_statu = "'categoria':'".implode("<r>", $array_categoria_status)."'";	
		
		$multiple = "'multiple':'no'";
			 
		echo '({'.$participante_statu.','.$eventos_statu.','.$modalidad_statu.','.$categoria_statu.','.$multiple.'})';			
	   
	}else{//si participante_sel tiene ids selecionados	
	$selparArr = explode(',', $this->participante_sel);
	foreach ($selparArr as $id_insert_participante){
	 if(!empty($id_insert_participante)){	   
////Registro Eventos		
	   $consulta = parent::consulta("SELECT id_regevento FROM reg_eventoparticipante WHERE id_evento = ".$this->evento." and id_registro = ".$id_insert_participante);	   
	   $num_total_registros = parent::num_rows($consulta);	   
			   if($num_total_registros==0)
				 {
				  //se registrara un nuevo evento para el participante	  
				    $consulta = parent::consulta("INSERT INTO reg_eventoparticipante (id_evento,id_registro) VALUES (".$this->evento.",".$id_insert_participante.")");				  
				  $id_insert_evento = mysql_insert_id(); 
				  $array_eventos_status[] = $id_insert_participante."<d>".$id_insert_evento."<d>ok";				  		  
				}
			   else
				{
				 $evento_participante = parent::fetch_row($consulta);
				 $id_insert_evento = $evento_participante[0]; 		 
				 $array_eventos_status[] = $id_insert_participante."<d>".$id_insert_evento."<d>cancel";		  		  		
				}
	    
		//recorriendo lista de modalidad, deporte, categoria, pruebas 
	   $lista = explode('<r>', $this->lista_modalidad_categorias);
	   foreach ($lista as $categoria){	
	   $dato = explode('<d>', $categoria);	   	
	   
////Registro Modalidad		
	  $consulta = parent::consulta("SELECT id_regmodalidad FROM reg_modalidadparticipante WHERE id_regevento = ".$id_insert_evento." and id_modalidad = ".$dato[0]);
	   $num_total_registros = parent::num_rows($consulta);
			 if($num_total_registros==0)
			   {
				//se registrara una nueva modalidad para el participante	  
				$consulta = parent::consulta("INSERT INTO reg_modalidadparticipante (id_regevento,id_modalidad,id_evento,id_registro) VALUES (".$id_insert_evento.",".$dato[0].','.$this->evento.",".$id_insert_participant.")");
				$id_insert_modalidad = mysql_insert_id(); 
				$array_modalidad_status[] = $id_insert_participante."<d>".$id_insert_modalidad."<d>".$id_insert_evento."<d>".$dato[0]."<d>ok";		  
			  }
			 else
			  {
				$modalidad_participante = parent::fetch_row($consulta);
				$id_insert_modalidad = $modalidad_participante[0];		 
				$array_modalidad_status[] = $id_insert_participante."<d>".$id_insert_modalidad."<d>".$id_insert_evento."<d>".$dato[0]."<d>cancel";	  		  			
			  }			
		
////Registro Categoria				       		      
	   $consulta = parent::consulta("SELECT id_categoriapar FROM reg_categoriaparticipante WHERE id_categoria = ".$dato[2]." and id_regmodalidad = ".$id_insert_modalidad);
	   $num_total_registros = parent::num_rows($consulta);
	  
		   if($num_total_registros==0)
			 {
			  //se registrara una nueva categoria para el participante	  			  
			 $consulta = parent::consulta("INSERT INTO reg_categoriaparticipante (id_evento,id_registro,id_regmodalidad,id_categoria,reg_categoriaparticipante_pruebas) VALUES (".$this->evento.",".$id_insert_participant.','.$id_insert_modalidad.",".$dato[2].",'".$dato[3]."')");	  			  
			 $array_categoria_status[] = $id_insert_participante."<d>".$id_insert_evento."<d>".$dato[2]."<d>ok";
			 }
		   else 
			 {	 
			 $array_categoria_status[] = $id_insert_participante."<d>".$id_insert_evento."<d>".$dato[2]."<d>cancel"; 		        
			 }		 				
			 
			 
	  }//for lista categorias, deporte, modalidad, deporte
	 }//if antes de for
	}//for
	
	
	$eventos_statu = "'eventos':'".implode("<r>", $array_eventos_status)."'";
	$modalidad_statu = "'modalidad':'".implode("<r>", $array_modalidad_status)."'";
	$categoria_statu = "'categoria':'".implode("<r>", $array_categoria_status)."'";	
	
	$multiple = "'multiple':'si'";
		 
	echo '({'.$eventos_statu.','.$modalidad_statu.','.$categoria_statu.','.$multiple.'})';	
	
	}//if else selrow
	   
	   
	}//class end
	
}//end	
?>