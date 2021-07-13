<?php
error_reporting(E_ALL);
class buscarcedulas extends MySQL
{
    var $evento = '';
	var $municipio = '';
	var $rama = '';
	var $deporte = '';
	var $categoria = '';
	
	function utf8($string_utf8)
	{
	   $string_utf8_temp = htmlentities($string_utf8,ENT_NOQUOTES, 'UTF-8');
	   $string_utf8_res = htmlspecialchars_decode($string_utf8_temp, ENT_NOQUOTES);
	   return	$string_utf8_res;
	}	
	 
    function GenerarJson()
	{	     
		 if(empty($this->evento)) $filtroevento = ''; else $filtroevento = ' and reg_ep.id_evento = '.$this->evento;
		 if(empty($this->municipio)) $filtromunicipio = ''; else $filtromunicipio = ' and reg_p.id_municipio = '.$this->municipio;		 
                 
         if(empty($this->categoria)){ $filtrocategoria = ''; } else
                 {                 
                  $categoriaArr = explode (",", $this->categoria);      
				  $filtrocategoria = "";
                  foreach ($categoriaArr as $val) {                    
 

                   $filtrocategoria .= 'cat_c.id_categoria = '.$val.' or ';
               

                   }

                   $filtrocategoria = substr($filtrocategoria,0,strlen($filtrocategoria)-4);
                   $filtrocategoria = ' and ('.$filtrocategoria.')';

                }
		 
		 if(empty($this->rama)) $filtrorama = ''; else $filtrorama = ' and reg_p.reg_participante_sexo = \''.$this->rama.'\'';
		 if(empty($this->deporte)) $filtrodeporte = ''; else $filtrodeporte = ' and cat_dd.cat_deporte_nombre = '.$this->deporte;		
		 
		 /*$filtroparticipantes = " where ucase(cat_m.cat_modalidad_nombre) = 'DEPORTISTA' or ucase(cat_m.cat_modalidad_nombre) = 'ENTRENADOR' or ucase(cat_m.cat_modalidad_nombre) = 'AUXILIAR' or ucase(cat_m.cat_modalidad_nombre) = 'DELEGADO POR DEPORTE'";*/
		 
		 /*print "select reg_p.id_registro, reg_p.reg_participante_nombre as nombre, reg_p.reg_participante_paterno as appaterno, reg_p.reg_participante_materno as apmaterno, reg_p.reg_participante_curp as curp, cat_m.cat_modalidad_nombre as modalidad, cat_d.cat_deporte_nombre as deporte, cat_c.cat_categoria_nombre as nombrecategoria, cat_c.cat_categoria_rangoinicio as rangoinicio, cat_c.cat_categoria_rangofin as rangofin, cat_c.cat_categoria_prueba as pruebas, cat_c.cat_categoria_rama as rama  from ((reg_participante as reg_p inner join ((reg_modalidadparticipante as reg_m inner join cat_modalidad as cat_m on reg_m.id_modalidad = cat_m.id_modalidad) left join  cat_deportes as cat_dd on reg_m.reg_modalidadparticipante_deporte = cat_dd.id_deporte) on reg_p.id_registro = reg_m.id_registro) inner join (reg_eventoparticipante as reg_ep inner join reg_eventos as reg_e on reg_ep.id_evento = reg_e.id_evento) on reg_p.id_registro = reg_ep.id_registro) left join ((reg_categoriaparticipante as reg_c inner join cat_categoria as cat_c on reg_c.id_categoria = cat_c.id_categoria) inner join cat_deportes as cat_d on cat_c.id_deporte = cat_d.id_deporte) on reg_p.id_registro = reg_c.id_registro where (ucase(cat_m.cat_modalidad_nombre) = 'DEPORTISTA' or ucase(cat_m.cat_modalidad_nombre) = 'ENTRENADOR' or ucase(cat_m.cat_modalidad_nombre) = 'AUXILIAR')".$filtromunicipio."".$filtroevento."".$filtrocategoria."".$filtrorama."".$filtrodeporte." order by deporte DESC";*/
		 
		 $consulta = parent::consulta("select reg_p.reg_participante_fechanac as fechanac, reg_p.id_registro, reg_p.reg_participante_nombre as nombre, reg_p.reg_participante_paterno as appaterno, reg_p.reg_participante_materno as apmaterno, reg_p.reg_participante_curp as curp, cat_m.cat_modalidad_nombre as modalidad, cat_d.cat_deporte_nombre as deporte, cat_c.cat_categoria_nombre as nombrecategoria, cat_c.cat_categoria_rangoinicio as rangoinicio, cat_c.cat_categoria_rangofin as rangofin, cat_c.cat_categoria_prueba as pruebas, cat_c.cat_categoria_rama as rama  from ((reg_participante as reg_p inner join ((reg_modalidadparticipante as reg_m inner join cat_modalidad as cat_m on reg_m.id_modalidad = cat_m.id_modalidad) left join  cat_deportes as cat_dd on reg_m.reg_modalidadparticipante_deporte = cat_dd.id_deporte) on reg_p.id_registro = reg_m.id_registro) inner join (reg_eventoparticipante as reg_ep inner join reg_eventos as reg_e on reg_ep.id_evento = reg_e.id_evento) on reg_p.id_registro = reg_ep.id_registro) left join ((reg_categoriaparticipante as reg_c inner join cat_categoria as cat_c on reg_c.id_categoria = cat_c.id_categoria) inner join cat_deportes as cat_d on cat_c.id_deporte = cat_d.id_deporte) on reg_p.id_registro = reg_c.id_registro where (ucase(cat_m.cat_modalidad_nombre) = 'DEPORTISTA' or ucase(cat_m.cat_modalidad_nombre) = 'ENTRENADOR' or ucase(cat_m.cat_modalidad_nombre) = 'AUXILIAR')".$filtromunicipio."".$filtroevento."".$filtrocategoria."".$filtrorama." order by deporte DESC");
		/* $consulta = parent::consulta("select reg_p.id_registro, reg_p.reg_participante_nombre as nombre, reg_p.reg_participante_paterno as appaterno, reg_p.reg_participante_materno as apmaterno, reg_p.reg_participante_curp as curp, cat_m.cat_modalidad_nombre as modalidad, cat_d.cat_deporte_nombre as deporte, cat_c.cat_categoria_nombre as nombrecategoria, cat_c.cat_categoria_rangoinicio as rangoinicio, cat_c.cat_categoria_rangofin as rangofin, cat_c.cat_categoria_prueba as pruebas, cat_c.cat_categoria_rama as rama from ((reg_participante as reg_p inner join ((reg_modalidadparticipante as reg_m inner join cat_modalidad as cat_m on reg_m.id_modalidad = cat_m.id_modalidad) left join  cat_deportes as cat_dd on reg_m.reg_modalidadparticipante_deporte = cat_dd.id_deporte) on reg_p.id_registro = reg_m.id_registro".$filtromunicipio.") inner join (reg_eventoparticipante as reg_ep inner join reg_eventos as reg_e on reg_ep.id_evento = reg_e.id_evento".$filtroevento.") on reg_p.id_registro = reg_ep.id_registro) left join ((reg_categoriaparticipante as reg_c inner join cat_categoria as cat_c on reg_c.id_categoria = cat_c.id_categoria".$filtrocategoria.") inner join cat_deportes as cat_d on cat_c.id_deporte = cat_d.id_deporte) on reg_p.id_registro = reg_c.id_registro".$filtroparticipantes);*/
 		     	  
			 $num_total_registros = parent::num_rows($consulta);
			 if($num_total_registros>0)
			 {
			   while ($actual = parent::fetch_assoc($consulta)) 
			   {		    
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