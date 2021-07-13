<?php
error_reporting(E_ALL);
class jsonvalidar extends MySQL
{	     
    var $deporte = 0;
	var $municipio = '';
	var $nombres = '';
	var $appaterno = '';
	var $apmaterno = '';
	var $modalidad = '';
	var $categoria = '';
	var $rama = '';
	var $ano = '';
	var $evento = '';
	
	function GenerarValidar()
	  {	     
	  if(empty($this->deporte) || $this->deporte == 0) $filtrodeporte = ''; else $filtrodeporte = ' and cat_d.id_deporte = '.$this->deporte;
	  
	  if(empty($this->evento)) $filtroevento = ''; else $filtroevento = ' and reg_e.id_evento = '.$this->evento;
	  
	  if(empty($this->municipio) || $this->municipio == 0) $filtromunicipio = ''; else $filtromunicipio = " and cat_mu.id_municipio = ".$this->municipio;
	  
	  if(empty($this->nombres)) $filtronombres = ''; else $filtronombres = " and UCASE(reg_p.reg_participante_nombre) like '%".strtoupper($this->nombres)."%'";
			  
	  if(empty($this->appaterno)) $filtroappaterno = ''; else $filtroappaterno = " and UCASE(reg_p.reg_participante_paterno) like '%".strtoupper($this->appaterno)."%'";
			  
	  if(empty($this->apmaterno)) $filtroapmaterno = ''; else $filtroapmaterno = " and UCASE(reg_p.reg_participante_materno) like '%".strtoupper($this->apmaterno)."%'";			            	           
	  if(empty($this->modalidad)) $filtromodalidad = ''; else $filtromodalidad = ' and reg_m.id_modalidad = '.$this->modalidad;
	  if(empty($this->categoria)) $filtrocategoria = ''; else $filtrocategoria = ' and reg_c.id_categoria = '.$this->categoria;  
	  
	  if(empty($this->rama)) $filtrorama = ''; else $filtrorama = ' and reg_p.reg_participante_sexo = \''.$this->rama.'\'';	     
	  if(empty($this->ano)) $filtroano = ''; else $filtroano = " and (year(reg_participante_fechanac) BETWEEN ".$this->ano." AND ".$this->ano.")";	
	  
	  $filtro = $filtromunicipio.$filtroano.$filtromodalidad.$filtrodeporte.$filtrorama.$filtronombres.$filtroappaterno.$filtroapmaterno.$filtrocategoria.$filtroevento;
	  
	  if(!empty($filtro)){
		   $filtro = substr($filtro,5,strlen($filtro));		
		   $filtro = ' WHERE '.$filtro;
	  }   
	   	
	  $consulta = parent::consulta("select			
	  reg_p.id_registro as id_registro,  	     
	  reg_p.reg_participante_curp as curp,    			 		 			 
	  reg_p.reg_participante_nombre as nombre,
	  reg_p.reg_participante_paterno as appaterno,
	  reg_p.reg_participante_materno as apmaterno,
	  reg_p.reg_participante_fechanac as fechanac,
	  reg_p.reg_participante_sexo as sexo,			
	  cat_mu.cat_municipio_nombre as municipio,
	  reg_c.id_categoriapar as idcategoriapar,
      cat_m.cat_modalidad_nombre as modalidad, 
      cat_d.cat_deporte_nombre as deporte,
      cat_c.cat_categoria_nombre as categoria,
      cat_c.cat_categoria_prueba as prueba,
	  reg_e.reg_eventoparticipante_documentos as documentos,
	  reg_c.reg_categoriaparticipante_validado as validado
	  from
	  ((((((reg_participante as reg_p 
			inner join reg_eventoparticipante as reg_e on reg_p.id_registro = reg_e.id_registro)
			inner join reg_modalidadparticipante as reg_m on reg_e.id_regevento = reg_m.id_regevento)
			inner join reg_categoriaparticipante as reg_c on reg_c.id_regmodalidad = reg_m.id_regmodalidad)
			left join cat_municipio as cat_mu on cat_mu.id_municipio = reg_p.id_municipio)
			left join cat_categoria as cat_c on reg_c.id_categoria = cat_c.id_categoria)
			left join cat_deportes as cat_d on cat_c.id_deporte = cat_d.id_deporte)
			left join cat_modalidad as cat_m on reg_m.id_modalidad = cat_m.id_modalidad $filtro");
		
	    $count = parent::num_rows($consulta);
	    $i=0;
	    if($count>0)
		{					  
			   $responce->page = 1;
			   $responce->total = 1; 
			   $responce->records = $count;
			   while ($actual = parent::fetch_assoc($consulta)) 
			   {		   
			    
			    $documentos = explode(',', $actual['documentos']);
				
				if(empty($actual['documentos']))
				{$count_documentos = 0;}else{$count_documentos = count($documentos);}
				
				$responce->rows[$i]['id']=$actual['id_registro'].'-'.$actual['idcategoriapar']; 
		        $responce->rows[$i]['cell']=array(												
						$actual['nombre'],
						$actual['appaterno'],
						$actual['apmaterno'],
						$actual['modalidad'],
						$actual['deporte'],
						$actual['categoria'],
						str_replace(",",'<br />',$actual['prueba']),
						$actual['sexo'],
						(count($documentos) == 5) ? "<img src='../img/documentos_todos.jpg' style='vertical-align:top; cursor:pointer;' onclick='javascript:documentos(\"".$actual['id_registro'].'-'.$actual['idcategoriapar']."\",\"".$actual['documentos']."\");' />" : "<img style='vertical-align:top; cursor:pointer;' src='../img/documentos_".$count_documentos.".jpg' onclick='javascript:documentos(\"".$actual['id_registro'].'-'.$actual['idcategoriapar']."\",\"".$actual['documentos']."\");' />",
						(file_exists("../fotosparticipantes/".$actual["curp"].".png")) ? "<img class='edit_foto' style=' vertical-align:top; cursor:pointer;' src='../img/editar_img.jpg' onclick='javascript:editarfoto(\"".$actual["curp"]."\",\"\");'/><br /><img id='foto".$actual["curp"]."' src='../fotosparticipantes/".$actual["curp"].".png?nocache=".(rand()*1000)."' style='vertical-align:top; cursor:pointer;' onmouseover='javascript:actualizarfoto(\"".$actual["curp"]."\");' onclick='javascript:actualizarfoto(\"".$actual["curp"]."\");'/>" : "<img id='foto".$actual["curp"]."'  src='../img/foto_renovar.jpg' style='vertical-align:middle; cursor:pointer;' onmouseover='javascript:actualizarfoto(\"".$actual["curp"]."\");' onclick='javascript:actualizarfoto(\"".$actual["curp"]."\");'/>",
						 $actual['validado']);						
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