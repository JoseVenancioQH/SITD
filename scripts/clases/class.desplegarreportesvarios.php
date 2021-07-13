<?php
error_reporting(E_ALL);
class desplegarreportesvarios extends MySQL
{					
    var $municipio = '';
	var $evento = '';	
	var $modalidad = '';
	var $deporte = '';
	var $rama = '';
	var $categoria = '';	
	var $pruebas = '';	
	
	var $nombres = '';
	var $apmaterno = '';	
	var $appaterno = '';
	var $curp = '';	
	
	var $orden = '';
	var $anoinicio = '';
	var $anofin = '';
	var $convivencia = '';
    
	
	function GeneraReportesVarios()
	  {	   	
	          if(empty($this->curp)) $filtrocurp = ''; else $filtrocurp = " and UCASE(reg_p.reg_participante_curp) like '%".strtoupper($this->curp)."%'";
			  
	          if(empty($this->nombres)) $filtronombres = ''; else $filtronombres = " and UCASE(reg_p.reg_participante_nombre) like '%".strtoupper($this->nombres)."%'";
			  
			  if(empty($this->appaterno)) $filtroappaterno = ''; else $filtroappaterno = " and UCASE(reg_p.reg_participante_paterno) like '%".strtoupper($this->appaterno)."%'";
			  
			 if(empty($this->apmaterno)) $filtroapmaterno = ''; else $filtroapmaterno = " and UCASE(reg_p.reg_participante_materno) like '%".strtoupper($this->apmaterno)."%'";
			 
			           	         
	         if(empty($this->municipio)) $filtromunicipio = ''; else $filtromunicipio = ' and reg_p.id_municipio = '.$this->municipio;
			 if(empty($this->evento)) $filtroevento = ''; else $filtroevento = ' and reg_ep.id_evento = '.$this->evento;
			 if(empty($this->modalidad)) $filtromodalidad = ''; else $filtromodalidad = ' and reg_m.id_modalidad = '.$this->modalidad;
			 if(empty($this->deporte)) $filtrodeporte = ''; else $filtrodeporte = ' and cat_c.id_deporte = '.$this->deporte;
			 if(empty($this->categoria)){ $filtrocategoria = ''; } else
                 {                 
                  $categoriaArr = explode ("_", $this->categoria);      
				  $filtrocategoria = "";
                  foreach ($categoriaArr as $val){
				    $filtrocategoria .= 'cat_c.id_categoria = '.$val.' or ';
				  }
                  $filtrocategoria = substr($filtrocategoria,0,strlen($filtrocategoria)-4);
                  $filtrocategoria = ' and ('.$filtrocategoria.')';
                }
		    if(!empty($this->rama)) {if($this->rama == 'H') $this->rama = 'Varonil'; else $this->rama = 'Femenil';}
		    if(empty($this->rama)) $filtrorama = ''; else $filtrorama = ' and cat_c.cat_categoria_rama = \''.$this->rama.'\'';
			
			if(empty($this->pruebas)){ $filtropruebas = ''; } else
                 {                 
                  $pruebasArr = explode (",", $this->pruebas);      
				  $filtropruebas = "";
                  foreach ($pruebasArr as $val){
                   $filtropruebas .= "UCASE(reg_c.reg_categoriaparticipante_pruebas) like '%".strtoupper($val)."%' or ";                  }
                  $filtropruebas = substr($filtropruebas,0,strlen($filtropruebas)-4);
                  $filtropruebas = ' and ('.$filtropruebas.')';
                }		 			
			if(empty($this->anoinicio) && empty($this->anofin)) $filtroano = ''; else $filtroano = " and (year(reg_participante_fechanac) BETWEEN ".$this->anoinicio." AND ".$this->anofin.")";		
			if(empty($this->convivencia)) $filtroconvivencia = "'' as convivencia, "; else $filtroconvivencia = "if(year(reg_p.reg_participante_fechanac)>=".$this->convivencia.",'Convivencia','') as convivencia, ";	
			
			if(empty($this->orden)){ $filtroorden = ''; } else
                 {                 
                  $ordenArr = explode(",", $this->orden);      
				  $filtroorden = "";
                  foreach ($ordenArr as $val){
				    if(strtoupper($val) == 'CURP')
					{$filtroorden .= 'reg_p.reg_participante_curp, ';}
					if(strtoupper($val) == 'NOMBRES')
					{$filtroorden .= 'reg_p.reg_participante_nombre, ';}
					if(strtoupper($val) == 'APPATERNO')
					{$filtroorden .= 'reg_p.reg_participante_paterno, ';}
					if(strtoupper($val) == 'APMATERNO')
					{$filtroorden .= 'reg_p.reg_participante_materno, ';}
					if(strtoupper($val) == 'CONVIVENCIA')
					{$filtroorden .= 'convivencia, ';}
					if(strtoupper($val) == 'MUNICIPIO')
					{$filtroorden .= 'reg_p.id_municipio, ';}
					if(strtoupper($val) == 'MODALIDAD')
					{$filtroorden .= 'reg_m.id_modalidad, ';}
					if(strtoupper($val) == 'RAMA')
					{$filtroorden .= 'reg_p.reg_participante_sexo, ';}
					if(strtoupper($val) == 'DEPORTE')
					{$filtroorden .= 'cat_c.id_deporte, ';}
					if(strtoupper($val) == 'CATEGORIA')
					{$filtroorden .= 'reg_c.id_categoria, ';}
					if(strtoupper($val) == 'ANOPARTICIPANTE')
					{$filtroorden .= 'anoparticipante, ';}			    
				  }
                  $filtroorden = substr($filtroorden,0,strlen($filtroorden)-2);
                  $filtroorden = ' ORDER BY '.$filtroorden;
                }
			
		    $filtroreporte = $filtromunicipio.$filtroevento.$filtromodalidad.$filtrodeporte.$filtrocategoria.$filtrorama.$filtropruebas.$filtroano.$filtronombres.$filtroappaterno.$filtroapmaterno.$filtrocurp;
			
			if(!empty($filtroreporte)){
	             $filtroreporte = substr($filtroreporte,5,strlen($filtroreporte));		
    			 $filtroreporte = ' WHERE '.$filtroreporte;
			}
			
			$consulta = parent::consulta("select "			
			.$filtroconvivencia
			."reg_p.id_registro, "			  	         			 
			."cat_mu.cat_municipio_nombre as municipio, "			 
			."year(reg_p.reg_participante_fechanac) as anoparticipante, "
			."reg_p.reg_participante_nombre as nombre, "
			."reg_p.reg_participante_paterno as appaterno, "
			."reg_p.reg_participante_materno as apmaterno, "
			."reg_p.reg_participante_curp as curp, "
			."reg_p.reg_participante_fechanac as fechanac, "
			."reg_p.reg_participante_entidad as entidad, "
			."reg_p.reg_participante_direccion as direccion, "
			."reg_p.reg_participante_codigop as codigop, "
			."reg_p.reg_participante_telefonos as telefonos, "
			."reg_p.reg_participante_correo as correo, "
			."reg_p.reg_participante_peso as peso, "
			."reg_p.reg_participante_talla as talla, "
			."reg_p.reg_participante_sexo as sexo, "
			."reg_p.reg_participante_tiposanguineo as tiposanguineo, "
			."reg_p.reg_participante_localidad as localidad, "
			."reg_p.reg_participante_colonia as colonia, "			 		 
			."reg_p.reg_participante_rfc as rfc, "			 		 
			."group_concat(concat_WS(' | ', concat('Modalidad:',cat_m.cat_modalidad_nombre),concat('Nombre Deporte:',cat_d.cat_deporte_nombre),concat('Nombre Categoria:',cat_c.cat_categoria_nombre),concat('Pruebas:',reg_c.reg_categoriaparticipante_pruebas),concat('Cargo:',reg_m.reg_modalidadparticipante_cargo)) SEPARATOR ' <br /> ' ) AS caracteristicas, " 
			."cat_c.cat_categoria_rangoinicio as rangoinicio, "
			."cat_c.cat_categoria_rangofin as rangofin, "		 
			."cat_c.cat_categoria_rama as rama  "			 
			."from "
		 ."(((reg_participante as reg_p inner join cat_municipio as cat_mu on reg_p.id_municipio = cat_mu.id_municipio) left join ((reg_modalidadparticipante as reg_m inner join cat_modalidad as cat_m on reg_m.id_modalidad = cat_m.id_modalidad) left join  cat_deportes as cat_dd on reg_m.reg_modalidadparticipante_deporte = cat_dd.id_deporte) on reg_p.id_registro = reg_m.id_registro) inner join (reg_eventoparticipante as reg_ep inner join reg_eventos as reg_e on reg_ep.id_evento = reg_e.id_evento) on reg_p.id_registro = reg_ep.id_registro) left join ((reg_categoriaparticipante as reg_c inner join cat_categoria as cat_c on reg_c.id_categoria = cat_c.id_categoria) inner join cat_deportes as cat_d on cat_c.id_deporte = cat_d.id_deporte) on reg_p.id_registro = reg_c.id_registro ".$filtroreporte." GROUP BY reg_p.id_registro".$filtroorden);		 
			 $num_total_registros = parent::num_rows($consulta);
			 if($num_total_registros>0)
			 {
			   while ($actual = parent::fetch_assoc($consulta)) 
			   {			    			  
			      if(is_null($actual['apmaterno'])) $actual['apmaterno'] = 'Ninguno';
				  if(is_null($actual['direccion'])) $actual['direccion'] = 'Ninguno';
				  if(is_null($actual['codigop'])) $actual['codigop'] = 'Ninguno';
				  if(is_null($actual['telefonos'])) $actual['telefonos'] = 'Ninguno';
				  if(is_null($actual['correo'])) $actual['correo'] = 'Ninguno';
				  if(is_null($actual['peso'])) $actual['peso'] = 'Ninguno';
				  if(is_null($actual['talla'])) $actual['talla'] = 'Ninguno';
				  if(is_null($actual['tiposanguineo'])) $actual['tiposanguineo'] = 'Ninguno';
				  if(is_null($actual['localidad'])) $actual['localidad'] = 'Ninguno';
				  if(is_null($actual['colonia'])) $actual['colonia'] = 'Ninguno';
				  if(is_null($actual['rfc'])) $actual['rfc'] = 'Ninguno';				  
				  if(is_null($actual['rangoinicio'])) $actual['rangoinicio'] = 'Ninguno';
				  if(is_null($actual['rangofin'])) $actual['rangofin'] = 'Ninguno';
			      
			      $arrData[] = $actual; 
			   }
			   return $arrData;			 
			 }
			 else
			 {
			   return "no";
			 }			 
	  }  	  	  	      	
}

?>