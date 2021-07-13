<?php
error_reporting(E_ALL);
class jsonautocomplet extends MySQL
{	
    var $municipio = '';
	var $evento = '';
	
	function GenerarJson()
	  {	   	          
			 $consulta = parent::consulta("SELECT * FROM reg_participante_2008");		 
			 $num_total_registros = parent::num_rows($consulta);
			 if($num_total_registros>0)
			 {
			   while ($actual = parent::fetch_assoc($consulta)) 
			   {			    		    
                $arrData[] = $actual; 
			   }
			   return $arrData;
			   /*return parent::fetch_assoc($consulta);*/
			 }
			 else
			 {
			   return "no";
			 }			 
	  } 
	  
	function GenerarJsonActual()
	  {	   	          	         
	         if(empty($this->municipio)) $filtromunicipio = ''; else $filtromunicipio = ' and reg_p.id_municipio = '.$this->municipio;
			 if(empty($this->evento)) $filtroevento = ''; else $filtroevento = ' where reg_ep.id_evento = '.$this->evento;			 
			 
			 $consulta = parent::consulta("select "			
			 ."reg_p.id_registro, "			  	         			 
			 ."cat_mu.cat_municipio_nombre as municipio, "			 
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
			 ."group_concat(concat_WS(' | ',concat('IDP:',reg_p.id_registro),concat('IDRM:',reg_m.id_regmodalidad),concat('IDRC:',reg_c.id_categoriapar),concat('IDC:',reg_c.id_categoria),concat('IDD:',cat_d.id_deporte),concat('IDDD:',cat_dd.id_deporte), concat('MOD:',cat_m.cat_modalidad_nombre),concat('ND:',cat_d.cat_deporte_nombre),concat('NDD:',cat_dd.cat_deporte_nombre),concat('NC:',cat_c.cat_categoria_nombre),concat('PRU:',reg_c.reg_categoriaparticipante_pruebas),concat('CAR:',reg_m.reg_modalidadparticipante_cargo)) SEPARATOR ' <br /> ' ) AS caracteristicas, "			 
			 ."cat_c.cat_categoria_rangoinicio as rangoinicio, "
			 ."cat_c.cat_categoria_rangofin as rangofin, "
			 ."cat_c.cat_categoria_prueba as pruebas, "
			 ."reg_m.id_modalidad as id_modalidad, "
			 ."cat_c.cat_categoria_rama as rama  "			 
			 ."from "
		 ."(((reg_participante as reg_p inner join cat_municipio as cat_mu on reg_p.id_municipio = cat_mu.id_municipio) left join ((reg_modalidadparticipante as reg_m inner join cat_modalidad as cat_m on reg_m.id_modalidad = cat_m.id_modalidad) left join  cat_deportes as cat_dd on reg_m.reg_modalidadparticipante_deporte = cat_dd.id_deporte) on reg_p.id_registro = reg_m.id_registro) inner join (reg_eventoparticipante as reg_ep inner join reg_eventos as reg_e on reg_ep.id_evento = reg_e.id_evento) on reg_p.id_registro = reg_ep.id_registro) left join ((reg_categoriaparticipante as reg_c inner join cat_categoria as cat_c on reg_c.id_categoria = cat_c.id_categoria) inner join cat_deportes as cat_d on cat_c.id_deporte = cat_d.id_deporte) on reg_p.id_registro = reg_c.id_registro ".$filtroevento.$filtromunicipio." GROUP BY reg_p.id_registro ORDER BY cat_d.id_deporte DESC");		 
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
				  /*if(is_null($actual['deporte']))
				  { 
				    if(is_null($actual['deporte2']))
				    {
					 $actual['deporte'] = $actual['cargo'];					 
					 //comite orgnizador
					}
					else
					{
					 $actual['deporte'] = $actual['deporte2'];					
					}//entrenador, auxiliar, delegado por deporte
				  } 
				  if(is_null($actual['pruebas'])) $actual['pruebas'] = 'Ninguno';
				  if(is_null($actual['idscategoria'])) $actual['idscategoria'] = 'Ninguno';
				  if(is_null($actual['nombrecategoria'])) $actual['nombrecategoria'] = 'Ninguno';*/
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