<?php
error_reporting(E_ALL);
class jsonreportes extends MySQL
{	
    //var $page = 0; // get the requested page
	//var $limit = 0; // get how many rows we want to have into the grid
	//var $sidx = 0; // get index row - i.e. user click to sort
	//var $sord = 0; // get the direction if(!$sidx) $sidx =1; 
    var $deporte = 0;
	var $municipio = '';
	var $nombres = '';
	var $appaterno = '';
	var $apmaterno = '';
	var $modalidad = '';
	var $categoria = '';
	var $rama = '';
	var $ordenar = '';
	
	var $anoinicio = '';
	var $anofin = '';
	var $convanoinicio = '';
	var $validado = '';
	
	var $evento = '';
	
	function GenerarJson()
	  {	     
	  if(empty($this->deporte) || $this->deporte == 0) $filtrodeporte = ''; else $filtrodeporte = ' and cat_d.id_deporte = '.$this->deporte;
	  
	  if(empty($this->evento)) $filtroevento = ''; else $filtroevento = ' and reg_e.id_evento = '.$this->evento;
	  
	  if(empty($this->municipio) || $this->municipio == 0) $filtromunicipio = ''; else $filtromunicipio = " and cat_mu.id_municipio = ".$this->municipio;
	  
	  if(empty($this->nombres)) $filtronombres = ''; else $filtronombres = " and UCASE(reg_p.reg_participante_nombre) like '%".strtoupper($this->nombres)."%'";
			  
	  if(empty($this->appaterno)) $filtroappaterno = ''; else $filtroappaterno = " and UCASE(reg_p.reg_participante_paterno) like '%".strtoupper($this->appaterno)."%'";
			  
	  if(empty($this->apmaterno)) $filtroapmaterno = ''; else $filtroapmaterno = " and UCASE(reg_p.reg_participante_materno) like '%".strtoupper($this->apmaterno)."%'";			            	           
	  if(empty($this->modalidad)) $filtromodalidad = ''; else $filtromodalidad = ' and reg_m.id_modalidad = '.$this->modalidad;
	  if(empty($this->categoria)) $filtrocategoria = ''; else $filtrocategoria = ' and reg_c.id_categoria = '.$this->categoria;
	  if(empty($this->validado)) $filtrovalidado = ''; else $filtrovalidado = ' and reg_c.reg_categoriaparticipante_validado = "'.$this->validado.'"';
	  
	  if(empty($this->anoinicio) && empty($this->anofin)) $filtroano = ''; else $filtroano = " and (year(reg_p.reg_participante_fechanac) BETWEEN ".$this->anoinicio." AND ".$this->anofin.")";  
	  
	  //if(!empty($this->rama)) {if($this->rama == 'H') $this->rama = 'Varonil'; else $this->rama = 'Femenil';}
	  if(empty($this->rama)) $filtrorama = ''; else $filtrorama = ' and reg_p.reg_participante_sexo = \''.$this->rama.'\'';	     
	 
	  
	  $filtro = $filtromunicipio.$filtromodalidad.$filtrodeporte.$filtrorama.$filtronombres.$filtroappaterno.$filtroapmaterno.$filtrocategoria.$filtroano.$filtrovalidado.$filtroevento;
	  
	  if(!empty($filtro)){
		   $filtro = substr($filtro,5,strlen($filtro));		
		   $filtro = ' WHERE '.$filtro;
	  }   
	  
	  if($this->ordenar!=''){		  
		 $arrorden = explode(',',$this->ordenar);		 
		 $orden_reporte = array();		 
		 foreach ($arrorden as $val) {		  			  
				if($val == 'municipio'){$orden_reporte[] = 'cat_mu.cat_municipio_nombre ASC';}
				if($val == 'nombres'){$orden_reporte[] = 'reg_p.reg_participante_nombre ASC';} 
				if($val == 'appaterno'){$orden_reporte[] = 'reg_p.reg_participante_paterno ASC';} 
				if($val == 'apmaterno'){$orden_reporte[] = 'reg_p.reg_participante_materno ASC';} 
				if($val == 'modalidad'){$orden_reporte[] = 'cat_m.cat_modalidad_nombre ASC';} 
				if($val == 'categoria'){$orden_reporte[] = 'cat_c.cat_categoria_nombre ASC';}
				if($val == 'sexo'){$orden_reporte[] = 'reg_p.reg_participante_sexo ASC';}
				if($val == 'anonacimiento'){$orden_reporte[] = 'cat_d.cat_deporte_nombre ASC';}
				if($val == 'deporte'){$orden_reporte[] = 'cat_d.cat_deporte_nombre ASC';}		  	 
		 }	
		 $filtroordenar = 'ORDER BY '.implode(',',$orden_reporte);
		 
	  }else{$filtroordenar = '';}
	  
	   	
	  $consulta = parent::consulta("select			
	  reg_p.id_registro as id_registro,  	     
	  reg_p.reg_participante_curp as curp,    			 		 			 
	  reg_p.reg_participante_nombre as nombre,
	  reg_p.reg_participante_paterno as appaterno,
	  reg_p.reg_participante_materno as apmaterno,
	  reg_p.reg_participante_fechanac as fechanac,
	  reg_p.reg_participante_sexo as sexo,			
	  GROUP_CONCAT(DISTINCT cat_mu.cat_municipio_nombre SEPARATOR ',') AS municipio,	 	  
	  reg_p.reg_participante_direccion as direccion,
	  reg_p.reg_participante_codigop as codigop,
	  reg_p.reg_participante_telefonos as telefonos,
	  reg_p.reg_participante_correo as correo,
	  reg_p.reg_participante_peso as peso,
	  reg_p.reg_participante_talla as talla,
	  reg_p.reg_participante_tiposanguineo as tiposanguineo,
	  reg_p.reg_participante_localidad as localidad,
	  reg_p.reg_participante_rfc as rfc,
	  reg_p.reg_participante_colonia as colonia,
	  reg_e.reg_eventoparticipante_documentos as documentos
	 
	  from
	  ((((((reg_participante as reg_p 
			inner join reg_eventoparticipante as reg_e on reg_p.id_registro = reg_e.id_registro)
			inner join reg_modalidadparticipante as reg_m on reg_e.id_regevento = reg_m.id_regevento)
			inner join reg_categoriaparticipante as reg_c on reg_c.id_regmodalidad = reg_m.id_regmodalidad)
			left join cat_municipio as cat_mu on cat_mu.id_municipio = reg_p.id_municipio)
			left join cat_categoria as cat_c on reg_c.id_categoria = cat_c.id_categoria)
			left join cat_deportes as cat_d on cat_c.id_deporte = cat_d.id_deporte)
			left join cat_modalidad as cat_m on reg_m.id_modalidad = cat_m.id_modalidad $filtro GROUP BY reg_p.id_registro  $filtroordenar");                             
		
	    $count = parent::num_rows($consulta);
	    $i=0;
	    if($count>0)
		{					  
			   $responce->page = 1;
			   $responce->total = 1; 
			   $responce->records = $count;
			   while ($actual = parent::fetch_assoc($consulta)) 
			   {		
			    $rama_desplegar = ($actual['sexo'] == 'H') ? 'Varonil' : 'Femenil';
				if(!empty($this->convanoinicio))
				{
					if(date('Y', strtotime ($actual['fechanac'])) >= $this->convanoinicio)
					{$convivencia_des ='Conv.';}else{$convivencia_des ='';}					
				}
				else
				{
					$convivencia_des='';
				}			
				
				$documentos_des = $actual['documentos'];		
				$documentos_des = str_replace('acta','Acta de Nacimiento',$documentos_des);
				$documentos_des = str_replace('curp','CURP',$documentos_des);
				$documentos_des = str_replace('sired','SIRED',$documentos_des);
				$documentos_des = str_replace('constancia','Constancia Medica',$documentos_des);
				$documentos_des = str_replace('fotos','Fotos',$documentos_des);
				$documentos_des = str_replace(',','<br />',$documentos_des);				
				
			    $responce->rows[$i]['id']=$actual['id_registro']; 
		        $responce->rows[$i]['cell']=array(		
						$convivencia_des,						
						$actual['curp'].'<br />'.$actual['nombre'].'<br />'.$actual['appaterno'].'<br />'.$actual['apmaterno'],
						$documentos_des,
						/*$actual['curp'],
						$actual['nombre'],
						$actual['appaterno'],
						$actual['apmaterno'],*/
						str_replace(',','<br />',$actual['municipio']),
						date('d-m-Y', strtotime ($actual['fechanac'])),
						$rama_desplegar,
						"<table class=\"nospace\">
						       <tr><td>Dir.: </td><td>".$actual['direccion']."</td></tr>
							   <tr><td>C.P.: </td><td>".$actual['codigop']."</td></tr>
							   <tr><td>Tel.: </td><td>".$actual['telefonos']."</td></tr>
							   <tr><td>Correo: </td><td>".$actual['correo']."</td></tr>
							   <tr><td>Peso: </td><td>".$actual['peso']."</td></tr>
							   <tr><td>Talla: </td><td>".$actual['talla']."</td></tr>
							   <tr><td>T. Sang: </td><td>".$actual['tiposanguineo']."</td></tr>							   
							   <tr><td>Loc.: </td><td>".$actual['localidad']."</td></tr>
							   <tr><td>R.F.C.: </td><td>".$actual['rfc']."</td></tr>
							   <tr><td>Col.: </td><td>".$actual['colonia']."</td></tr>
						</table>",
						(file_exists("../fotosparticipantes/".$actual["curp"].".png")) ? "<img class='edit_foto' style=' vertical-align:top; cursor:pointer;' src='../img/editar_img.jpg' onclick='javascript:editarfoto(\"".$actual["curp"]."\",\"\");'/><br /><img id='foto".$actual["curp"]."' src='../fotosparticipantes/".$actual["curp"].".png?nocache=".(rand()*1000)."' style='vertical-align:top; cursor:pointer;' onmouseover='javascript:actualizarfoto(\"".$actual["curp"]."\");' onclick='javascript:actualizarfoto(\"".$actual["curp"]."\");'/>" : "<img id='foto".$actual["curp"]."'  src='../img/foto_renovar.jpg' style='vertical-align:middle; cursor:pointer;' onmouseover='javascript:actualizarfoto(\"".$actual["curp"]."\");' onclick='javascript:actualizarfoto(\"".$actual["curp"]."\");'/>");						
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